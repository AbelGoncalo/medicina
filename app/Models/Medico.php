<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    use HasFactory;

        protected $table = "medicos";
        protected $primaryKey = "id_medico";
        protected $fillable =[ 
            'nome',
            'nascimento',
            'bi',
            'sexo',
            'id_especialidade',
            'id_endereco',
            'id_contacto',
            'id_usuario'
        ];

        public function especialidade(){

            return $this->hasOne(Especialidade::class,'id_especialidade','id_medico');
        }

        
        public function endereco(){
            return $this->hasOne(Endereco::class,'id_endereco','id_medico');
        }
    
        public function contacto(){
            return $this->hasOne(Contacto::class,'id_contacto','id_medico');
        }
    
        public function usuario(){
            return $this->hasOne(User::class,'id_usuario','id_medico');
        }

        public function consulta(){

          return  $this->hasOne(Consulta::class,'id_consulta');
        }
}
