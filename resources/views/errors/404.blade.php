@extends('template.admin')

<style>
	
	h2 {
		margin: 0 10px;
		font-size: 40px;
		text-align: center;
	}
	 
	h2 > span {
		color: #bbb;
		font-size: 80px;
	}

	h2 > p{
		color: red;
		font-weight: bold;
	}

	div > p{
		font-weight: bold;
		font-size: 18px;
	}

	.error{
		max-width: 380px; 
		width: 480px;
		margin: 0 auto;
	}
	  
</style>

@section('panel')	
	<h2><span>ERROR 404</span><br><p>Página no encontrada</p></h2>
	<div><p>¡Vaya! Algo salió mal.</p>Puede que la página solicitada yo no exista, haya cambiado de nombre. Trata de volver a cargar esta página o no dudes en contactar con nosotros si el problema persiste.</div>
@stop
