@extends('template.admin')

@section('panel-title', session('parametros')[108]['VALOR'])

@section('content')

    @if (Session::has("message"))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("message")}}
        </div>
    @endif

<div class="col-xs-6 col-xs-push-3 col-sm-4 col-sm-push-4">
    <div align="center">
    	{!! Html::image('images/logo.png', "Micrium", ['id' => 'imgCalender', 'title' => 'Micrium', 'class' => 'img-responsive']) !!}
    </div>
</div>

@stop