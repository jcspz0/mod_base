@extends('template.admin')

@section('panel-title', session('parametros')[19]['VALOR'])


@section('panel')
	@parent
@stop

@section('content')

@if(count($errors) > 0)
	<div id="myAlert" class="alert alert-danger alert-dismissible" role="alert">
  		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  		<ul>
  			@foreach($errors as $error)
  				<li>{!!$error!!}</li>
  			@endforeach
  		</ul>
	</div>
@endif

{!!Form::model($rol, ['route' => ['rol.update', $rol->ID], 'method' => 'PUT', 'class' => 'form-group-sm form-horizontal'])!!}	
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[14]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombre" name="nombre" value="{{$rol->NOMBRE}}">
			</div>
		</div>

		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[15]['VALOR']}}</label>
			<div class="col-sm-8">						
				<input type="text" class="form-control" id="descripcion" name="descripcion" value="{{$rol->DESCRIPCION}}">
			</div>
		</div>
	
		<div class="form-group" align="center">
			<button type="submit" class="btn btn-primary">{{session('parametros')[20]['VALOR']}}</button>
			<a href="{{ route('rol.index') }}" class="btn btn-danger">{{session('parametros')[21]['VALOR']}}</a>	
		</div>
	</div>

	
{!! Form::close() !!}		
@stop