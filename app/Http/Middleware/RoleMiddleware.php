<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Check for Admin (1), Inventory Manager (2), Order Manager (3), Marketing Manager (4), or Store Manager (5)
            if (in_array($user->role_as, ['1', '2', '3', '4', '5'])) {
                return $next($request);
            } else {
                return redirect('/home')->with('status', 'Access Denied! You do not have the required privileges.');
            }
        }
        return redirect('/home')->with('status', 'Please Login First');
    }
}