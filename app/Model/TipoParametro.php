<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

use \base\Model\Permiso;

class TipoParametro extends Model{
	protected $table = 'mu_tipo_parametro';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'DESCRIPCION'];


	public function getListaByIdRol($idRol){
		/**
		 * SELECT tp.ID, tp.NOMBRE, tp.DESCRIPCION FROM mu_tipo_parametro tp 
		 * INNER JOIN mu_rol_tipoparametro rtp ON tp.ID = rtp.ID_MU_TIPO_PARAMETRO 
		 * WHERE rtp.ID_MU_ROL = 15 AND rtp.ID_MU_PERMISO <> 1;
		 */
		return TipoParametro ::select('mu_tipo_parametro.*')
				  ->join('mu_rol_tipoparametro', 'mu_rol_tipoparametro.ID_MU_TIPO_PARAMETRO', '=', 'mu_tipo_parametro.ID')
				  ->where('mu_rol_tipoparametro.ID_MU_ROL', $idRol)
				  ->where('mu_rol_tipoparametro.ID_MU_PERMISO', '<>', config('sistema.ID_PERMISO_NEGADO'))
				  ->orderBy('NOMBRE', 'ASC')
				  ->get();
	}	

}
