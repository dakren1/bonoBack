<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre');
            $table->string('descripcion');
            $table->timestamps();
        });
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Escritorio","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Pasajes Activos","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Historial de Pasajes","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Clientes","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Choferes","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Usuarios","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Roles","descripcion"=>""]
        );
        DB::table('permisos')->insertGetId(
            ["nombre"=>"Configuracion","descripcion"=>""]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos');
    }
}
