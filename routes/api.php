<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Parte de usuarios

Route::get('/usuarios',function(Request $request){
    $tabla = DB::table('usuarios')->join('rols','usuarios.idrol','=','rols.id')
    ->select('usuarios.id','usuarios.nombre','usuarios.email','usuarios.usuario','rols.id as idrol','rols.nombre as rol')->get();
    return json_encode($tabla);
});

Route::post('/usuarios',function(Request $request){
    $usuario = $request->input('usuario');
    $nombre = $request->input('nombre');
    $email = $request->input('email');
    $password = $request->input('password');
    $idrol = $request->input('idrol');
    DB::table('usuarios')->insertGetId([
        "usuario"=>$usuario,
        "nombre"=>$nombre,
        "email"=>$email,
        "password"=>$password,
        "idrol"=>$idrol
    ]);

    $retorno= ["mensaje" => "Finalizado"];
    return json_encode($retorno);
});

Route::get('/usuarios/{id}',function(Request $request,$indice){
    $resultado = DB::table('usuarios')->where('id',$indice)->get()[0];
    return json_encode($resultado);
});

Route::put('/usuarios',function(Request $request){
    $id = $request->input('id');
    $usuario = $request->input('usuario');
    $nombre = $request->input('nombre');
    $email = $request->input('email');
    $password = $request->input('password');
    $idrol = $request->input('idrol');

    DB::table('usuarios')->where('id',$id)->update([
        "usuario"=>$usuario,
        "nombre"=>$nombre,
        "email"=>$email,
        "password"=>$password,
        "idrol"=>$idrol
    ]);

    $retorno= ["mensaje" => "Finalizado"];
    return json_encode($retorno);
});

//Login
Route::post('/login',function(Request $request){
    //Obtengo la informacion del request
    $usuario = $request->input('usuario');
    $password = $request->input('password');
    //Realizo la consulta a la base de datos
    $base = DB::table('usuarios')->select('id','password','idrol')->where('usuario','=',$usuario)->get();

    //Verifico que el usuario exista, si no devuelvo
    if(count($base)==0){
        return json_encode([
            "respuesta" => "no",
            "apikey" => ""
        ]);
    }
    //Paso el dato de json a clase
    $aux = $base[0];
    //Inicializo el retorno
    $retorno = [];
    
    //Elijo el retorno
    if($aux->password==$password){
        //Generar un string aleatorio
        $str=rand(); 
        $result = md5($str);
        //Verifico que no se encuentre una session anterior activa
        $base = DB::table('sessions')->select('id')->where('idusuario','=',$aux->id)->get();
        if(count($base)==0){
            //Agrego a la base de datos la session del api
            DB::table('sessions')->insertGetId([
            "idusuario" => $aux->id,
            "apikey" => $result
            ]);
        }
        else{
            //Modifico el api key
            DB::table('sessions')->where('id','=',$base[0]->id)->update(["apikey"=>$result]);
        }
        
        //Busco los permisos
        $base = DB::table('rolpermisos')
        ->join('permisos','rolpermisos.idpermiso','=','permisos.id')
        ->select('permisos.id','permisos.nombre')->where('rolpermisos.idrol','=',$aux->idrol)->get();

        //Muestro el retorno
        $retorno = [
            "respuesta" => "si",
            "apikey" => $result,
            "permisos" => $base
        ];
    }
    else{
        $retorno = [
            "respuesta" => "no",
            "apikey" => ""
        ];
    }
    return json_encode($retorno);
    
});


//Parte de roles

Route::get('/rol',function(Request $request){
    $resultado = DB::table('rols')->get();
    return json_encode($resultado);
});


Route::get('/rol/{id}',function(Request $request,$indice){
    $resultado = DB::table('rols')
    ->where('rols.id','=',$indice)
    ->get();

    return json_encode($resultado[0]);
});

//Guardar un rol
Route::post('/rol', function(Request $request){
    try {
        
    
    $nombre = $request->input('nombre');
    $descripcion = $request->input('descripcion');
    $permisos = $request->input('permisos');
    
    //$permisos = substr($permisos,1,strlen($permisos)-2);
    //$permisos = explode(',',$permisos);

    
    DB::table('rols')->insertGetId([
        "nombre"=>$nombre,
        "descripcion"=>$descripcion
    ]);

    $id = DB::table('rols')->select('id')->where('nombre','=',$nombre)->get();
    $id = $id[0];
    
    foreach($permisos as $permiso){
        DB::table('rolpermisos')->insert([
            "idrol"=>$id->id,
            "idpermiso"=>$permiso
        ]);
    }

    $retorno = ["mensaje"=>"Finalizado"];

    return json_encode($retorno);
} catch (Exception $th) {
    
    return json_encode([
        "mensaje"=>$th->getMessage()
        ]);
}
});

//Modificar un rol
Route::put('/rol',function(Request $request){
    $id = $request->input('id');
    $nombre = $request->input('nombre');
    $descripcion = $request->input('descripcion');
    $permisos = $request->input('permisos');

    DB::table('rols')->where('id',$id)->update([
        "nombre"=>$nombre,
        "descripcion"=>$descripcion
    ]);


    DB::table('rolpermisos')->where('idrol',$id)->delete();

    foreach($permisos as $permiso){
        DB::table('rolpermisos')->insert([
            "idrol"=>$id,
            "idpermiso"=>$permiso
        ]);
    }

    $retorno = ["mensaje"=>"Finalizado"];
  //  $retorno = ["mensaje"=>$id];
    return json_encode($retorno);
});


//Obtener los permisos

Route::get('permisos',function(Request $request){
    $resultado = DB::table('permisos')->get();
    return json_encode($resultado);
});


//Devuelve los permisos basado en un rol establecido
Route::get('/permisos/{id}',function (Request $request, $indice)
{
    $tabla = DB::table('rolpermisos')->where('idrol','=',$indice)->select('idpermiso');
    $resultado = DB::table('permisos')
    ->leftJoinSub($tabla,'rolpermisos',function($join){
        $join->on('rolpermisos.idpermiso','=','permisos.id');
    })->select('id','nombre','descripcion','idpermiso')->get();
    return json_encode($resultado);
});


//Sector de choferes
Route::get('/choferes',function(Request $request){
    $tabla = DB::table('chofers')->get();
    return json_encode($tabla);
});

Route::post('/choferes',function(Request $request){
    $nombre = $request->input('nombre');
    $usuario = $request->input('usuario');
    $dni = $request->input('dni');
    $direccion = $request->input('direccion');
    $password = $request->input('password');
    $telefono = $request->input('telefono');

    DB::table('chofers')->insertGetId([
        "nombre"=>$nombre,
        "usuario" => $usuario,
        "dni" => $dni,
        "direccion" => $direccion,
        "password" => $password,
        "telefono" => $telefono
    ]);
    
    $retorno = ["mensaje"=>"Finalizado"];
    return json_encode($retorno);
});

Route::put('/choferes',function(Request $request){
    $id = $request->input('id');
    $nombre = $request->input('nombre');
    $usuario = $request->input('usuario');
    $dni = $request->input('dni');
    $direccion = $request->input('direccion');
    $password = $request->input('password');
    $telefono = $request->input('telefono');

    DB::table('chofers')->where('id',$id)->update([
        "nombre"=>$nombre,
        "usuario" => $usuario,
        "dni" => $dni,
        "direccion" => $direccion,
        "password" => $password,
        "telefono" => $telefono
    ]);
    
    $retorno = ["mensaje"=>"Finalizado"];
    return json_encode($retorno);
});

Route::get('/choferes/{id}',function(Request $request,$indice){
    $tabla = DB::table('chofers')->where('id',$indice)->get();
    return json_encode($tabla[0]);
});

///Sector de clientes

Route::get('/clientes',function(Request $request){
    $tabla = DB::table('clientes')->select('id','nombre')->get();
    
    foreach($tabla as $fila){
        $aux = DB::table('telefonos')->select('numero')->where('idcliente',$fila->id)->get();
        $fila->telefonos= $aux;
        $aux = DB::table('direccions')->select('direccion')->where('idcliente',$fila->id)->get();
        $fila->direcciones= $aux;
    }
    return json_encode($tabla);
});

Route::get('/clientes/{id}',function(Request $request,$indice){
    $tabla = DB::table('clientes')->select('id','nombre')->where('id',$indice)->get();
    $tabla = $tabla[0];
    $aux = DB::table('telefonos')->select('numero')->where('idcliente',$tabla->id)->get();
    $tabla->telefonos= $aux;
    $aux = DB::table('direccions')->select('direccion')->where('idcliente',$tabla->id)->get();
    $tabla->direcciones= $aux;
    return json_encode($tabla);
});

Route::post('/clientes',function(Request $request){
    $nombre = $request->input('nombre');
    if($request->input('imei')!=null){
        $imei = $request->input('imei');
        DB::table('clientes')->insertGetId([
            "nombre"=>$nombre,
            "imei"=>$imei
        ]);
        $tabla = DB::table('clientes')->where('nombre','=',$nombre,'and','imei','=',$imei)->get();
        $retorno = ["id" => $tabla[0]->id];

    }
    ///
    else{
        DB::table('clientes')->insertGetId([
            "nombre"=>$nombre
        ]);
        $tabla = DB::table('clientes')->where('nombre','=',$nombre)->get();
        $retorno = ["id" => $tabla[0]->id];
    }
    return json_encode($retorno);
});

Route::put('/clientes',function(Request $request){
    $id = $request->input('id');
    $nombre = $request->input('nombre');
    $imei = $request->input('imei');
    DB::table('clientes')->where('id',$id)
    ->update([
        "nombre"=>$nombre,
        "imei"=>$imei
    ]);
    $retorno = ["mensaje"=>"Finalizado"];
    return json_encode($retorno);
});