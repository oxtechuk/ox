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

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();

            return redirect()->route('admin.login')->with('error', 'تم تعطيل هذا الحساب.');
        }

        if (! method_exists($user, 'isAdmin') || ! $user->isAdmin()) {
            abort(403, 'غير مصرح لك بالوصول إلى لوحة التحكم الإدارية.');
        }

        return $next($request);
    }
}
