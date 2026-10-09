<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /**
     * Customer Account Dashboard
     */
    public function index()
    {
        $user = Auth::user();
        $bookings = $user->bookings()->with('tour')->latest()->get();

        return view('my-account', compact('user', 'bookings'));
    }

    /**
     * Update Profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'current_password' => ['nullable', 'required_with:new_password'],
            'new_password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Please enter your full name.',
            'current_password.required_with' => 'Please enter your current password to set a new one.',
            'new_password.min' => 'Your new password must be at least 6 characters.',
            'new_password.confirmed' => 'The new password confirmation does not match.',
        ]);

        if (!empty($validated['new_password'])) {
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
            }
            $user->password = Hash::make($validated['new_password']);
        }

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->save();

        return back()->with('success', 'Your account details have been updated!');
    }
}
