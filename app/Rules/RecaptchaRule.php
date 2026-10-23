<?php

namespace App\Rules;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Translation\PotentiallyTranslatedString;

class RecaptchaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secretKey = config('services.recaptcha.secret_key');
        if (empty($secretKey) && class_exists(SiteSetting::class)) {
            $secretKey = SiteSetting::get('recaptcha_secret_key', '');
        }

        // If secret key is not set (e.g. local development / testing without API keys), skip verification gracefully
        if (empty($secretKey)) {
            return;
        }

        if (empty($value) || ! is_string($value)) {
            $fail(__('فشل التحقق من أمان المتصفح (reCAPTCHA)، يرجى إعادة المحاولة.'));

            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => $secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);

            if (! $response->successful()) {
                Log::warning('reCAPTCHA verification HTTP request failed with status: '.$response->status());
                $fail(__('تعذر الاتصال بخدمة التحقق من الأمان، يرجى إعادة المحاولة.'));

                return;
            }

            $data = $response->json();

            if (! ($data['success'] ?? false)) {
                $errorCodes = implode(', ', $data['error-codes'] ?? []);
                Log::info('reCAPTCHA verification failed for IP: '.request()->ip().' codes: '.$errorCodes);
                $fail(__('فشل التحقق من أمان الروبوت (reCAPTCHA)، يرجى إعادة المحاولة.'));

                return;
            }

            // For reCAPTCHA v3, verify score
            if (isset($data['score'])) {
                $minScore = (float) (config('services.recaptcha.minimum_score') ?: (class_exists(SiteSetting::class) ? SiteSetting::get('recaptcha_min_score', 0.5) : 0.5));
                if ((float) $data['score'] < $minScore) {
                    Log::warning('reCAPTCHA low score detected (potential bot): '.$data['score'].' from IP: '.request()->ip());
                    $fail(__('تم رصد نشاط آلي غير موثوق، يرجى المحاولة من متصفح عادي.'));

                    return;
                }
            }
        } catch (\Throwable $e) {
            Log::error('reCAPTCHA exception: '.$e->getMessage());
            // In case of network timeout to Google, allow form through if in testing or notify user
            if (app()->environment('local', 'testing')) {
                return;
            }
            $fail(__('تعذر التحقق من الأمان حالياً، يرجى المحاولة لاحقاً.'));
        }
    }
}
