@extends('template.admin')

@section('panel-title', session('parametros')[135]['VALOR'])

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
				<div class="panel-heading">{{ session('parametros')[141]['VALOR'] }}: {{ $category->nombre }}</div>
				<div class="panel-body">
					{!! Form::model($category, ['route' => ['category.update', $category], 'method' => 'PUT']) !!}
						@include('category.partials.fields')
					<div class="btn-group">
						<button type="submit" class="btn btn-info">{{ session('parametros')[140]['VALOR'] }}</button>
					</div>
					{!! Form::close() !!}
					<br>
					<div class="btn-group">
						@if ($acciones[config('sistema.ID_ACCION_ELIMINAR')])
							@include('category.partials.delete')
						@endif
					</div>
				</div>
			</div>
			<a href="{{ route('category.index') }}" class="btn btn-danger">{{session('parametros')[139]['VALOR']}}</a>
		</div>
	</div>
</div>



@stop