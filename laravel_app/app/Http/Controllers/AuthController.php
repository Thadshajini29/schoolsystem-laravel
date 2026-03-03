<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_name' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'user_name' => 'The provided credentials do not match our records.',
        ])->onlyInput('user_name');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'user_name' => ['required', 'string', 'max:255', 'unique:users,user_name', 'alpha_dash'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'user_name' => $validated['user_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            // 'password' => $validated['password'], // Store as plain text for demonstration (not recommended for production)
            'role' => 'student', // Default role assignment
        ]);

        // Do not auto-login
        // Auth::login($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please login to continue.');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        // In a production environment, you would send an actual email here
        // For now, we'll just send a success message
        // You can use Laravel's built-in password reset functionality or implement your own

        return back()->with('status', 'Password reset link has been sent to your email address!');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // In a production environment, you would verify the token and update the password
        // For demonstration, we'll just show success message

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('login')->with('success', 'Password has been reset successfully! Please login with your new password.');
        }

        return back()->withErrors(['email' => 'Unable to reset password. Please try again.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
