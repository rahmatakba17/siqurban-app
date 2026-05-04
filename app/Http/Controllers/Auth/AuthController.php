<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->status === 'inactive') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors([
                    'name' => 'Akun Anda belum aktif. Harap tunggu konfirmasi Admin.',
                ])->onlyInput('name');
            }

            $request->session()->regenerate();

            if ($user->role === 'panitia') {
                event(new \App\Events\PanitiaLoggedIn($user));
            }

            return redirect()->intended(
                in_array($user->role, ['admin', 'superadmin'])
                    ? route('admin.dashboard')
                    : route('panitia.dashboard')
            );
        }

        return back()->withErrors([
            'name' => 'Nama atau password salah.',
        ])->onlyInput('name');
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'panitia',
            'status' => 'inactive',
        ]);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Harap tunggu konfirmasi Admin sebelum dapat login.');
    }
}
