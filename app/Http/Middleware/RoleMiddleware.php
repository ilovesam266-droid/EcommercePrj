<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

use function Laravel\Prompts\info;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role  // role cần kiểm tra
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $role = null): Response
    {
        // Kiểm tra người dùng đã đăng nhập
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        // Log::info('User role: ' . ($user ? $user->role : 'null'));
        // Kiểm tra role
        if ($user->role->value !== $role) {
            return response()->json([
                'message' => 'Forbidden. You do not have the required role.'
            ], 403);
        }


        return $next($request);
    }
}
