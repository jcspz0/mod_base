<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class RolFormulario extends Model{
	protected $table = 'mu_rol_formulario';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['ID_MU_FORMULARIO', 'ID_MU_ROL', 'ID_MU_ACCION', 'ESTADO'];


	/*public function mu_rol(){
        return $this->hasMany('base\Model\Rol', 'ID_MU_ROL', 'ID');
    }*/

	public function getLista($idRol){
		return RolFormulario::where('ID_MU_ROL', $idRol)
						    ->get();
	}

	/**
	 * Metodo que se encarga de cargar las acciones del formulario en el arbol de la vista de permiso.
	 */
	public function getListaAccion($idFormulario, $idRol){
		return RolFormulario::where('ID_MU_FORMULARIO', $idFormulario)
						   -> where('ID_MU_ROL', $idRol)
							  //where('ESTADO', true)
						   ->get();
	}

	public function updateByRol($idRol){
		RolFormulario::where('ID_MU_ROL', $idRol)
					 ->update(['ESTADO' => false]);
	}

	public function getAccion($idFormulario, $idRol, $idAccion){
		return RolFormulario::where('ID_MU_FORMULARIO', $idFormulario)
						    ->where('ID_MU_ROL', $idRol)
							->where('ID_MU_ACCION', $idAccion)
						    ->first();
	}

	public function obtenerPermisos( $acciones ){
		$permisos = array();
        foreach ($acciones as  $accion) {
            $permisos[$accion->ID_MU_ACCION] = $accion->ESTADO;
        }
        return $permisos;
    }

	/**
	 * 
	 */
	/*public function getListaAccionByTrue($idFormulario, $idRol){
		return RolFormulario::where('ID_MU_FORMULARIO', $idFormulario)
						    ->where('ID_MU_ROL', $idRol)
							->where('ESTADO', true)
						    ->get();
	}*/

	/**
	 * Para cargar el menu del sistema
	 */
	//public function 
}
