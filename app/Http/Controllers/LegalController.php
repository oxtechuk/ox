<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    /**
     * Display the comprehensive Privacy Policy page.
     */
    public function privacy(Request $request): View
    {
        $locale = $request->query('lang', session('locale', $request->cookie('locale', app()->getLocale() ?: 'ar')));
        if (! in_array($locale, ['ar', 'en', 'fr'], true)) {
            $locale = 'ar';
        }
        app()->setLocale($locale);

        return view('legal.privacy', [
            'locale' => $locale,
        ]);
    }
}
