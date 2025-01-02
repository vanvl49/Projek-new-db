<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gedung extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'gedung';
    protected $fillable = [
        'nama_gedung',
        'deskripsi',
        'kapasitas',
        'fasilitas',
        'alamat',
        'harga_internal',
        'harga_eksternal',
        'is_available',
        'gambar_gedung',
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'gedung_id');
    }
}
