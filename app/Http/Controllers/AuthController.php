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
            'email.required' => 'Vui lòng nhập email hoặc số điện thoại của bạn.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
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
                    $userAgent = $request->userAgent() ?: 'Trình duyệt web';
                    Mail::to($user->email)->send(new LoginNotificationMail($user, $ip, $userAgent));
                }
            } catch (\Throwable $e) {
                Log::error('Lỗi gửi email thông báo đăng nhập: ' . $e->getMessage());
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công!',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ],
                ]);
            }

            return redirect()->intended('/')->with('success', 'Chào mừng ' . $user->name . ' trở lại!');
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Email/Số điện thoại hoặc mật khẩu không chính xác.',
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
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
            'name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'name.string' => 'Họ và tên không hợp lệ.',
            'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng (VD: example@gmail.com).',
            'email.unique' => 'Địa chỉ email này đã có tài khoản trên hệ thống. Bạn vui lòng chuyển sang tab "ĐĂNG NHẬP" hoặc dùng email khác.',
            'phone.max' => 'Số điện thoại không được vượt quá 30 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có tối thiểu 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không trùng khớp với mật khẩu đã nhập.',
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
            Log::error('Lỗi gửi email chào mừng đăng ký tài khoản: ' . $e->getMessage());
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký tài khoản thành công!',
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ]);
        }

        return redirect('/')->with('success', 'Đăng ký tài khoản thành công! Chào mừng ' . $user->name);
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

        return redirect('/')->with('info', 'Bạn đã đăng xuất.');
    }
}
