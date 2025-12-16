<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role_as == '5') { // Check if the user is a Store Manager
                return $next($request);
            }
            return redirect('/home')->with('status', 'Access Denied! You do not have the required privileges.');
        }
        return redirect('/home')->with('status', 'Please Login First');
    }
}