<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->unique();
            $table->string('descripcion');
            $table->timestamps();
        });
        DB::table('rols')->insertGetId([
            "nombre"=>"Admin","descripcion"=>"Puede hacer todo"
        ]);DB::table('rols')->insertGetId([
            "nombre"=>"Visor","descripcion"=>"Solo puede ver el mapa"
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rols');
    }
}
