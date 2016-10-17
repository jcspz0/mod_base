<?php

namespace base\Model;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model{
	protected $table = 'mu_bitacora';
	public  $timestamps = false;
	protected $primaryKey = 'ID';
	protected $fillable = ['FECHA_HORA', 'DIRECCION_IP', 'ID_MU_USUARIO', 'ID_MU_FORMULARIO', 'ID_MU_ACCION', 'DESCRIPCION'];

    /*public function mu_accion(){
        return $this->hasOne('base\Model\Accion', 'ID_MU_ACCION', 'ID');
    }*/

    public function getTotal(){
        return Bitacora::count();
    }

	public function getLista($start, $length){
        //->skip(10)->take(5)->get()
        return Bitacora::skip($start)
                       ->take($length)
                       ->orderBy("ID", "DESC")
                       ->get();
    }


	public static function guardar($idFormulario, $idAccion, $descripcion){
        //dd('idForm: '.$idFormulario.", idAc: ".$idAccion);
        $bitacora = new Bitacora();
        $bitacora->FECHA_HORA = date('Y-m-d H:i:s');
        $bitacora->DIRECCION_IP = $bitacora->getRealIP();
        $bitacora->ID_MU_USUARIO = session('usuario')->ID;
        $bitacora->ID_MU_FORMULARIO = $idFormulario;
        $bitacora->ID_MU_ACCION = $idAccion;
        $bitacora->DESCRIPCION = $descripcion;
        $bitacora->save();
    }

    public function fechaRegistro(){
        $fecha = date_create($this->FECHA_HORA);
        return date_format($fecha, 'd/m/Y H:i:s');
    } 

    public function getRealIP(){

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }   
}
