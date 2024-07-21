<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoricoClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_clinicos', function (Blueprint $table) {
            $table->id('id_historico_clinico');
            $table->string('exame_efetuado')->nullable();
            $table->string('resultado')->nullable();
            $table->string('dignostico')->nullable();
            $table->string('procedimento')->nullable();
            $table->string('terapeutica')->nullable();
            $table->integer('medico')->nullable();
            $table->unsignedBigInteger('id_utente');
            $table->foreign('id_utente')->references('id_utente')->on('utentes')->onDelete('cascade');
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
        Schema::dropIfExists('historico_clinicos');
    }
}
