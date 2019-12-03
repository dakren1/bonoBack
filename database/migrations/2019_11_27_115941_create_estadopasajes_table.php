<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstadopasajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estadopasajes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });
        DB::table('estadopasajes')->insert([
            "nombre"=>"En espera"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"Chofer en camino"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"En camino"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"Finalizado"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"Cancelado por el usuario"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"Cancelado por el operador"
        ]);
        DB::table('estadopasajes')->insert([
            "nombre"=>"Cancelado por lejano"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estadopasajes');
    }
}
