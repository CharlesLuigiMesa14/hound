<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegistrationController extends Controller
{
    // Show the admin registration form
    public function create()
    {
        return view('admin.register'); // Adjust the path as necessary
    }

    // Handle the registration request
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string', // Ensure role is selected
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'lname' => $request->lname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Save the selected role
        ]);

        // Optionally log in the user or redirect to a specific page
        // Auth::login($user);

        return redirect()->route('admin.register')->with('success', 'Admin registered successfully!');
    }
}