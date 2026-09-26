<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'يرجى تسجيل الدخول للوصول إلى لوحة التحكم.');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();

            return redirect()->route('admin.login')->with('error', 'تم تعطيل هذا الحساب.');
        }

        return $next($request);
    }
}
