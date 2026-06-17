<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\MahasiswaProfile;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Process login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->status === 'suspended') {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda sedang ditangguhkan (suspended).'
                ]);
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Show registration form for students.
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.register');
    }

    /**
     * Process registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'nim' => 'required|string|max:20|unique:mahasiswa_profiles,nim',
            'email' => 'required|email|max:150|unique:users,email',
            'password' => 'required|string|min:8',
        ], [
            'nim.unique' => 'NIM sudah terdaftar di sistem.',
            'email.unique' => 'Email sudah terdaftar di sistem.',
            'password.min' => 'Password minimal harus terdiri dari 8 karakter.'
        ]);

        // Create User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'active',
        ]);

        // Create Student Profile
        MahasiswaProfile::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'prodi' => 'Belum Diatur',
            'fakultas' => 'Belum Diatur',
            'angkatan' => date('Y'),
        ]);

        Auth::login($user);

        return redirect()->route('student.dashboard')->with('success', 'Registrasi berhasil! Selamat datang di SIPINJAM.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil log out.');
    }

    /**
     * Helper method to redirect based on user role.
     */
    private function redirectBasedOnRole($user)
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isOfficer()) {
            return redirect()->route('officer.dashboard');
        } else {
            return redirect()->route('student.dashboard');
        }
    }

    /**
     * Show the forgot password request view.
     */
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view for the given token.
     */
    public function showResetPassword(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', __($status))
                    : back()->withErrors(['email' => __($status)]);
    }
}
