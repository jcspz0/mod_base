<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Accion extends Model{
	protected $table = 'mu_accion';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'ESTADO'];

	/*public function mu_bitacora(){
		return $this->belongsTo('base\Model\Bitacora', 'ID_MU_ACCION', 'ID');
	}*/
}
