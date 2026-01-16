<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\SiteSetting;

class CheckMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if maintenance mode is enabled
        if (SiteSetting::get('maintenance_mode') === '1') {
            // Allow access to admin and login pages
            if ($request->is('admin*') || $request->is('login') || $request->is('logout') || $request->is('register')) {
                return $next($request);
            }

            // Also allow access if user is admin
            if (auth()->check() && auth()->user()->is_admin) {
                return $next($request);
            }

            // Redirect to maintenance page
            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}
