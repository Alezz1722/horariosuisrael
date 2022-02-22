<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListadoFechasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listado_fechas', function (Blueprint $table) {
            $table->bigIncrements('idListadoFecha');
            $table->date('fechaListadoFecha');
            $table->time('horaInicioListadoFecha');
            $table->time('horaFinListadoFecha');
            $table->unsignedBigInteger('idFecha');
            $table->foreign('idFecha')->references('idFecha')->on('fechas');
            $table->string('estadoListadoFecha');
            $table->string('observacionListadoFecha');
            $table->date('fechaAplazadaListadoFecha')->nullable();
            $table->time('horaInicioAplazadaListadoFecha')->nullable();
            $table->time('horaFinAplazadaListadoFecha')->nullable();
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
        Schema::dropIfExists('listado_fechas');
    }
}
