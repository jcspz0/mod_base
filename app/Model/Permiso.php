<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Permiso extends Model{
	protected $table = 'mu_permiso';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'DESCRIPCION'];	
}
