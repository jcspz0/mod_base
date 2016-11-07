{!! Form::open(['route' => ['item.destroy', $item], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">{{ session('parametros')[157]['VALOR'] }}</button>
{!! Form::close() !!}