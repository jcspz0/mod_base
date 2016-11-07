<div class="form-group">
    {!! Form::label('nombre', session('parametros')[158]['VALOR']) !!}
    {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'ingresa un nombre']) !!}
</div>
<div class="form-group">
    {!! Form::label('precio', session('parametros')[159]['VALOR']) !!}
    {!! Form::text('precio', null, ['class' => 'form-control', 'placeholder' => '0.00']) !!}
</div>
<div class="form-group">
    {!! Form::label('stock', session('parametros')[160]['VALOR']) !!}
    {!! Form::text('stock', null, ['class' => 'form-control', 'placeholder' => '0']) !!}
</div>
<div class="form-group">
    {!! Form::label('category_id', session('parametros')[161]['VALOR']) !!}
    {!! Form::select('category_id', $categories, ['class' => 'form-control']) !!}
</div>