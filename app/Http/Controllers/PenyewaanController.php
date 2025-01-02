<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\RiwayatAdminController;

class PenyewaanController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $penyewaan = Penyewaan::where('id_user', $userId)
            ->whereIn('confirmed_status', ['pending'])
            ->with('gedung')
            ->get();

        $penyewaan_confirmed = Penyewaan::where('id_user', $userId)
            ->where('confirmed_status', 'confirmed') // Validasi status harus confirmed
            ->whereDate('tanggal_selesai', '>=', Carbon::now()->toDateString())
            ->get();
        return view('customer.penyewaan', compact('penyewaan', 'penyewaan_confirmed'));
    }

    public function showSewa(Request $request)
    {
        $gedungId = $request->gedung_id;

        $penyewaan = Penyewaan::where('gedung_id', $gedungId)
            ->where('confirmed_status', 'confirmed')
            ->get();

        $booking = $penyewaan->map(function ($sewa) {
            return [
                'title' => $sewa->detail_acara,
                'start' => Carbon::parse($sewa->tanggal_mulai)->toDateString(),
                'end' => Carbon::parse($sewa->tanggal_selesai)->addDay()->toDateString(),
                'id' => $sewa->id,
            ];
        });

        // dd($booking);
        return response()->json($booking);
    }


    // Menyimpan data gedung ke database
    public function store(Request $request)
    {
        $request->validate([
            'gedung_id' => 'required|exists:gedung,id',
            'detail_acara' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);


        $ceksewa = Penyewaan::where('gedung_id', $request->gedung_id)
            ->where('confirmed_status', 'confirmed')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai]);
            })
            ->exists();

        if ($ceksewa) {
            return redirect()->back()->withErrors(['error' => 'Tanggal yang Anda pilih sudah disewa.']);
        }

        // Simpan data penyewaan
        Penyewaan::create([
            'id_user' => Auth::id(), // ID user yang sedang login
            'gedung_id' => $request->gedung_id,
            'detail_acara' => $request->detail_acara,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'confirmed_status' => 'pending', // Default belum dikonfirmasi
        ]);

        return redirect()->back()->with('success', 'Penyewaan berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:penyewaan,id',
            'gedung_id' => 'required|exists:gedung,id',
            'detail_acara' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $penyewaan = Penyewaan::find($request->id);

        $penyewaan->update([
            'gedung_id' => $request->gedung_id,
            'detail_acara' => $request->detail_acara,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect()->route('penyewaan.customer')->with('success', 'Penyewaan berhasil diperbarui!');
    }

    public function batalkan(Request $request, RiwayatAdminController $riwayatController)
    {
        $request->validate([
            'id' => 'required|exists:penyewaan,id',
        ]);

        // Update status penyewaan
        $penyewaan = Penyewaan::find($request->id);

        $tanggalMulai = Carbon::parse($penyewaan->tanggal_mulai); // Mengonversi tanggal_mulai ke objek Carbon

        if ($tanggalMulai->diffInDays(Carbon::now()->startOfDay()) <= 3 && $penyewaan->confirmed_status == 'confirmed') {
            return redirect()->back()->withErrors([
                'error' => 'Penyewaan tidak dapat dibatalkan karena H-3 dari tanggal mulai. Silahkan hubungi admin jika ingin membatalkan penyewaan.',
            ]);
        }

        $penyewaan->update(['confirmed_status' => 'rejected']);
        $riwayatController->storeFromPenyewaan($penyewaan);

        return redirect()->route('penyewaan.customer')->with('success', 'Penyewaan berhasil dibatalkan!');
    }
}
