<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Exception;

class SocialiteController extends Controller
{
    public function authProviderRedirect($provider) {
        if ($provider) {
            return Socialite::driver($provider)->redirect();
        }
        abort(404);
    }

    public function socialAuthentication($provider) {
        try {
            // Check if 'code' is present in the request
            if (!request()->has('code')) {
                // Handle cancellation
                return redirect('login')->with('message', 'Authentication was canceled.');
            }

            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('auth_provider_id', $socialUser->id)->first();
            
            if ($user) {
                Auth::login($user);
            } else {
                $userData = User::create([
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'password' => Hash::make('Password@1234'), // Use a better strategy for passwords
                    'auth_provider_id' => $socialUser->id,
                    'auth_provider' => $provider,
                ]);

                if ($userData) {
                    Auth::login($userData);
                }
            }

            return redirect('/');
        } catch (Exception $e) {
            \Log::error($e);
            return redirect('/')->with('error', 'An error occurred during authentication.');
        }
    }
}