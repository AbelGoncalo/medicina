<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
        protected $primaryKey = 'id_usuario';
        protected $table = 'users';
        protected $fillable = [
        'nome',
        'email',
        'password',
        'Nivel',
    ];
 
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function utente(){
        return $this->belongsTo(Utente::class,'id_usuario','id_utente');
    }
 
    public function medico(){
        return $this->belongsTo(Utente::class,'id_usuario','id_medico');
    }
}
