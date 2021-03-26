<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUsersController extends Controller
{
    // Admin users index route
    public function index()
    {
        // When a query is given search by query
        $query = request('q');
        if ($query != null) {
            $users = User::search($query)->get();
        } else {
            $users = User::all();
        }
        $users = $users->sortBy(User::sortByName(), SORT_NATURAL | SORT_FLAG_CASE)
            ->paginate(config('pagination.web.limit'))->withQueryString();

        // Return admin users index view
        return view('admin.users.index', ['users' => $users]);
    }

    // Admin users store route
    public function store(Request $request)
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
            'password' => 'required|min:6|confirmed',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Create user
        $user = User::create([
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
            'role' => $fields['role']
        ]);

        // Go to the new admin user show page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users show route
    public function show(User $user)
    {
        return view('admin.users.show', [ 'user' => $user ]);
    }

    // Admin users edit route
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user, 'countries' => User::COUNTRIES]);
    }

    // Admin users hijack route
    public function hijack(User $user)
    {
        // Login as the user
        Auth::login($user, true);

        // Go to the home page
        return redirect()->route('home');
    }

    // Admin users update route
    public function update(Request $request, User $user)
    {
        // Validate input
        $fields = $request->validate([
            'firstname' => 'required|min:2|max:48',
            'insertion' => 'nullable|max:16',
            'lastname' => 'required|min:2|max:48',
            'gender' => 'required|integer|digits_between:' . User::GENDER_MALE . ',' . User::GENDER_OTHER,
            'birthday' => 'required|date',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->email, 'email')
            ],
            'phone' => 'nullable|max:255',
            'address' => 'required|min:2|max:255',
            'postcode' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'country' => 'required|min:2|max:255',
            'role' => 'required|integer|digits_between:' . User::ROLE_NORMAL . ',' . User::ROLE_ADMIN
        ]);

        // Update user
        $user->update([
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
            'role' => $fields['role']
        ]);

        // Update user password when not empty
        if (request('password') != '') {
            $fields = $request->validate([
                'password' => 'required|min:6|confirmed'
            ]);

            $user->update([
                'password' => Hash::make($fields['password'])
            ]);
        }

        // Go to the admin user show page
        return redirect()->route('admin.users.show', $user);
    }

    // Admin users delete route
    public function delete(User $user)
    {
        // Delete user
        $user->delete();

        // Go to the users index page
        return redirect()->route('admin.users.index');
    }
}
