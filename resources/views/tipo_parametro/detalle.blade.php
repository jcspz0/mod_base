@extends('template.admin')

@section('panel-title', session('parametros')[77]['VALOR'])

@section('content')

{!!Form::open(['action' => ['TipoParametroController@parametro', $parametro->ID_MU_TIPO_PARAMETRO], 'method' => 'GET', 'class' => 'form-group-sm form-horizontal'])!!}
	<div class="col-xs-10 col-xs-push-1 col-sm-8 col-sm-push-2">
		
		<div class="form-group">
			<label for="nombre" class="col-sm-4 control-label">{{session('parametros')[74]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$parametro->NOMBRE}}</p>
			</div>
		</div>
		<div class="form-group">
			<label for="valor" class="col-sm-4 control-label">{{session('parametros')[75]['VALOR']}}</label>			
			<div class="col-sm-8">
				<p class="help-block">{{$parametro->VALOR}}</p>		
			</div>
		</div>

		<div class="form-group">
			<label for="descripcion" class="col-sm-4 control-label">{{session('parametros')[76]['VALOR']}}</label>
			<div class="col-sm-8">
				<p class="help-block">{{$parametro->DESCRIPCION_CAMPO}}</p>
			</div>
		</div>
	
		<div align="center">
			{!!link_to_action('TipoParametroController@parametro', $title = session('parametros')[78]['VALOR'], $parameters = $parametro->ID_MU_TIPO_PARAMETRO, $attributes = ['class'=>'btn btn-danger'])!!}
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