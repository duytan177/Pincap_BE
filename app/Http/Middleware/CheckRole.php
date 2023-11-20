<?php

namespace App\Http\Middleware;

use App\Enums\User\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *

     */
    public function handle(Request $request, Closure $next)
    {
        $userRole = $request->role;

        // Kiểm tra vai trò của người dùng
        if (Role::getValue($userRole) == "0") {
            return $next($request);
        } else {
            return response()->json(['message' => 'You are not ADMIN'], 403);
        }
    }
}
