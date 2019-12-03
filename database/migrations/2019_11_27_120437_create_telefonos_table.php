<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telefonos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero');
            $table->unsignedBigInteger('idcliente');
            $table->foreign('idcliente')->references('id')->on('clientes');
            $table->timestamps();
        });
        DB::table('telefonos')->insertGetId([
            "numero"=>"113581",
            "idcliente"=>"1"
        ]);
        DB::table('telefonos')->insertGetId([
            "numero"=>"11358131",
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
        Schema::dropIfExists('telefonos');
    }
}
