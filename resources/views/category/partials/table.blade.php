<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>Acciones</th>
    </tr>
    @foreach($categories as $category)
        <tr data-id="{{ $category->id }}">
            <td>{{ $category->id }}</td>
            <td>{{ $category->nombre }}</td>
            <td>
                @if ($acciones[config('sistema.ID_ACCION_EDITAR')])
                    <a href="{{ route('category.edit', $category) }}" class="">editar</a>
                @endif
                @if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
                    <a href="#!" class="btn-delete">eliminar</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>