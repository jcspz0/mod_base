<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;
use base\Http\Requests;
use base\Http\Controllers\Controller;

use Redirect;

use \base\Model\RolTipoParametro;
use \base\Model\Usuario;
use \base\Model\TipoParametro;
use \base\Model\Parametro;
use \base\Model\Bitacora;
use \base\Utils\Convert;

class TipoParametroController extends Controller{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){            
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_PARAMETRO');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
                //dd($this->permisos);
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //echo "PASANDO X EL INDEX ::.";
        if (is_null(session('usuario'))){            
            return Redirect::to('/');
        }
        
        $usuario = session('usuario');

        $tipoParametro = new TipoParametro();
        $tipoParametros = $tipoParametro->getListaByIdRol($usuario->mu_rol->ID);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("tipo_parametro.index", compact('tipoParametros', 'usuario', 'selectRoles', 'acciones', 'menus'));
        return view("tipo_parametro.index", compact('tipoParametros', 'usuario', 'selectRoles', 'acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
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

    //  METODOS PARA LOS PARAMETROS
    public function parametro($idTipoParametro){
        //echo "ParametroController: idTipoParametro=".$idTipoParametro;
        $parametro = new Parametro();
        $parametros = $parametro->getListaParametroByTipoParametro($idTipoParametro);

        $idRol = session('usuario')->mu_rol->ID;
        $rolTipoParametro = new RolTipoParametro();
        $rolTipoParametro = $rolTipoParametro->getRolTipoParametro($idRol, $idTipoParametro);
        $permiso = $rolTipoParametro->ID_MU_PERMISO;

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("tipo_parametro.parametro", compact('parametros', 'permiso', 'acciones', 'menus'));
        return view("tipo_parametro.parametro", compact('parametros', 'permiso', 'acciones'));
    }

    /**
     * METODOS PARA EDITAR PARAMETRO
     * GET Y POST
     */
    public function editParametro($idTipoParametro, $idParametro){
        $parametro = new Parametro();
        $parametro = $parametro->getParametroByTipoParametro($idParametro, $idTipoParametro);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("tipo_parametro.edit", compact('parametro', 'acciones', 'menus'));   
        return view("tipo_parametro.edit", compact('parametro', 'acciones'));   
    }

    public function updateParametro($idTipoParametro, $idParametro, Request $request){
        $parametro = new Parametro();
        $parametro = $parametro->getParametroByTipoParametro($idParametro, $idTipoParametro);
        $parametro->VALOR = $request['valor'];
        $parametro->DESCRIPCION_CAMPO = $request['descripcion'];
        if($idParametro==112){
            $parametro->VALOR = Convert::encrypt($request['valor']);
        }
        $parametro->save();
        //return view("tipo_parametro.edit", compact('parametro')); 
        //return Redirect::to('rol');
        Bitacora::guardar(config('sistema.ID_FORMULARIO_PARAMETRO'), config('sistema.ID_ACCION_EDITAR'), 'Se modifico el parametro: '.$parametro);

        $parametro->cargarParametroSession(); 
        return Redirect::action('TipoParametroController@parametro', array($idTipoParametro));
    }
    
    /**
     * METODO PARA DETALLE DE UN PARAMETRO
     */
    public function detalleParametro($idTipoParametro, $idParametro){
        $parametro = new Parametro();
        $parametro = $parametro->getParametroByTipoParametro($idParametro, $idTipoParametro);

        $acciones = $this->permisos;
        //$menus = $this->menus;
        //return view("tipo_parametro.detalle", compact('parametro', 'acciones', 'menus'));
        return view("tipo_parametro.detalle", compact('parametro', 'acciones'));
    }

}
