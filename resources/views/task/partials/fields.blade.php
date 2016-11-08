<div class="form-group">
    {!! Form::label('agent_id', session('parametros')[179]['VALOR']) !!}
    {!! Form::select('agent_id', $agents, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('client_id', session('parametros')[180]['VALOR']) !!}
    {!! Form::select('client_id', $clients, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('activity_id', session('parametros')[181]['VALOR']) !!}
    {!! Form::select('activity_id', $activities, ['class' => 'form-control']) !!}
</div>