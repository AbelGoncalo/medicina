<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utentes', function (Blueprint $table) {
            $table->id('id_utente');
            $table->string('nome');
            $table->date('nascimento');
            $table->string('seguro');
            $table->string('sexo');
            $table->integer('seguro_numero');
            $table->string('bi');
            $table->unsignedBigInteger('id_endereco');
            $table->unsignedBigInteger('id_contacto');
            $table->unsignedBigInteger('id_usuario');

            $table->foreign('id_endereco')->references('id_endereco')->on('enderecos')->onDelete('cascade');
            $table->foreign('id_contacto')->references('id_contacto')->on('contactos')->onDelete('cascade');
            $table->foreign('id_usuario')->references('id_usuario')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('utentes');
    }
}
