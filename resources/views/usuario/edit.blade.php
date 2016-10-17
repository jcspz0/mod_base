@extends('template.admin')

@section('panel-title', session('parametros')[57]['VALOR'])

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

{!!Form::model($usuario, ['route' => ['usuario.update', $usuario->ID], 'method' => 'PUT', 'class' => 'form-group-sm form-horizontal'])!!}
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 " >
			
		<div class="form-group">
			<label for="ci" class="col-sm-4 control-label">{{session('parametros')[46]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="ci" name="ci" value="{{$usuario->CI}}">
			</div>
		</div>
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[47]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="nombre" name="nombre" value="{{$usuario->NOMBRE}}">
			</div>
		</div>
		
		<div class="form-group">
			<label for="paterno" class="col-sm-4 control-label">{{session('parametros')[48]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="paterno" name="paterno" value="{{$usuario->APELLIDO_PATERNO}}">
			</div>
		</div>			

		<div class="form-group">
			<label for="materno" class="col-sm-4 control-label">{{session('parametros')[49]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="materno" name="materno" value="{{$usuario->APELLIDO_MATERNO}}">
			</div>
		</div>

		<div class="form-group">
			<label for="usuario" class="col-sm-4 control-label">{{session('parametros')[50]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="usuario" name="usuario" value="{{$usuario->USUARIO}}">
			</div>
		</div>

		<div class="form-group">
			<label for="correo" class="col-sm-4 control-label">{{session('parametros')[51]['VALOR']}}</label>
			<div class="col-sm-8">						
				<input type="text" class="form-control" id="correo" name="correo" value="{{$usuario->CORREO}}">
			</div>
		</div>

		<div class="form-group">
			<label for="telefono" class="col-sm-4 control-label">{{session('parametros')[52]['VALOR']}}</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" id="telefono" name="telefono" value="{{$usuario->TELEFONO}}">
			</div>
		</div>

		<div class="form-group">
			<label for="rol" class="col-sm-4 control-label">{{session('parametros')[53]['VALOR']}}</label>
			<div class="col-sm-8">
				{!!Form::select('rol', $selectRoles, $usuario->mu_rol->ID, ['class' => 'form-control', 'id' => 'rol' ])!!}
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-primary" >{{session('parametros')[58]['VALOR']}}</button>
				<a href="{{ route('usuario.index') }}" class="btn btn-danger">{{session('parametros')[59]['VALOR']}}</a>
			</div>
		</div>

	</div>

{!!Form::close()!!}	

@stop