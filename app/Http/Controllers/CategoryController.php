<?php

namespace base\Http\Controllers;

use base\Model\Bitacora;
use base\Model\Category;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use base\Model\umov\Umov;
use Validator;


class CategoryController extends Controller
{

    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_CATEGORY');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
                //dd($this->permisos);
            }
        });
        $this->token=session('parametros')[113]['VALOR'];
    }

    public static $rules = array(
        'nombre' => 'required|max:60',
    );
    //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            // 'direccion.required' => session('parametros')[36]['VALOR'],
            'nombre.required' => session('parametros')[146]['VALOR'],//'Campo :attribute requerido.',
            'nombre.max' => session('parametros')[147]['VALOR'],//"Maximo de caracteres excedido del campo :attribute, tiene mas de 60.",
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
        $categories = Category::name($request->get('nombre'))->orderBy('id', 'ASC')->paginate(5);
        $acciones = $this->permisos;
        return view('category.index', compact('categories','acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
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
            //----- umov
            $category = new Category($request->all());
            $category->save();
            $id = $category->id;
            $cadena = Umov::getStringCategory($id, $request->nombre);
            $activities = Umov::postData($this->token, "subGroup",$cadena);
            if(!is_null($activities)){
                \Session::flash('message', 'la categoria se creo correctamente');
                Bitacora::guardar(config('sistema.ID_FORMULARIO_CATEGORY'), config('sistema.ID_ACCION_NUEVO'), 'Se creo la categoria: '.$category);
            }else{
                $category->delete();
                \Session::flash('message', 'no se pudo guardar la categoria, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('category.index');
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
        $category = Category::findOrFail($id);
        $acciones = $this->permisos;
        return view('category.edit', compact('category','acciones'));
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
            $cadena = Umov::getStringCategory($id, $request->nombre);
            $activities = Umov::putData($this->token, "subGroup", $id,$cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $category = Category::findOrFail($id);
                $category->fill($request->all());
                $category->save();
                \Session::flash('message', 'la categoria se actualizo correctamente');
                Bitacora::guardar(config('sistema.ID_FORMULARIO_CATEGORY'), config('sistema.ID_ACCION_EDITAR'), 'Se edito la categoria: '.$category);
            }else{
                \Session::flash('message', 'no se pudo actualizar la categoria, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }

        return redirect()->route('category.index');
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
            $cat = Category::findOrFail($id);
            //----- umov
            $cadena = Umov::getStringCategoryDestroy();
            $activities = Umov::destroyData($this->token, "subGroup", $id, $cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $cat->delete();
                $message = $cat->nombre . ' El registro fue Eliminado';

                if ($request->ajax()){
                    Bitacora::guardar(config('sistema.ID_FORMULARIO_CATEGORY'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino la categoria: '.$cat);
                    return response()->json([
                        'id' => $cat->id,
                        'message' => $message
                    ]);
                }

                \Session::flash('message', $message);
                Bitacora::guardar(config('sistema.ID_FORMULARIO_CATEGORY'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino la categoria: '.$cat);
            }else{
                \Session::flash('message', 'no se pudo eliminar la categoria, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }

        return redirect()->route('category.index');
    }
}
