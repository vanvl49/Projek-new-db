<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penyewaan;

class PenyewaanSeeder extends Seeder
{
    public function run()
    {
        Penyewaan::create([
            'id_user' => 1,
            'gedung_id' => 1,
            'detail_acara' => 'Seminar Teknologi Informasi',
            'tanggal_mulai' => '2024-12-01',
            'tanggal_selesai' => '2024-12-01',
            'confirmed_status' => 'pending'
        ]);

        Penyewaan::create([
            'id_user' => 2,
            'gedung_id' => 1,
            'detail_acara' => 'Seminar Proposal',
            'tanggal_mulai' => '2024-12-04',
            'tanggal_selesai' => '2024-12-04',
            'confirmed_status' => 'confirmed'
        ]);
    }
}
