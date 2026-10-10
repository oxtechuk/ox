<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Models\VisitorTraffic;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitorTraffic
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    /**
     * Perform any final actions after the response has been sent to the browser.
     */
    public function terminate(Request $request, Response $response): void
    {
        // Only track successful GET HTML requests
        if ($request->method() !== 'GET' || $response->getStatusCode() >= 400) {
            return;
        }

        // Exclude admin routes, authenticated admins, and admin-tagged devices
        if ($this->shouldExcludeRequest($request)) {
            return;
        }

        try {
            $userAgent = $request->userAgent() ?? '';
            $isBot = $this->detectBot($userAgent);

            // Determine referer & source
            $referer = $request->header('referer');
            $source = $this->classifyRefererSource($referer, $request->query('utm_source'));

            // Device, browser, and platform
            $deviceType = $this->detectDevice($userAgent);
            $browser = $this->detectBrowser($userAgent);
            $platform = $this->detectPlatform($userAgent);

            // Session identification
            $sessionId = $request->hasSession() ? $request->session()->getId() : md5($request->ip().$userAgent);

            // Anonymized IP
            $ip = $request->ip();
            $anonymizedIp = $ip ? preg_replace('/(\.\d+)$/', '.0', $ip) : null;

            // Route & Path
            $path = mb_substr($request->path(), 0, 190);
            $routeName = $request->route() ? mb_substr($request->route()->getName() ?? '', 0, 80) : null;

            // Associate with Project if on project show page
            $projectId = null;
            if ($routeName === 'projects.show' && $request->route('slug')) {
                $slug = $request->route('slug');
                $project = Project::where('slug', $slug)->first();
                $projectId = $project?->id;
            }

            // Detect visitor country (Cloudflare / CDN headers / Accept-Language / GeoIP)
            [$countryCode, $countryName] = $this->detectCountry($request);

            VisitorTraffic::create([
                'session_id' => mb_substr($sessionId, 0, 80),
                'ip_address' => $anonymizedIp,
                'url' => mb_substr($request->fullUrl(), 0, 500),
                'path' => $path,
                'route_name' => $routeName,
                'project_id' => $projectId,
                'referer' => $referer,
                'referer_source' => $source,
                'utm_source' => mb_substr($request->query('utm_source', ''), 0, 80) ?: null,
                'utm_medium' => mb_substr($request->query('utm_medium', ''), 0, 80) ?: null,
                'utm_campaign' => mb_substr($request->query('utm_campaign', ''), 0, 80) ?: null,
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
                'country_code' => $countryCode ?: null,
                'country_name' => $countryName ?: null,
                'is_bot' => $isBot,
            ]);
        } catch (\Throwable $e) {
            // Silently ignore tracking errors to protect user traffic
        }
    }

    /**
     * Determine if the request should be excluded from visitor tracking.
     */
    protected function shouldExcludeRequest(Request $request): bool
    {
        // 1. Exclude logged-in admin users
        if (\Illuminate\Support\Facades\Auth::check()) {
            $user = \Illuminate\Support\Facades\Auth::user();
            if ((method_exists($user, 'isAdmin') && $user->isAdmin()) || ($user->role ?? null) === 'admin' || $user->is_active) {
                return true;
            }
        }

        // 2. Exclude browsers tagged as admin or developer devices
        if (
            $request->cookie('ox_admin_device') === '1' ||
            $request->cookie('ox_exclude_admin') === '1' ||
            ($request->hasSession() && $request->session()->get('is_admin_session'))
        ) {
            return true;
        }

        // 3. Exclude administrative path prefixes and system endpoints
        $adminPrefix = trim(config('app.admin_prefix', env('ADMIN_PREFIX', 'ox-secure-cp')), '/');

        if ($request->is(
            $adminPrefix,
            $adminPrefix.'/*',
            'ox-secure-cp',
            'ox-secure-cp/*',
            'admin',
            'admin/*',
            'api/admin*',
            'login*',
            'register*',
            'logout*',
            'assets/*',
            'storage/*',
            'up',
            '_debugbar*',
            'favicon*',
            'checkout/paypal/config',
            'traffic/event'
        )) {
            return true;
        }

        // 4. Exclude named admin routes
        if ($request->route() && str_starts_with($request->route()->getName() ?? '', 'admin.')) {
            return true;
        }

        return false;
    }

    /**
     * Detect visitor country from headers, language, or IP lookup.
     *
     * @return array{0: ?string, 1: ?string}
     */
    protected function detectCountry(Request $request): array
    {
        // 1. Check Cloudflare & CDN headers
        $headerCode = $request->header('CF-IPCountry')
            ?: $request->header('X-Country-Code')
            ?: $request->header('X-Forwarded-Country')
            ?: $request->header('GEOIP_COUNTRY_CODE')
            ?: $request->server('GEOIP_COUNTRY_CODE');

        if ($headerCode && is_string($headerCode)) {
            $code = strtolower(trim($headerCode));
            if (strlen($code) === 2 && ctype_alpha($code) && $code !== 'xx' && $code !== 't1') {
                return [$code, $this->resolveCountryName($code)];
            }
        }

        // 2. Browser Accept-Language region code (e.g. "ar-SA" => "sa", "ar-EG" => "eg", "en-US" => "us")
        $acceptLang = $request->header('Accept-Language', '');
        if ($acceptLang && preg_match('/[a-z]{2}-([a-zA-Z]{2})/i', $acceptLang, $matches)) {
            $code = strtolower($matches[1]);
            if (strlen($code) === 2 && ctype_alpha($code)) {
                return [$code, $this->resolveCountryName($code)];
            }
        }

        // 3. Default for Arabic browser locale without country (e.g. "ar")
        if (str_starts_with(strtolower($acceptLang), 'ar')) {
            return ['sa', 'السعودية'];
        }

        return [null, null];
    }

    /**
     * Resolve Arabic display name for country code.
     */
    protected function resolveCountryName(string $code): string
    {
        $dictionary = [
            'sa' => 'السعودية',
            'eg' => 'مصر',
            'ae' => 'الإمارات',
            'kw' => 'الكويت',
            'qa' => 'قطر',
            'om' => 'عُمان',
            'bh' => 'البحرين',
            'jo' => 'الأردن',
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
            'gb' => 'المملكة المتحدة',
            'us' => 'الولايات المتحدة',
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

        return $dictionary[$code] ?? strtoupper($code);
    }

    protected function detectBot(string $ua): bool
    {
        return (bool) preg_match('/(bot|crawl|slurp|spider|mediapartners|googlebot|bingbot|yandex|duckduckbot|baiduspider|twitterbot|facebookexternalhit|rogerbot|embedly|quora link preview|showyoubot|outbrain|pinterest\/0\.|slackbot|vkShare|W3C_Validator)/i', $ua);
    }

    protected function classifyRefererSource(?string $referer, ?string $utmSource): string
    {
        if ($utmSource) {
            $u = strtolower($utmSource);
            if (str_contains($u, 'google')) {
                return 'google';
            }
            if (str_contains($u, 'meta') || str_contains($u, 'fb') || str_contains($u, 'ig') || str_contains($u, 'face') || str_contains($u, 'insta')) {
                return 'meta';
            }
            if (str_contains($u, 'tik')) {
                return 'tiktok';
            }
            if (str_contains($u, 'snap')) {
                return 'snapchat';
            }
            if (str_contains($u, 'twit') || str_contains($u, 'x')) {
                return 'twitter';
            }
            if (str_contains($u, 'what') || str_contains($u, 'wa')) {
                return 'whatsapp';
            }
        }

        if (empty($referer)) {
            return 'direct';
        }

        $r = strtolower($referer);
        if (str_contains($r, 'google.')) {
            return 'google';
        }
        if (str_contains($r, 'facebook.com') || str_contains($r, 'instagram.com') || str_contains($r, 'fb.com') || str_contains($r, 'fb.me')) {
            return 'meta';
        }
        if (str_contains($r, 'tiktok.com')) {
            return 'tiktok';
        }
        if (str_contains($r, 'snapchat.com')) {
            return 'snapchat';
        }
        if (str_contains($r, 'twitter.com') || str_contains($r, 'x.com') || str_contains($r, 't.co')) {
            return 'twitter';
        }
        if (str_contains($r, 'whatsapp') || str_contains($r, 'wa.me')) {
            return 'whatsapp';
        }

        // Check if referer is self/internal
        $host = parse_url($referer, PHP_URL_HOST);
        $currentHost = request()->getHost();
        if ($host && ($host === $currentHost || str_ends_with($host, $currentHost))) {
            return 'internal';
        }

        return 'referral';
    }

    protected function detectDevice(string $ua): string
    {
        if (preg_match('/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i', $ua)) {
            return 'tablet';
        }
        if (preg_match('/(mobile|android|iphone|ipod|blackberry|opera mini|iemobile)/i', $ua)) {
            return 'mobile';
        }

        return 'desktop';
    }

    protected function detectBrowser(string $ua): string
    {
        if (preg_match('/Edg/i', $ua)) {
            return 'Edge';
        }
        if (preg_match('/Chrome/i', $ua) && ! preg_match('/Edg/i', $ua)) {
            return 'Chrome';
        }
        if (preg_match('/Safari/i', $ua) && ! preg_match('/Chrome/i', $ua)) {
            return 'Safari';
        }
        if (preg_match('/Firefox/i', $ua)) {
            return 'Firefox';
        }
        if (preg_match('/Opera|OPR/i', $ua)) {
            return 'Opera';
        }

        return 'Other';
    }

    protected function detectPlatform(string $ua): string
    {
        if (preg_match('/iPhone|iPad|iPod/i', $ua)) {
            return 'iOS';
        }
        if (preg_match('/Android/i', $ua)) {
            return 'Android';
        }
        if (preg_match('/Windows/i', $ua)) {
            return 'Windows';
        }
        if (preg_match('/Macintosh|Mac OS X/i', $ua)) {
            return 'macOS';
        }
        if (preg_match('/Linux/i', $ua)) {
            return 'Linux';
        }

        return 'Other';
    }
}
