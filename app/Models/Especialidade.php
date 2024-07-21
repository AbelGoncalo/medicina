<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    use HasFactory;
    protected $table = "especialidades";
    protected $primaryKey = "id_especialidade";
    protected $fillable = ['especialidade'];

     

    public function exame(){
 
        $this->hasMany(Exame::class,'id_especialidade','id_exame');  
    }

    public function medico(){

        return $this->belongsTo(Medico::class,'id_especialidade','id_medico');
    }
}
