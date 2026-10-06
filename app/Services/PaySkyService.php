<?php

namespace App\Services;

use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Support\Facades\Log;

class PaySkyService
{
    protected string $mid;

    protected string $tid;

    protected string $secretKey;

    protected string $mode;

    protected string $scriptUrl;

    public function __construct()
    {
        $this->mid = (string) (SiteSetting::get('paysky_mid') ?: config('services.paysky.mid', '10000000001'));
        $this->tid = (string) (SiteSetting::get('paysky_tid') ?: config('services.paysky.tid', '10000001'));
        $this->secretKey = (string) (SiteSetting::get('paysky_secret_key') ?: config('services.paysky.secret_key', '31323334353637383930313233343536'));
        $this->mode = (string) (SiteSetting::get('paysky_mode') ?: config('services.paysky.mode', 'test'));

        $this->scriptUrl = $this->mode === 'live'
            ? config('services.paysky.live_script_url')
            : config('services.paysky.test_script_url');
    }

    public function isEnabled(): bool
    {
        return (bool) SiteSetting::get('paysky_enabled', true);
    }

    public function getMid(): string
    {
        return $this->mid;
    }

    public function getTid(): string
    {
        return $this->tid;
    }

    public function getScriptUrl(): string
    {
        return $this->scriptUrl;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * Generate PaySky / UPG SecureHash using HMAC-SHA256 with parameter string
     *
     * @param  array<string, mixed>  $parameters
     * @return array{hash: string, raw_string: string}
     */
    public function generateSecureHashWithRaw(array $parameters): array
    {
        unset($parameters['SecureHash'], $parameters['secure_hash']);

        // Sort keys ascending alphabetically
        ksort($parameters);

        // Build canonical query string with key=value&key2=value2
        $pairs = [];
        foreach ($parameters as $key => $value) {
            if ($value !== null && $value !== '') {
                $pairs[] = $key.'='.$value;
            }
        }
        $rawString = implode('&', $pairs);

        try {
            $binaryKey = ctype_xdigit($this->secretKey) && (strlen($this->secretKey) % 2 === 0)
                ? hex2bin($this->secretKey)
                : $this->secretKey;

            $hash = strtoupper(hash_hmac('sha256', $rawString, (string) $binaryKey));
        } catch (Exception $e) {
            Log::error('PaySky SecureHash calculation error', [
                'error' => $e->getMessage(),
                'raw_string' => $rawString,
            ]);

            $hash = strtoupper(hash_hmac('sha256', $rawString, $this->secretKey));
        }

        return [
            'hash' => $hash,
            'raw_string' => $rawString,
        ];
    }

    /**
     * Generate PaySky SecureHash using HMAC-SHA256
     *
     * @param  array<string, mixed>  $parameters
     */
    public function generateSecureHash(array $parameters): string
    {
        return $this->generateSecureHashWithRaw($parameters)['hash'];
    }

    /**
     * Prepare configuration payload for PaySky Lightbox
     *
     * @return array<string, mixed>
     */
    public function prepareLightboxPayload(Order $order): array
    {
        // PaySky accepts amount in minor currency units (e.g. 100.00 EGP = 10000)
        $amountTrxn = (int) round(((float) $order->total_amount) * 100);
        $trxDateTime = now()->format('YmdHis');

        // UPG / PaySky Lightbox canonical hash parameters
        $hashParams = [
            'Amount' => (string) $amountTrxn,
            'DateTimeLocalTrxn' => $trxDateTime,
            'MerchantId' => $this->mid,
            'MerchantReference' => $order->merchant_reference,
            'TerminalId' => $this->tid,
        ];

        $hashResult = $this->generateSecureHashWithRaw($hashParams);
        $secureHash = $hashResult['hash'];
        $rawString = $hashResult['raw_string'];

        // Record log
        try {
            PaymentLog::record(
                event: 'lightbox_payload_prepared',
                status: 'info',
                message: 'تم تجهيز معاملات نافذة الدفع Lightbox وتوليد توقيع SecureHash',
                order: $order,
                requestPayload: array_merge($hashParams, [
                    'AmountTrxn' => (string) $amountTrxn,
                    'CurrencyCode' => $order->currency === 'EGP' ? '818' : ($order->currency === 'SAR' ? '682' : '840'),
                    'TrxDateTime' => $trxDateTime,
                ]),
                responsePayload: [
                    'SecureHash' => $secureHash,
                    'hash_raw_string' => $rawString,
                ]
            );
        } catch (Exception $e) {
            Log::warning('Could not write payment log', ['error' => $e->getMessage()]);
        }

        return [
            'MID' => $this->mid,
            'TID' => $this->tid,
            'AmountTrxn' => $amountTrxn,
            'MerchantReference' => $order->merchant_reference,
            'TrxDateTime' => $trxDateTime,
            'DateTimeLocalTrxn' => $trxDateTime,
            'SecureHash' => $secureHash,
            'OrderNumber' => $order->order_number,
            'CustomerEmail' => $order->customer_email,
            'CustomerName' => $order->customer_name,
            'CustomerMobile' => $order->customer_phone ?? '',
            'ScriptUrl' => $this->scriptUrl,
            'Mode' => $this->mode,
        ];
    }

    /**
     * Verify PaySky callback or IPN payload
     *
     * @param  array<string, mixed>  $responseParams
     */
    public function verifyCallback(array $responseParams): bool
    {
        $receivedHash = $responseParams['SecureHash'] ?? $responseParams['secure_hash'] ?? null;
        if (! $receivedHash) {
            return false;
        }

        $calculatedHash = $this->generateSecureHash($responseParams);

        $matched = hash_equals(strtoupper((string) $receivedHash), strtoupper($calculatedHash));

        try {
            PaymentLog::record(
                event: $matched ? 'signature_verified' : 'signature_mismatch',
                status: $matched ? 'success' : 'failed',
                message: $matched ? 'تم التحقق من صحة التوقيع الرقمي بنجاح' : 'فشل التحقق: عدم تطابق التوقيع الرقمي مع المفتاح السري',
                merchantReference: $responseParams['MerchantReference'] ?? null,
                requestPayload: $responseParams,
                responsePayload: ['CalculatedHash' => $calculatedHash, 'ReceivedHash' => $receivedHash]
            );
        } catch (Exception $e) {
            Log::warning('Could not write payment log', ['error' => $e->getMessage()]);
        }

        return $matched;
    }
}
