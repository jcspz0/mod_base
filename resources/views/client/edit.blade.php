@extends('template.admin')

@section('panel-title', session('parametros')[114]['VALOR'])

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
				<div class="panel-heading">{{session('parametros')[124]['VALOR']}}: {{ $client->nombre }}</div>
				<div class="panel-body">
					{!! Form::model($client, ['route' => ['client.update', $client], 'method' => 'PATCH']) !!}
						@include('client.partials.fields')
					<div class="btn-group">
						<button type="submit" class="btn btn-info">{{session('parametros')[125]['VALOR']}}</button>
					</div>
					{!! Form::close() !!}
					<br>
					<div class="btn-group">
						@if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
							@include('client.partials.delete')
						@endif
					</div>
				</div>
			</div>
			<a href="{{ route('client.index') }}" class="btn btn-danger">{{session('parametros')[122]['VALOR']}}</a>
		</div>
	</div>
</div>



@stop