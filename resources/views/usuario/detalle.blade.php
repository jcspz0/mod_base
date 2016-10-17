@extends('template.admin')

@section('panel-title', session('parametros')[63]['VALOR'])

@section('content')

{!!Form::open(['action' => 'UsuarioController@index', 'method' => 'GET', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 " >
			
		<div class="form-group">
			<label for="ci" class="col-sm-4 control-label">{{session('parametros')[46]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->CI}}</p>
			</div>
		</div>
		
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
			<label for="usuario" class="col-sm-4 control-label">{{session('parametros')[50]['VALOR']}}</label>
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
			<label for="telefono" class="col-sm-4 control-label">{{session('parametros')[52]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->TELEFONO}}</p>
			</div>
		</div>

		<div class="form-group">
			<label for="registrado" class="col-sm-4 control-label">Registrado: </label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->fechaRegistro()}}</p>
			</div>
		</div>

		<div class="form-group">
			<label for="modificado" class="col-sm-4 control-label">Modificado: </label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->fechaActualizacion()}}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label for="bloqueado" class="col-sm-4 control-label">Bloqueado: </label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->bloqueado()}}</p>
			</div>
		</div>

		<div class="form-group">
			<label for="rol" class="col-sm-4 control-label">{{session('parametros')[53]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->mu_rol->NOMBRE}}</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-danger">{{session('parametros')[64]['VALOR']}}</button>
			</div>
		</div>
			
	</div>

{!!Form::close()!!}	

@stop