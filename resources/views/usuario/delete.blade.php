@extends('template.admin')

@section('panel-title', session('parametros')[60]['VALOR'])

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

{!!Form::open(['route' =>  ['usuario.destroy', $usuario->ID], 'method' => 'DELETE', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">

		<div class="form-group">
			<label for="ci" class="col-sm-4 control-label">{{session('parametros')[46]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->CI}}</label>		
			</div>
		</div>
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[47]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->NOMBRE}}</label>	
			</div>
		</div>
		
		<div class="form-group">
			<label for="paterno" class="col-sm-4 control-label">{{session('parametros')[48]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->APELLIDO_PATERNO}}</label>	
			</div>
		</div>			

		<div class="form-group">
			<label for="materno" class="col-sm-4 control-label">{{session('parametros')[49]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->APELLIDO_MATERNO}}</label>	
			</div>
		</div>

		<div class="form-group">
			<label for="usuario" class="col-sm-4 control-label">{{session('parametros')[50]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->USUARIO}}</label>	
			</div>
		</div>

		<div class="form-group">
			<label for="correo" class="col-sm-4 control-label">{{session('parametros')[51]['VALOR']}}</label>
			<div class="col-sm-8">						
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->CORREO}}</label>	
			</div>
		</div>

		<div class="form-group">
			<label for="telefono" class="col-sm-4 control-label">{{session('parametros')[52]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->TELEFONO}}</label>	
			</div>
		</div>

		<div class="form-group">
			<label for="rol" class="col-sm-4 control-label">{{session('parametros')[53]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="col-sm-4 control-label">{{$usuario->mu_rol->NOMBRE}}</label>
			</div>
		</div>
			
		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				@if(count($errors) == 0)
					<button type="submit" class="btn btn-primary">{{session('parametros')[61]['VALOR']}}</button>
				@endif
				<a href="{{ route('usuario.index') }}" class="btn btn-danger">{{session('parametros')[62]['VALOR']}}</a>
			</div>
		</div>
		
	</div>
{!!Form::close()!!}	

@stop