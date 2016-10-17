@extends('template.admin')

@section('panel-title', session('parametros')[73]['VALOR'])

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
			<th>Descripción</th>
			<th>Accion</th>
		</tr>
	</thead>
	<tbody>
		@foreach($tipoParametros as $tipoParametro)
		<tr>
			<td>{{$tipoParametro->NOMBRE}}</td>
			<td>{{$tipoParametro->DESCRIPCION}}</td>
			<td>{!!link_to_action('TipoParametroController@parametro', $title = 'Ver Parametros', $parameters = $tipoParametro->ID, $attributes = [])!!}</td>
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