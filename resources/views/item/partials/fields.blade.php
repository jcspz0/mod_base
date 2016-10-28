<div class="form-group">
    {!! Form::label('nombre', 'Nombre') !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingresa un nombre']) !!}
</div>
<div class="form-group">
    {!! Form::label('precio', 'precio') !!}
    {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => '0.00']) !!}
</div>
<div class="form-group">
    {!! Form::label('stock', 'stock') !!}
    {!! Form::text('stock', null, ['class' => 'form-control', 'placeholder' => '0']) !!}
</div>
<div class="form-group">
    {!! Form::label('category_id', 'Categoria') !!}
    {!! Form::select('category_id', $combobox, ['class' => 'form-control']) !!}
</div>