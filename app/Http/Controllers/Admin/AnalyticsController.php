<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Project;
use App\Models\TrackingPixel;
use App\Models\TrafficEvent;
use App\Models\VisitorTraffic;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->input('period', '7days');

        // Determine date boundary
        $startDate = match ($period) {
            'today' => now()->startOfDay(),
            '30days' => now()->subDays(30)->startOfDay(),
            'this_month' => now()->startOfMonth(),
            default => now()->subDays(7)->startOfDay(),
        };

        $adminPrefix = trim(config('app.admin_prefix', env('ADMIN_PREFIX', 'ox-secure-cp')), '/');

        $baseQuery = VisitorTraffic::humans()
            ->where('created_at', '>=', $startDate)
            ->where('path', 'not like', $adminPrefix.'%')
            ->where('path', 'not like', 'ox-secure-cp%')
            ->where('path', 'not like', 'admin%');

        // 1. KPI Stats
        $totalPageviews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->distinct('session_id')->count('session_id');
        $liveVisitors = VisitorTraffic::humans()
            ->where('created_at', '>=', now()->subMinutes(10))
            ->where('path', 'not like', $adminPrefix.'%')
            ->where('path', 'not like', 'ox-secure-cp%')
            ->where('path', 'not like', 'admin%')
            ->distinct('session_id')
            ->count('session_id');

        $avgPages = $uniqueVisitors > 0 ? round($totalPageviews / $uniqueVisitors, 1) : 1.0;

        $whatsappClicks = TrafficEvent::where('event_name', 'whatsapp_click')
            ->where('created_at', '>=', $startDate)
            ->count();

        $consultationsCount = Consultation::where('created_at', '>=', $startDate)->count();

        // Previous Period for Growth Calculation
        $daysCount = match ($period) {
            'today' => 1,
            '30days' => 30,
            'this_month' => now()->day,
            default => 7,
        };
        $prevStartDate = (clone $startDate)->subDays($daysCount);
        $prevPageviews = VisitorTraffic::humans()
            ->whereBetween('created_at', [$prevStartDate, $startDate])
            ->where('path', 'not like', $adminPrefix.'%')
            ->where('path', 'not like', 'ox-secure-cp%')
            ->where('path', 'not like', 'admin%')
            ->count();
        $growthPageviews = $prevPageviews > 0
            ? round((($totalPageviews - $prevPageviews) / $prevPageviews) * 100, 1)
            : ($totalPageviews > 0 ? 100.0 : 0.0);

        // 2. Traffic Chart Data (Grouped by Day)
        $chartLabels = [];
        $chartPageviews = [];
        $chartVisitors = [];

        $loopDays = match ($period) {
            'today' => 24, // group by hours if today
            '30days' => 30,
            'this_month' => now()->day,
            default => 7,
        };

        if ($period === 'today') {
            for ($h = 0; $h <= now()->hour; $h++) {
                $hourLabel = sprintf('%02d:00', $h);
                $chartLabels[] = $hourLabel;
                $hStart = now()->copy()->startOfDay()->addHours($h);
                $hEnd = (clone $hStart)->endOfHour();

                $hQuery = VisitorTraffic::humans()
                    ->whereBetween('created_at', [$hStart, $hEnd])
                    ->where('path', 'not like', $adminPrefix.'%')
                    ->where('path', 'not like', 'ox-secure-cp%')
                    ->where('path', 'not like', 'admin%');
                $chartPageviews[] = (clone $hQuery)->count();
                $chartVisitors[] = (clone $hQuery)->distinct('session_id')->count('session_id');
            }
        } else {
            for ($i = $loopDays - 1; $i >= 0; $i--) {
                $targetDate = now()->subDays($i);
                $chartLabels[] = $targetDate->locale('ar')->isoFormat('D MMM');
                $dStart = (clone $targetDate)->startOfDay();
                $dEnd = (clone $targetDate)->endOfDay();

                $dQuery = VisitorTraffic::humans()
                    ->whereBetween('created_at', [$dStart, $dEnd])
                    ->where('path', 'not like', $adminPrefix.'%')
                    ->where('path', 'not like', 'ox-secure-cp%')
                    ->where('path', 'not like', 'admin%');
                $chartPageviews[] = (clone $dQuery)->count();
                $chartVisitors[] = (clone $dQuery)->distinct('session_id')->count('session_id');
            }
        }

        // 3. Traffic Sources Breakdown (Google, Meta, Direct, WhatsApp, TikTok, etc.)
        $sourcesRaw = (clone $baseQuery)
            ->select('referer_source', DB::raw('count(*) as count'))
            ->groupBy('referer_source')
            ->orderByDesc('count')
            ->get();

        $sourcesMap = [
            'google' => ['label' => 'Google (بحث وإعلانات)', 'color' => '#4285F4', 'icon' => 'google'],
            'meta' => ['label' => 'Meta (Facebook & Instagram)', 'color' => '#1877F2', 'icon' => 'meta'],
            'whatsapp' => ['label' => 'واتساب وإحالات مباشرة', 'color' => '#25D366', 'icon' => 'whatsapp'],
            'tiktok' => ['label' => 'تيك توك (TikTok)', 'color' => '#000000', 'icon' => 'tiktok'],
            'snapchat' => ['label' => 'سناب شات (Snapchat)', 'color' => '#FFFC00', 'icon' => 'snapchat'],
            'twitter' => ['label' => 'منصة X (Twitter)', 'color' => '#1DA1F2', 'icon' => 'twitter'],
            'direct' => ['label' => 'زيارات مباشرة (Direct)', 'color' => '#10B981', 'icon' => 'direct'],
            'referral' => ['label' => 'مواقع شريكة وخارجية', 'color' => '#8B5CF6', 'icon' => 'referral'],
            'internal' => ['label' => 'تصفح داخلي', 'color' => '#64748B', 'icon' => 'internal'],
        ];

        $trafficSources = [];
        foreach ($sourcesRaw as $row) {
            $srcKey = $row->referer_source ?: 'direct';
            $info = $sourcesMap[$srcKey] ?? ['label' => ucfirst($srcKey), 'color' => '#64748B', 'icon' => 'other'];
            $pct = $totalPageviews > 0 ? round(($row->count / $totalPageviews) * 100, 1) : 0;
            $trafficSources[] = [
                'key' => $srcKey,
                'label' => $info['label'],
                'color' => $info['color'],
                'count' => $row->count,
                'percentage' => $pct,
            ];
        }

        // 4. Top Visited Pages & Projects
        $topPagesRaw = (clone $baseQuery)
            ->select('path', 'project_id', DB::raw('count(*) as views'), DB::raw('count(distinct session_id) as visitors'))
            ->groupBy('path', 'project_id')
            ->orderByDesc('views')
            ->take(8)
            ->get();

        $projectsById = Project::whereIn('id', $topPagesRaw->pluck('project_id')->filter())->get()->keyBy('id');

        $topPages = $topPagesRaw->map(function ($row) use ($projectsById, $totalPageviews) {
            $title = 'الرئيسية';
            if ($row->path === '/' || empty($row->path)) {
                $title = 'الصفحة الرئيسية (Landing Page)';
            } elseif ($row->project_id && isset($projectsById[$row->project_id])) {
                $title = 'مشروع: '.$projectsById[$row->project_id]->title;
            } elseif (str_starts_with($row->path, 'projects/')) {
                $slug = substr($row->path, 9);
                $title = 'مشروع: '.ucfirst(str_replace('-', ' ', $slug));
            } elseif (str_starts_with($row->path, 'digital-store')) {
                $title = 'متجر البرامج الرقمية';
            } elseif (str_starts_with($row->path, 'consult')) {
                $title = 'صفحة حجز الاستشارة';
            } else {
                $title = '/'.ltrim($row->path, '/');
            }

            return [
                'path' => '/'.ltrim($row->path, '/'),
                'title' => $title,
                'views' => $row->views,
                'visitors' => $row->visitors,
                'percentage' => $totalPageviews > 0 ? round(($row->views / $totalPageviews) * 100, 1) : 0,
            ];
        });

        // 5. Device Breakdown (Mobile vs Desktop vs Tablet)
        $devicesRaw = (clone $baseQuery)
            ->select('device_type', DB::raw('count(*) as count'))
            ->groupBy('device_type')
            ->get()
            ->pluck('count', 'device_type');

        $mobileCount = $devicesRaw['mobile'] ?? 0;
        $desktopCount = $devicesRaw['desktop'] ?? 0;
        $tabletCount = $devicesRaw['tablet'] ?? 0;
        $deviceTotal = max(1, $mobileCount + $desktopCount + $tabletCount);

        $devicesStats = [
            'mobile' => ['count' => $mobileCount, 'pct' => round(($mobileCount / $deviceTotal) * 100, 1)],
            'desktop' => ['count' => $desktopCount, 'pct' => round(($desktopCount / $deviceTotal) * 100, 1)],
            'tablet' => ['count' => $tabletCount, 'pct' => round(($tabletCount / $deviceTotal) * 100, 1)],
        ];

        // 6. Top Countries
        $countriesRaw = (clone $baseQuery)
            ->select(
                DB::raw("LOWER(COALESCE(NULLIF(country_code, ''), 'sa')) as code"),
                DB::raw('count(*) as count'),
                DB::raw('count(distinct session_id) as visitors')
            )
            ->groupBy('code')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $countryDictionary = [
            'sa' => 'المملكة العربية السعودية',
            'ae' => 'الإمارات العربية المتحدة',
            'eg' => 'جمهورية مصر العربية',
            'kw' => 'دولة الكويت',
            'qa' => 'دولة قطر',
            'om' => 'سلطنة عُمان',
            'bh' => 'مملكة البحرين',
            'jo' => 'المملكة الأردنية',
            'iq' => 'العراق',
            'ye' => 'اليمن',
            'sy' => 'سوريا',
            'lb' => 'لبنان',
            'ps' => 'فلسطين',
            'sd' => 'السودان',
            'ly' => 'ليبيا',
            'dz' => 'الجزائر',
            'ma' => 'المغرب',
            'tn' => 'تونس',
            'tr' => 'تركيا',
            'de' => 'ألمانيا',
            'gb' => 'بريطانيا (المملكة المتحدة)',
            'us' => 'الولايات المتحدة الأمريكية',
            'fr' => 'فرنسا',
            'ca' => 'كندا',
            'nl' => 'هولندا',
            'se' => 'السويد',
            'it' => 'إيطاليا',
            'es' => 'إسبانيا',
            'ch' => 'سويسرا',
            'ru' => 'روسيا',
            'cn' => 'الصين',
            'in' => 'الهند',
            'my' => 'ماليزيا',
        ];

        $topCountries = $countriesRaw->map(function ($c) use ($countryDictionary, $totalPageviews) {
            $code = strtolower($c->code);
            $flagRelPath = "assets/flags/{$code}.webp";
            $flagUrl = file_exists(public_path($flagRelPath)) ? asset($flagRelPath) : null;

            return [
                'code' => $code,
                'name' => $countryDictionary[$code] ?? strtoupper($code),
                'flag_url' => $flagUrl,
                'count' => (int) $c->count,
                'visitors' => (int) ($c->visitors ?? $c->count),
                'percentage' => $totalPageviews > 0 ? round(($c->count / $totalPageviews) * 100, 1) : 0,
            ];
        });

        // 7. Tracking Pixels Integration Status
        $pixels = TrackingPixel::all()->keyBy('platform');

        // 8. Recent Live Traffic Log (excluding admin paths)
        $recentVisits = VisitorTraffic::humans()
            ->where('path', 'not like', $adminPrefix.'%')
            ->where('path', 'not like', 'ox-secure-cp%')
            ->where('path', 'not like', 'admin%')
            ->latest('id')
            ->take(10)
            ->get();

        // 9. Check if current admin browser is excluded
        $isAdminExcluded = $request->cookie('ox_admin_device') === '1'
            || $request->cookie('ox_exclude_admin') === '1'
            || auth()->check()
            || (bool) session('is_admin_session');

        return view('admin.analytics.index', compact(
            'period',
            'totalPageviews',
            'uniqueVisitors',
            'liveVisitors',
            'avgPages',
            'growthPageviews',
            'whatsappClicks',
            'consultationsCount',
            'chartLabels',
            'chartPageviews',
            'chartVisitors',
            'trafficSources',
            'topPages',
            'devicesStats',
            'topCountries',
            'pixels',
            'recentVisits',
            'isAdminExcluded'
        ));
    }

    public function recordEvent(Request $request): JsonResponse
    {
        // Ignore real-time events from administrators or admin devices
        if (
            \Illuminate\Support\Facades\Auth::check() ||
            $request->cookie('ox_admin_device') === '1' ||
            $request->cookie('ox_exclude_admin') === '1' ||
            $request->session()->get('is_admin_session')
        ) {
            return response()->json(['ignored' => true, 'reason' => 'admin_excluded']);
        }

        $eventName = $request->input('event_name');
        $pageUrl = $request->input('page_url');
        $data = $request->input('data');

        if (! $eventName && $request->getContent()) {
            $decoded = json_decode($request->getContent(), true);
            if (is_array($decoded)) {
                $eventName = $decoded['event_name'] ?? null;
                $pageUrl = $decoded['page_url'] ?? $pageUrl;
                $data = $decoded['data'] ?? $data;
            }
        }

        if (! $eventName) {
            return response()->json(['error' => 'Missing event_name'], 422);
        }

        // Ignore events triggered on administrative pages
        $adminPrefix = trim(config('app.admin_prefix', env('ADMIN_PREFIX', 'ox-secure-cp')), '/');
        $checkUrl = $pageUrl ?? $request->header('referer', '');
        if (
            str_contains($checkUrl, $adminPrefix) ||
            str_contains($checkUrl, '/admin') ||
            str_contains($checkUrl, 'ox-secure-cp')
        ) {
            return response()->json(['ignored' => true, 'reason' => 'admin_page']);
        }

        $sessionId = $request->hasSession() ? $request->session()->getId() : md5($request->ip().$request->userAgent());

        TrafficEvent::create([
            'session_id' => mb_substr($sessionId, 0, 80),
            'event_name' => mb_substr($eventName, 0, 80),
            'page_url' => mb_substr($pageUrl ?? $request->header('referer', ''), 0, 500) ?: null,
            'event_data' => is_array($data) ? $data : null,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Toggle the exclusion cookie for the admin's device.
     */
    public function toggleExcludeAdmin(Request $request): JsonResponse
    {
        $current = $request->cookie('ox_admin_device', '1');
        $newVal = $current === '1' ? '0' : '1';
        cookie()->queue(cookie()->forever('ox_admin_device', $newVal));
        cookie()->queue(cookie()->forever('ox_exclude_admin', $newVal));

        return response()->json([
            'success' => true,
            'is_excluded' => $newVal === '1',
            'message' => $newVal === '1'
                ? 'تم استبعاد متصفحك من إحصائيات وترافيك الزوار بنجاح.'
                : 'تم تفعيل التتبع لمتصفحك.',
        ]);
    }
}
