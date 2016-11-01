<?php

namespace base\Http\Controllers;

use base\Model\Client;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use base\Model\umov\Umov;
use Validator;

class ClientController extends Controller
{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_CLIENTE');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
                //dd($this->permisos);
            }
        });
        $this->token=Umov::getToken('master','formacionjuan','micrium2016');
    }

    public static $rules = array(
        //'CI' => 'required|min:7|max:20',
        'nombre' => 'required|max:60',
        'razon_social' => 'required|max:20',
        'latitud' => 'required|max:255|numeric',
        'longitud' => 'required|max:20|numeric',
        // 'id_cliente' => 'required|not_in:0'
    );
    //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            // 'direccion.required' => session('parametros')[36]['VALOR'],
            'nombre.required' => 'Campo :attribute requerido.',
            'nombre.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 60.",

            'razon_social.required' => 'Campo :attribute requerido.',
            'razon_social.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 20.",

            'latitud.required' => 'Campo :attribute requerido.',
            'latitud.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 255.",
            'latitud.numeric' => "coordenadas incorrectas en :attribute, no ingrese letras",

            'longitud.required' => 'Campo :attribute requerido.',
            'longitud.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 20.",
            'longitud.numeric' => "coordenadas incorrectas en :attribute, no ingrese letras",

            // 'id_cliente.required' => 'La empresa requiered el id del cliente.',
            // 'id_cliente.not_in' => 'La empresa a crear no tiene el id del cliente asociado.',

        );
        return Validator::make($data, $reglas, $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$clients = \DB::table('mu_client')->get();
        $clients = Client::name($request->get('nombre'))->orderBy('id', 'ASC')->paginate(5);
        //dd($clients);
        $acciones = $this->permisos;
        return view('client.index', compact('clients','acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            //----- umov
            $v = Self::validar($request->all());
            if($v->fails()){
                $errors = $v->messages()->all();
                return redirect()->back()->withErrors($v->messages())->withInput();
            }
            $client = new Client($request->all());
            $client->save();
            $id=$client->id;
            $cadena = Umov::getStringClient($id, $request->nombre,$request->razon_social, $request->latitud, $request->longitud);
            $activities = Umov::postData($this->token, "serviceLocal",$cadena);
            if(!is_null($activities)){
                \Session::flash('message', 'el cliente se creo correctamente');
            }else{
                $client->delete();
                \Session::flash('message', 'no se pudo guardar el cliente, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('client.index');
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
        $client = Client::findOrFail($id);
        $acciones = $this->permisos;

        return view('client.edit', compact('client','acciones'));
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
        try{
            $v = Self::validar($request->all());
            if($v->fails()){
                $errors = $v->messages()->all();
                return redirect()->back()->withErrors($v->messages())->withInput();
            }
            $cadena = Umov::getStringClient($id, $request->nombre,$request->razon_social, $request->latitud, $request->longitud);
            $activities = Umov::putData($this->token, "serviceLocal", $id,$cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $client = Client::findOrFail($id);
                $client->fill($request->all());
                $client->save();
                \Session::flash('message', 'el cliente se actualizo correctamente');
            }else{
                \Session::flash('message', 'no se pudo actualizar el cliente, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('client.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            $cli = Client::findOrFail($id);
            //----- umov
            $cadena = Umov::getStringClientDestroy();
            $activities = Umov::destroyData($this->token, "serviceLocal", $id, $cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $cli->delete();
                $message = $cli->nombre . ' El registro fue Eliminado';

                if ($request->ajax()){
                    return response()->json([
                        'id' => $cli->id,
                        'message' => $message
                    ]);
                }

                \Session::flash('message', $message);
            }else{
                \Session::flash('message', 'no se pudo eliminar el cliente, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('client.index');
    }
}
