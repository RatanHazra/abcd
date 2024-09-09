<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If user is not logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        // Super Admin
        if ($userRole == 3) {
            return $next($request);
        }
        // Admin
        elseif ($userRole == 2) {
            return redirect()->route('admin.dashboard');
        }
        // User
        elseif ($userRole == 1) {
            return redirect()->route('dashboard');
        }
    }
}
