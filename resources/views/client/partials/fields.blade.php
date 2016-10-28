<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingresa un nombre']) !!}
</div>
<div class="form-group">
    {!! Form::label('razon_social', 'Razon Social') !!}
    {!! Form::text('razon_social', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('latitud', 'Latitud') !!}
    {!! Form::text('latitud', '-1.0', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('longitud', 'Longitud') !!}
    {!! Form::text('longitud', '-1.0', ['class' => 'form-control']) !!}
</div>