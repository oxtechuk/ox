<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DigitalOrderController;
use App\Http\Controllers\Admin\DigitalProductController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\QuotationController as AdminQuotationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SiteContentController as AdminSiteContentController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\TrackingController as AdminTrackingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\DigitalCheckoutController;
use App\Http\Controllers\DigitalStoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayPalCheckoutController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SeoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/portfolio', [ProjectController::class, 'index'])->name('portfolio.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/consultation/store', [ConsultationController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('consultation.store');

/*
|--------------------------------------------------------------------------
| Digital Store, Software Sales & High-Converting Landing Pages
|--------------------------------------------------------------------------
*/
Route::get('/store', [DigitalStoreController::class, 'index'])->name('store.index');
Route::get('/store/product/{slug}', [DigitalStoreController::class, 'show'])->name('store.product');
Route::get('/p/{slug}', [DigitalStoreController::class, 'landing'])->name('store.landing');

/*
|--------------------------------------------------------------------------
| Checkout & PaySky Gateway Integration
|--------------------------------------------------------------------------
*/
Route::post('/checkout/initiate', [DigitalCheckoutController::class, 'initiate'])
    ->middleware('throttle:15,1')
    ->name('checkout.initiate');
Route::match(['get', 'post'], '/checkout/paysky/callback', [DigitalCheckoutController::class, 'callback'])->name('checkout.paysky.callback');
Route::post('/checkout/paysky/webhook', [DigitalCheckoutController::class, 'webhook'])->name('checkout.paysky.webhook');
Route::post('/checkout/paysky/log-error', [DigitalCheckoutController::class, 'logClientError'])->name('checkout.paysky.log_error');

// PayPal Checkout Routes
Route::get('/checkout/paypal/config', [PayPalCheckoutController::class, 'config'])->name('checkout.paypal.config');
Route::post('/checkout/paypal/create', [PayPalCheckoutController::class, 'create'])->name('checkout.paypal.create');
Route::post('/checkout/paypal/capture', [PayPalCheckoutController::class, 'capture'])->name('checkout.paypal.capture');
Route::post('/checkout/paypal/webhook', [PayPalCheckoutController::class, 'webhook'])->name('checkout.paypal.webhook');

Route::get('/checkout/success/{orderNumber}', [DigitalCheckoutController::class, 'success'])->name('checkout.success');

/*
|--------------------------------------------------------------------------
| Customer Portal & Secure Downloads
|--------------------------------------------------------------------------
*/
Route::get('/account', [CustomerDashboardController::class, 'dashboard'])->name('customer.dashboard');
Route::get('/account/login', [CustomerDashboardController::class, 'showLogin'])->name('customer.login');
Route::post('/account/login', [CustomerDashboardController::class, 'login'])
    ->middleware('throttle:6,1')
    ->name('customer.login.submit');
Route::post('/account/logout', [CustomerDashboardController::class, 'logout'])->name('customer.logout');
Route::get('/downloads/{token}', [CustomerDashboardController::class, 'download'])
    ->middleware('throttle:30,1')
    ->name('digital.download');
Route::get('/lang/{locale}', [SeoController::class, 'switchLanguage'])->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Dynamic SEO: Sitemap & Robots
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', [SeoController::class, 'sitemap'])->name('seo.sitemap');
Route::get('/robots.txt', [SeoController::class, 'robots'])->name('seo.robots');
Route::get('/llms.txt', [SeoController::class, 'llmsText'])->name('seo.llms');
Route::get('/llms-full.txt', [SeoController::class, 'llmsFullText'])->name('seo.llms-full');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
$adminPrefix = config('app.admin_prefix', env('ADMIN_PREFIX', 'ox-secure-cp'));

// If a custom admin prefix is enabled, disguise the standard /admin URL with a 404 Not Found
if ($adminPrefix !== 'admin') {
    Route::any('/admin', fn () => abort(404));
    Route::any('/admin/{any}', fn () => abort(404))->where('any', '.*');
}

Route::prefix($adminPrefix)->name('admin.')->group(function () {
    Route::get('/', function () {
        return auth()->check() ? redirect()->route('admin.dashboard') : redirect()->route('admin.login');
    });

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:6,1')
        ->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Protected Admin Dashboard Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Projects Management
        Route::resource('projects', AdminProjectController::class);

        // Testimonials & Video Reviews Management
        Route::resource('testimonials', AdminTestimonialController::class);

        // Consultations Management & Lead Attribution
        Route::get('/consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
        Route::get('/consultations/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');
        Route::patch('/consultations/{consultation}/status', [AdminConsultationController::class, 'updateStatus'])->name('consultations.status');
        Route::delete('/consultations/{consultation}', [AdminConsultationController::class, 'destroy'])->name('consultations.destroy');

        // Digital Products & Software Store Management
        Route::resource('digital-products', DigitalProductController::class);
        Route::resource('digital-orders', DigitalOrderController::class)->only(['index', 'show']);
        Route::get('/payment-logs', [PaymentLogController::class, 'index'])->name('payment-logs.index');
        Route::get('/payment-logs/{paymentLog}', [PaymentLogController::class, 'show'])->name('payment-logs.show');
        Route::post('/payment-logs/clear-old', [PaymentLogController::class, 'clearOld'])->name('payment-logs.clear_old');

        // Site Content Management
        Route::get('/site-content', [AdminSiteContentController::class, 'index'])->name('site-content.index');
        Route::post('/site-content/update', [AdminSiteContentController::class, 'update'])->name('site-content.update');

        // Global Site Settings (Logos, Footer, Regional Tech SEO, SMTP)
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings/update', [AdminSettingController::class, 'update'])->name('settings.update');

        // Marketing Tracking Pixels (GA4, GTM, Meta, Snapchat, TikTok)
        Route::get('/tracking', [AdminTrackingController::class, 'index'])->name('tracking.index');
        Route::post('/tracking/update', [AdminTrackingController::class, 'update'])->name('tracking.update');

        // CRM System
        Route::prefix('crm')->name('crm.')->group(function () {
            // Clients
            Route::resource('clients', AdminClientController::class);

            // Quotations
            Route::resource('quotations', AdminQuotationController::class);
            Route::post('quotations/{quotation}/send-email', [AdminQuotationController::class, 'sendEmail'])->name('quotations.send_email');
            Route::post('quotations/{quotation}/convert-to-invoice', [AdminQuotationController::class, 'convertToInvoice'])->name('quotations.convert_to_invoice');

            // Invoices
            Route::resource('invoices', AdminInvoiceController::class);
            Route::post('invoices/{invoice}/payments', [AdminInvoiceController::class, 'addPayment'])->name('invoices.payments.store');
            Route::post('invoices/{invoice}/send-email', [AdminInvoiceController::class, 'sendEmail'])->name('invoices.send_email');
        });

        // Executive Analytics & Attribution Reports
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');

        // Users & Roles Management
        Route::resource('users', AdminUserController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Storage Asset Fallback Route
|--------------------------------------------------------------------------
| Serves files directly from storage/app/public when the public/storage
| symlink is missing or unsupported by the web server (e.g. cPanel / shared hosting).
*/
Route::get('/storage/{path}', function (string $path) {
    if (str_contains($path, '..') || str_contains($path, '\\')) {
        abort(404);
    }

    $filePath = storage_path('app/public/'.$path);

    if (! file_exists($filePath) || ! is_file($filePath)) {
        abort(404);
    }

    $mime = mime_content_type($filePath) ?: 'application/octet-stream';

    return response()->file($filePath, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.fallback');
