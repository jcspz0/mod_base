<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

use \DB;

class Password extends Model{
	protected $table = 'mu_password';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	/**
	 * PWD_GENERADO: [0, false => usuario, 1, true => el sistema]
	 * ID_MU_USUARIO_REGISTRO: El id del usuario que esta reseteando o cambiando la contraseña
	 */
	protected $fillable = ['PWD', 'FECHA_REGISTRO', 'ID_MU_USUARIO', 'PWD_GENERADO', 'ID_MU_USUARIO_REGISTRO'];

	const GENERADO_USUARIO = false;
	const GENERADO_SISTEMA = true;

	public function existePassword($idUsuario, $pass){
		$password = Password::where('ID_MU_USUARIO', $idUsuario)
						    ->where('PWD', $pass)
						    ->where('FECHA_REGISTRO', function($query) use ($idUsuario){
								$query->select(DB::raw('MAX(FECHA_REGISTRO)'))
				                  	  ->from(with(new Password)->getTable())
				                      ->where('ID_MU_USUARIO', $idUsuario);
								})
						    ->first();
		//dd($password);
		return $password;
	}
}
