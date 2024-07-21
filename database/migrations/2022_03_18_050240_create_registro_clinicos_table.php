<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroClinicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_clinicos', function (Blueprint $table) {
            $table->id('id_rcu');
            $table->string('grupo_sanguinio',5)->nullable();
            $table->json('alergias')->nullable();
            $table->json('historico_saude')->nullable();
            $table->string('boletim_vacina')->default('Nenhum');
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
        Schema::dropIfExists('registro_clinicos');
    }
}
