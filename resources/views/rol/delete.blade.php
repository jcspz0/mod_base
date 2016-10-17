@extends('template.admin')

@section('panel-title', session('parametros')[22]['VALOR'])

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

{!!Form::open(['route' =>  ['rol.destroy', $rol->ID], 'method' => 'DELETE', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">

		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[14]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$rol->NOMBRE}}</label>		
			</div>
		</div>
		
		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[15]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="descripcion" class="col-sm-4 control-label">{{$rol->DESCRIPCION}}</label>	
			</div>
		</div>
				
		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				@if(count($errors) == 0)
				<button type="submit" class="btn btn-primary">{{session('parametros')[23]['VALOR']}}</button>
				@endif
				<a href="{{ route('rol.index') }}" class="btn btn-danger">{{session('parametros')[24]['VALOR']}}</a>
			</div>
		</div>
		
	</div>
{!!Form::close()!!}	

@stop