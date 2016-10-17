@extends('template.admin')

@section('panel-title', session('parametros')[104]['VALOR'])

@section('content')

<?php $message = Session::get("message"); ?>

@if (Session::has("message"))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get("message")}}
	</div>
@endif

<table id="tblDatos" class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Valor</th>
			<th>Descripción</th>
			<th>Acción</th>
		</tr>
	</thead>
	<tbody>
		@foreach($parametros as $parametro)
		<tr>
			<td>{{$parametro->NOMBRE}}</td>
			<td>{{$parametro->VALOR}}</td>
			<td>{{$parametro->DESCRIPCION_CAMPO}}</td>
			<td>
				<a href="{{ action('TipoParametroController@detalleParametro', [$parametro->ID_MU_TIPO_PARAMETRO, $parametro->ID]) }}" title="Detalle"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></a>
				@if ($permiso == config('sistema.ID_PERMISO_ESCRITURA'))
					<a href="{{ action('TipoParametroController@editParametro', [$parametro->ID_MU_TIPO_PARAMETRO, $parametro->ID]) }}" title="Editar"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>				
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

<div>
	<a href="{{ route('tipo_parametro.index') }}" class="btn btn-danger">{{session('parametros')[105]['VALOR']}}</a>
</div>

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