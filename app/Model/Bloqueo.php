<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Bloqueo extends Model{
	protected $table = 'mu_bloqueo';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['IP', 'INTENTO_FALLIDO', 'ULTIMA_VISITA', 'BLOQUEADO'];

	public function obtenerBloqueoPorIP($ip){
		$bloqueo = Bloqueo::where('IP', $ip)
						  ->first();
	}
}
