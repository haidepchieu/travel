<?php

namespace App\Http\Controllers;

use App\Mail\LoginNotificationMail;
use App\Mail\RegisterWelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle Customer Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Please enter your email or phone number.',
            'password.required' => 'Please enter your password.',
        ]);

        $remember = $request->boolean('remember');

        // Allow login with either email or phone
        $user = User::where('email', $credentials['email'])
            ->orWhere('phone', $credentials['email'])
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Send login notification email to user
            try {
                if (!empty($user->email)) {
                    $ip = $request->ip() ?: '127.0.0.1';
                    $userAgent = $request->userAgent() ?: 'Web browser';
                    Mail::to($user->email)->send(new LoginNotificationMail($user, $ip, $userAgent));
                }
            } catch (\Throwable $e) {
                Log::error('Failed to send login notification email: ' . $e->getMessage());
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Signed in successfully!',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ],
                ]);
            }

            return redirect()->intended('/')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Incorrect email/phone number or password.',
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Incorrect email/phone number or password.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle Customer Registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.string' => 'Please enter a valid name.',
            'name.max' => 'Your name may not exceed 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address (e.g. example@gmail.com).',
            'email.unique' => 'An account with this email already exists. Please switch to the "SIGN IN" tab or use a different email.',
            'phone.max' => 'Your phone number may not exceed 30 characters.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // Send welcome email to newly registered user
        try {
            if (!empty($user->email)) {
                Mail::to($user->email)->send(new RegisterWelcomeMail($user));
            }
        } catch (\Throwable $e) {
            Log::error('Failed to send welcome email: ' . $e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Your account has been created successfully!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ]);
        }

        return redirect('/')->with('success', 'Your account has been created successfully! Welcome, ' . $user->name);
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect('/')->with('info', 'You have been signed out.');
    }
}
