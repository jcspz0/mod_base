<?php

namespace base\Http\Controllers;

use base\Model\Client;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;


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
        $client = new Client($request->all());
        $client->save();

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
        $client = Client::findOrFail($id);

        $client->fill($request->all());
        $client->save();

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
        $client = Client::findOrFail($id);

        $client->delete();

        $message = $client->nombre . ' El registro fue Eliminado';

        if ($request->ajax()){
            return response()->json([
                'id' => $client->id,
                'message' => $message
            ]);
        }

        \Session::flash('message', $message);

        return redirect()->route('client.index');
    }
}
