<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>categoria</th>
        <th>Acciones</th>
    </tr>
    @foreach($items as $item)
        <tr data-id="{{ $item->id }}">
            <td>{{ $item->id }}</td>
            <td>{{ $item->nombre }}</td>
            <td>{{ $item->precio }}</td>
            <td>{{ $item->stock }}</td>
            <td>{{ $item->category->nombre }}</td>
            <td>
                @if ($acciones[config('sistema.ID_ACCION_EDITAR')])
                    <a href="{{ route('item.edit', $item) }}" class=""><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                @endif
                @if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
                    <a href="#!" class="btn-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                @endif
            </td>
        </tr>
    @endforeach
</table>