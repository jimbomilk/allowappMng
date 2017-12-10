<div class="form-group" id={{$var}}>
    @if (!isset($nolabel))
        {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
    @endif
    @if (isset($val))
        {!! Form::number($var, $val, array('class'=>'form-control')) !!}
    @else
        {!! Form::number($var, null, array('class'=>'form-control')) !!}
    @endif
</div>