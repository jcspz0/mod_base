@extends('template.admin')

@section('panel-title', session('parametros')[6]['VALOR'])

@section('panel')
	<div class="col-sm-6 col-sm-push-3 col-md-6 col-md-push-3 col-lg-4 col-lg-push-4">
		@parent
    </div>
@stop

@section('content')

	{!!Form::open(['route' => 'login.store', 'method' => 'POST', 'class' => 'form-horizontal form-group-sm'])!!}
		@include('alert.request')
		@include('alert.error')

        <div class="form-group">
			<label for="correo" class="col-sm-4 control-label">{{session('parametros')[7]['VALOR']}}</label>
			<div class="col-sm-8">
				{!!Form::text('correo', $correo, ['class'=>'form-control'])!!}
			</div>
		</div>

		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[8]['VALOR']}}</label>
			<div class="col-sm-8">						
				{!!Form::password('password', ['class'=>'form-control'])!!}
			</div>
		</div>
	
		<div class="form-groupr" align="center">
			{!!Form::submit(session('parametros')[9]['VALOR'], ['class' => 'btn btn-block btn-primary'])!!}
		</div>		
	{!!Form::close()!!}

@stop


      