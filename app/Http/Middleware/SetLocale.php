<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            app()->setLocale(auth()->user()->language ?? session('locale', 'EN'));
        } elseif ($locale = $request->session()->get('locale')) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
