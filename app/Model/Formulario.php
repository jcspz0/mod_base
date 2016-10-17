<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

use \base\Model\RolFormulario;

class Formulario extends Model{
	protected $table = 'mu_formulario';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'URL', 'ORDEN', 'ID_FORMULARIO', 'ESTADO'];

	public function getListaMenuPadre(){
		//	SELECT * FROM mu_formulario WHERE ESTADO = TRUE AND ID_FORMULARIO IS NULL;
		return Formulario::where('ESTADO', true)
						 ->whereNull('ID_FORMULARIO')
						 ->get();
	}

	public function getListaItems($idFormulario){
		//	SELECT * FROM mu_formulario WHERE ESTADO = TRUE AND ID_FORMULARIO IS NULL;
		return Formulario::where('ESTADO', true)
						 ->where('ID_FORMULARIO', $idFormulario)
						 ->get();
	}	

	public function getListaItemsPorRolFormulario($idFormulario, $idRol){
		//	SELECT * FROM mu_formulario 
		//	WHERE ESTADO = TRUE AND ID_FORMULARIO = 1 AND ID IN (
		//		SELECT DISTINCT(ID_MU_FORMULARIO) FROM mu_rol_formulario 
		//		WHERE ESTADO = TRUE AND ID_MU_ROL = 1
		//	) ORDER BY orden ASC;
		
		return Formulario::where('ESTADO', true)
						 ->where('ID_FORMULARIO', $idFormulario)
						 ->whereIn('ID', function($query) use ($idRol){
                                $query->select('ID_MU_FORMULARIO')
                                	  ->distinct()
                                      ->from(with(new RolFormulario)->getTable())
                                      ->where('ESTADO', true)
                                      ->where('ID_MU_ROL', $idRol);
                       	 })
                       	 ->orderBy('ORDEN', 'ASC')
                       	 ->get();
	}
}
