<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = NULL)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->role == "admin") {
                return redirect("/super_admin/dashboard");
            } else if (Auth::user()->role == "wadir") {
                return redirect("/wadir/dashboard");
            } else if (Auth::user()->role == "ormawa") {
                return redirect("/ormawa/dashboard");
            }
        }

        return $next($request);
    }
}
