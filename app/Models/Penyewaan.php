<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;
    protected $table = 'penyewaan';
    protected $fillable = [
        'id_user',
        'gedung_id',
        'detail_acara',
        'tanggal_mulai',
        'tanggal_selesai',
        'confirmed_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,  'id_user', 'id_user');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id')->withTrashed();
    }

    public function riwayat()
    {
        return $this->hasOne(Riwayat::class, 'penyewaan_id');
    }
}
