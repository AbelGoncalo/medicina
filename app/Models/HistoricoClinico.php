<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoClinico extends Model
{
    use HasFactory;

    protected $table = "historico_clinicos";
    protected $primaryKey = "id_historico_clinico";
    protected $fillable = [
        'exame_efetuado',
        'resultado',
        'dignostico',
        'procedimento',
        'terapeutica',
        'id_utente',
        'medico',

    ];
    public function utente(){
        $this->hasMany(Utente::class,'id_utente');
    }
}
