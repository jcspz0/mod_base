@extends('template.admin')

@section('panel-title', 'Parametros')

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
				{!!link_to('#', $title = 'Editar', $parameters = $parametro->ID, $attributes = ['class'=>'btn'])!!}
				{!!link_to('#', $title = 'Detalle', $parameters = $parametro->ID, $attributes = ['class'=>'btn'])!!}
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
