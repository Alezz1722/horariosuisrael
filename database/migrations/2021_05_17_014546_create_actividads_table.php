<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActividadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividads', function (Blueprint $table) {
            $table->bigIncrements('idActividad');
            $table->string('nombreActividad');
            $table->string('descripcionActividad');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedBigInteger('idPeriodo');
            $table->unsignedBigInteger('idLugar');
            $table->foreign('idUsuario')->references('idUsuario')->on('usuarios');
            $table->foreign('idPeriodo')->references('idPeriodo')->on('periodos');
            $table->foreign('idLugar')->references('idLugar')->on('lugars');
            //$table->foreign('idRecurso')->references('idRecurso')->on('recursos');
            //$table->foreign('idFecha')->references('idFecha')->on('fechas');
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
        Schema::dropIfExists('actividads');
    }
}
