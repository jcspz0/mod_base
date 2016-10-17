@extends('template.admin')

@section('panel-title', session('parametros')[45]['VALOR'])

@section('content')

<?php $message = Session::get("message"); ?>

@if (Session::has("message"))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get("message")}}
	</div>
@endif

<div>
	@if ($acciones[config('sistema.ID_ACCION_NUEVO')])
		<a href="{{ route('usuario.create') }}" class="btn btn-primary">Nuevo</a>
	@endif
</div>
<br>

<table id="tblDatos" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>CI</th>
			<th>Nombre</th>
			<th>Apellido Paterno</th>
			<th>Apellido Materno</th>
			<th>Usuario</th>
			<th>Bloqueado</th>
			<th>Rol</th>			
			<th>Accion</th>						
		</tr>
	</thead>
	<tbody>
		@foreach($usuarios as $usuario)
		<tr>
			<td>{{$usuario->CI}}</td>
			<td>{{$usuario->NOMBRE}}</td>
			<td>{{$usuario->APELLIDO_PATERNO}}</td>
			<td>{{$usuario->APELLIDO_MATERNO}}</td>
			<td>{{$usuario->USUARIO}}</td>
			<td>{{$usuario->bloqueado()}}</td>
			<td>{{$usuario->mu_rol->NOMBRE}}</td>
			<th>
				@if ($acciones[config('sistema.ID_ACCION_NAVEGAR')])
					<a href="{{ route('usuario.show', [$usuario->ID]) }}" title="Detalle"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>				
				@endif

				@if ($acciones[config('sistema.ID_ACCION_EDITAR')])
					<a href="{{ route('usuario.edit', [$usuario->ID]) }}" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>				
				@endif
    			
				@if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
					<a href="{{ action('UsuarioController@showDelete', [$usuario->ID]) }}" title="Eliminar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>				
				@endif

				@if ($acciones[config('sistema.ID_ACCION_DESBLOQUEAR')])
					@if ($usuario->BLOQUEADO == true)
						<a href="{{ action('UsuarioController@mostrarDesbloquear', [$usuario->ID]) }}" title="Desbloquear"><span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span></a>				
					@endif
				@endif

				@if ($acciones[config('sistema.ID_ACCION_BLOQUEAR')])
					@if ($usuario->BLOQUEADO == false)
						<a href="{{ action('UsuarioController@mostrarBloquear', [$usuario->ID]) }}" title="Bloquear"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></a>				
					@endif
				@endif
	        </th>
		</tr>
		@endforeach
	</tbody>
</table>

<script>
	$(document).ready(function () {
            $("#tblDatos").DataTable({
                "order": [],
                "filter": true,
                "responsive": true,
                /*"language": {
                    "url": "/Account/getDataTableLanguage"
                }*/
            });
        });
</script>

@stop