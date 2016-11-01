<?php

namespace base\Http\Controllers;

use base\Model\Item;
use base\Model\Umov\Umov;
use base\Utils\MyLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

class StockController extends Controller
{
    public function __construct()
    {
        $this->token=Umov::getToken('master','formacionjuan','micrium2016');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "asdasd";
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
        $activities = Umov::getCantSaleById($this->token, "activityHistoryHierarchical",$id);// 53471021
        $pudo=self::actualizarItems($activities);
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

    private static function actualizarItems($items)
    {
        foreach ($items as $item){
            $result = self::actualizarStock($item['alternativeidentifier'],$item['cantidad']);
        }
        if ($result){
            return "200";
        }else{
            return "500";
        }
    }

    public static function actualizarStock($id, $cantidad){
        try{
            $it = Item::findOrFail($id);
            $cant = $it->stock;
            $it->stock = $cant - $cantidad;
            $it->save();
        }catch (ModelNotFoundException $e){
            MyLog::registrar('en actualizar Stock no se encontro el id del item -'.$id);
            return false;
        }catch (\Exception $e){
            return false;
        }
    }

}
