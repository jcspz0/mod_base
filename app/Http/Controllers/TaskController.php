<?php

namespace base\Http\Controllers;

use Illuminate\Http\Request;

use base\Model\Task;
use base\Model\Client;
use base\Model\Activity;
use base\Model\Agent;

use base\Model\Bitacora;
use base\Utils\MyLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use base\Http\Requests;
use base\Http\Controllers\Controller;

use base\Model\umov\Umov;
use Illuminate\Support\Facades\Redirect;
use Validator;

class TaskController extends Controller
{
    public function __construct(){
        $this->beforeFilter(function (){
            if (is_null(session('usuario'))){
                return Redirect::to('/');
            }
            else{
                $idFormulario = config('sistema.ID_FORMULARIO_TASK');
                $idRol = session('usuario')->mu_rol->ID;

                $this->cargarPermisos($idFormulario, $idRol);
                $this->cargarMenu($idRol);
                //dd($this->permisos);
            }
        });
        $this->token=session('parametros')[113]['VALOR'];
    }

    public static $rules = array(
        'agent_id' => 'correct_agent',
        'client_id' => 'correct_client',
        'activity_id' => 'correct_activity',
    );
    //'ID_MU_ROL' => 'required|exists:mu_rol,ID'

    public static function validar($data){
        $reglas = self::$rules;
        //$messages = self::$messages;
        $messages = array(
            'agent_id.correct_agent' => session('parametros')[182]['VALOR'],
            'client_id.correct_client' => session('parametros')[183]['VALOR'],
            'activity_id.correct_activity' => session('parametros')[184]['VALOR'],//º"categoria incorrecta, escoja una categoria valida",
        );
        return Validator::make($data, $reglas, $messages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::fecha($request->get('fecha'))->orderBy('created_at', 'DESC')->paginate(5);
        $acciones = $this->permisos;
        return view('task.index', compact('tasks','acciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agents = Agent::all()->lists('nombre','id')->prepend('Elige un agent', 0)->toArray();
        $clients = Client::all()->lists('nombre','id')->prepend('Elige un client', 0)->toArray();
        $activities = Activity::all()->lists('nombre','id')->prepend('Elige una activity', 0)->toArray();
        return view('task.create', compact('agents', 'clients', 'activities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $v = Self::validar($request->all());
            if($v->fails()){
                $errors = $v->messages()->all();
                return redirect()->back()->withErrors($v->messages())->withInput();
            }
            //----- umov
            $it = new Task($request->all());
            $it->save();
            $it->ida=$it->id;
            $it->save();
            $agent = Agent::where('id',$request->agent_id)->get();
            $agent_ida = $agent[0]['attributes']['ida'];
            $activity = Activity::where('id',$request->activity_id)->get();
            $activity_ida = $activity[0]['attributes']['ida'];
            $cadena = Umov::getStringTask($it->ida, $agent_ida, $it->client_id, $it->date, $it->hour, $activity_ida);
            $tareas = Umov::postData($this->token, "schedule",$cadena);
            if(!is_null($tareas)){
                \Session::flash('message', 'la tarea se creo correctamente');
                Bitacora::guardar(config('sistema.ID_FORMULARIO_TASK'), config('sistema.ID_ACCION_NUEVO'), 'Se creo la tarea: '.$it);
            }else{
                $it->delete();
                \Session::flash('message', 'no se pudo guardar la tarea, error con uMov');
            }
            //------
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('task.index');
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
        $task = Task::findOrFail($id);
        $acciones = $this->permisos;
        $cli = Client::findOrFail($task->client_id);
        $clients = Client::all()->lists('nombre','id')->prepend($cli->nombre, $cli->id)->toArray();
        $age = Agent::findOrFail($task->agent_id);
        $agents = Agent::all()->lists('nombre','id')->prepend($age->nombre, $age->id)->toArray();
        $act = Activity::findOrFail($task->activity_id);
        $activities = Activity::all()->lists('nombre','id')->prepend($act->nombre, $act->id)->toArray();
        return view('task.edit', compact('task','acciones','clients', 'agents', 'activities'));
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
        try{
            $v = Self::validar($request->all());
            if($v->fails()){
                $errors = $v->messages()->all();
                return redirect()->back()->withErrors($v->messages())->withInput();
            }
            $it = Task::findOrFail($id);
            $agent = Agent::where('id',$request->agent_id)->get();
            $agent_ida = $agent[0]['attributes']['ida'];
            $activity = Activity::where('id',$request->activity_id)->get();
            $activity_ida = $activity[0]['attributes']['ida'];
            $cadena = Umov::getStringTask($it->ida, $agent_ida, $request->client_id, $it->date, $it->hour, $activity_ida);
            $tareas = Umov::putData($this->token, "schedule", $it->ida,$cadena);
            if(!is_null($tareas)){
                //se pudo guardar correctamente
                $it->fill($request->all());
                $it->save();
                \Session::flash('message', 'la tarea se actualizo correctamente');
                Bitacora::guardar(config('sistema.ID_FORMULARIO_TASK'), config('sistema.ID_ACCION_EDITAR'), 'Se edito la tarea: '.$it);
            }else{
                \Session::flash('message', 'no se pudo actualizar la tarea, error con uMov');
            }

            $tas = Task::findOrFail($id);
            $tas->fill($request->all());
            $tas->save();
        }catch (\Exception $e){
            return $e;
        }
        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        try{
            $tas = Task::findOrFail($id);
            //---------
            $cadena = Umov::getStringTaskDestroy();
            $activities = Umov::destroyData($this->token, "schedule", $tas->ida, $cadena);
            if(!is_null($activities)){
                //se pudo guardar correctamente
                $tas->delete();
                $message = $tas->ida . ' El registro fue Eliminado';

                if ($request->ajax()){
                    Bitacora::guardar(config('sistema.ID_FORMULARIO_TASK'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino la tarea: '.$tas);
                    return response()->json([
                        'id' => $tas->id,
                        'message' => $message
                    ]);
                }
                \Session::flash('message', $message);
                Bitacora::guardar(config('sistema.ID_FORMULARIO_TASK'), config('sistema.ID_ACCION_ELIMINAR'), 'Se elimino la tarea: '.$tas);
            }else{
                \Session::flash('message', 'no se pudo eliminar la tarea, error con uMov');
            }
        }catch (\Exception $e){
            \Session::flash('message', 'no se pudo eliminar la categoria, error con uMov');
            return $e;
        }
        return redirect()->route('task.index');
    }
}
