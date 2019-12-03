<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolpermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rolpermisos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idrol');
            $table->unsignedBigInteger('idpermiso');
            $table->foreign('idrol')->references('id')->on('rols');
            $table->foreign('idpermiso')->references('id')->on('permisos');
            $table->timestamps();
        });
        DB::table('rolpermisos')->insertGetId(
            [
                "idrol"=>1,"idpermiso"=>1
            ]
            );
        DB::table('rolpermisos')->insertGetId(
            [
                "idrol"=>1,"idpermiso"=>2
            ]
            );
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>3]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>4]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>5]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>6]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>7]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>1,"idpermiso"=>8]);
        DB::table('rolpermisos')->insertGetId(["idrol"=>2,"idpermiso"=>1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rolpermisos');
    }
}
