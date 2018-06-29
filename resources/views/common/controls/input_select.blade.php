@if (!isset($nolabel))
{!! Form::label($var,Lang::get('label.'.$name.'.'.$var)) !!}
@endif
@if (isset($val))
    @if(isset($class))
        {!! Form::select($var,$col,$val, ['id' => $var, 'class' => $class]) !!}
    @else
        {!! Form::select($var,$col,$val, ['id' => $var, 'class' => 'form-control']) !!}
    @endif
@else
    @if(isset($class))
        {!! Form::select($var,$col,null, ['id' => $var, 'class' => $class]) !!}
    @else
        {!! Form::select($var,$col,null, ['id' => $var, 'class' => 'form-control']) !!}
    @endif
@endif
