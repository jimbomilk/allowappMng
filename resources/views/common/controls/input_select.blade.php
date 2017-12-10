<div class="form-group">
    @if (!isset($nolabel))
    {!! Form::label($var,Lang::get('label.'.$name.'.'.$var)) !!}
    @endif
    @if (isset($val))
    {!! Form::select($var,$col,$val, ['id' => $var, 'class' => 'form-control']) !!}
    @else
    {!! Form::select($var,$col,null, ['id' => $var, 'class' => 'form-control']) !!}
@endif
</div>