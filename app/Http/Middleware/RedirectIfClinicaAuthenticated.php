<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfClinicaAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('clinica')->check()) {
            return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
