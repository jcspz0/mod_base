{!! Form::open(['route' => ['item.destroy', $item], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">Eliminar Item</button>
{!! Form::close() !!}