<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idcliente');
            $table->string("direccion");
            $table->timestamps();
        });
        DB::table('direccions')->insertGetId([
            "direccion"=>"Colonia city",
            "idcliente"=>"1"
        ]);
        DB::table('direccions')->insertGetId([
            "direccion"=>"Colona",
            "idcliente"=>"1"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('direccions');
    }
}
