@extends('template.admin')

@section('panel-title', session('parametros')[65]['VALOR'])

@section('content')

{!!Form::open(['action' => ['UsuarioController@guardarBloquear', $usuario->ID], 'method' => 'POST', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 " >
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[47]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->NOMBRE}}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label for="paterno" class="col-sm-4 control-label">{{session('parametros')[48]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->APELLIDO_PATERNO}}</p>
			</div>
		</div>			

		<div class="form-group">
			<label for="materno" class="col-sm-4 control-label">{{session('parametros')[49]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->APELLIDO_MATERNO}}</p>			
			</div>
		</div>

		<div class="form-group">
			<label for="uusario" class="col-sm-4 control-label">{{session('parametros')[50]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->USUARIO}}</p>			
			</div>
		</div>

		<div class="form-group">
			<label for="correo" class="col-sm-4 control-label">{{session('parametros')[51]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->CORREO}}</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-primary">{{session('parametros')[66]['VALOR']}}</button>
				<a href="{{ route('usuario.index') }}" class="btn btn-danger">{{session('parametros')[67]['VALOR']}}</a>
			</div>
		</div>
			
	</div>
{!!Form::close()!!}	

@stop