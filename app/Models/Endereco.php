<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Utente;

class Endereco extends Model
{
    use HasFactory;
 

        /** */
        protected $fillable = [

            'morada',
            'localidade',
            'codigo_postal'
        ];
        protected $table = 'enderecos';
        protected $primaryKey = 'id_endereco';
        /**Relacionamento, um Endereco  pertence a um  Utente (1:1) */
        public function utente(){
            return $this->belongsTo(Utente::class,'id_endereco','id_utente');
        }


   
}
