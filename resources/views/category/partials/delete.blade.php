{!! Form::open(['route' => ['category.destroy', $category], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">Eliminar Cliente</button>
{!! Form::close() !!}