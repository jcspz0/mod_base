@extends('template.admin')

@section('panel-title', session('parametros')[79]['VALOR'])

@section('content')

{!!Form::open(['class' => 'form-horizontal form-group-sm'])!!} 

<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

<table id="tblDatos" class="table table-striped table-bordered">
	<thead>
		<tr>				
			<th>Fecha Hora</th>
			<th>Accion</th>
			<th>Formulario</th>
			<th>Usuario</th>
			<th>Descripcion</th>
			<th>IP</th>
		</tr>
	</thead>
	
</table>

{!!Form::close()!!}

<script>
    $(document).ready(function () {
    	var token = $("#token").val();
    	
        $("#tblDatos").DataTable({
            "processing": true, // for show progress bar
            "serverSide": true, // for process server side
            "filter": false, // this is for disable filter (search box)
            "order": [],
            "responsive": true,
            "ajax": {
                "headers": {'X-CSRF-TOKEN': token},
                //"url": "/mu_base/public/getBitacora",
                //"url": "getBitacora",
                "url": "{{ route('getBitacora')}}",
                "type": "POST",
                "datatype": "json"
            },
            "columns": [
                    { "data": "fechaHora", "name": "fechaHora", "autoWidth": true },
                    { "data": "accion", "name": "accion", "autoWidth": true },
                    { "data": "formulario", "name": "formulario", "autoWidth": true },
                    { "data": "usuario", "name": "usuario", "autoWidth": true },
                    { "data": "descripcion", "name": "descripcion", "autoWidth": true },
                    { "data": "direccionIp", "name": "direccionIp", "autoWidth": true }
            ],
            "columnDefs": [
                { "orderable": false, "targets": 0 }
            ],
            /*"language": {
                "url": "/Account/getDataTableLanguage"
            }*/
        });

    });
</script>

@stop