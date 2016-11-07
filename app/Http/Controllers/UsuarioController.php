<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use Validator;
use Redirect;
use Session;
use App;
use \base\Model\Usuario;
use \base\Model\Rol;
use \base\Model\Password;
use \base\Model\Bitacora;
use \base\Model\RolFormulario;

class UsuarioController extends Controller{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){            
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_USUARIO');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
                //dd($this->permisos);
            }
        });
    }

    /**
     * Validacion del formulario usuario
     */
    public static $rules = array(
        //'CI' => 'required|min:7|max:20',
        'CI' => 'required',
        'NOMBRE' => 'required|max:50', 
        'APELLIDO_PATERNO' => 'required|max:50',
        'APELLIDO_MATERNO' => 'required|max:50',
        //'telefono' => 'required|max:50',
        'CORREO' => 'required|email',
        'USUARIO' => 'required',
        'ID_MU_ROL' => 'exists:mu_rol,ID'
        //'ID_MU_ROL' => 'not_in:0'
    );
        //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            'CI.required' => session('parametros')[35]['VALOR'],
            //'CI.min' => "Minimo de caracteres disponible, menos de 7.",
            //'CI.max' => "Maximo de caracteres excedido, mas de 50.",
            'NOMBRE.required' => session('parametros')[36]['VALOR'],
            'APELLIDO_PATERNO.required' => session('parametros')[37]['VALOR'],
            'APELLIDO_MATERNO.required' => session('parametros')[38]['VALOR'],
            'CORREO.required' => session('parametros')[39]['VALOR'],
            'CORREO.email' => session('parametros')[40]['VALOR'],
            'USUARIO.required' => session('parametros')[42]['VALOR'],
            //'ID_MU_ROL.required' => "Por favor, seleccion un rol.",
            'ID_MU_ROL.exists' => session('parametros')[44]['VALOR']
        );
        return Validator::make($data, $reglas, $messages);
    }

    /**
     * Validacion del formulario cambiar contraseña del usuario
     */
    public static $rulesPw = array(
        'password_actual' => 'required',
        'password' => 'required|confirmed'
    );
        //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validarPw($data){
        $reglas = self::$rulesPw;
        //$messages = self::$messages;
        $messages = array(
            'password_actual.required' => session('parametros')[80]['VALOR'],
            'password.required' => session('parametros')[82]['VALOR'],
            'password.confirmed' => session('parametros')[83]['VALOR']
        );
        return Validator::make($data, $reglas, $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (is_null(session('usuario'))){            
            return Redirect::to('/');
        }
        
        $usuario = new Usuario();
        $usuarios = $usuario->getLista();  
        
        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.index", compact('usuarios', 'acciones', 'menus'));
        return view("usuario.index", compact('usuarios', 'acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $usuario = new Usuario();
        $rol = new Rol();
        $roles = $rol->getLista();
        $selectRoles = $this->cargarSelectRol($roles);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.create", compact('usuario', 'selectRoles', 'acciones', 'menus'));
        return view("usuario.create", compact('usuario', 'selectRoles', 'acciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //protected $fillable = ['CI', 'NOMBRE', 'APELLIDO_PATERNO', 'APELLIDO_MATERNO', 'TELEFONO', 'CORREO', 'USUARIO',  
        //                       'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'BLOQUEADO', 'ID_MU_ROL', 'ESTADO'];
        //dd($request->all());
        $usuario = new Usuario();
        $usuario->CI = $request["ci"];
        $usuario->NOMBRE = $request["nombre"];
        $usuario->APELLIDO_PATERNO = $request["paterno"];
        $usuario->APELLIDO_MATERNO = $request["materno"];
        $usuario->TELEFONO = $request["telefono"];
        $usuario->CORREO = $request["correo"];
        $usuario->USUARIO = $request["usuario"];
        $usuario->FECHA_REGISTRO = date('Y-m-d H:i:s');
        $usuario->FECHA_ACTUALIZACION = date('Y-m-d H:i:s');
        $usuario->INTENTO = 0;
        $usuario->BLOQUEADO = false;
        $usuario->ID_MU_ROL = $request["rol"];
        $usuario->ESTADO = true;

        $datos = $usuario->toArray();

        $v = Self::validar($datos);

        if($v->fails()){
            $errors = $v->messages()->all();
        }

        if (!$usuario->esUnicoUsuario(0, $usuario->USUARIO)){
            $errors[] = session('parametros')[43]['VALOR'];
        }
            
        if (!$usuario->esUnicoCorreo(0, $usuario->CORREO)){
            $errors[] = session('parametros')[41]['VALOR'];
        }
        
        if (isset($errors)){
            $rol = new Rol();
            $roles = $rol->getLista();
            $selectRoles = $this->cargarSelectRol($roles); 

            $acciones = $this->permisos;
            //$menus = $this->menus; 
            //return view('usuario.create', compact('usuario', 'selectRoles', 'errors', 'acciones', 'menus'));
            return view('usuario.create', compact('usuario', 'selectRoles', 'errors', 'acciones'));
        }        

        //$inicioSesion = session('usuario')->ID;
        $usuario->save();

        Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_NUEVO'), 'Se registro un nuevo usuario: '.$usuario);
     
        $this->guardarPassword($usuario->CI, $usuario->ID, Password::GENERADO_SISTEMA, session('usuario')->ID);
        Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_NUEVO'), 'Se creo el nuevo password del usuario: '.$usuario->USUARIO);

        return Redirect::to('usuario');            
    }    

    private function guardarPassword($ci, $idUsuario, $generado, $idUsuarioRegistrado){
        $password = new Password();
        $password->PWD = base64_encode($ci);
        $password->FECHA_REGISTRO = date('Y-m-d H:i:s');
        $password->ID_MU_USUARIO = $idUsuario;
        $password->PWD_GENERADO = $generado;
        $password->ID_MU_USUARIO_REGISTRO = $idUsuarioRegistrado;
        //dd($idUsuario.", ".$generado.", ".$idUsuarioRegistrado);
        $password->save();        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $usuario = Usuario::find($id);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.detalle", compact('usuario', 'acciones', 'menus'));
        return view("usuario.detalle", compact('usuario', 'acciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $usuario = Usuario::find($id);
        $rol = new Rol();
        $roles = $rol->getLista();
        $selectRoles = $this->cargarSelectRol($roles);
        //dd($selectRoles);
        
        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view('usuario.edit', compact('usuario', 'selectRoles', 'acciones', 'menus'));
        return view('usuario.edit', compact('usuario', 'selectRoles', 'acciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $usuario = Usuario::find($id);
        $usuario->CI = $request["ci"];
        $usuario->NOMBRE = $request["nombre"];
        $usuario->APELLIDO_PATERNO = $request["paterno"];
        $usuario->APELLIDO_MATERNO = $request["materno"];
        $usuario->TELEFONO = $request["telefono"];
        $usuario->CORREO = $request["correo"];
        $usuario->USUARIO = $request["usuario"];
        $usuario->FECHA_ACTUALIZACION = date('Y-m-d H:i:s');
        $usuario->ID_MU_ROL = $request["rol"];

        $datos = $usuario->toArray();

        $v = Self::validar($datos);

        if($v->fails()){
            $errors = $v->messages()->all();
        }

        if (!$usuario->esUnicoUsuario($usuario->ID, $usuario->USUARIO)){
            $errors[] = session('parametros')[43]['VALOR'];
        }

        if (!$usuario->esUnicoCorreo($usuario->ID, $usuario->CORREO)){
            $errors[] = session('parametros')[41]['VALOR'];
        }

        if (isset($errors) > 0){
            $rol = new Rol();
            $roles = $rol->getLista();
            $selectRoles = $this->cargarSelectRol($roles);  
            return view('usuario.edit', compact('usuario', 'selectRoles', 'errors'));    
        }

        $usuario->save();
        Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_EDITAR'), 'Se modifico el usuario: '.$usuario);
        return Redirect::to('usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDelete($id){
        $usuario = Usuario::find($id);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //$errors;
        if (session('usuario')->ID == $usuario->ID){
            $errors[] = session('parametros')[107]['VALOR']; 
        }
        return view("usuario.delete", compact('usuario', 'acciones', 'errors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $usuario = Usuario::find($id);
        $usuario->ESTADO = false;
        $usuario->save();
        Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino al usuario: '.$usuario->USUARIO);
        return Redirect::to('usuario');
    }

    public function listar(){
        $usuario = new Usuario();
        $usuarios = $usuario->getLista();
        return view("usuario.index", compact('usuarios'));
        //dd(Usuario::All());
    }

    public function cargarSelectRol($roles){
        $selectRoles = array('0' => '[Seleccione un rol]');
        foreach ($roles as $rol) {
            $selectRoles[$rol->ID] = $rol->NOMBRE;
        }
        return $selectRoles;
    }

    /**
     * IMPLEMENTACION DE USUARIO A DESBLOQUEAR
     * GET y POST
     */
    public function mostrarDesbloquear($idUsuario){
        $usuario = Usuario::find($idUsuario);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.desbloquear", compact('usuario', 'acciones', 'menus'));
        return view("usuario.desbloquear", compact('usuario', 'acciones'));
    }

    public function guardarDesbloquear(Request $request, $idUsuario){
        /**
         * El campo desbloquear tiene 2 valores: [0, 1]
         * 0 => Significa desbloquear
         * 1 => Significa desbloquear y restablecer contraseña
         */
        //echo "id: ".$idUsuario;
        //dd($request->All());
        $usuario = Usuario::find($idUsuario);
        if (isset($usuario)){
            $desbloquear = $request['desbloquear'];
            if ($desbloquear == Usuario::DESBLOQUEAR){
                $this->actualizarBloqueado($usuario, false);
            }
            if ($desbloquear == Usuario::DESBLOQUEAR_RESTABLECER){
                $this->actualizarBloqueado($usuario, false, 0);
                Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_DESBLOQUEAR'), 'Se desbloqueo al usuario: '.$usuario->USUARIO);
                $this->guardarPassword($usuario->CI, $usuario->ID, Password::GENERADO_SISTEMA, $usuario->ID);
                Bitacora::guardar(config('sistema.ID_FORMULARIO_CAMBIAR_CONTRASENA'), config('sistema.ID_ACCION_EDITAR'), 'Se reseteo la contraseña del usuario: '.$usuario->USUARIO);
            }
            return Redirect::to('usuario');
        }
        else{
            //App::abort(404);
            App::abort(503);
        }
    }

    /**
     * IMPLEMENTACION DE USUARIO BLOQUEADO
     * GET y POST
     */
    public function mostrarBloquear($idUsuario){
        $usuario = Usuario::find($idUsuario);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.bloquear", compact('usuario', 'acciones', 'menus'));
        return view("usuario.bloquear", compact('usuario', 'acciones'));
    }

    public function guardarBloquear($idUsuario){
        /**
         * El campo desbloquear tiene 2 valores: [0, 1]
         * 0 => Significa desbloquear
         * 1 => Significa desbloquear y restablecer contraseña
         */
        $usuario = Usuario::find($idUsuario);
        if (isset($usuario)){            
            $this->actualizarBloqueado($usuario, true, config('sistema.CANTIDAD_INTENTO_BLOQUEADO'));
            Bitacora::guardar(config('sistema.ID_FORMULARIO_USUARIO'), config('sistema.ID_ACCION_BLOQUEAR'), 'Se bloque al usuario: '.$usuario->USUARIO);
            return Redirect::to('usuario');
        }
        else{
            //App::abort(404);
            App::abort(503);
        }
    }

    private function actualizarBloqueado($usuario, $bloqueado, $intento){
        $usuario->BLOQUEADO = $bloqueado;
        $usuario->INTENTO = $intento;
        $usuario->save();        
    }

    /**
     * IMPLEMENTACION PARA CAMBIAR LA CONTRASEÑA
     * GET y POST
     */
    public function cargarCambiarContrasena($idUsuario){
        $usuario = Usuario::find($idUsuario);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("usuario.changepw", compact('usuario', 'acciones', 'menus'));
        return view("usuario.changepw", compact('usuario', 'acciones'));
    }

    public function guardarCambiarContrasena(Request $request){
        //dd($request->all());
        if (is_null(session('usuario'))){            
            return Redirect::to('/');
        }

        $datos = array('password_actual' => base64_encode($request['password_actual']), 'password' => base64_encode($request['password']), 'password_confirmation' => base64_encode($request['password_confirmation']));
        $errors = $this->validarPassword($datos);
        
        $usuario = session('usuario');
        if (count($errors) > 0){
            $rol = new Rol();
            $roles = $rol->getLista();
            $selectRoles = $this->cargarSelectRol($roles);

            $acciones = $this->permisos;
            //$menus = $this->menus;
            //return view('usuario.changepw', compact('usuario', 'selectRoles', 'errors', 'acciones', 'menus'));
            return view('usuario.changepw', compact('usuario', 'selectRoles', 'errors', 'acciones'));
        }

        $this->guardarPassword($request['password'], $usuario->ID, Password::GENERADO_USUARIO, $usuario->ID);
        Bitacora::guardar(config('sistema.ID_FORMULARIO_CAMBIAR_CONTRASENA'), config('sistema.ID_ACCION_EDITAR'), 'Se ha establecido una nueva contraseña: '.$usuario);

        return Redirect::to('usuario');
    }

    private function validarPassword($datos){
        $errors = array();
        $v = Self::validarPw($datos);
        if($v->fails()){
            $errors = $v->messages()->all();
        }

        $usuario = session('usuario');
        $password = new Password();
        $password = $password->existePassword($usuario->ID, $datos['password_actual']);
        if (!isset($password)){
            $errors [] = session('parametros')[81]['VALOR'];
        }

        return $errors;
    }
}
