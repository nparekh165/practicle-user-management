<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        $search = $request->input('search');
        if ( !empty( $search ) ) {
            $query->where('first_name', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);

        return view('users.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'addresses.*.address_type' => 'required|in:home,work,office',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.country' => 'required|string',
        ]);

        $user = User::create($request->only(['first_name', 'last_name', 'dob', 'gender', 'mobile']));

        foreach ($request->addresses as $address) {
            $user->addresses()->create($address);
        }

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $user->load('addresses');
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'addresses.*.address_type' => 'required|in:home,work,office',
            'addresses.*.city' => 'required|string',
            'addresses.*.state' => 'required|string',
            'addresses.*.country' => 'required|string',
        ]);

        $user->update($request->only(['first_name', 'last_name', 'dob', 'gender', 'mobile']));

        $user->addresses()->delete(); // simple re-create strategy

        if(!empty($request->addresses))
        {
            foreach ($request->addresses as $address) {
                $user->addresses()->create($address);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}

