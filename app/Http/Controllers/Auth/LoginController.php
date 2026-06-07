<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // CUSTOMER

    public function showUserLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login-user');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Pastikan yang login lewat form customer adalah customer
            if (!Auth::user()->isCustomer()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai customer.',
                ]);
            }

            return $this->redirectByRole(Auth::user());
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    // ADMIN & SUPER ADMIN

    public function showAdminLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login-admin');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 8 karakter.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Pastikan yang login lewat form admin adalah admin atau super admin
            if (Auth::user()->isCustomer()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini tidak memiliki akses sebagai admin.',
                ]);
            }

            return $this->redirectByRole(Auth::user());
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $role = auth()->user()->role;

        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role == 'admin_rental' || $role == 'super_admin') {
            return redirect()->route('admin.login');
        }

        return redirect()->route('beranda');
    }

    // REDIRECT BY ROLE

    private function redirectByRole($user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard')
                ->with('login_success', 'Login Berhasil');
        }
    
        if ($user->isAdminRental()) {
            return redirect()->route('admin.dashboard')
                ->with('login_success', 'Login Berhasil');
        }
    
        return redirect()->route('beranda')
            ->with('login_success', 'Login Berhasil');
    }
}