<?php

namespace base\Http\Controllers;

use base\Model\Category;
use base\Model\Item;
use base\Utils\MyLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use base\Model\umov\Umov;
use Illuminate\Support\Facades\Redirect;
use Validator;

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
        $this->token=Umov::getToken('master','formacionjuan','micrium2016');
    }

    public static $rules = array(
        'nombre' => 'required|max:60',
        'precio' => 'required|max:1000|numeric',
        'stock' => 'required|max:15|numeric',
        'category_id' => 'required|correct_category',
    );
    //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            // 'direccion.required' => session('parametros')[36]['VALOR'],
            'nombre.required' => 'Campo :attribute requerido.',
            'nombre.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 60.",

            'precio.required' => 'Campo :attribute requerido.',
            'precio.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 20.",
            'precio.numeric' => "datos incorrectos en :attribute, no ingrese letras",

            'stock.required' => 'Campo :attribute requerido.',
            'stock.max' => "Maximo de caracteres excedido del campo :attribute, tiene mas de 255.",
            'stock.numeric' => "datos incorrectos en :attribute, no ingrese letras",

            'category_id.correct_category' => "categoria incorrecta, escoja una categoria valida",
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
        $categories = Category::all()->lists('nombre','id')->prepend('Elige una categoria', 0)->toArray();
        return view('item.create', compact('categories'));
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
            $v = Self::validar($request->all());
            if($v->fails()){
                $errors = $v->messages()->all();
                return redirect()->back()->withErrors($v->messages())->withInput();
            }
            $category = Category::where('id',$request->category_id)->get();
            $category_name = $category[0]['attributes']['id'];
            //----- umov
            $precio=$request->precio;
            $preciouMov=str_replace(',','.',$precio);
            $it = new Item($request->all());
            $it->save();
            $id=$it->id;
            $cadena = Umov::getStringItem($id, $category_name, $request->nombre, $request->stock, $preciouMov);
            $activities = Umov::postData($this->token, "item",$cadena);
            if(!is_null($activities)){
                \Session::flash('message', 'el item se creo correctamente');
            }else{
                $it->delete();
                \Session::flash('message', 'no se pudo guardar el item, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
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

        $cat = Category::findOrFail($item->category_id);

        $categories = Category::all()->lists('nombre','id')->prepend($cat->nombre, $cat->id)->toArray();
        return view('item.edit', compact('item','acciones','categories'));
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
            $category = Category::where('id',$request->category_id)->get();
            $category_name = $category[0]['attributes']['id'];
            //----- umov
            $precio=$request->precio;
            $preciouMov=str_replace(',','.',$precio);
            $cadena = Umov::getStringItem($id, $category_name, $request->nombre, $request->stock, $preciouMov);
            $activities = Umov::putData($this->token, "item", $id,$cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $item = Item::findOrFail($id);
                $item->fill($request->all());
                $item->save();
                \Session::flash('message', 'el item se actualizo correctamente');
            }else{
                \Session::flash('message', 'no se pudo actualizar el item, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
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
        try{
            $it = Item::findOrFail($id);
            $ida=$it->ida;
            //----- umov
            $cadena = Umov::getStringItemDestroy();
            $activities = Umov::destroyData($this->token, "item", $id, $cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $it->delete();
                $message = $it->nombre . ' El registro fue Eliminado';

                if ($request->ajax()){
                    return response()->json([
                        'id' => $it->id,
                        'message' => $message
                    ]);
                }

                \Session::flash('message', $message);
            }else{
                \Session::flash('message', 'no se pudo eliminar el item, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }

        return redirect()->route('item.index');
    }

}