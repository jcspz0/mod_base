{!! Form::open(['route' => ['task.destroy', $task], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">{{ session('parametros')[178]['VALOR'] }}</button>
{!! Form::close() !!}