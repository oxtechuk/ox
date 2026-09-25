<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported application locales.
     *
     * @var array<string>
     */
    protected array $supportedLocales = ['ar', 'en', 'fr'];

    /**
     * Handle an incoming request and set application locale.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        // 1. Check query parameter e.g. ?lang=en
        if ($request->has('lang') && in_array($request->query('lang'), $this->supportedLocales, true)) {
            $locale = $request->query('lang');
            session(['locale' => $locale]);
            cookie()->queue('locale', $locale, 60 * 24 * 365);
        }

        // 2. Check session
        if (! $locale && session()->has('locale') && in_array(session('locale'), $this->supportedLocales, true)) {
            $locale = session('locale');
        }

        // 3. Check cookie
        if (! $locale && $request->hasCookie('locale') && in_array($request->cookie('locale'), $this->supportedLocales, true)) {
            $locale = $request->cookie('locale');
            session(['locale' => $locale]);
        }

        // 4. Default fallback
        if (! $locale) {
            $locale = 'ar';
        }

        app()->setLocale($locale);

        $response = $next($request);

        return $response;
    }
}
