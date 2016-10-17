@extends('template.admin')

@section('panel-title', session('parametros')[27]['VALOR'])

@section('content')

{!!Form::open()!!}
	<input type="hidden" id="idRol" name="idRol" value="{{$rol->ID}}">
	<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

	<table id="tblDatos" class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>Tipo Parametro</th>
				<th>Permiso</th>
			</tr>
		</thead>
		<tbody>
			@foreach($rolTipoParametros as $rolTipoParametro)
			<tr>
				<td>{{$rolTipoParametro->nombreTipoParametro}}</td>
				<td>
					{!!Form::select('permiso_'.$rolTipoParametro->ID.'_'.$rolTipoParametro->ID_MU_TIPO_PARAMETRO, $selectPermisos, $rolTipoParametro->ID_MU_PERMISO, ['id' => 'permiso_'.$rolTipoParametro->ID.'_'.$rolTipoParametro->ID_MU_TIPO_PARAMETRO, "onchange" => "guardarPermiso($rolTipoParametro->ID, $rolTipoParametro->ID_MU_TIPO_PARAMETRO, this.value)"])!!}
					<span id="mensaje{{$rolTipoParametro->ID.'_'.$rolTipoParametro->ID_MU_TIPO_PARAMETRO}}"></span>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>

	<div align="center">
		<!--<button type="submit" class="btn btn-primary">Guardar</button>-->
		<a href="{{ route('rol.index') }}" class="btn btn-danger">{{session('parametros')[28]['VALOR']}}</a>
	</div>

{!!Form::close()!!}	

<script language="javascript">
$(document).ready(function () {
	$("#tblDatos").DataTable({
	    "order": [],
	    "filter": true,
	    "responsive": true,
	    /*"language": {
	        "url": "/Account/getDataTableLanguage"
	    }*/
	});
});

function guardarPermiso(idRolTipoParametro, idTipoParametro, value){
	//alert(idRolTipoParametro+", " + idTipoParametro+", "+value);
	var token = $("#token").val();
	var idRol = $("#idRol").val();
	idspan = "mensaje"+idRolTipoParametro+"_"+idTipoParametro;
	$('#'+idspan).removeClass('text-success text-danger');
	$("#"+idspan).text("registrando...");
	$.ajax({
		url: "/mu_base/public/guardarPermisoParametro",
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data:{idRol: idRol, idRolTipoParametro: idRolTipoParametro, idTipoParametro: idTipoParametro, idPermiso: value},
		success:function(resp){
			if (resp.result){
				$('#'+idspan).addClass('text-success'); 
			}
			else{
				$('#'+idspan).addClass('text-danger'); 
			}
			$("#"+idspan).text(resp.mensaje);
		},
	});
}
</script>

@stop