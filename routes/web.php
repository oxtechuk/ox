<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\SiteContentController as AdminSiteContentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\TrackingController as AdminTrackingController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\QuotationController as AdminQuotationController;
use App\Http\Controllers\Admin\InvoiceController as AdminInvoiceController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Models\Project;
use App\Models\SiteSetting;

/*
|--------------------------------------------------------------------------
| Public Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/consultation/store', [ConsultationController::class, 'store'])->name('consultation.store');

/*
|--------------------------------------------------------------------------
| Dynamic SEO: Sitemap & Robots
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', function () {
    $projects = Project::all();
    $baseUrl = url('/');

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">';
    
    // Homepage
    $xml .= '<url>';
    $xml .= '<loc>' . $baseUrl . '</loc>';
    $xml .= '<lastmod>' . now()->toAtomString() . '</lastmod>';
    $xml .= '<changefreq>daily</changefreq>';
    $xml .= '<priority>1.0</priority>';
    $xml .= '</url>';

    // Projects
    foreach ($projects as $project) {
        $xml .= '<url>';
        $xml .= '<loc>' . route('projects.show', $project->slug) . '</loc>';
        $xml .= '<lastmod>' . $project->updated_at->toAtomString() . '</lastmod>';
        $xml .= '<changefreq>weekly</changefreq>';
        $xml .= '<priority>0.8</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200)->header('Content-Type', 'text/xml');
})->name('seo.sitemap');

Route::get('/robots.txt', function () {
    $sitemapUrl = url('/sitemap.xml');
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /admin/\n";
    $content .= "Disallow: /admin/login\n\n";
    $content .= "Sitemap: {$sitemapUrl}\n";

    return response($content, 200)->header('Content-Type', 'text/plain');
})->name('seo.robots');

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
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
