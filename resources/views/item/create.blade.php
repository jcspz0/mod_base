@extends('template.admin')

@section('panel-title', session('parametros')[148]['VALOR'])

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
				<div class="panel-heading">{{ session('parametros')[155]['VALOR'] }}</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'item.store', 'method' => 'POST']) !!}
						@include('item.partials.fields')
						<button type="submit" class="btn btn-default">{{ session('parametros')[156]['VALOR'] }}</button>
					{!! Form::close() !!}
				</div>
			</div>
			<div>
				<a href="{{ route('item.index') }}" class="btn btn-danger">{{session('parametros')[154]['VALOR']}}</a>
			</div>
		</div>
	</div>
</div>



@stop