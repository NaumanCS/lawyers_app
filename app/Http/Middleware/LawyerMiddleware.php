<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LawyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 'lawyer') {
            return $next($request);
        } else if ((Auth::user()->role !== 'lawyer')) {
            return redirect()->back()->with('error', 'You do not have access of this page');
        } else {
            return redirect('/login');
        }
    }
}
