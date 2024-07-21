<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exame extends Model
{
    use HasFactory;
    protected $table = "exames";
    protected $primaryKey = "id_exame";
    protected $fillable = ['nome','id_especialidade'];

    public function especialidade(){

        return $this->belongsTo(Especialidade::class,'id_especialidade','id_medico');
    }
    public function especialidade_exame(){

        return $this->belongsTo(Especialidade::class,'id_especialidade');
    }
}
