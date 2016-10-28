<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>Nombre</th>
        <th>razon social</th>
        <th>latitud</th>
        <th>longitud</th>
        <th>Acciones</th>
    </tr>
    @foreach($clients as $client)
        <tr data-id="{{ $client->id }}">
            <td>{{ $client->id }}</td>
            <td>{{ $client->nombre }}</td>
            <td>{{ $client->razon_social }}</td>
            <td>{{ $client->latitud }}</td>
            <td>{{ $client->longitud }}</td>
            <td>
                @if ($acciones[config('sistema.ID_ACCION_EDITAR')])
                    <a href="{{ route('client.edit', $client) }}" class="">editar</a>
                @endif
                @if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
                    <a href="#!" class="btn-delete">eliminar</a>
                @endif
            </td>
        </tr>
    @endforeach
</table>