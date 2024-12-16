<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nama' => 'Lutfi',
            'email' => 'Lutfiarif@gmail.com',
            'password' => bcrypt('password123'),
            'nomor_telepon' => '08123456789',
            'alamat' => 'Jl. Jawa Jember',
            'user_type' => 'internal',
        ]);

        User::create([
            'nama' => 'Gadis',
            'email' => 'RistiGadis@gmail.com',
            'password' => bcrypt('password321'),
            'nomor_telepon' => '08123456789',
            'alamat' => 'Jl. Mastrip Jember',
        ]);
    }
}
