<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketingManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role_as == '4') { // Check if the user is a Marketing Manager
            return $next($request);
        }

        return redirect('/home')->with('status', 'Access Denied! You do not have Marketing Manager privileges.');
    }
}