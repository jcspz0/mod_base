@extends('template.admin')

@section('panel-title', session('parametros')[13]['VALOR'])

@section('content')

@if (Session::has("message"))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get("message")}}
	</div>
@endif

<div>
	@if ($acciones[config('sistema.ID_ACCION_NUEVO')])
		<a href="{{ route('rol.create') }}" class="btn btn-primary">Nuevo</a>
	@endif
</div>
<br>
<!--table.table>(thead>th*2)>(tbody>td*2)-->
<table id="tblDatos" class="table table-striped table-bordered">
	<thead>
		<tr>				
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Accion</th>						
		</tr>
	</thead>
	<tbody>
		@foreach($roles as $rol)
		<tr>
			<td>{{$rol->NOMBRE}}</td>
			<td>{{$rol->DESCRIPCION}}</td>
			<td>
				@if ($acciones[config('sistema.ID_ACCION_NAVEGAR')])
					<a href="{{ route('rol.show', [$rol->ID]) }}" title="Detalle"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>				
				@endif

				@if ($acciones[config('sistema.ID_ACCION_EDITAR')])
					<a href="{{ route('rol.edit', [$rol->ID]) }}" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>				
				@endif

				@if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
				@if ($rol->ID != 1)	
					<a href="{{ action('RolController@showDelete', [$rol->ID]) }}" title="Eliminar"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>				
				@endif
				@endif

				@if ($acciones[config('sistema.ID_ACCION_PARAMETRIZAR')])
					<a href="{{ action('RolController@crearPermisoParametro', [$rol->ID]) }}" title="Parametrizar"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></a>				
				@endif

				@if ($acciones[config('sistema.ID_ACCION_PERMISO')])
					<a href="{{ action('RolController@crearPermiso', [$rol->ID]) }}" title="Permisos"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a>				
				@endif
	        </td>
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