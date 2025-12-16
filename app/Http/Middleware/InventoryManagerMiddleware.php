<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role_as == '2') { // Inventory Manager
                return $next($request);
            } else {
                return redirect('/home')->with('status', 'Access Denied! You do not have inventory manager privileges.');
            }
        }
        return redirect('/home')->with('status', 'Please Login First');
    }
}