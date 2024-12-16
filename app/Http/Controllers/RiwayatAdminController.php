<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use Illuminate\Http\Request;
use App\Models\Penyewaan;
use Carbon\Carbon;


class RiwayatAdminController extends Controller
{
    public function index()
    {
        $penyewaan = Penyewaan::where('confirmed_status', 'confirmed')
            ->whereDate('tanggal_mulai', '<', Carbon::now()->toDateString())
            ->whereDoesntHave('riwayat') // Periksa apakah belum ada riwayat
            ->get();

        foreach ($penyewaan as $item) {
            $this->storeFromPenyewaan($item);
        }

        $riwayat = Riwayat::with(['penyewaan.gedung' => function($query) {
            $query->withTrashed(); // Menyertakan gedung yang dihapus
        }])->get();
        return view('admin.riwayat', compact('riwayat'));
    }

    public function storeFromPenyewaan(Penyewaan $penyewaan)
    {
        if ($penyewaan->riwayat) {
            return; // Jika riwayat sudah ada, abaikan
        }

        $tanggalMulai = Carbon::parse($penyewaan->tanggal_mulai);
        $tanggalSelesai = Carbon::parse($penyewaan->tanggal_selesai);
        $durasi = $tanggalMulai->diffInDays($tanggalSelesai) + 1;

        $totalHargaSewa = $penyewaan->gedung->harga_internal * $durasi;

        $penyewaan->riwayat()->create([
            'penyewaan_id' => $penyewaan->id,
            'total_harga_sewa' => $totalHargaSewa,
        ]);
    }
}
