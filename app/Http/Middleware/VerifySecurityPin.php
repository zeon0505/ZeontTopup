<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class VerifySecurityPin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Only enforce for admins
        if ($user && $user->is_admin) {
            
            // 1. Check if PIN is set
            if (empty($user->security_pin)) {
                // If on dashboard or admin pages, redirect to profile to SET PIN
                if ($request->is('admin*') && !$request->is('profile')) {
                    return redirect()->route('profile')->with('warning', 'Harap setel Security PIN Anda terlebih dahulu untuk mengakses Dashboard Admin.');
                }
            }

            // 2. Check if PIN is verified in session
            // We skip verification for the verification route itself to avoid loop
            if (!empty($user->security_pin) && !Session::get('admin_pin_verified')) {
                if ($request->is('admin*') && !$request->is('admin/verify-pin')) {
                    return redirect()->route('admin.pin.verify');
                }
            }
        }

        return $next($request);
    }
}
