@extends('template.admin')

@section('panel-title', session('parametros')[25]['VALOR'])

@section('content')

{!!Form::open(['action' => 'RolController@index', 'method' => 'GET', 'class' => 'form-group-sm form-horizontal'])!!}		
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">

		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[14]['VALOR']}}</label>
			<div class="col-sm-8">
				<label class="control-label">{{$rol->NOMBRE}}</label>					
			</div>
		</div>

		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[15]['VALOR']}}</label>
			<div class="col-sm-8">						
				<label class="control-label">{{$rol->DESCRIPCION}}</label>
			</div>
		</div>
	
		<div class="form-group" align="center">
			<button type="submit" class="btn btn-danger">{{session('parametros')[26]['VALOR']}}</button>
		</div>
			
	</div>
{!!Form::close()!!}	

@stop