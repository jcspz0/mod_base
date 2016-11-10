<?php

namespace base\Model\Umov;

use base\Utils\MyLog;
use Illuminate\Database\Eloquent\Model;

use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

use base\Utils\Convert;

class Umov extends Model
{
    public static function getToken($login, $enviroment, $password){
        /**
         * devuelve el token del ambiente al que quiere ingresar, pasando primero por una autenticacion
         *
         * @access public
         * @param String $login el login del usuario
         * @param String $enviroment el ambiente de uMov
         * @param String $password contrasenia del usuario
         * @return String $token retorna el doken del ambiente
         * @throws Exception ocurre una exception cuando la informacion de logueo es incorrecta, retorna null
         */
        //$base='jcspz0.hol.es';
        $base='localhost';

        if(!Umov::authentication($login, $enviroment, $password)){
            return null;
        }

        $clientToken = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/',
        ]);
        $tipo_dato = 'form_params';
        $dato = '<apiToken>
                    <login>'.$login.'</login>
                    <password>'.$password.'</password>
                    <domain>'.$enviroment.'</domain>
                </apiToken>';
        try{
            $response = $clientToken->request('POST','token.xml',[ $tipo_dato => ['data' => $dato]]);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $token = $array['message'];
            return $token;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getToken los datos fueron (login=>'.$login.',enviroment=>'.$enviroment.',pass=>'.$password.'])');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function authentication($login, $enviroment, $password)
    {
        /**
         * verifica si los credenciales ingresados son validos para uMov
         *
         * @access public
         * @param String $login el login del usuario
         * @param String $enviroment el ambiente de uMov
         * @param String $password contrasenia del usuario
         * @return String $token retorna el statusCode de la validacion, 200 si es correcta, otro si no lo es
         * @throws Exception ocurre una exception cuando la informacion de logueo es incorrecta, retorna null
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/',
        ]);
        $tipo_dato = 'form_params';
        $dato = '<authentication>
                    <login>'.$login.'</login>
                    <password>'.$password.'</password>
                    <domain>'.$enviroment.'</domain>
                </authentication>';
        try{
            $response = $client->request('POST','authentication.xml', [ $tipo_dato => ['data' => $dato]]);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $token = $array['statusCode'];
            return $token;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en authentication los datos fueron (login=>'.$login.',enviroment=>'.$enviroment.',pass=>'.$password.'])');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getAllDataId($token, $data)
    {
        /**
         * Devuelve todas las actividades del ambiente de uMov
         *
         * @access public
         * @param String $token token del ambiente
         * @param String $data el dato que quiere consultar
         * @return array $result retorna todas las actividades del ambiente
         * @throws Exception si no se puede conectar a uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $i=0;
            foreach ($array['entries']['entry'] as $actividad){
                foreach ($actividad as $a){
                    if(isset($a['id'])){
                        $result[$i]=$a['id'];
                    }else{
                        $result[$i]=$actividad['id'];
                    }
                }
                $i++;
            }
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[un error en getAllDataId, los datos fueron (data=>'.$data);
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getAllDataIdByCriteria($token, $data, $field, $value)
    {
        /**
         *  Devuelve en un array los ID's de las actividades de un ambiente por campos de busqueda, el valor puede contener espacios
         *
         * @access public
         * @param String $token token del ambiente
         * @param String $data el dato que quiere consultar
         * @param String $field campo de la actividad por la cual se va a ejecutar la busqueda
         * @param String $value el valor del campo por el cual se va a realizar la busqueda
         * @return array $result retorna un array con todas las actividades encontradas en la busqueda, es null si no se encuentra ningun registro
         * @throws Exception cuando no se puede conectar a Umov y retorna null
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'.xml?'.$field.'='.Convert::convertSpaceBlankToUrl($value);
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $i=0;
            foreach ($array['entries']['entry'] as $actividad){
                foreach ($actividad as $a){
                    if(isset($a['id'])){
                        $result[$i]=$a['id'];
                    }else{
                        $result[$i]=$actividad['id'];
                    }
                }
                $i++;
            }
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getAllDataIdByCriteria, los datos fueron (data=>'.$data.',field=>'.$field.',value=>'.$value.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getDataById($token, $data, $activity_id)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getDataById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getDataByAlternativeIdentifier($token, $data, $alternative_identifier)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/alternativeIdentifier/'.$alternative_identifier.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[ hubo un error en getDataByAlternativeIdentifier, los datos fueron (data=>'.$data.',alternative_identifier=>'.$alternative_identifier.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    //-------------
    public static function postDataById($token, $data, $activity_id, $cadena)
    {
        /**
         * registra todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @param String $cadena es la cadena que necesita uMov para ingresar lso datos
         * @return array $result retorna un array con datos especificando los valores ingresados
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            $result=null;
            $tipo_dato = 'form_params';
            $response = $client->request('POST',$url,
                [ $tipo_dato =>
                    [   'data' => $cadena ,]
                ]);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en postDataById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.',cadena=>'.$cadena.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function postDataByAlternativeIdentifier($token, $data, $alternative_identifier, $cadena)
    {
        /**
         * registra todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @param String $cadena es la cadena que necesita uMov para ingresar lso datos
         * @return array $result retorna un array con datos especificando los valores ingresados
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/alternativeIdentifier/'.$alternative_identifier.'.xml';
        try{
            $result=null;
            $tipo_dato = 'form_params';
            $response = $client->request('POST',$url,
                [ $tipo_dato =>
                    [   'data' => $cadena ,]
                ]);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en postDataByAlternativeIdentifier, los datos fueron (data=>'.$data.',alternative_identifier=>'.$alternative_identifier.',cadena=>'.$cadena.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function postData($token, $data, $cadena)
    {
        /**
         * registra todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @param String $cadena es la cadena que necesita uMov para ingresar lso datos
         * @return array $result retorna un array con datos especificando los valores ingresados
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'.xml';
        try{
            $result=null;
            $tipo_dato = 'form_params';
            $response = $client->request('POST',$url,
                [ $tipo_dato =>
                    [   'data' => $cadena ,]
                ]);

            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en postData, los datos fueron (data=>'.$data.',cadena=>'.$cadena.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function putData($token, $data, $alternativeIdentifier, $cadena)
    {
        /**
         * registra todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @param String $cadena es la cadena que necesita uMov para ingresar lso datos
         * @return array $result retorna un array con datos especificando los valores ingresados
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/alternativeIdentifier/'.$alternativeIdentifier.'.xml';
        try{
            $result=null;
            $tipo_dato = 'form_params';
            $response = $client->request('POST',$url,
                [ $tipo_dato =>
                    [   'data' => $cadena ,]
                ]);

            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en putData, los datos fueron (data=>'.$data.',alternativeIdentifier=>'.$alternativeIdentifier.',cadena=>'.$cadena.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function destroyData($token, $data, $alternativeIdentifier, $cadena)
    {
        /**
         * registra todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @param String $cadena es la cadena que necesita uMov para ingresar lso datos
         * @return array $result retorna un array con datos especificando los valores ingresados
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/alternativeIdentifier/'.$alternativeIdentifier.'.xml';
        try{
            $result=null;
            $tipo_dato = 'form_params';
            $response = $client->request('POST',$url,
                [ $tipo_dato =>
                    [   'data' => $cadena ,]
                ]);

            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = $array;
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en destroyData, los datos fueron (data=>'.$data.',alternativeIdentifier=>'.$alternativeIdentifier.',cadena=>'.$cadena.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getStringItem($ida, $categoria, $nombre, $stock, $precio){
        return $cadena='<item><subGroup><alternativeIdentifier>'.$categoria.'</alternativeIdentifier></subGroup><description>'.$nombre.'</description><active>true</active><alternativeIdentifier>'.$ida.'</alternativeIdentifier><customFields><stock>'.$stock.'</stock><precio>'.$precio.'</precio></customFields></item>';
    }

    public static function getStringItemDestroy(){
        return $cadena='<item><active>false</active></item>';
    }

    public static function getStringCategory($ida ,$name){
        return $cadena = '<subGroup>
                  <active>true</active>
                  <description>'.$name.'</description>
                  <alternativeIdentifier>'.$ida.'</alternativeIdentifier>
                </subGroup>';
    }

    public static function getStringCategoryDestroy(){
        return $cadena = '<subGroup><active>false</active></subGroup>';
    }

    public static function getStringClient($ida, $nombre, $razon_social, $latitud, $longitud){
        return $cadena = '<serviceLocal><active>true</active>
                              <description>'.$nombre.'</description>
                              <corporateName>'.$razon_social.'</corporateName>
                              <alternativeIdentifier>'.$ida.'</alternativeIdentifier>
                              <geoCoordinate>'.$latitud.', '.$longitud.'</geoCoordinate>
                            </serviceLocal>';
    }

    public static function getStringClientDestroy(){
        return $cadena = '<serviceLocal><active>false</active></serviceLocal>';
    }

    public static function getStringTask($ida, $agent_ida, $client_ida, $date, $hour, $activity_ida){
        return $cadena = '<schedule>
                            <alternativeIdentifier>'.$ida.'</alternativeIdentifier>
                            <agent>
                                <alternativeIdentifier>'.$agent_ida.'</alternativeIdentifier>
                            </agent>
                            <serviceLocal>
                                <alternativeIdentifier>'.$client_ida.'</alternativeIdentifier>
                            </serviceLocal>
                            <date>'.$date.'</date>
                            <hour>'.$hour.'</hour>
                            <activitiesOrigin>4</activitiesOrigin>
                            <activityRelationship>
                                <activity>
                                    <alternativeIdentifier>'.$activity_ida.'</alternativeIdentifier>
                                </activity>
                            </activityRelationship>
                            <customFields>
                                 <callback>'.env('URL_CALLBACK').'callback</callback>
                            </customFields>
                        </schedule>';
    }

    public static function getStringTaskDestroy(){
        return $cadena='<schedule>
                          <situation><id>70</id></situation>
                        </schedule>';
    }

    public static function getStringNotification($agent_ida, $mensaje){
        return $cadena='<scheduleNotification>
                            <message>'.$mensaje.'</message>
                            <agents><agent>
                                <alternativeIdentifier>'.$agent_ida.'</alternativeIdentifier>
                            </agent></agents>
                        </scheduleNotification>';
    }

    public static function getStringMessage($agent_ida, $mensaje){
        return $cadena='<message>
                            <sender><alternativeIdentifier>master</alternativeIdentifier></sender>
                            <recipients>
                                <recipient><alternativeIdentifier>'.$agent_ida.'</alternativeIdentifier></recipient>
                            </recipients><description>'.$mensaje.'</description><sendNotification/>
                        </message>';
    }



    //------------- todo referido al callback

    public static function getActivityHistoryHierarchicalById($token, $data, $activity_id)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            /*$items = $array['sections']['section'][0]['items'];
            $result = [];
            $i=0;
            foreach ($items as $item){
                $result[$i] = [ 'id' => $item['id'], 'alternativeidentifier' => $item['alternativeIdentifier'], 'cantidad' => $item['fields']['field'][3]['fieldHistory']['value'] ];
                $i++;
            }*/
            return $array;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getActivityHistoryHierarchicalById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getCantSaleById($token, $data, $activity_id)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            //$result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $secciones = [];
            $result = [];
            foreach ($array['sections'] as $seccion){
                if(isset($seccion[0])){
                    $i=0;
                    foreach ($seccion as $sec){
                        $secciones[$i]= $sec;
                        $i++;
                    }
                }else{
                    $secciones[0] = $seccion;
                }
                $i=0;
                foreach ($secciones as $items){
                    foreach ($items['items'] as $item){
                        if (isset($item[0])){//este if sirve para saber si vino un solo item o varios
                            foreach ($item as $it){
                                //----------------
                                foreach ($it['fields']['field'] as $campo){
                                    if($campo['alternativeIdentifier']=='cantidad'){
                                        $result[$i] = [ 'id' => $it['id'], 'alternativeidentifier' => $it['alternativeIdentifier'], 'descripcion' => $it['description'], 'cantidad' => $campo['fieldHistory']['value'] ];
                                        $i++;
                                    }else{
                                        //no tiene la cantidad en el item que mando
                                    }
                                }
                                //----------------
                                /*if (isset($it['fields']['field'][3]['fieldHistory']['value'])){
                                    $result[$i] = [ 'id' => $it['id'], 'alternativeidentifier' => $it['alternativeIdentifier'], 'descripcion' => $it['description'], 'cantidad' => $it['fields']['field'][4]['fieldHistory']['value'] ];
                                    $i++;
                                }else{
                                    //no tiene la cantidad en el item que mando
                                }*/
                            }
                        }else{
                            //--------------
                            foreach ($item['fields']['field'] as $campo){
                                if($campo['alternativeIdentifier']=='cantidad'){
                                    $result[$i] = [ 'id' => $item['id'], 'alternativeidentifier' => $item['alternativeIdentifier'], 'descripcion' => $item['description'], 'cantidad' => $campo['fieldHistory']['value'] ];
                                    $i++;
                                }else{
                                    //no tiene la cantidad en el item que mando
                                }
                            }
                            //-------------
                            /*if (isset($item['fields']['field'][3]['fieldHistory']['value'])){
                                $result[$i] = [ 'id' => $item['id'], 'alternativeidentifier' => $item['alternativeIdentifier'], 'descripcion' => $item['description'], 'cantidad' => $item['fields']['field'][4]['fieldHistory']['value'] ];
                                $i++;
                            }else{
                                //no es un campo que contenga cantidades, o no esta posicionado donde deberia
                            }*/
                        }
                    }
                }
            }
            if(empty($result)){
                throw new \Exception('no contiene un campo cantidad',20);
            }
            return $result;
        }catch (RequestException $e) {
            dd($e);
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getCantSaleById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }catch (\Exception $e){
            if($e->getCode()==20){
                MyLog::registrar('4)[la activiry_id en getCantSaleById no contiene el campo cantidad]->'.$activity_id);
            }
            return null;
        }
    }

    public static function getStatusTaskById($token, $data, $activity_id)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            //$result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $ida=$array['schedule']['alternativeIdentifier'];
            if($array['schedule']['situation']['id']=='50'){
                return $ida;
            }else{
                return null;
            }
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getStatusTaskById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getAgentId($token, $data, $activity_id)
    {
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url=$data.'/'.$activity_id.'.xml';
        try{
            //$result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            if(isset($array['schedule']['agent']['alternativeIdentifier'])){
                return $array['schedule']['agent']['alternativeIdentifier'];
            }else{
                return null;
            }
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getStatusTaskById, los datos fueron (data=>'.$data.',activity_id=>'.$activity_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function getStockUMOV($token, $item_id){
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url='item/'.$item_id.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = -1;
            if (isset($array['customFields']['stock'])){
                $result = $array['customFields']['stock'];
            }
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse()->getBody());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getStockUMOV, los datos fueron (item_id=>'.$item_id.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

    public static function setStockUMOV($token, $item_id, $cant){
        /**
         * devuelve todos los valores de una actividad en especifico por el criterio de busqueda del ID
         *
         * @access public
         * @param $token es el token del ambiente
         * @param $activity_id es el id de la actividad que se va a buscar
         * @return array $result retorna un array con todos
         * @throws Exception no se pudo conectar con uMov
         */
        $client = new Client([
            'base_uri' => 'https://api.umov.me/CenterWeb/api/'.$token.'/',
        ]);
        $url='item/'.$item_id.'.xml';
        try{
            $result=null;
            $response = $client->request('GET',$url);
            $array = Convert::convertXMLtoJSON($response->getBody());
            $result = -1;
            if (isset($array['customFields']['stock'])){
                $result = $array['customFields']['stock'];
            }
            return $result;
        }catch (RequestException $e) {
            //echo Psr7\str($e->getRequest());
            if ($e->hasResponse()) {
                //echo Psr7\str($e->getResponse());
                MyLog::registrar('1)[error exception has response]-> '.$e->getResponse());
            }
            if ($e->getResponse()->getStatusCode()!=200){
                //echo "statusCode != 200";
                MyLog::registrar('2)[error exception response code is not a status 200');
                //return null;
            }
            MyLog::registrar('3)[hubo un error en getStockUMOV, los datos fueron (item_id=>'.$item_id.',cant=>'.$cant.')]');
            //echo "hubo un problema en el retorno del token";
            return null;
        }
    }

}
