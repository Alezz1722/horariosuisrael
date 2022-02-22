<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fechas', function (Blueprint $table) {
            $table->bigIncrements('idFecha');
            $table->date('fechaInicioFecha');
            $table->date('fechaFinFecha');
            $table->time('horaInicioFecha');
            $table->time('horaFinFecha');
            $table->string('diaFecha');
            $table->string('frecuenciaFecha');
            $table->unsignedBigInteger('idActividad');
            $table->foreign('idActividad')->references('idActividad')->on('actividads');
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
        Schema::dropIfExists('fechas');
    }
}
