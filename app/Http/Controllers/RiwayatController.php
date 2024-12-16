<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Riwayat;
use App\Models\Penyewaan;
use Carbon\Carbon;
use App\Http\Controllers\RiwayatAdminController;

class RiwayatController extends Controller
{
    public function index()
    {
        $penyewaan = Penyewaan::where('id_user', Auth::id())
            ->where('confirmed_status', 'confirmed')
            ->whereDate('tanggal_mulai', '<', Carbon::now()->toDateString())
            ->whereDoesntHave('riwayat') // Periksa apakah belum ada riwayat
            ->get();

        foreach ($penyewaan as $item) {
            $this->storeFromPenyewaan($item);
        }

        $riwayat = Riwayat::whereHas('penyewaan', function ($query) {
            $query->where('id_user', Auth::id())
                ->where('confirmed_status', 'confirmed');
        })->get();

        return view('customer.riwayat', compact('riwayat'));
    }
}
