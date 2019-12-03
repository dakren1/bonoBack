<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('usuario')->unique();
            $table->string('password');
            $table->string('email')->nullable();
            $table->string('nombre')->nullable();
            $table->unsignedBigInteger('idrol');
            $table->foreign('idrol')->references('id')->on('rols');
            $table->timestamps();
        });
        DB::table('usuarios')->insertGetId(["usuario"=>"delbono","password"=>"4210","email"=>"mathias.brizuela@gmail.com","idrol"=>1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
