<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;
use \base\Model\RolTipoParametro;

class Rol extends Model{
	protected $table = 'mu_rol';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'DESCRIPCION', 'ESTADO'];

	public function mu_usuario(){
        return $this->hasMany('base\Model\Usuario', 'ID_MU_ROL', 'ID');
    }

	public function getLista(){
		return Rol::where('ESTADO', true)
				  ->orderBy("ID", "ASC")
				  ->get();
	}

	public function esUnicoNombre($id, $nombre){
		if ($id == 0){
			$rol = Rol::where('NOMBRE', $nombre)
						->where('ESTADO', true)
						->first();
		}
		else{
			$rol = Rol::where('NOMBRE', $nombre)
						->where('ESTADO', true)
						->where('ID', '<>', $id)
						->first();
		}
		return !isset($rol);
	}

	public function __toString(){
        return '[NOMBRE='.$this->NOMBRE.', DESCRIPCION='.$this->DESCRIPCION.']';
    }

	/**
	 * usuario puede crear mucho post
	 * post puede pertenecer solo a un usuario
	 */
}
