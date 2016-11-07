@extends('template.admin')

@section('panel-title', session('parametros')[148]['VALOR'])

@section('content')

<?php $message = Session::get("message"); ?>

@if (Session::has("message"))
	<div class="alert alert-success alert-dismissible" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		{{Session::get("message")}}
	</div>
@endif

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{ session('parametros')[149]['VALOR'] }}</div>
				<div class="panel-body">
					{!! Form::open(['route' => 'item.index', 'method' => 'GET', 'class' => 'navbar-form navbar-left pull-right', 'rol' => 'search']) !!}
						<div class="form-group">
							{!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'nombre del item']) !!}
						</div>
						<button type="submit" class="btn btn-default">{{ session('parametros')[150]['VALOR'] }}</button>
					{!! Form::close() !!}
					<p>
						@if ($acciones[config('sistema.ID_ACCION_NUEVO')])
							<a class="btn btn-info" href="{{ route('item.create') }}" role="button">
								{{ session('parametros')[151]['VALOR'] }}
							</a>
						@endif
					</p>
					<p>Hay {{ $items->total() }} items</p>
					@include('item.partials.table')
					{!! $items->render() !!}
				</div>
			</div>
		</div>
	</div>
</div>

{!! Form::open(['route' => ['item.destroy', ':ITEM_ID'], 'method' => 'DELETE', 'id' => 'form-delete']) !!}
{!! Form::close() !!}
<script>
	$(document).ready(function () {
		$('.btn-delete').click(function (e) {
			e.preventDefault();
			var row = $(this).parents('tr');
			var id = row.data('id');
			var form = $('#form-delete');
			var url = form.attr('action').replace(':ITEM_ID', id);
			var data = form.serialize();
			row.fadeOut();
			$.post(url, data, function (result) {
				alert(result.message);
			}).fail(function () {
				alert('El Item no pudo ser Eliminado');
				row.show();
			});
		});
	});
</script>

@endsection
