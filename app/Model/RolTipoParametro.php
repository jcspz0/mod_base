<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class RolTipoParametro extends Model{
	protected $table = 'mu_rol_tipoparametro';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['ID_MU_ROL', 'ID_MU_TIPO_PARAMETRO', 'ID_MU_PERMISO'];

	public $nombreTipoParametro;

	/*public function mu_rol(){
        //return $this->hasOne('base\Model\Rol', 'ID_MU_ROL', 'ID');
        return $this->hasMany('base\Model\Rol', 'ID_MU_ROL', 'ID');
    }*/

    public function getRolTipoParametro($idRol, $idTipoParametro){
		$rolTipoParametro = RolTipoParametro::where('ID_MU_ROL', $idRol)
											->where('ID_MU_TIPO_PARAMETRO', $idTipoParametro)
											->first();
		/*if (isset($rolTipoParametro)){
			echo "ID_PERMISO: ".$rolTipoParametro->ID_MU_PERMISO;
			return $rolTipoParametro->ID_MU_PERMISO;
		}*/
		return $rolTipoParametro;

	}
}
