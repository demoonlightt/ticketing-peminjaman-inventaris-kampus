<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\MahasiswaProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    /**
     * Redirect to Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google.
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Find or create the user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'email' => $googleUser->getEmail(),
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(),
                    'provider' => 'google',
                    'avatar' => $googleUser->getAvatar(),
                    // Generate a random password since they login via Google
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'student',
                    'status' => 'active',
                ]);
            } else {
                // Update Google credentials without overwriting manual password
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'provider' => 'google',
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }

            // Ensure profile exists if they are a student
            if ($user->role === 'student') {
                MahasiswaProfile::firstOrCreate([
                    'user_id' => $user->id
                ], [
                    'nim' => 'G-' . substr($googleUser->getId() ?? rand(100000, 999999), -10),
                    'prodi' => 'Belum Diatur',
                    'fakultas' => 'Belum Diatur',
                    'angkatan' => date('Y'),
                ]);
            }

            Auth::login($user);

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isOfficer()) {
                return redirect()->route('officer.dashboard');
            } else {
                return redirect()->route('student.dashboard');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal login menggunakan akun Google Anda: ' . $e->getMessage()
            ]);
        }
    }
}
