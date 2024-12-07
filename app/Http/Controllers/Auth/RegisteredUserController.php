<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register'); // Tampilan template register Breeze
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nama' => 'required| string| max:255',
            'email' => 'required| string| email| max:255| unique:users,email',
            'password' => 'required| string|min-:8 |confirmed',
            'nomor_telepon' => 'required| string| max:13',
            'alamat' => 'required| string| max:255',
        ]);

        // Menyimpan user ke database
        $user = User::create([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'nomor_telepon' => $request->input('nomor_telepon'),
            'alamat' => $request->input('alamat'),
        ]);

        // Event Registered (untuk email verifikasi, dll.)
        event(new Registered($user));

        // Otomatis login setelah register
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }
}
