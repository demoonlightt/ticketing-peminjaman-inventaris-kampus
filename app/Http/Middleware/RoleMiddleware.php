<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            // Check status, if suspended, block access
            if ($user->status === 'suspended') {
                Auth::logout();
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Akun Anda sedang ditangguhkan (suspended).'], 403);
                }
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda sedang ditangguhkan (suspended).'
                ]);
            }
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke halaman ini.'], 403);
        }

        // Redirect authenticated users to their respective dashboards instead of throwing a raw 403 page
        $redirectRoute = match ($user->role) {
            'admin' => 'admin.dashboard',
            'officer' => 'officer.dashboard',
            'student' => 'student.dashboard',
            default => 'login',
        };

        if ($redirectRoute === 'login') {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Role tidak valid.'
            ]);
        }

        return redirect()->route($redirectRoute)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}
