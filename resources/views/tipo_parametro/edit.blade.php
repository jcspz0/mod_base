@extends('template.admin')

@section('panel-title', session('parametros')[101]['VALOR'])

@section('content')


{!!Form::open(['action' => ['TipoParametroController@updateParametro', $parametro->ID_MU_TIPO_PARAMETRO, $parametro->ID], 'method' => 'POST', 'class' => 'form-group-sm form-horizontal'])!!}
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[74]['VALOR']}}</label>
			<div class="col-sm-8">
				<label for="nombre" class="control-label">{{$parametro->NOMBRE}}</label>
			</div>
		</div>
		<div class="form-group">
			<label for="valor" class="col-sm-4 control-label">{{session('parametros')[75]['VALOR']}}</label>			
			<div class="col-sm-8">
				@if ($parametro->TIPO == 'CADENA')
					{!!Form::text('valor', $parametro->VALOR, ['class'=>'form-control'])!!}
				@else
					@if ($parametro->TIPO == 'MULTI CADENA')
						{!!Form::textarea('valor', $parametro->VALOR, ['class'=>'form-control'])!!}
					@else
						@if ($parametro->TIPO == 'BOOLEANO')
							{!!Form::select('valor', ['0' => 'false', '1' => 'true'], $parametro->VALOR, ['class' => 'form-control'])!!}
						@else
							@if ($parametro->TIPO == 'FECHA')
								{!!Form::text('valor', $parametro->VALOR, ['id' => 'valor', 'readonly', 'class'=>'form-control', 'placeholder'=>'Ingresa el Nombre del usuario'])!!}
							@else
								@if ($parametro->TIPO == 'FECHA HORA')
									<input type="text" class="form-control" id="valor" name="valor" value="{{$parametro->VALOR}}">
								@else
									@if ($parametro->TIPO == 'ENTERO')
										<input type="text" class="form-control" onkeypress="return soloNumero(event)" name="valor" value="{{$parametro->VALOR}}">
									@endif
								@endif
							@endif
						@endif
					@endif
				@endif
			</div>
		</div>

		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[76]['VALOR']}}</label>
			<div class="col-sm-8">						
				<input type="text" class="form-control" id="descripcion" name="descripcion" value="{{$parametro->DESCRIPCION_CAMPO}}">
			</div>
		</div>
	
		<div align="center">
			<button type="submit" class="btn btn-primary">{{session('parametros')[102]['VALOR']}}</button>
			{!!link_to_action('TipoParametroController@parametro', $title = session('parametros')[103]['VALOR'], $parameters = $parametro->ID_MU_TIPO_PARAMETRO, $attributes = ['class'=>'btn btn-danger'])!!}
		</div>
	</div>
<script>

$(function() {
	$( "#valor" ).datepicker({
		dateFormat: "dd/mm/yy"
		//showOn: "button",
		//buttonImage: "http://localhost/mu_base/public/img/calendar.png",
		//buttonImageOnly: true,
		//buttonText: "Select date"
	});

	//$( "#datepicker" ).datepicker();
});
</script>
{!! Form::close() !!}



			
@stop