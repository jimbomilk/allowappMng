@if (isset($val))
    {!! Form::hidden($var, $val, array('id'=>$var)) !!}
@else
    {!! Form::hidden($var, null, array('id'=>$var)) !!}
@endif