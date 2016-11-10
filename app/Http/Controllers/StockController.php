<?php

namespace base\Http\Controllers;

use base\Model\Item;
use base\Model\Task;
use base\Model\umov\Umov;
use base\Utils\MyLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use base\Model\Parametro;

use base\Http\Requests;
use base\Http\Controllers\Controller;

class StockController extends Controller
{
    public function __construct()
    {
        //$this->token=session('parametros')[113]['VALOR'];
        try{
            $parametro = Parametro::findOrfail(113);
            $this->token=$parametro->VALOR;
        }catch (ModelNotFoundException $e){
            MyLog::registrar('error de token en stockController, el constructor no obtuvo el token de los parametros 113');
            return false;
        }catch (\Exception $e){
            MyLog::registrar('error en stockController, hubo un error en el constructor');
        }
    }

    public static function getToken(){
        try{
            $parametro = Parametro::findOrfail(113);
            return $parametro->VALOR;
        }catch (ModelNotFoundException $e){
            MyLog::registrar('error de token en stockController, el constructor no obtuvo el token de los parametros 113');
            return false;
        }catch (\Exception $e){
            MyLog::registrar('error en stockController, hubo un error en el constructor');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('item.index');
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
        $id=$request->input('id');
        //$agent_ida='master';
        $activities = Umov::getCantSaleById($this->token, "activityHistoryHierarchical",$id);// 53471021 53478835
        $agent_ida = Umov::getAgentId($this->token, "activityHistoryHierarchical",$id);
        $pudo=self::actualizarItems($activities,$agent_ida);
        return $pudo;
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

    private static function actualizarItems($items, $agent_ida)
    {
        foreach ($items as $item){
            $result = self::actualizarStock($item['alternativeidentifier'],$item['cantidad'], $agent_ida);
        }
        if ($result){
            return "200";
        }else{
            return "500";
        }
    }

    public static function actualizarStock($id, $cantidad, $agent_ida){
        try{
            $it = Item::findOrFail($id);
            $cant = $it->stock;
            $it->stock = $cant - $cantidad;
            if($it->stock>=0){
                $flag=self::saveUmovStock($it->id,$it->stock);
                if ($flag){
                    $it->save();
                    MyLog::registrar('se realizo la venta correcta del item->'.$it->id.'con stock inicial de '.$cant.', con venta de  '.$cantidad.', con un stock resultante de '.$it->stock);
                }else{
                    MyLog::registrar('hubo un problema en [actualizarStock] con uMov, no se pudo actualziar el stock de id->'.$it->id.'con stock->'.$cant.', se trato de vender '.$cantidad);
                }
            }else{
                //aqui avisar a uMov q no se pudo realizar la venta
                self::sendMessage($agent_ida, $it->id,$cantidad);
                MyLog::registrar('[no se pudo realizar la venta, stock muy bajo] el item->'.$it->id.' se quiso vender->'.$cantidad.' y solo existian '.$cant);
            }
            return true;
        }catch (ModelNotFoundException $e){
            MyLog::registrar('en actualizar Stock no se encontro el id del item -'.$id);
            return false;
        }catch (\Exception $e){
            return false;
        }
    }

    public function changeStatus(Request $request){
        $id=$request->input('id');
        $ida = Umov::getStatusTaskById($this->token, "activityHistoryHierarchical",$id);// 53471021 53478835
        if(is_null($ida)){
            MyLog::registrar('metodo changeStatus, id de activity history->'.$id.'devolvio null');
            return '500';
        }else{
            $tas = Task::where('ida',$ida)->first();
            $tas->estado='terminado';
            $tas->save();
        }
        return "200";
    }

    public static function saveUmovStock($id,$stock){
        $cadena = '<item><alternativeIdentifier>'.$id.'</alternativeIdentifier><customFields><stock>'.$stock.'</stock></customFields></item>';
        $activities = Umov::putData(self::getToken(), "item", $id,$cadena);
        if(!is_null($activities)){
            return true;
        }else{
            return false;
        }
    }

    public static function sendMessage($agent_ida, $item_id,$cantidad){
        try {
            $token=self::getToken();
            $item = Item::findOrFail($item_id);
            $item_name = $item->nombre;
            $message='no se pudo realizar la venta del item-> '.$item_name.' tiene un stock inicial de '.$item->stock.' y se trato de vender '.$cantidad;
            $cadena = Umov::getStringMessage($agent_ida,$message);
            $res = Umov::postData($token, "message", $cadena);
            if(!is_null($res)){
                MyLog::registrar('se ha enviado a '.$agent_ida.' el siguiente mensaje->'.$message);
                $cadena = Umov::getStringNotification($agent_ida,$message);
                $res_n = Umov::postData($token,'scheduleNotification', $cadena);
                if(!is_null($res_n)){
                    MyLog::registrar('se ha enviado a '.$agent_ida.' la siguiente notificacion->'.$message);
                }else{
                    MyLog::registrar('error, no se ha podido enviadar a '.$agent_ida.' la siguiente notificacion->'.$message);
                }
                return true;
            }else{
                MyLog::registrar('error, no se ha podido enviadar a '.$agent_ida.' el siguiente mensaje->'.$message);
                return false;
            }
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            MyLog::registrar('no se encontro el Item->'.$item_id.' en la funcion sendMessage');
            return false;
        }
    }

}
