<?php
	
namespace base\Utils;

class Convert
{
	public static function convertXMLtoJSON($request)
	{
		/**
		 * convierte un XML a JSON
		 *
		 * @access public
		 * @param String $request una cadena xml
		 * @return json $array retorna un json convertido
		 * @throws Exception no se pudo realizar bien la conversion, los datos enviados no son XML, retorna null
		 */
		try{
			$xml = simplexml_load_string($request);
	        $json = json_encode($xml);
	        $array = json_decode($json,TRUE);
			return $array;
		}catch(\Exception $e){
			//echo "hubo un error en la conversion de convertXmltoJSON";
			return null;
		}
	}

	public static function convertSpaceBlankToUrl($url)
	{
		/**
		 * convierte una cadena con espacios a una cadena con %20 en vez de espacios
		 *
		 * @access public
		 * @param String $url
		 * @return String $space retorna una cadena con los espacios reemplazados por %20
		 * @throws Exception cuando hubo algun problema en al conversion, la cadena enviada es nula o no es una cadena, se retorna null
		 */
		try{
			$trim=trim($url);
			$space=str_replace(' ','%20',$trim);
			return $space;
		}catch(\Exception $e){
			echo "hubo un error en la conversion de convertSpaceBlankToUrl";
			return null;
		}
	}

	public static function encrypt($string, $key='micrium') {
		$result = '';
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		}
		return base64_encode($result);
	}

	public static function decrypt($string, $key='micrium') {
		$result = '';
		$string = base64_decode($string);
		for($i=0; $i<strlen($string); $i++) {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		}
		return $result;
	}

	
}