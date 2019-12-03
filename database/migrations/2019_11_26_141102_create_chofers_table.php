<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChofersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Nombre	Telefono	Direccion	Usuario	Dni	Modificar

        Schema::create('chofers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->integer('dni');
            $table->string('telefono')->nullable();
            $table->string('direccion')->nullable();
            $table->string('usuario');
            $table->string('password');
            $table->timestamps();
        });
        DB::table('chofers')->insertGetId([
            "nombre"=>"MAt",
            "dni"=>"212583",
            "telefono"=>"3513",
            "direccion"=>"Sarmiento",
            "usuario"=>"mat",
            "password"=>"396521"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chofers');
    }
}
