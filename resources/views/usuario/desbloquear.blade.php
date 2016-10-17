@extends('template.admin')

@section('panel-title', session('parametros')[68]['VALOR'])

@section('content')

{!!Form::open(['action' => ['UsuarioController@guardarDesbloquear', $usuario->ID], 'method' => 'POST', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2 " >
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">Nombre: </label>
			<div class="col-sm-8">
				<label class="control-label">{{$usuario->NOMBRE}}</label>
			</div>
		</div>
		
		<div class="form-group">
			<label for="paterno" class="col-sm-4 control-label">Apellido Paterno: </label>
			<div class="col-sm-8">
				<label class="control-label">{{$usuario->APELLIDO_PATERNO}}</label>
			</div>
		</div>			

		<div class="form-group">
			<label for="materno" class="col-sm-4 control-label">Apellido Materno: </label>
			<div class="col-sm-8">
				<p class="help-block">{{$usuario->APELLIDO_MATERNO}}</p>			
			</div>
		</div>

		<div class="form-group">
			<label for="usuario" class="col-sm-4 control-label">Desbloqueo: </label>
			<div class="col-sm-8">
				<div class="radio">
					<label>
						<input type="radio" name="desbloquear" id="desbloquear1" value="0" checked>
						{{session('parametros')[69]['VALOR']}}
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="desbloquear" id="desbloquear2" value="1">
						{{session('parametros')[70]['VALOR']}}
					</label>
				</div>
			</div>
		</div>		

		<div class="form-group">
			<label class="col-sm-4 control-label"></label>
			<div class="col-sm-8">
				<button type="submit" class="btn btn-primary">{{session('parametros')[71]['VALOR']}}</button>
				<a href="{{ route('usuario.index') }}" class="btn btn-danger">{{session('parametros')[72]['VALOR']}}</a>
			</div>
		</div>
			
	</div>

{!!Form::close()!!}	

@stop