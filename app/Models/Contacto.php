<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

     
 
        protected $table = "contactos";
        protected $primaryKey = "id_contacto";
    /** */
    protected $fillable = [
    
        'telefone',
        'email'
    ];

    public function utente(){
        return $this->belongsTo(Utente::class,'id_contacto','id_utente');
    }
    public function medico(){
        return $this->belongsTo(Medico::class,'id_contacto','id_medico');
    }

}
