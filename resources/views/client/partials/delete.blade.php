{!! Form::open(['route' => ['client.destroy', $client], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">{{session('parametros')[126]['VALOR']}}</button>
{!! Form::close() !!}