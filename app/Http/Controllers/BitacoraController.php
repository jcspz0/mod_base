<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use Redirect;
use Session;

use \base\Model\Bitacora;
use \base\Model\Accion;
use \base\Model\Formulario;
use \base\Model\Usuario;
use \base\Classes\LazyDatatable;

class BitacoraController extends Controller{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){            
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_BITACORA');
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
        if ( is_null( session('usuario') ) ){            
            return Redirect::to('/');
        }

        /*$bitacora = new Bitacora();
        $bitacoras = $bitacora->getLista();        
        return view("bitacora.index", compact('bitacoras'));*/

        $acciones = $this->permisos;
        //$menus = $this->menus;

        //return view("bitacora.index");
        //return view("bitacora.index", compact('acciones', 'menus'));
        return view("bitacora.index", compact('acciones'));
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
    public function show($id)
    {
        return Redirect::to("generateUmov");
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

    public function getBitacora(Request $request){
        //dd( $request->All() );
        if ( $request->ajax() ){

            $bitacora = new Bitacora();
            $totalRegistros = $bitacora->getTotal();
            $bitacoras = $bitacora->getLista($request['start'], $request['length']);


            $registros = new LazyDatatable();
            
            $registros->draw = $request['draw'];;
            $registros->recordsFiltered = $totalRegistros;
            $registros->recordsTotal = $totalRegistros;

            $datos = array();
            foreach ($bitacoras as $bitacora) {
                $tupla['fechaHora'] = $bitacora->fechaRegistro();
                //$tupla['accion'] = $bitacora->ID_MU_ACCION;
                //{{$usuario->mu_rol->NOMBRE}}
                $accion = Accion::find($bitacora->ID_MU_ACCION);
                $tupla['accion'] = $accion->NOMBRE;
                $formulario = Formulario::find($bitacora->ID_MU_FORMULARIO);
                $tupla['formulario'] = $formulario->NOMBRE;
                $usuario = USUARIO::find($bitacora->ID_MU_USUARIO);
                $tupla['usuario'] = $usuario->USUARIO;
                $tupla['descripcion'] = $bitacora->DESCRIPCION;
                $tupla['direccionIp'] = $bitacora->DIRECCION_IP;
                $datos[] = $tupla;
            }
            $registros->data = $datos;

            //dd(response()->json($registros));
            return response()->json($registros); 
        }
    }
}
