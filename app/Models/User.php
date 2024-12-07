<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['nama', 'email', 'password', 'nomor_telepon', 'alamat'];
    public $incrementing = true;
    protected $keyType = 'int';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class, 'id_user', 'id_user');
    }
}
