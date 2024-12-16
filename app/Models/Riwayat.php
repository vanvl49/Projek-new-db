<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riwayat extends Model
{
    use HasFactory;
    protected $table = 'riwayat';
    protected $fillable = ['penyewaan_id', 'total_harga_sewa'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($riwayat) {
            if (Riwayat::where('penyewaan_id', $riwayat->penyewaan_id)->exists()) {
                throw new \Exception('Riwayat untuk penyewaan ini sudah ada.');
            }
        });
    }

    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class, 'penyewaan_id');
    }
}
