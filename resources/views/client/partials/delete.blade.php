{!! Form::open(['route' => ['client.destroy', $client], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">Eliminar Cliente</button>
{!! Form::close() !!}