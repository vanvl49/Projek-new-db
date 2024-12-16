<?php

namespace App\Http\Controllers;

use App\Models\Penyewaan;
use Illuminate\Http\Request;
use App\Http\Controllers\RiwayatAdminController;

class PenyewaanAdminController extends Controller
{
    public function pending()
    {
        // Mengambil data penyewaan dengan status 'pending'
        $penyewaan = Penyewaan::with(['gedung', 'user'])
            ->where('confirmed_status', 'pending')
            ->get();

        return view('admin.penyewaan', compact('penyewaan'));
    }

    public function updateStatus(Request $request, RiwayatAdminController $riwayatController)
    {
        $request->validate([
            'id' => 'required|exists:penyewaan,id',
            'status' => 'required|in:confirmed,rejected',
        ]);

        // Update status penyewaan
        $penyewaan = Penyewaan::find($request->id);
        $penyewaan->confirmed_status = $request->status;
        $penyewaan->save();

        if ($penyewaan->confirmed_status === 'rejected') {
            $riwayatController->storeFromPenyewaan($penyewaan);
        }
    
        $message = $request->status === 'confirmed' ? 'Penyewaan berhasil dikonfirmasi.' : 'Penyewaan berhasil dibatalkan.';
        return back()->with('success', $message);
    }
}
