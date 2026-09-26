<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CaptureMarketingAttribution
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Capture UTM parameters if present
        $utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $hasUtm = false;

        foreach ($utmParams as $param) {
            if ($request->filled($param)) {
                $hasUtm = true;
                session()->put("attribution.{$param}", $request->query($param));
            }
        }

        // Detect platform from UTM source or Referer
        $utmSource = $request->query('utm_source', session('attribution.utm_source'));
        $referrer = $request->header('referer');

        if ($referrer && ! session()->has('attribution.referrer_url')) {
            session()->put('attribution.referrer_url', $referrer);
        }

        $platform = null;

        if ($utmSource) {
            $sourceLower = strtolower($utmSource);
            if (str_contains($sourceLower, 'snap')) {
                $platform = 'Snapchat';
            } elseif (str_contains($sourceLower, 'tik')) {
                $platform = 'TikTok';
            } elseif (str_contains($sourceLower, 'meta') || str_contains($sourceLower, 'fb') || str_contains($sourceLower, 'ig') || str_contains($sourceLower, 'face') || str_contains($sourceLower, 'insta')) {
                $platform = 'Meta Ads';
            } elseif (str_contains($sourceLower, 'goog')) {
                $platform = 'Google Ads / Search';
            } elseif (str_contains($sourceLower, 'x') || str_contains($sourceLower, 'twit')) {
                $platform = 'X (Twitter)';
            } elseif (str_contains($sourceLower, 'link')) {
                $platform = 'LinkedIn';
            } else {
                $platform = ucfirst($utmSource);
            }
        } elseif ($referrer) {
            $refLower = strtolower($referrer);
            if (str_contains($refLower, 'snapchat.com')) {
                $platform = 'Snapchat';
            } elseif (str_contains($refLower, 'tiktok.com')) {
                $platform = 'TikTok';
            } elseif (str_contains($refLower, 'facebook.com') || str_contains($refLower, 'fb.com') || str_contains($refLower, 'instagram.com')) {
                $platform = 'Meta (Instagram/Facebook)';
            } elseif (str_contains($refLower, 'google.')) {
                $platform = 'Google Organic';
            } elseif (str_contains($refLower, 'x.com') || str_contains($refLower, 'twitter.com') || str_contains($refLower, 't.co')) {
                $platform = 'X (Twitter)';
            } elseif (str_contains($refLower, 'linkedin.com')) {
                $platform = 'LinkedIn';
            } else {
                $platform = 'Direct / Organic';
            }
        }

        if ($platform && (! session()->has('attribution.platform_detected') || $hasUtm)) {
            session()->put('attribution.platform_detected', $platform);
        }

        return $next($request);
    }
}
