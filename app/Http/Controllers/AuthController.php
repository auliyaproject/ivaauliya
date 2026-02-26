<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /*
    |----------------------------------------------------------------------
    | TAMPIL FORM REGISTER
    |----------------------------------------------------------------------
    */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /*
    |----------------------------------------------------------------------
    | PROSES REGISTER
    |----------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // RESET SESSION ROLE
        session()->forget(['role', 'admin_verified']);

        // SETELAH REGISTER → PILIH ROLE
        return redirect()->route('pilih.role')
            ->with('success', 'Registrasi berhasil!');
    }

    /*
    |----------------------------------------------------------------------
    | TAMPIL FORM LOGIN
    |----------------------------------------------------------------------
    */
    public function showLoginForm()
    {
        // JIKA SUDAH LOGIN & SUDAH PILIH ROLE
        if (Auth::check() && session('role') === 'kasir') {
            return redirect()->route('kasir.index');
        }

        if (Auth::check() && session('role') === 'admin' && session('admin_verified')) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    /*
    |----------------------------------------------------------------------
    | PROSES LOGIN
    |----------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // RESET ROLE & VERIFIKASI SETIAP LOGIN
            session()->forget(['role', 'admin_verified']);

            // SETELAH LOGIN → PILIH ROLE
            return redirect()->route('pilih.role')
                ->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /*
    |----------------------------------------------------------------------
    | LOGOUT
    |----------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // HAPUS SEMUA SESSION ROLE
        session()->forget(['role', 'admin_verified']);

        return redirect()->route('login');
    }
}
