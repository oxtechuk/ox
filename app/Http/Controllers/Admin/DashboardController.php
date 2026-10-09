<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Consultation;
use App\Models\DigitalProduct;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\Project;
use App\Models\Quotation;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use App\Models\TrackingPixel;
use App\Models\User;
use App\Models\VisitorTraffic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // 1. Core Financial & Digital Store Sales Stats (100% Dynamic)
        $paidOrdersQuery = Order::where('payment_status', 'paid');
        $totalRevenue = (float) (clone $paidOrdersQuery)->sum('total_amount');
        $monthlyRevenue = (float) (clone $paidOrdersQuery)
            ->where('created_at', '>=', now()->subDays(30))
            ->sum('total_amount');

        $payskyRevenue = (float) Order::where('payment_gateway', 'paysky')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $paypalRevenue = (float) Order::where('payment_gateway', 'paypal')
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $paidOrdersCount = (clone $paidOrdersQuery)->count();
        $totalOrdersCount = Order::count();

        // Monthly Growth Calculation (Real Math)
        $currentMonthRev = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('total_amount');
        $lastMonthRev = (float) Order::where('payment_status', 'paid')
            ->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
            ->sum('total_amount');

        $growthPercentage = $lastMonthRev > 0
            ? round((($currentMonthRev - $lastMonthRev) / $lastMonthRev) * 100, 1)
            : ($currentMonthRev > 0 ? 100.0 : 0.0);

        // CRM Invoices & Quotations
        $totalInvoiced = (float) Invoice::sum('total_amount');
        $totalCollected = (float) Invoice::where('status', 'paid')->sum('total_amount');
        $totalQuotations = Quotation::count();
        $totalClients = Client::count();

        // Gateway connectivity checks
        $payskyConfigured = ! empty(config('services.paysky.mid')) && ! empty(config('services.paysky.tid'));
        $paypalConfigured = ! empty(config('services.paypal.client_id'));

        // 2. Real-time Visitors & Countries Traffic (100% Dynamic)
        $totalVisitors = VisitorTraffic::humans()->distinct('session_id')->count('session_id');
        $totalPageviews = VisitorTraffic::humans()->count();
        $liveVisitors = VisitorTraffic::humans()
            ->where('created_at', '>=', now()->subMinutes(10))
            ->distinct('session_id')
            ->count('session_id');
        $todayVisitors = VisitorTraffic::humans()
            ->whereDate('created_at', today())
            ->distinct('session_id')
            ->count('session_id');

        $countryDictionary = [
            'sa' => 'المملكة العربية السعودية',
            'ae' => 'الإمارات العربية المتحدة',
            'eg' => 'جمهورية مصر العربية',
            'kw' => 'الكويت',
            'qa' => 'قطر',
            'om' => 'سلطنة عمان',
            'bh' => 'مملكة البحرين',
            'jo' => 'الأردن',
            'de' => 'ألمانيا',
            'gb' => 'المملكة المتحدة',
            'us' => 'الولايات المتحدة',
            'fr' => 'فرنسا',
            'ca' => 'كندا',
        ];

        $topCountries = VisitorTraffic::humans()
            ->whereNotNull('country_code')
            ->select('country_code', DB::raw('count(*) as count'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->take(6)
            ->get()
            ->map(function ($c) use ($countryDictionary, $totalPageviews) {
                $code = strtolower($c->country_code);

                return [
                    'code' => strtoupper($code),
                    'name' => $countryDictionary[$code] ?? strtoupper($code),
                    'views' => $c->count,
                    'visitors' => $c->visitors,
                    'percentage' => $totalPageviews > 0 ? round(($c->count / $totalPageviews) * 100, 1) : 0,
                ];
            });

        $defaultCurrency = SiteSetting::get('default_currency', 'USD');

        // 3. Compiled System Stats
        $stats = [
            'total_revenue' => $totalRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'growth_percentage' => $growthPercentage,
            'paysky_revenue' => $payskyRevenue,
            'paypal_revenue' => $paypalRevenue,
            'paid_orders_count' => $paidOrdersCount,
            'total_orders_count' => $totalOrdersCount,
            'active_products_count' => DigitalProduct::where('status', 'active')->count(),
            'total_products_count' => DigitalProduct::count(),
            'new_consultations' => Consultation::where('status', 'new')->count(),
            'total_consultations' => Consultation::count(),
            'total_projects' => Project::count(),
            'active_testimonials' => Testimonial::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_invoiced' => $totalInvoiced,
            'total_collected' => $totalCollected,
            'total_quotations' => $totalQuotations,
            'total_clients' => $totalClients,
            'paysky_active' => $payskyConfigured,
            'paypal_active' => $paypalConfigured,
            'total_visitors' => $totalVisitors,
            'total_pageviews' => $totalPageviews,
            'live_visitors' => $liveVisitors,
            'today_visitors' => $todayVisitors,
            'currency' => $defaultCurrency,
        ];

        // 4. Monthly Chart Data (Last 7 Months)
        $chartLabels7M = [];
        $chartRevenue7M = [];
        $chartOrders7M = [];

        for ($i = 6; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $chartLabels7M[] = $monthDate->translatedFormat('M Y');

            $monthStart = (clone $monthDate)->startOfMonth();
            $monthEnd = (clone $monthDate)->endOfMonth();

            $monthOrders = Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$monthStart, $monthEnd]);

            $chartRevenue7M[] = (float) (clone $monthOrders)->sum('total_amount');
            $chartOrders7M[] = (int) (clone $monthOrders)->count();
        }

        // 30 Days Dynamic Chart Data
        $chartLabels30D = [];
        $chartRevenue30D = [];
        for ($w = 3; $w >= 0; $w--) {
            $wStart = now()->subWeeks($w + 1)->startOfDay();
            $wEnd = now()->subWeeks($w)->endOfDay();
            $chartLabels30D[] = 'الأسبوع '.(4 - $w);
            $chartRevenue30D[] = (float) Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$wStart, $wEnd])
                ->sum('total_amount');
        }

        // Current Year Quarters Dynamic Chart Data
        $chartLabelsYear = ['الربع 1', 'الربع 2', 'الربع 3', 'الربع 4'];
        $chartRevenueYear = [];
        for ($q = 1; $q <= 4; $q++) {
            $qStart = Carbon::create(now()->year, ($q - 1) * 3 + 1, 1)->startOfDay();
            $qEnd = (clone $qStart)->addMonths(3)->subDay()->endOfDay();
            $chartRevenueYear[] = (float) Order::where('payment_status', 'paid')
                ->whereBetween('created_at', [$qStart, $qEnd])
                ->sum('total_amount');
        }

        // Traffic Chart Data (Last 7 Days)
        $chartLabelsTraffic = [];
        $chartViewsTraffic = [];
        $chartVisitorsTraffic = [];
        for ($d = 6; $d >= 0; $d--) {
            $dayDate = now()->subDays($d);
            $chartLabelsTraffic[] = $dayDate->locale('ar')->isoFormat('D MMM');
            $dayStart = (clone $dayDate)->startOfDay();
            $dayEnd = (clone $dayDate)->endOfDay();

            $dQuery = VisitorTraffic::humans()->whereBetween('created_at', [$dayStart, $dayEnd]);
            $chartViewsTraffic[] = (clone $dQuery)->count();
            $chartVisitorsTraffic[] = (clone $dQuery)->distinct('session_id')->count('session_id');
        }

        // 5. Recent Activities
        $recentOrders = Order::with('items.product')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        $recentConsultations = Consultation::orderBy('id', 'desc')
            ->take(6)
            ->get();

        $recentProjects = Project::orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'chartLabels7M',
            'chartRevenue7M',
            'chartOrders7M',
            'chartLabels30D',
            'chartRevenue30D',
            'chartLabelsYear',
            'chartRevenueYear',
            'chartLabelsTraffic',
            'chartViewsTraffic',
            'chartVisitorsTraffic',
            'topCountries',
            'recentOrders',
            'recentConsultations',
            'recentProjects'
        ));
    }

    public function hub(): View
    {
        $hubStats = [
            'projects_count' => Project::count(),
            'testimonials_count' => Testimonial::count(),
            'quotations_count' => Quotation::count(),
            'payment_logs_count' => PaymentLog::count(),
            'users_count' => User::count(),
            'tracking_pixels_count' => TrackingPixel::count(),
            'site_settings_count' => SiteSetting::count(),
            'media_count' => count(Storage::disk('public')->allFiles()),
        ];

        return view('admin.hub', compact('hubStats'));
    }
}
