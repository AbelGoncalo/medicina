<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultas', function (Blueprint $table) {
                $table->id('id_consulta');
                $table->string('tipo_exame');
                $table->dateTime('data_marcacao');
                $table->dateTime('data_realizacao')->nullable();
                $table->string('anexos')->nullable();
                $table->boolean('status')->default(false)->nullable();
                $table->unsignedBigInteger('id_medico');
                $table->unsignedBigInteger('id_utente');
                $table->foreign('id_utente')->references('id_utente')->on('utentes')->onDelete('cascade');
                $table->foreign('id_medico')->references('id_medico')->on('medicos')->onDelete('cascade');;
                $table->timestamps();
 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultas');
    }
}
