<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;
    protected $primaryKey = "id_consulta";
    protected $table = "consultas";

    protected $fillable = [
        'tipo_exame',
        'data_marcacao',
        'anexos',
        'status',
        'id_medico',
        'id_utente',

    ];

    public function utente(){

        return $this->hasMany(Utente::class,'id_utente');
    }

    public function medico(){
        return $this->belongsTo(Medico::class,'id_medico');
    }
}
