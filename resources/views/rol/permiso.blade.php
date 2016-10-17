@extends('template.admin')

@section('panel-title', session('parametros')[30]['VALOR'])


@section('panel')
	<!--<div class="col-sm-6 col-sm-push-3 col-md-6 col-md-push-3 col-lg-4 col-lg-push-4">-->
		@parent
    <!--</div>-->
@stop

@section('content')

{!!Form::open(['class' => 'form-horizontal form-group-sm'])!!} 

<input type="hidden" id="idRol" name="idRol" value="{{$rol->ID}}">
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

<div id="alert" class="alert alert-danger ocultar" role="alert" >
    <div id="mensaje_permiso"></div>
</div>

<div id="arbolTest"></div>
<br>
<input type="button" value="{{session('parametros')[31]['VALOR']}}" class="btn btn-primary" onclick="enviarDatos()" />
<a href="{{ route('rol.index') }}" class="btn btn-danger">{{session('parametros')[32]['VALOR']}}</a>

{!!Form::close()!!}

<script type="text/javascript">
    var selectedItems = [];
    //var form = $('#form_arbol');
   
    $(document).ready(function () {
        var idRol = $("#idRol").val();
        var token = $("#token").val();
        $("#arbolTest").jstree({
            "core": {
                "data": 

                function (obj, callback) {
                    $.ajax({
                        async: true,
                        headers: {'X-CSRF-TOKEN': token},
                        type: "POST",
                        data: {idRol: idRol},
                        //url: "/mu_base/public/cargarArbol",
                        //url: "/cargarArbol",
                        //url: form.attr('action'),
                        url: "{{ route('cargarArbol')}}",
                        dataType: "json",
                        success: function (resp) {
                            //alert(resp);
                            if(resp.result){
                                callback.call(this, resp.arbol);
                            }
                            else{
                                //window.location = "http://localhost/mu_base/public/" + response.ruta;              
                                //window.location = "http://localhost/mu_base/public/" + resp.ruta;              
                            }
                        }
                    });
                }


            },
            "checkbox": {
                "keep_selected_style": false
            },
            "plugins": ["checkbox"]
        });

        $('#arbolTest').on("changed.jstree", function (e, data) {
            selectedItems = data.selected;
        });
    });

    function enviarDatos() {
        var idRol = $("#idRol").val();
        var token = $("#token").val();
        //console.log("idRol: " + idRol);
        var parametros = "";
        selectedItems.forEach(function (element, index, array) {
            if (index == selectedItems.length - 1) {
                parametros += element + "=true";
            } else {
                parametros += element + "=true&";
            }
        });

        console.log(parametros);

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': token},
            //url: "/mu_base/public/guardarArbol",
            //url: "/guardarArbol",
            url: "{{ route('guardarArbol')}}",
            data: parametros+"&idRol="+idRol,
            success: function (resp) {
                $('#alert').removeClass('ocultar alert-success alert-info alert-danger');
                if (resp.result){
                    $('#alert').addClass('alert-success'); 
                }
                else{
                    $('#alert').addClass('alert-danger'); 
                }
                $('#mensaje_permiso').html(resp.mensaje); 
            }
        });
    }
</script>

@stop


      