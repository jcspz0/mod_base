<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model{
	protected $table = 'mu_parametro';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['NOMBRE', 'TIPO', 'VALOR', 'DESCRIPCION_CAMPO', 'ID_MU_TIPO_PARAMETRO'];

	const CADENA = 'CADENA';
	const MULTI_CADENA = 'MULTI CADENA';
	const BOLEANO = 'BOLEANO';
	const FECHA = 'FECHA';
	const FECHA_HORA = 'FECHA HORA';

	public static $messages = array(
        'nuevo' => 'NUEVO...jjjj',
        'editar' => 'EDITAR',
        'eliminar' => 'ELIMINAR',
        'detalle' => 'DETALLE',
    );

	public function getListaParametroByTipoParametro($idTipoParametro){
		$parametros = Parametro::where('ID_MU_TIPO_PARAMETRO', $idTipoParametro)
							   ->orderBy('NOMBRE', 'ASC')
							   ->get();
		return $parametros;

	}

	public function getParametroByTipoParametro($idParametro, $idTipoParametro){
		return Parametro::where('ID', $idParametro)
						->where('ID_MU_TIPO_PARAMETRO', $idTipoParametro)
						->first();
	}

	public function getTipoFecha(){
		$fecha = date_create($this->VALOR);
		return date_format($fecha, 'd/m/Y');
	}

	public function getTipoFechaHora(){
		$fecha = date_create($this->VALOR);
		return date_format($fecha, 'd/m/Y H:i:s');
	}

	public function cargarParametroSession(){
		$parametros = Parametro::all();
        //dd($parametros->toArray());

        $array_param = array();
        foreach ($parametros as $parametro) {
            $array_param[$parametro->ID] = $parametro->toArray();
        }

        //dd($array_param);
        //session(['INICIO' => 'PROBANDO_SESSCION', 'DEMO' => 'DEMITO']);
        //session($array_param);
        session(['parametros' => $array_param]);
        //return $array_param;
	}

	public function __toString(){
        return '[NOMBRE='.$this->NOMBRE.', VALOR='.$this->VALOR.', DESCRIPCION='.$this->DESCRIPCION_CAMPO.']';
    }
}
