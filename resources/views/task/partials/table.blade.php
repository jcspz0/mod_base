<table class="table table-striped">
    <tr>
        <th>#</th>
        <th>id_Al</th>
        <th>agente</th>
        <th>cliente</th>
        <th>actividad</th>
        <th>fecha</th>
        <th>hora</th>
        <th>Acciones</th>
    </tr>
    @foreach($tasks as $task)
        <tr data-id="{{ $task->id }}">
            <td>{{ $task->id }}</td>
            <td>{{ $task->ida }}</td>
            <td>{{ $task->agent->nombre }}</td>
            <td>{{ $task->client->nombre }}</td>
            <td>{{ $task->activity->nombre }}</td>
            <td>{{ $task->date }}</td>
            <td>{{ $task->hour }}</td>
            <td>
                @if ($acciones[config('sistema.ID_ACCION_EDITAR')])
                    <a href="{{ route('task.edit', $task) }}" class=""><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                @endif
                @if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
                    <a href="#!" class="btn-delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                @endif
            </td>
        </tr>
    @endforeach
</table>