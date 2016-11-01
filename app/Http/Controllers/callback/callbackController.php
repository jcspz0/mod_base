<?php

namespace base\Http\Controllers\callback;

use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use base\Model\Callback as Callback;

use base\Utils\Convert;
use base\Utils\MyLog;

use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class callbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        MyLog::registrar('ingresaron al servicio Rest por GET');
        return "servicio Rest para tareas";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        MyLog::registrar('ingresaron al servicio por POSTs->'.$request->input('data'));
        $salida='hubo un error en el proceso de todo el servicio';
        try{
            $array = Convert::convertXMLtoJSON($request->input('data'));
            $task = $array['alternativeIdentifier'];
            //if (!isset($task[0])){
            //    $task='';
            //}
            $activities = $array['activityHistories'];
            foreach ($activities as $act) {
                $salida='';
                foreach ($act as $a) {
                    Callback::create([
                        'alternativeIdentifier' => $task,
                        'activity_history_id' => $a['id'],
                    ]);
                    $salida=$salida.' [se registro la alternativeIdentifier -'.$task.'- y la activity_history_id -'.$a['id'].'-]';
                    MyLog::registrar($salida);
                    MyLog::registrar('comenzando a consumir el ERP con el activity_history_id ['.$a['id'].'], llamando al metodo actualizar cantidad');
                    //aqui tengo q mandar el id a stock para q procese
                    try{
                        $client = new Client([
                            'base_uri' => 'http://localhost/mod_base/public/',
                        ]);
                        $tipo_dato = 'form_params';
                        $response = $client->request('POST','stock',
                            [ $tipo_dato =>
                                [
                                    'id' => $a['id'] ,
                                ]
                            ]);
                        $body = $response->getBody();
                    }catch (RequestException $e){
                        if ($e->getResponse()->getStatusCode()!=200){
                            echo "statusCode != 200 en postData";
                            return false;
                        }
                    }catch (\Exception $e){
                        return false;
                    }
                }
            }
            MyLog::registrar('se termino de analizar todos los activity_history');
            return 'ok';
            //return $salida;
        }catch(\Exception $e){
            if($request->input('data') == null){
                MyLog::registrar('no se enviaron bien los datos al servicio || la variable enviada no tiene el nombre de data');
                return $e;
            }
            MyLog::registrar('hubo alguna excepcion || el Request es el siguiente-> '.$request->input('data'));
            return $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private static function actualizarStock($items)
    {
        try{
            $client = new Client([
                'base_uri' => 'http://localhost/mod_base/public/',
            ]);
            $tipo_dato = 'form_params';
            foreach ($items as $item){
                $response = $client->request('POST','stock',
                    [ $tipo_dato =>
                        [
                            'id' => $item['alternativeidentifier'] ,
                            'cantidad' => $item['cantidad'] ,
                        ]
                    ]);
                $body = $response->getBody();
            }
            return true;
        }catch (RequestException $e){
            if ($e->getResponse()->getStatusCode()!=200){
                echo "statusCode != 200 en postData";
                return false;
            }
        }catch (\Exception $e){
            return false;
        }

    }
    
}
