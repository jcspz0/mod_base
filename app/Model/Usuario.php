<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model{
	protected $table = 'mu_usuario';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['CI', 'NOMBRE', 'APELLIDO_PATERNO', 'APELLIDO_MATERNO', 'TELEFONO', 'CORREO', 'USUARIO', 'FECHA_REGISTRO', 'FECHA_ACTUALIZACION', 'INTENTO', 'BLOQUEADO', 'ID_MU_ROL', 'ESTADO'];

	const DESBLOQUEAR = 0;					//	Desbloquear al usuario
	const DESBLOQUEAR_RESTABLECER = 1;		//	Desbloquear y resetable la contraseña

	public function mu_rol(){
		return $this->belongsTo('base\Model\Rol', 'ID_MU_ROL', 'ID');
	}

	public function getLista(){
		return Usuario::where('ESTADO', true)
					  //->where('BLOQUEADO', false)
					  ->get();
					  //->paginate(10);
	}

	public function getListaPorRol($idRol){
		return Usuario::where('ID_MU_ROL', $idRol)
					  ->where('ESTADO', true)
					  ->get();
	}

	public function esUnicoUsuario($id, $usuario){
		// SELECT * FROM mu_usuario WHERE USUARIO = 'vasquezs' AND ESTADO = TRUE AND ID != 26;
		if ($id == 0){
			$u = Usuario::where('USUARIO', $usuario)
						->where('ESTADO', true)
						->first();
		}
		else{
			$u = Usuario::where('USUARIO', $usuario)
						->where('ESTADO', true)
						->where('ID', '<>', $id)
						->first();
		}
		return !isset($u);
	}

	public function esUnicoCorreo($id, $correo){
		if ($id == 0){
			$u = Usuario::where('ESTADO', true)
						->where('CORREO', $correo)
						->first();
		}
		else{
			$u = Usuario::where('ESTADO', true)
						->where('CORREO', $correo)
						->where('ID', '<>', $id)
						->first();
		}
		return !isset($u);
	}

	public function existeUsuario($correo){
		$usuario = Usuario::where('ESTADO', true)
						  ->where('USUARIO', $correo)
						  ->orWhere('CORREO', $correo)
						  ->first();
		//dd($usuario);
		return $usuario;
	}

	public function bloqueado(){		
		return $this->BLOQUEADO == 0? "NO": "SI";
	}

	public function fechaRegistro(){
		$fecha = date_create($this->FECHA_REGISTRO);
		return date_format($fecha, 'd/m/Y H:i:s');
	}

	public function fechaActualizacion(){
		$fecha = date_create($this->FECHA_ACTUALIZACION);
		return date_format($fecha, 'd/m/Y H:i:s');
	}

	public function __toString(){
        return '[CI='.$this->CI.', NOMBRE='.$this->NOMBRE.', AP PATERNO='.$this->APELLIDO_PATERNO.', AP MATERNO='.$this->APELLIDO_MATERNO.']';
    }
}
