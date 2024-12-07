<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Tampilkan halaman login admin
    public function showLoginForm()
    {
        return view('admin.login'); // Buat view untuk halaman ini
    }

    // Proses login admin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Pastikan username dan password cocok dengan yang ditentukan
        $adminUsername = 'admin'; // Ganti dengan username yang Anda tentukan
        $adminPassword = 'password123'; // Ganti dengan password yang Anda tentukan

        if (
            $request->username === $adminUsername &&
            Hash::check($request->password, Hash::make($adminPassword))
        ) {
            // Simpan status login admin ke session
            session(['is_admin' => true]);
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        return back()->withErrors(['login' => 'Invalid username or password']);
    }

    // Logout admin
    public function logout()
    {
        session()->forget('is_admin');
        return redirect()->route('home')->with('success', 'Logged out successfully');
    }

    // Dashboard admin
    public function dashboard()
    {
        if (!session('is_admin')) {
            return redirect()->route('admin.login')->withErrors(['unauthorized' => 'Please log in as admin.']);
        }

        return view('admin.dashboard'); // Buat view untuk dashboard admin
    }
}
