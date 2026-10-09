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

        $baseQuery = VisitorTraffic::humans()->where('created_at', '>=', $startDate);

        // 1. KPI Stats
        $totalPageviews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->distinct('session_id')->count('session_id');
        $liveVisitors = VisitorTraffic::humans()
            ->where('created_at', '>=', now()->subMinutes(10))
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

                $hQuery = VisitorTraffic::humans()->whereBetween('created_at', [$hStart, $hEnd]);
                $chartPageviews[] = (clone $hQuery)->count();
                $chartVisitors[] = (clone $hQuery)->distinct('session_id')->count('session_id');
            }
        } else {
            for ($i = $loopDays - 1; $i >= 0; $i--) {
                $targetDate = now()->subDays($i);
                $chartLabels[] = $targetDate->locale('ar')->isoFormat('D MMM');
                $dStart = (clone $targetDate)->startOfDay();
                $dEnd = (clone $targetDate)->endOfDay();

                $dQuery = VisitorTraffic::humans()->whereBetween('created_at', [$dStart, $dEnd]);
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
            ->whereNotNull('country_code')
            ->select('country_code', DB::raw('count(*) as count'))
            ->groupBy('country_code')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $countryDictionary = [
            'sa' => 'السعودية',
            'ae' => 'الإمارات',
            'eg' => 'مصر',
            'kw' => 'الكويت',
            'qa' => 'قطر',
            'om' => 'عمان',
            'bh' => 'البحرين',
            'jo' => 'الأردن',
            'de' => 'ألمانيا',
            'gb' => 'بريطانيا',
            'us' => 'الولايات المتحدة',
        ];

        $topCountries = $countriesRaw->map(function ($c) use ($countryDictionary, $totalPageviews) {
            $code = strtolower($c->country_code);

            return [
                'code' => $code,
                'name' => $countryDictionary[$code] ?? strtoupper($code),
                'flag_url' => file_exists(public_path("assets/flags/{$code}.webp")) ? asset("assets/flags/{$code}.webp") : null,
                'count' => $c->count,
                'percentage' => $totalPageviews > 0 ? round(($c->count / $totalPageviews) * 100, 1) : 0,
            ];
        });

        // 7. Tracking Pixels Integration Status
        $pixels = TrackingPixel::all()->keyBy('platform');

        // 8. Recent Live Traffic Log
        $recentVisits = VisitorTraffic::humans()->latest('id')->take(10)->get();

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
            'recentVisits'
        ));
    }

    public function recordEvent(Request $request): JsonResponse
    {
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

        $sessionId = $request->hasSession() ? $request->session()->getId() : md5($request->ip().$request->userAgent());

        TrafficEvent::create([
            'session_id' => mb_substr($sessionId, 0, 80),
            'event_name' => mb_substr($eventName, 0, 80),
            'page_url' => mb_substr($pageUrl ?? $request->header('referer', ''), 0, 500) ?: null,
            'event_data' => is_array($data) ? $data : null,
        ]);

        return response()->json(['success' => true]);
    }
}
