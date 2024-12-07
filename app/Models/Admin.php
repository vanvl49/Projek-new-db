<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['username', 'password'];
    public $incrementing = true;
    protected $keyType = 'int';

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
