<?php

namespace base\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use \base\Model\RolFormulario;
use \base\Model\Formulario;

use \base\Classes\Menu;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $permisos;

    public function cargarPermisos($idFormulario, $idRol){
        $rolFormulario = new RolFormulario();
        $acciones = $rolFormulario->getListaAccion($idFormulario, $idRol); 
        $this->permisos = $rolFormulario->obtenerPermisos($acciones); 
    }

    public function cargarMenu($idRol){
        $formulario = new Formulario();
        $formularios = $formulario->getListaMenuPadre();

        $listaMenus = array();
        foreach ($formularios as $formulario) {
            $menu = new Menu();
            $menu->menu = $formulario;
            $menu->items = $formulario->getListaItemsPorRolFormulario($formulario->ID, $idRol);
            $listaMenus[] = $menu;
        }
        session(['menus' => $listaMenus]);
    }

    public function getRealIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }
}
