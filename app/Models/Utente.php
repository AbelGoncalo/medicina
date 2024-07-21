<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Endereco;
class Utente extends Model
{
    use HasFactory;
        protected $primaryKey = 'id_utente';

    protected $fillable = [
        'nome',
        'nascimento',
        'seguro',
        'sexo',
        'seguro_numero',
        'bi' 
       
    ];
    protected $table = 'utentes';
   
    public function endereco(){
        return $this->hasOne(Endereco::class,'id_endereco','id_utente');
    }

    public function contacto(){
        return $this->hasOne(Contacto::class,'id_contacto','id_utente');
    }

    public function usuario(){
        return $this->hasOne(User::class,'id_usuario','id_utente');
    }
    public function consulta(){

        return $this->belongsTo(Consulta::class,'id_utente');
    }

    public function historicoClinico(){
        return $this->belongsTo(HistoricoClinico::class,'id_utente');
    }

}
