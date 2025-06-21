<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // تحقق من تسجيل الدخول ومن أن role = 1
        if (Auth::check() && Auth::user()->role == 1) {
            return $next($request);
        }
        // إذا لم يكن مديرًا
        return redirect()->route('/login')->with('error', 'ليس لديك صلاحية للوصول إلى لوحة التحكم.');
    }
}
