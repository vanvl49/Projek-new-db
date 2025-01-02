<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Gedung;
use App\Models\Penyewaan;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Tampilkan halaman login admin
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Proses login admin
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome, Admin!');
        }

        return back()->withErrors(['login' => 'Invalid username or password']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route('home'));
    }

    // Dashboard admin
    public function dashboard()
    {
        $gedungs = Gedung::all();
        $totalGedung = Gedung::count();

        // Menghitung jumlah penyewa aktif (penyewaan yang sudah dikonfirmasi)
        $totalPenyewaAktif = Penyewaan::where('confirmed_status', 'confirmed')->count();

        $penyewaanTerbaru = Penyewaan::with(['gedung', 'user'])
            ->where('confirmed_status', 'pending')
            ->latest() // Mengambil penyewaan terbaru berdasarkan tanggal
            ->first();

        $confirmedPerBulan = DB::table('riwayat')
            ->join('penyewaan', 'riwayat.penyewaan_id', '=', 'penyewaan.id')
            ->select(DB::raw('MONTH(penyewaan.tanggal_mulai) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->where('penyewaan.confirmed_status', 'confirmed')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        $rejectedPerBulan = DB::table('riwayat')
            ->join('penyewaan', 'riwayat.penyewaan_id', '=', 'penyewaan.id')
            ->select(DB::raw('MONTH(penyewaan.tanggal_mulai) as bulan'), DB::raw('COUNT(*) as jumlah'))
            ->where('penyewaan.confirmed_status', 'rejected')
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->pluck('jumlah', 'bulan')
            ->toArray();

        // Pastikan data bulan yang kosong tetap diisi dengan 0
        $confirmedData = [];
        $rejectedData = [];
        for ($i = 1; $i <= 12; $i++) {
            $confirmedData[] = $confirmedPerBulan[$i] ?? 0;
            $rejectedData[] = $rejectedPerBulan[$i] ?? 0;
        }

        return view('admin.dashboard', compact(
            'gedungs',
            'totalGedung',
            'totalPenyewaAktif',
            'penyewaanTerbaru',
            'confirmedData',
            'rejectedData'
        ));
    }
}
