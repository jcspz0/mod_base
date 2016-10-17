<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use Crypt;
use Session;
use Redirect;
use Validator;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use \base\Model\Usuario;
use \base\Model\Password;
use \base\Model\Parametro;
use \base\Model\Bitacora;
use \base\Model\Bloqueo;

class LoginController extends Controller{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('parametros')) ){
                $parametro = new Parametro();
                $parametro->cargarParametroSession();
            }            
        });
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //echo "entro a login";
        //dd("SIIII");
        if (!is_null(session('usuario'))){
            return Redirect::to('bienvenido');
        }
        $correo = '';
        return view('login', compact('correo'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $correo = $request['correo'];
        $p = base64_encode($request['password']);

        $errors = $this->validarLogueo($correo, $p);

        if (count($errors) > 0){
            return view('login', compact('correo', 'errors'));
        }
        else{
            $usuario = session('usuario');
            $usuario->INTENTO = 0;
            $usuario->save();
            Bitacora::guardar(config('sistema.ID_FORMULARIO_LOGIN'), config('sistema.ID_ACCION_INICIAR_SESSION'), 'Acaba de iniciar session el usuario: '.$usuario->USUARIO);
            //return Redirect::to('rol');             
            return Redirect::to('bienvenido'); 
        }
    }

    private function estaBloqueadoPorIP(){
        $ip = $this->getRealIP();
        $bloqueo = new Bloqueo();
        $bloqueo = $bloqueo->obtenerBloqueoPorIP($ip);

         $errors = array();
        if (isset($bloqueo)){
            $bloqueo->INTENTO_FALLIDO++;
            $blqoueo->ULTIMA_VISITA = date('Y-m-d H:i:s');
            if ($bloqueo->INTENTO_FALLIDO > session('parametros')[99]['VALOR']){
                $bloqueo->BLOQUEADO = true;
                $errors[] = session('parametros')[100]['VALOR'];
            }
            $bloqueo->save();
        }
        else{
            $bloqueo = new Bloqueo();
            $bloqueo->IP = $ip;
            $bloqueo->INTENTO_FALLIDO = 1;
            $blqoueo->ULTIMA_VISITA = date('Y-m-d H:i:s');
            $bloqueo->BLOQUEADO = false;
        }
        return $errors;
    }

    private function validarLogueo($correo, $p){
        $errors = array();
        if ($correo == ""){
            $errors [] = session('parametros')[1]['VALOR'];
        }
        if ($p == ""){
            $errors [] = session('parametros')[4]['VALOR'];
        }
        if (count($errors) > 0){
            return $errors;
        }

        $usuario = new Usuario();
        $usuario = $usuario->existeUsuario($correo);
        if (!isset($usuario)){
            $errors [] = session('parametros')[2]['VALOR'];
            return $errors;
        }
        if ($usuario->BLOQUEADO == true){
            $errors [] = session('parametros')[3]['VALOR'];
            return $errors;
        }

        $password = new Password();
        $password = $password->existePassword($usuario->ID, $p);
        if (!isset($password)){
            $errors [] = session('parametros')[5]['VALOR'];                
            $usuario->INTENTO++;
            if ($usuario->INTENTO > session('parametros')[99]['VALOR']){
                $usuario->BLOQUEADO = true;
                $errors [] = session('parametros')[100]['VALOR'];
            }
            $usuario->save();
        }

        if (count($errors) < 1){
            session(['usuario' => $usuario]);
        }        

        return $errors;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Se encarga de cerrar la session del usuario.
     * 
     * @return [type] [description]
     */
    public function logout(){
        //Auth::logout();
        $usuario = session('usuario');
        /*$usuario->INTENTO = 0;
        $usuario->save();*/
        Bitacora::guardar(config('sistema.ID_FORMULARIO_LOGIN'), config('sistema.ID_ACCION_CERRAR_SESSION'), 'Acaba de cerrar session el usuario: '.$usuario->USUARIO);
        session()->flush();
        return Redirect::to('/');
    }
}
