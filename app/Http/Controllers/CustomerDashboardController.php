<?php

namespace App\Http\Controllers;

use App\Mail\CustomerMagicLoginMail;
use App\Models\DownloadToken;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class CustomerDashboardController extends Controller
{
    /**
     * Show customer dashboard with purchased products, licenses, and downloads
     */
    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('customer.login');
        }

        $user = Auth::user();

        // Get all paid orders for this user or customer email
        $orders = Order::with(['items.product', 'downloadTokens.product'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('customer_email', $user->email);
            })
            ->where('payment_status', 'paid')
            ->latest('paid_at')
            ->get();

        return view('customer.dashboard', compact('user', 'orders'));
    }

    /**
     * Show customer login page
     */
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.login');
    }

    /**
     * Handle customer login submission with email and password
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if (! $user->is_active) {
                Auth::logout();

                return back()->withErrors(['email' => 'تم تعطيل هذا الحساب. يرجى التواصل مع الدعم الفني.']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('customer.dashboard'))
                ->with('success', 'أهلاً بك مجدداً، '.$user->name);
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->onlyInput('email');
    }

    /**
     * Fast Passwordless Login using Customer Email and Order Number
     */
    public function loginWithOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'order_number' => 'required|string|max:100',
        ]);

        $email = strtolower(trim($validated['email']));
        $orderQuery = trim($validated['order_number']);

        $order = Order::where(function ($q) use ($email) {
            $q->where('customer_email', $email)
                ->orWhereHas('user', fn ($u) => $u->where('email', $email));
        })
            ->where(function ($q) use ($orderQuery) {
                $q->where('order_number', $orderQuery)
                    ->orWhere('merchant_reference', $orderQuery)
                    ->orWhere('transaction_id', $orderQuery);
            })
            ->where('payment_status', 'paid')
            ->first();

        if (! $order) {
            return back()->withErrors([
                'order_number' => 'لم نتمكن من العثور على طلب مدفوع مطابق لهذا البريد الإلكتروني ورقم الطلب.',
            ])->withInput();
        }

        $user = $order->user ?: User::where('email', $email)->first();
        if (! $user) {
            $user = User::create([
                'name' => $order->customer_name ?: 'عميل Ox Tech',
                'email' => $order->customer_email,
                'password' => Hash::make(Str::password(12)),
                'role' => 'client',
                'is_active' => true,
            ]);
            $order->update(['user_id' => $user->id]);
        }

        if (! $user->is_active) {
            return back()->withErrors(['order_number' => 'تم تعطيل هذا الحساب. يرجى التواصل مع الدعم الفني.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')
            ->with('success', 'تم تسجيل دخولك بنجاح عبر رقم الطلب #'.$order->order_number);
    }

    /**
     * Show Forgot Password view
     */
    public function showForgotPassword(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('customer.dashboard');
        }

        return view('customer.forgot-password');
    }

    /**
     * Send Instant Magic Login Link and Temporary Password to Customer Email
     */
    public function sendResetOrMagicLink(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = strtolower(trim($validated['email']));
        $user = User::where('email', $email)->first();

        if ($user) {
            $tempPassword = Str::password(10, letters: true, numbers: true, symbols: false);
            $user->update(['password' => Hash::make($tempPassword)]);

            $magicUrl = URL::temporarySignedRoute(
                'customer.magic-login',
                now()->addHours(24),
                ['user' => $user->id]
            );

            try {
                Mail::to($user->email)->send(
                    new CustomerMagicLoginMail(
                        user: $user,
                        magicUrl: $magicUrl,
                        tempPassword: $tempPassword
                    )
                );
            } catch (\Exception $e) {
                Log::error('Failed to send magic login email: '.$e->getMessage());
            }
        }

        return back()->with('success', 'إذا كان هذا البريد مسجلاً لدينا، فقد تم إرسال رابط الدخول المباشر إلى بريدك الإلكتروني بنجاح (يرجى فحص صندوق الوارد أو مجلد الرسائل غير المرغوب فيها).');
    }

    /**
     * Authenticate Customer via One-Click Magic Link
     */
    public function magicLogin(Request $request, User $user): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'رابط الدخول غير صالح أو منتهي الصلاحية.');
        }

        if (! $user->is_active) {
            return redirect()->route('customer.login')->withErrors(['email' => 'تم تعطيل هذا الحساب.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return redirect()->route('customer.dashboard')
            ->with('success', 'مرحباً بك! تم تسجيل الدخول بنجاح عبر الرابط المباشر.');
    }

    /**
     * Customer logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login')->with('success', 'تم تسجيل الخروج بنجاح.');
    }

    /**
     * Secure Tokenized Product Download
     */
    public function download(string $token): BinaryFileResponse|RedirectResponse
    {
        $downloadToken = DownloadToken::with(['product', 'order.items'])
            ->where('token', $token)
            ->firstOrFail();

        if (! $downloadToken->isValid()) {
            return redirect()->route('customer.dashboard')->with('error', 'عذراً، هذا الرابط منتهي الصلاحية أو تم استنفاد الحد الأقصى لعدد مرات التحميل.');
        }

        $product = $downloadToken->product;
        $order = $downloadToken->order;
        $orderItem = $order->items->where('product_id', $product->id)->first();
        $licenseKey = $orderItem ? $orderItem->license_key : 'N/A';

        // Check file path or generate distribution package
        $disk = Storage::disk('local');
        $fileName = $product->file_name ?: Str::slug($product->name).'-v'.$product->version.'.zip';
        $storagePath = $product->file_path;

        if ($storagePath && $disk->exists($storagePath)) {
            $downloadToken->recordDownload();

            return response()->download($disk->path($storagePath), $fileName);
        }

        // If no custom file uploaded yet, generate a branded package with license and instructions
        $tempDir = storage_path('app'.DIRECTORY_SEPARATOR.'temp_downloads');
        if (! file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipFilePath = $tempDir.DIRECTORY_SEPARATOR.'package_'.$downloadToken->token.'.zip';

        $zip = new ZipArchive;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $readmeContent = "========================================================\n"
                .' '.$product->name.' (v'.$product->version.")\n"
                .' '.config('app.name', 'Ox Tech')." Digital Distribution\n"
                ."========================================================\n\n"
                .'رقم الطلب: '.$order->order_number."\n"
                .'اسم العميل: '.$order->customer_name."\n"
                .'البريد الإلكتروني: '.$order->customer_email."\n"
                .'مفتاح الترخيص (License Key): '.$licenseKey."\n"
                .'تاريخ التفعيل: '.now()->format('Y-m-d H:i:s')."\n\n"
                ."تعليمات التثبيت والاستخدام:\n"
                ."1. قم بفك الضغط عن هذا المجلد في بيئة العمل الخاصة بك.\n"
                ."2. استخدم مفتاح الترخيص الموضح أعلاه لتفعيل البرنامج عند أول تشغيل.\n"
                ."3. للدعم الفني والتحديثات، يرجى زيارة حسابك على الموقع:\n"
                .'   '.route('customer.dashboard')."\n\n"
                .'شكراً لثقتكم باختيار حلولنا الرقمية!';

            $zip->addFromString('LICENSE.txt', $readmeContent);
            $zip->addFromString('README_AR.txt', $readmeContent);
            $zip->addFromString('app_manifest.json', json_encode([
                'product_name' => $product->name,
                'version' => $product->version,
                'license_key' => $licenseKey,
                'issued_to' => $order->customer_name,
                'order_number' => $order->order_number,
                'build_timestamp' => now()->timestamp,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            $zip->close();

            $downloadToken->recordDownload();

            return response()->download($zipFilePath, $fileName)->deleteFileAfterSend(true);
        }

        return redirect()->route('customer.dashboard')->with('error', 'حدث خطأ أثناء تجهيز ملف التحميل. يرجى التواصل مع الدعم الفني.');
    }
}
