<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use \base\Model\Usuario;
use \base\Model\Rol;
use \base\Model\Formulario;
use \base\Classes\Menu;
use \base\Model\umov\Umov;
use \base\Model\Parametro;
use \base\Utils\Convert;

Route::resource('callback','callback\callbackController');

Route::resource('stock','StockController');

Route::resource('item','ItemController');

Route::resource('client','ClientController');
Route::resource('category','CategoryController');

Route::resource('guz','umov\GuzzleController');


Route::get('generateUmov', ['as' => 'generateUmov', 'uses' => function(){
    if (is_null(session('usuario'))){
        return Redirect::to('/');
    }
    $token = Umov::getToken(session('parametros')[110]['VALOR'],session('parametros')[111]['VALOR'],Convert::decrypt(session('parametros')[112]['VALOR']));
    if(!is_null($token)){
        $parametro = new Parametro();
        $parametro = $parametro->getParametroByTipoParametro(113, 12);//113 es el id del token en mu_parametro y 12 es el id en mu_tipo_parametro
        $parametro->VALOR = $token;
        $parametro->save();
        \Session::flash('message', 'se genero un nuevo token de uMov');
    }else{
        \Session::flash('message', 'no se pudo generar el token de uMov, verifique sus datos de autentificacion');
    }
    return Redirect::back();
}]);

/**
 * Ruta de pagina bienvenida
 */

Route::get('bienvenido', function () {
    if (is_null(session('usuario'))){            
        return Redirect::to('/');
    }

	$idRol = session('usuario')->mu_rol->ID;
    
	$formulario = new Formulario();
    $formularios = $formulario->getListaMenuPadre();

    $menus = array();
    foreach ($formularios as $formulario) {
        //dd($menu->toArray());
        $menu = new Menu();
        $menu->menu = $formulario;
        $menu->items = $formulario->getListaItemsPorRolFormulario($formulario->ID, $idRol);
        $menus[] = $menu;
    }
    session(['menus' => $menus]);
    return view('bienvenido');
});

/**
 * Rutas de Login
 */
Route::get('/', 'LoginController@index');
Route::resource('login', 'LoginController');
Route::get('logout', 'LoginController@logout');

//Route::resource('login', 'LoginController');

/**
 * Rutas del controlador Rol
 */
Route::resource('rol', 'RolController');

Route::get('rol/{id}/delete', 'RolController@showDelete');

Route::get('rol/{id}/parametrizar', 'RolController@crearPermisoParametro');
//Route::post('guardarPermisoParametro', 'RolController@guardarPermisoParametro');
Route::post('guardarPermisoParametro', ['as' => 'guardarPermisoParametro', 'uses' => 'RolController@guardarPermisoParametro']);
//Route::post('rol/{id}/parametrizar', 'RolController@guardarPermisoParametro');


Route::get('rol/{id}/permiso', 'RolController@crearPermiso');
Route::post('rol/{id}/permiso', 'RolController@guardarPermiso');

//Route::post('cargarArbol', 'RolController@cargarArbol');
//Route::post('guardarArbol', 'RolController@guardarArbol');
Route::post('cargarArbol', ['as' => 'cargarArbol', 'uses' => 'RolController@cargarArbol']);
Route::post('guardarArbol', ['as' => 'guardarArbol', 'uses' => 'RolController@guardarArbol']);

/**
 * Rutas del controlador Usuario
 */
Route::resource('usuario', 'UsuarioController');
Route::get('usuario/{id}/delete', 'UsuarioController@showDelete');

Route::get('usuario/{id}/desbloquear', 'UsuarioController@mostrarDesbloquear');
Route::post('usuario/{id}/desbloquear', 'UsuarioController@guardarDesbloquear');

Route::get('usuario/{id}/bloquear', 'UsuarioController@mostrarBloquear');
Route::post('usuario/{id}/bloquear', 'UsuarioController@guardarBloquear');

Route::get('usuario/{id}/changepd', 'UsuarioController@cargarCambiarContrasena');
Route::post('usuario/{id}/changepd', 'UsuarioController@guardarCambiarContrasena');

/**
 * Rutas del controlador Tipo Parametro
 */
Route::resource('tipo_parametro', 'TipoParametroController');

Route::get('tipo_parametro/{idTipoParametro}/parametro', 'TipoParametroController@parametro');

Route::get('tipo_parametro/{idTipoParametro}/parametro/{idParametro}/detalle', 'TipoParametroController@detalleParametro');

Route::get('tipo_parametro/{idTipoParametro}/parametro/{idParametro}/edit', 'TipoParametroController@editParametro');
Route::post('tipo_parametro/{idTipoParametro}/parametro/{idParametro}/edit', 'TipoParametroController@updateParametro');


/**
 * Rutas del controlador Bitacora
 */
Route::resource('bitacora', 'BitacoraController');
//Route::post('getBitacora', 'BitacoraController@getBitacora');
Route::post('getBitacora', ['as' => 'getBitacora', 'uses' => 'BitacoraController@getBitacora']);



/*Route::any('imagen1', function () {
    return view('template.imagen1');
});
Route::any('imagen2', function () {
    return view('imagen2');
});*/

/*Route::any('imagen1', ['as' => 'imagen1', function () {
    return view('template.imagen1');
} ]);
Route::any('imagen2',  ['as' => 'imagen2', function () {
    return view('imagen2');
}]);*/