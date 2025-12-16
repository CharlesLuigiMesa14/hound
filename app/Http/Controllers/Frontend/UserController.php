<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display all orders for the authenticated user
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view("frontend.orders.index", compact('orders'));
    }

    // View a specific order
    public function view($id)
    {
        $orders = Order::where('id', $id)->where('user_id', Auth::id())->first();
        return view('frontend.orders.view', compact('orders'));
    }

    // Show all users (customers and admins)
    public function showUsers()
    {
        $customers = User::where('role_as', 0)->get(); // Role 0 for customers
        $admins = User::where('role_as', '>', 0)->get(); // Roles 1-5 for admins
        return view('admin.users.index', compact('customers', 'admins'));
    }

    // Display user profile
    public function profile()
    {
        $user = Auth::user();
        return view('frontend.profile.index', compact('user'));
    }

    // Update user profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address1' => 'nullable|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'pincode' => 'nullable|string|max:10',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                $oldImagePath = public_path('assets/uploads/userprofile/' . $user->profile_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/userprofile'), $filename);
            $user->profile_image = $filename;
        }

        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address1 = $request->address1;
        $user->address2 = $request->address2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->pincode = $request->pincode;
        $user->save();

        return redirect()->route('profile.index')->with('status', 'Profile updated successfully!');
    }

    // Display the admin profile
    public function adminProfile()
    {
        $adminUser = Auth::user();
        return view('layouts.inc.profileadmin', compact('adminUser'));
    }

    // Update the admin profile
    public function updateAdminProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $adminUser = Auth::user();

        if ($request->hasFile('profile_image')) {
            if ($adminUser->profile_image) {
                $oldImagePath = public_path('assets/uploads/userprofile/' . $adminUser->profile_image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $file = $request->file('profile_image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/uploads/userprofile'), $filename);
            $adminUser->profile_image = $filename;
        }

        $adminUser->name = $request->name;
        $adminUser->lname = $request->lname;
        $adminUser->email = $request->email;
        $adminUser->phone = $request->phone;
        $adminUser->save();

        return redirect()->route('profile.admin')->with('status', 'Profile updated successfully!');
    }

    // Change user password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.admin')->with('status', 'Password changed successfully!');
    }

    // Validate current password via AJAX
    public function validateCurrentPassword(Request $request)
    {
        $request->validate(['current_password' => 'required|string']);

        $user = Auth::user();
        if (Hash::check($request->current_password, $user->password)) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false], 403);
    }

    // Change user role
    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|integer|between:0,5',
        ]);

        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->role_as = $request->role;
        $user->save();

        return response()->json(['message' => 'Role changed successfully.']);
    }

    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register'); // Adjust the view path as needed
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->lname = $request->lname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Optional: Automatically log the user in after registration
        Auth::login($user);

        return redirect()->route('home')->with('status', 'Registration successful! You are now logged in.');
    }

    // Change user email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'new_email' => 'required|email|unique:users,email',
            'current_password' => 'required',
        ]);

        $user = Auth::user();

        // Check if the provided password matches the authenticated user's password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        // Update email
        $user->email = $request->new_email;
        $user->email_verified_at = null; // Set email_verified_at to null for re-verification
        $user->save();

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        return back()->with('status', 'Email updated successfully. Please verify your new email address.');
    }
    public function validatePassword(Request $request)
{
    $request->validate(['password' => 'required|string']);

    $user = auth()->user(); // Get the authenticated user
    if (Hash::check($request->password, $user->password)) {
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}

public function changeEmail(Request $request)
{
    $request->validate(['email' => 'required|email|unique:users,email']);
    
    $user = auth()->user();
    $user->email = $request->email;
    $user->save();

    return response()->json(['success' => true]);
}
}