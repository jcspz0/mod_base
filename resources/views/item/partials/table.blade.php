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
            <td>{{ $item->category_id }}</td>
            <td>
                @if ($acciones[config('sistema.ID_ACCION_EDITAR')])
                    <a href="{{ route('item.edit', $item) }}" class="">editar</a>
                @endif
                @if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
                    <a href="#!" class="btn-delete">eliminar</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>