<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_as == '3') { // Check if the user is an Order Manager
            return $next($request);
        }

        return redirect('/home')->with('status', 'Access Denied! You do not have Order manager privileges.');
    }
}