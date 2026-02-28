<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login page.
     */
    public function showLogin()
    {
        // If already logged in, redirect based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole(Auth::user());
        }

        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Show the registration page.
     */
    public function showRegister()
    {
        // If already logged in, redirect based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.register');
    }

    /**
     * Handle student registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create new student user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'student', // Always register as student
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to student dashboard
        return redirect()->route('student.dashboard')
            ->with('success', 'স্বাগতম! আপনি সফলভাবে নিবন্ধিত হয়েছেন।');
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'logout-success');
    }

    /**
     * Display the password reset link request view.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a password reset link to the user.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     */
    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle the password reset request.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        // Reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole($user)
    {
        return match($user->role) {
            'admin' => redirect('/admin'),
            'instructor' => redirect('/instructor'),
            'student' => redirect('/student/dashboard'),
            default => redirect('/'),
        };
    }
}
