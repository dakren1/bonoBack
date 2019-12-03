<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipos', function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string('nombre');
        });

        DB::table('tipos')->insert([
            "nombre"=>"Aplicacion"
        ]);
        DB::table('tipos')->insert([
            "nombre"=>"Operador"
        ]);
        DB::table('tipos')->insert([
            "nombre"=>"PSX"
        ]);

        Schema::create('pasajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idcliente');
            $table->foreign('idcliente')->references('id')->on('clientes');
            $table->string('salida');
            $table->string('destino')->nullable();
            $table->unsignedBigInteger('idestado');
            $table->foreign('idestado')->references('id')->on('estadopasajes');
            $table->unsignedBigInteger('idchofer')->nullable();
            $table->foreign('idchofer')->references('id')->on('chofers');
            $table->double('latsalida')->nullable();
            $table->double('lonsalida')->nullable();
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
        Schema::dropIfExists('tipos');
        Schema::dropIfExists('pasajes');
    }
}
