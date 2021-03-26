<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;

class AuthController extends Controller
{
    // Login route
    public function login(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Try to login when successfull go to home page
        if (
            Auth::attempt([
                'email' => $fields['email'],
                'password' => $fields['password']
            ], true)
        ) {
            return redirect()->route('home');
        }

        // When not successfull go back with error
        return redirect()->route('auth.login')->withInput()
            ->with('error', __('auth.login.error'));
    }

    // Register route
    public function register(Request $request)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|max:255',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'password' => 'required|min:6|confirmed'
        ]);

        // Create user
        User::create([
            'firstname' => $fields['firstname'],
            'insertion' => $fields['insertion'],
            'lastname' => $fields['lastname'],
            'gender' => $fields['gender'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'phone' => $fields['phone'],
            'address' => $fields['address'],
            'postcode' => $fields['postcode'],
            'city' => $fields['city'],
            'country' => $fields['country'],
            'password' => Hash::make($fields['password']),

            // First created account is always admin
            'role' => User::count() == 0 ? User::ROLE_ADMIN : User::ROLE_NORMAL
        ]);

        // Login user in
        Auth::attempt([
            'email' => $fields['email'],
            'password' => $fields['password']
        ], true);

        // Go to home page
        return redirect()->route('home');
    }

    // Logout route
    public function logout()
    {
        // Logout user
        Session::flush();
        Auth::logout();

        // Go to login page
        return redirect()->route('auth.login');
    }
}
