<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Check if the email already exists
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            // IMPORTANT: Check if the user was registered via Google
            // This distinguishes between local registrations and Google registrations,
            // providing the user with the correct guidance on how to proceed.
            if ($user->auth_provider === 'google') {
                return back()->withErrors([
                    'email' => 'This email is already registered through Google. Please sign in using Google.',
                ]);
            }
            // Return standard email taken error if not from Google
            return back()->withErrors([
                'email' => 'The email address is already taken.',
            ]);
        }
    
        $user = User::create([
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'auth_provider' => 'local', // Default to 'local'
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME);
    }
}