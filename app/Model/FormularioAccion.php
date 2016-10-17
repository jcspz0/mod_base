<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class FormularioAccion extends Model{
	protected $table = 'mu_formulario_accion';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['ID_MU_FORMULARIO', 'ID_MU_ACCION', 'ESTADO'];
}
