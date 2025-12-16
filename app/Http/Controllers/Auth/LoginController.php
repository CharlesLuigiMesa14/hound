<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\User; // Ensure to import the User model

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Handle login request
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Update the user's activity status
            $user = Auth::user();
            $user->is_active = true; // Set user as online
            $user->last_active_at = now(); // Set current timestamp
            $user->save(); // Save changes

            return $this->authenticated($request, $user);
        }

        return $this->sendFailedLoginResponse($request);
    }

    // Redirect based on user role after authentication
    protected function authenticated(Request $request, $user)
    {
        switch ($user->role_as) {
            case '1': // Admin
                return redirect('dashboard')->with('status', 'Welcome to your dashboard, Admin ' . $user->name);
            case '2': // Inventory Manager
                return redirect('inventory-dashboard')->with('status', 'Welcome to your Inventory dashboard, ' . $user->name);
            case '3': // Order Manager
                return redirect('orders-dashboard')->with('status', 'Welcome to your Orders dashboard, ' . $user->name);
            case '4': // Marketing Manager
                return redirect('marketing-dashboard')->with('status', 'Welcome to your Marketing dashboard, ' . $user->name);
            case '5': // Store Manager
                return redirect('storemanager-dashboard')->with('status', 'Welcome to your Store dashboard, ' . $user->name);
            default:
                return redirect('/')->with('status', 'Logged in successfully, ' . $user->name);
        }
    }

    // Override the sendFailedLoginResponse method
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [];

        // Check if the email is valid
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Please enter a valid email address.';
        } else {
            // Check if the user exists
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                $errors['email'] = 'No account found with this email address.';
            } elseif (!Auth::attempt($request->only('email', 'password'))) {
                // Check if the password is incorrect
                $errors['password'] = 'The provided password is incorrect.';
            }
        }

        // Return errors if any
        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput($request->only('email', 'remember'));
        }

        throw ValidationException::withMessages(['email' => 'The provided credentials are incorrect.']);
    }

    // Validate the login request
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    }

    // Override the logout method
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->is_active = false; // Set to offline
            $user->last_active_at = now(); // Update last active timestamp
            $user->save(); // Save changes
        }

        Auth::logout();
        return redirect('/login'); // Change to your desired route
    }
}