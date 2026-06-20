<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\MahasiswaProfile;
use App\Models\OfficerProfile;

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

    /**
     * Developer quick role switcher (local environment only).
     */
    public function devSwitchRole($role)
    {
        if (config('app.env') !== 'local') {
            abort(403, 'Fitur ini hanya dapat digunakan pada mode local development.');
        }

        if (!in_array($role, ['admin', 'officer', 'student'])) {
            return back()->with('error', 'Role tidak valid.');
        }

        $user = User::where('role', $role)->first();

        if (!$user) {
            // Auto-create developer account if not exists
            if ($role === 'admin') {
                $user = User::create([
                    'name' => 'Developer Admin',
                    'email' => 'admin@sipinjam.com',
                    'password' => Hash::make('password'),
                    'role' => 'admin',
                    'status' => 'active',
                ]);
            } elseif ($role === 'officer') {
                $user = User::create([
                    'name' => 'Developer Officer',
                    'email' => 'officer@sipinjam.com',
                    'password' => Hash::make('password'),
                    'role' => 'officer',
                    'status' => 'active',
                ]);
                OfficerProfile::create([
                    'user_id' => $user->id,
                    'employee_number' => 'NIP-DEV-999',
                    'division' => 'Operasional Dev',
                ]);
            } elseif ($role === 'student') {
                $user = User::create([
                    'name' => 'Developer Student',
                    'email' => 'student@sipinjam.com',
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => 'active',
                ]);
                MahasiswaProfile::create([
                    'user_id' => $user->id,
                    'nim' => 'NIM-DEV-999',
                    'prodi' => 'Teknik Informatika',
                    'fakultas' => 'Teknik',
                    'angkatan' => date('Y'),
                ]);
            }
        }

        Auth::login($user);
        return $this->redirectBasedOnRole($user)->with('success', 'Berhasil beralih ke hak akses: ' . strtoupper($role));
    }

    /**
     * Diagnostic tool for testing file uploads.
     */
    public function devTestUpload(Request $request)
    {
        if (config('app.env') !== 'local') {
            abort(403, 'Hanya untuk mode local development.');
        }

        $diagnostics = [];
        $diagnostics['php_version'] = PHP_VERSION;
        $diagnostics['sys_temp_dir'] = sys_get_temp_dir();
        $diagnostics['upload_tmp_dir_setting'] = ini_get('upload_tmp_dir');
        $diagnostics['upload_max_filesize'] = ini_get('upload_max_filesize');
        $diagnostics['post_max_size'] = ini_get('post_max_size');
        $diagnostics['memory_limit'] = ini_get('memory_limit');

        // Check write permission in sys_temp_dir
        $tempDir = sys_get_temp_dir();
        $testFile = $tempDir . DIRECTORY_SEPARATOR . 'test_write_' . time() . '.tmp';
        $written = @file_put_contents($testFile, 'test');
        if ($written !== false) {
            $diagnostics['sys_temp_dir_writable'] = true;
            @unlink($testFile);
        } else {
            $diagnostics['sys_temp_dir_writable'] = false;
            $diagnostics['sys_temp_dir_write_error'] = error_get_last()['message'] ?? 'Unknown error';
        }

        // Check storage/app/public write permission
        $publicDiskRoot = storage_path('app/public');
        $testStorageFile = $publicDiskRoot . DIRECTORY_SEPARATOR . 'test_write_' . time() . '.tmp';
        $writtenStorage = @file_put_contents($testStorageFile, 'test');
        if ($writtenStorage !== false) {
            $diagnostics['storage_public_writable'] = true;
            @unlink($testStorageFile);
        } else {
            $diagnostics['storage_public_writable'] = false;
            $diagnostics['storage_public_write_error'] = error_get_last()['message'] ?? 'Unknown error';
        }

        $result = null;
        if ($request->isMethod('post')) {
            try {
                $diagnostics['has_file_avatar'] = $request->hasFile('avatar');
                $diagnostics['file_avatar_raw'] = $_FILES['avatar'] ?? null;

                if ($request->hasFile('avatar')) {
                    $file = $request->file('avatar');
                    $diagnostics['uploaded_file_valid'] = $file->isValid();
                    $diagnostics['uploaded_file_error_code'] = $file->getError();
                    $diagnostics['uploaded_file_mime'] = $file->getMimeType();
                    $diagnostics['uploaded_file_client_mime'] = $file->getClientMimeType();
                    $diagnostics['uploaded_file_size'] = $file->getSize();

                    // Try validation rules
                    $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
                        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                    ]);

                    if ($validator->fails()) {
                        $diagnostics['validation_failed'] = true;
                        $diagnostics['validation_errors'] = $validator->errors()->all();
                    } else {
                        $diagnostics['validation_failed'] = false;
                        // Try saving
                        $path = $file->store('avatars', 'public');
                        $diagnostics['saved_path'] = $path;
                        $diagnostics['saved_url'] = asset('storage/' . $path);
                        $result = "Success! Saved to " . $path;
                    }
                } else {
                    $result = "No file detected under key 'avatar'.";
                }
            } catch (\Exception $e) {
                $diagnostics['exception'] = $e->getMessage();
                $diagnostics['exception_trace'] = $e->getTraceAsString();
                $result = "Failed with exception: " . $e->getMessage();
            }
        }

        $html = '<!DOCTYPE html><html><head><title>Dev Upload Test</title>';
        $html .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
        $html .= '</head><body class="bg-light p-5"><div class="container bg-white p-4 rounded shadow">';
        $html .= '<h2>Diagnostic File Upload Tool</h2>';
        if ($result) {
            $html .= '<div class="alert alert-info">Result: ' . htmlspecialchars($result) . '</div>';
        }
        $html .= '<form method="POST" enctype="multipart/form-data" class="mb-4">';
        $html .= csrf_field();
        $html .= '<div class="mb-3"><label class="form-label">Select file to test upload</label><input type="file" name="avatar" class="form-control"></div>';
        $html .= '<button type="submit" class="btn btn-primary">Upload and Test</button></form>';
        $html .= '<h4>Diagnostics Data:</h4><pre class="bg-dark text-light p-3 rounded">' . json_encode($diagnostics, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</pre>';
        $html .= '</div></body></html>';

        return response($html);
    }
}
