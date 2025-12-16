<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterAdminController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_as' => ['required', 'integer', 'in:2,3,4,5'], // Validate role_as values
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role_as' => $data['role_as'], // Save role_as
        ]);
    }

    protected function registered(Request $request, $user)
    {
        Auth::login($user); // Log in the user

        switch ($user->role_as) {
            case 2:
                return redirect('inventory-dashboard')->with('status', 'Welcome to your Inventory dashboard, ' . $user->name);
            case 3:
                return redirect('orders-dashboard')->with('status', 'Welcome to your Orders dashboard, ' . $user->name);
            case 4:
                return redirect('marketing-dashboard')->with('status', 'Welcome to your Marketing dashboard, ' . $user->name);
            case 5:
                return redirect('storemanager-dashboard')->with('status', 'Welcome to your Store dashboard, ' . $user->name);
            default:
                return redirect('home')->with('status', 'Welcome, ' . $user->name);
        }
    }
}