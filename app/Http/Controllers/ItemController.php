<?php

namespace base\Http\Controllers;

use base\Model\Category;
use base\Model\Item;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_ITEM');
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
        $items = Item::name($request->get('nombre'))->orderBy('id', 'ASC')->paginate(5);
        //dd($clients);
        $acciones = $this->permisos;
        return view('item.index', compact('items','acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all()->lists('nombre','id');
        $combobox =  array(0=>'seleccione una categoria');
        foreach ($categories as $category){
            array_push($combobox,$category);
        }
        $selected = array();
        return view('item.create', compact('combobox', 'selected'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item($request->all());
        $item->save();

        return redirect()->route('item.index');
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
        $item = Item::findOrFail($id);
        $acciones = $this->permisos;

        $categories = Category::all()->lists('nombre','id');
        $combobox =  array(0=>'seleccione una categoria');
        foreach ($categories as $category){
            array_push($combobox,$category);
        }
        $selected = array();
        return view('item.edit', compact('item','acciones','combobox', 'selected'));
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
        $item = Item::findOrFail($id);

        $item->fill($request->all());
        $item->save();

        return redirect()->route('item.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $item->delete();

        $message = $item->nombre . ' El registro fue Eliminado';

        if ($request->ajax()){
            return response()->json([
                'id' => $item->id,
                'message' => $message
            ]);
        }

        \Session::flash('message', $message);

        return redirect()->route('item.index');
    }
}
