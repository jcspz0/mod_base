<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use Validator;
use Redirect;
use Session;
use App;

use \base\Model\Rol;
use \base\Model\TipoParametro;
use \base\Model\Permiso;
use \base\Model\RolTipoParametro;
use \base\Model\Parametro;
use \base\Model\RolFormulario;
use \base\Model\FormularioAccion;
use \base\Model\Formulario;
use \base\Model\Accion;
use \base\Model\Bitacora;
use \base\Model\Usuario;
use \base\Classes\EstructuraArbol;
//use \base\Classes\Menu;

class RolController extends Controller{    

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){            
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_ROL');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
            }
        });
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

        $rol = new Rol();
        $roles = $rol->getLista();

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("rol.index", compact('roles', 'acciones', 'menus'));

        return view("rol.index", compact('roles', 'acciones'));
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $rol = new Rol();

        $acciones = $this->permisos;
        return view("rol.create", compact('rol', 'acciones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        //dd($request->all());
        $rol = new Rol();
        $rol->NOMBRE = $request['nombre'];
        $rol->DESCRIPCION = $request['descripcion'];;
        $rol->ESTADO = true;

        //$datos = array('nombre' => $request['nombre'], 'descripcion' => $request['descripcion']);
        $datos = $rol->toArray();        
        $v = Self::validar($datos);

        if($v->fails()){
            $errors = $v->messages()->all();            
        }

        if (!$rol->esUnicoNombre(0, $rol->NOMBRE)){
            $errors[] = session('parametros')[11]['VALOR'];
        }

        if (isset($errors)){
            $acciones = $this->permisos;
            return view('rol.create', compact('rol', 'errors', 'acciones'));
        }

        $rol->save();
        Bitacora::guardar(config('sistema.ID_FORMULARIO_ROL'), config('sistema.ID_ACCION_NUEVO'), 'Se registro un nuevo rol: '.$rol);
        $this->guardarRolFormulario($rol->ID);

        return Redirect::to('rol');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $rol = Rol::find($id);

        $acciones = $this->permisos;
        return view("rol.detalle", compact('rol', 'acciones'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $rol = Rol::find($id);

        $acciones = $this->permisos;
        return view('rol.edit', compact('rol', 'acciones'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $rol = Rol::find($id);
        $rol->NOMBRE = $request['nombre'];
        $rol->DESCRIPCION = $request['descripcion'];

        $datos = $rol->toArray();        
        $v = Self::validar($datos);

        if($v->fails()){
            $errors = $v->messages()->all();            
        }

        if (!$rol->esUnicoNombre($rol->ID, $rol->NOMBRE)){
            $errors[] = session('parametros')[11]['VALOR'];
        }

        if (isset($errors)){
            $acciones = $this->permisos;
            //return Redirect::action('RolController@edit', array($id));
            return view('rol.edit', compact('rol', 'errors', 'acciones'));
        }

        $rol->save();
        Bitacora::guardar(config('sistema.ID_FORMULARIO_ROL'), config('sistema.ID_ACCION_EDITAR'), 'Se modifico el rol: '.$rol);
        //Session::flash("message", "Rol editado correctamente.");
        return Redirect::to('rol');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showDelete($id){
        $rol = Rol::find($id);

        $acciones = $this->permisos;

        $usuario = new Usuario();
        $usuarios = $usuario->getListaPorRol($id);
        $errors;
        if (count($usuarios) > 0){
            $errors[] = session('parametros')[106]['VALOR'];
        }

        return view("rol.delete", compact('rol', 'acciones', 'errors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $rol = Rol::find($id);
        $rol->ESTADO = false;
        $rol->save();
        Bitacora::guardar(config('sistema.ID_FORMULARIO_ROL'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino el rol: '.$rol->NOMBRE);
        //Session::flash('message', 'Rol Eliminado Correctamente');
        return Redirect::to('rol');
    }

    public static $rules = array(
        //'NOMBRE' => 'required|max:50|unique:mu_rol',
        'NOMBRE' => 'required',
        //'DESCRIPCION' => 'required|max:200', 
        'DESCRIPCION' => 'required', 
    );

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            'NOMBRE.required' => session('parametros')[10]['VALOR'],
            //'NOMBRE.unique' => "El nombre del rol ya se encuentra registrado.",
            //'NOMBRE.max' => "Maximo de caracteres excedido, mas de 50.",
            'DESCRIPCION.required' => session('parametros')[12]['VALOR'],
            //'DESCRIPCION.max' => "Maximo de caracteres excedido."
        );
        return Validator::make($data, $reglas, $messages);
    }

    /**
     * IMPLEMENTACION DE ROL PARAMETROS
     */
    public function crearPermisoParametro($idRol){
        $rol = Rol::find($idRol);
        $permisos = Permiso::All();
        $tipoParametros = TipoParametro::All();
        $selectPermisos = $this->cargarSelectPermiso($permisos);
        //dd($rol);
        
        $rolTipoParametros = array();
        foreach ($tipoParametros as $tipoParametro) {
            $rolTipoParametro = new RolTipoParametro();
            $rolTipoParametro = $rolTipoParametro->getRolTipoParametro($rol->ID, $tipoParametro->ID);
            if (!isset($rolTipoParametro)){
                $rolTipoParametro = new RolTipoParametro();
                $rolTipoParametro->ID = 0;
                $rolTipoParametro->ID_MU_ROL = $rol->ID;
                $rolTipoParametro->ID_MU_TIPO_PARAMETRO = $tipoParametro->ID;
                $rolTipoParametro->ID_MU_PERMISO = 0;                
            }            
            $rolTipoParametro->nombreTipoParametro = $tipoParametro->NOMBRE;
            $rolTipoParametros[] = $rolTipoParametro;
        }
        
        $acciones = $this->permisos;
        //return view("rol.parametrizar", compact('rol', 'selectPermisos', 'tipoParametros'));
        return view("rol.parametrizar", compact('rol', 'selectPermisos', 'rolTipoParametros', 'acciones'));
    }

    /*public function guardarPermisoParametro(Request $request, $idRol){
        $idRolTipoParametros = array_slice($request->All(), 1);
        //dd($idRolTipoParametros);
        $rol = Rol::find($idRol);
        if (isset($rol)){
            foreach ($idRolTipoParametros as $key => $idPermiso) {
                $tupla = explode("_", $key);
                $id = $tupla[1];
                $idTipoParametro = $tupla[2];
                if ($id <> 0){
                    $rolTipoParametro = RolTipoParametro::find($id);
                    $rolTipoParametro->ID_MU_PERMISO = $idPermiso;
                }
                else{
                    $rolTipoParametro = new RolTipoParametro();
                    $rolTipoParametro->ID_MU_ROL = $rol->ID;
                    $rolTipoParametro->ID_MU_TIPO_PARAMETRO = $idTipoParametro;
                    $rolTipoParametro->ID_MU_PERMISO = $idPermiso;
                }
                $rolTipoParametro->save();
            }
            return Redirect::to('rol');
        }
        else{
            //App::abort(404);
            App::abort(503);
        }
    }*/

    public function guardarPermisoParametro(Request $request){
        //dd($request->all());
        if ( $request->ajax() ){
            $rol = Rol::find($request['idRol']);
            if (isset($rol)){
                $idRolTipoParametro = $request['idRolTipoParametro'];
                if ($idRolTipoParametro <> 0){
                    $rolTipoParametro = RolTipoParametro::find($idRolTipoParametro);
                    $rolTipoParametro->ID_MU_PERMISO = $request['idPermiso'];
                }
                else{
                    $rolTipoParametro = new RolTipoParametro();
                    $rolTipoParametro->ID_MU_ROL = $rol->ID;
                    $rolTipoParametro->ID_MU_TIPO_PARAMETRO = $request['idTipoParametro'];
                    $rolTipoParametro->ID_MU_PERMISO = $request['idPermiso'];
                }
                $rolTipoParametro->save();
               
                return response()->json(['result' => true, 'mensaje' => session('parametros')[29]['VALOR']]);
            }
            else{
                //App::abort(404);
                return response()->json(['result' => false, 'mensaje' => 'No se pudo actualizarse el permiso.']);
                //App::abort(503);
            }
        }
    }

    public function cargarSelectPermiso($permisos){
        $selectPermisos = array();
        foreach ($permisos as $permiso) {
            $selectPermisos[$permiso->ID] = $permiso->NOMBRE;
        }
        return $selectPermisos;
    }

    /**
     *  IMPLEMENTACION DEL ROL PERMISOS
     */
    public function crearPermiso($idRol){
        $rol = Rol::find($idRol);

        $acciones = $this->permisos;
        return view("rol.permiso", compact('rol', 'acciones'));
    }

    public function cargarArbol(Request $request){
        if ( $request->ajax() ){
            $idRol = $request['idRol'];
            //$idRol = 0;
            $rol = Rol::find($idRol);          
            if (isset($rol)){
                $rolFormulario = new RolFormulario();
                //$listaRolFormularios = $rolFormulario->getLista($idRol);

                $formulario = new Formulario();
                $listaMenu = $formulario->getListaMenuPadre();
                //dd($listaMenu->toArray());
                $arbol = array();
                foreach ($listaMenu as $menu) {
                    $listaItems = $formulario->getListaItems($menu->ID);
                    if (count($listaItems) > 0){
                        $arbol[] = $this->crearArbol($menu->ID, "#", $menu->NOMBRE, "", false);
                        //dd($listaItems->toArray());
                        foreach ($listaItems as $item) {
                            $arbol[] = $this->crearArbol($item->ID, $item->ID_FORMULARIO, $item->NOMBRE, "", false);
                            $listaAccion = $rolFormulario->getListaAccion($item->ID, $idRol);
                            //dd($listaAccion->toArray());
                            foreach ($listaAccion as $accion) {
                                //$id = "check_".$menu->ID."_".$item->ID."_".$accion->ID_MU_ACCION;
                                $id = "check_".$accion->ID."_".$item->ID."_".$accion->ID_MU_ACCION;
                                //echo $parent."<br>";
                                $_accion = Accion::find($accion->ID_MU_ACCION);
                                $icon = "glyphicon glyphicon-ok";
                                $arbol[] = $this->crearArbol($id, $item->ID, $_accion->NOMBRE, $icon, $accion->ESTADO);
                            }
                        }
                    }
                }
                //dd(response()->json($arbol));
                return response()->json(['result' => true, 'arbol' => $arbol]);
            }
            else{
                //App::abort(503);
                return response()->json(['result' => false, 'ruta' => 'usuario']);
            }
        }
    }

    private function crearArbol($id, $parent, $text, $icon, $selected){
        $arbol = new EstructuraArbol();
        $arbol->id = $id;
        $arbol->parent = $parent;
        $arbol->text = $text;
        if ($icon != ""){
            $arbol->icon = $icon;
        }
        $arbol->state['selected']  = $selected;
        return $arbol;
    }

    public function guardarArbol(Request $request){
        if ( $request->ajax() ){
            $idRol = $request['idRol'];
            $rol = Rol::find($idRol);
            if (!is_null($rol)){
                $rolFormulario = new RolFormulario();
                $rolFormulario->updateByRol($idRol);
                
                //dd($request->all());
                $datos = $request->all();
                foreach ($datos as $key => $value) {
                    $check = explode("_", $key);
                    if (count($check) == 4){
                        //echo "KEY: ".$key.", ".$check[1];
                        $rolFormulario = RolFormulario::find($check[1]);
                        $rolFormulario->ESTADO = true;
                        $rolFormulario->save();
                    }
                }
                return response()->json(['result' => true, 'mensaje' => session('parametros')[33]['VALOR']]); 
            }
            else{
                return response()->json(['result' => false, 'mensaje' => session('parametros')[34]['VALOR']]);                 
            }
        }
        return response()->json(['result' => false, 'mensaje' => session('parametros')[34]['VALOR']]); 
    }

    /**
     *  SE ENCARGA DE GUARDAR TODOS LOS FORMULARIO DE UN ROL A LA TABLA ROL FORMULARIO
     */
    public function guardarRolFormulario($rolId){
        $formularioAccion = FormularioAccion::where('ESTADO', true)
                                            ->get();
        foreach ($formularioAccion as $fa) {
            $rolFormulario = new RolFormulario();
            $rolFormulario->ID_MU_FORMULARIO = $fa->ID_MU_FORMULARIO;
            $rolFormulario->ID_MU_ROL = $rolId;
            $rolFormulario->ID_MU_ACCION = $fa->ID_MU_ACCION;
            $rolFormulario->ESTADO = false;
            $rolFormulario->save();
        }
    }
}
