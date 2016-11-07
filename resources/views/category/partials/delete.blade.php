{!! Form::open(['route' => ['category.destroy', $category], 'method' => 'DELETE']) !!}
    <button type="submit" class="btn btn-danger" onclick="return confirm('seguro que desea eliminar')">{{session('parametros')[145]['VALOR']}}</button>
{!! Form::close() !!}