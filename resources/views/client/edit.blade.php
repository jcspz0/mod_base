@extends('template.admin')

<!--@section('panel-title', session('parametros')[45]['VALOR'])-->

@section('content')

<?php $message = Session::get("message"); ?>

@if (Session::has("message"))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get("message")}}
	</div>
@endif

@include('alert.errors')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Editar Cliente: {{ $client->nombre }}</div>
				<div class="panel-body">
					{!! Form::model($client, ['route' => ['client.update', $client], 'method' => 'PUT']) !!}
						@include('client.partials.fields')
						<button type="submit" class="btn btn-info">Actualizar Cliente</button>
					{!! Form::close() !!}
				</div>
			</div>
			@if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
				@include('client.partials.delete')
			@endif
		</div>
	</div>
</div>



@stop