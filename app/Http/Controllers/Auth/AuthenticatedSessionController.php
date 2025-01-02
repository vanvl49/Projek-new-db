<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Gedung;
use App\Models\Penyewaan;
use Carbon\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = Auth::user();

        // Kirim data gedung langsung ke view melalui redirect
        return redirect()->route('dashboard')
            ->with('user', $user);
    }

    public function dashboard()
    {
        $query = Gedung::query();

        $query->where('is_available', '=', true);

        $gedungs = $query->take(3)->get();

        // Logika harga berdasarkan user type
        foreach ($gedungs as $gedung) {
            $gedung->harga_tampil = Auth::user()->user_type === 'internal'
                ? $gedung->harga_internal
                : $gedung->harga_eksternal;
        };

        $penyewaan = Penyewaan::where('id_user', Auth::id())
            ->where('confirmed_status', 'confirmed')
            ->whereDate('tanggal_selesai', '>=', Carbon::now()->toDateString())
            ->get();
        $penyewaan_pending = Penyewaan::where('id_user', Auth::id())
            ->where('confirmed_status', 'pending') // Validasi status harus confirmed
            ->get();
            
        return view('customer.dashboard', compact(
            'gedungs',
            'penyewaan',
            'penyewaan_pending'
        ));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
    }
}
