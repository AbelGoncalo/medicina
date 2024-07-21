<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroClinico extends Model
{
    use HasFactory;
    protected $primaryKey = "id_rcu";
    protected $table = "registro_clinicos";
    protected $casts = [
        'historico_saude'=>'array',
        'alergias'=>'array'
    ];

    protected $fillable = [

        'grupo_sanguinio',
        'alergias', 
        'historico_saude',
        'boletim_vacina',
        'id_utente'
    ];
    
}
