<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $role
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Jika belum login
        if (!$user) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        // Jika role tidak sesuai
        if ($user->role !== $role) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        return $next($request);
    }
}
