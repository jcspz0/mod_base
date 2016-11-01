<?php
/**
 * Created by PhpStorm.
 * User: micrium
 * Date: 19/10/2016
 * Time: 02:39 PM
 */

namespace base\Utils;




use base\Model\Log;

class MyLog
{
    public static function registrar($dato)
    {
        /**
         * registra en la base de datos, en la tabla logs, en el campo log la cadena que se ha enviado de $dato
         *
         * @access public
         * @param String $dato cadena que se requiera guardar en log
         * @return null no retorna nada
         */
        Log::create([
            'log' => $dato,
        ]);
    }
}