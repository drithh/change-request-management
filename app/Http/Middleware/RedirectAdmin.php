<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('filament.admin.pages.dashboard');
            } else if (Auth::user()->is_verified) {
                return $next($request);
            } else {
                abort(403, "Your account is not verified.");
            }
        }
        return $next($request);
    }
}
