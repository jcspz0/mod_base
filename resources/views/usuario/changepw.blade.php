@extends('template.admin')

@section('panel-title', session('parametros')[84]['VALOR'])

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

{!!Form::model(['action' => ['UsuarioController@guardarCambiarContrasena', $usuario->ID], 'method' => 'POST'], ['class' => 'form-group-sm form-horizontal'])!!}

	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 " >
			
		<div class="form-group">
			<label for="ci" class="col-sm-4 control-label">{{session('parametros')[85]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->CI}}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[86]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->NOMBRE}}</p>
			</div>
		</div>
		
		<div class="form-group">
			<label for="paterno" class="col-sm-4 control-label">{{session('parametros')[87]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->APELLIDO_PATERNO}}</p>
			</div>
		</div>			

		<div class="form-group">
			<label for="materno" class="col-sm-4 control-label">{{session('parametros')[88]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->APELLIDO_MATERNO}}</p>
			</div>
		</div>

		<div class="form-group">
			<label for="password_actual" class="col-sm-4 control-label">{{session('parametros')[89]['VALOR']}}</label>
			<div class="col-sm-8">
				{!!Form::password('password', ['id' => 'password_actual', 'name' => 'password_actual', 'class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-4 control-label">{{session('parametros')[90]['VALOR']}}</label>
			<div class="col-sm-8">
				{!!Form::password('password', ['id' => 'password', 'name' => 'password', 'class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label for="password_confirmation" class="col-sm-4 control-label">{{session('parametros')[91]['VALOR']}}</label>
			<div class="col-sm-8">
				{!!Form::password('password', ['id' => 'password_confirmation', 'name' => 'password_confirmation', 'class'=>'form-control'])!!}
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-primary">{{session('parametros')[92]['VALOR']}}</button>
				<a href="{{ route('usuario.index') }}" class="btn btn-danger">{{session('parametros')[93]['VALOR']}}</a>
			</div>
		</div>

	</div>
{!!Form::close()!!}	

</div>

@stop