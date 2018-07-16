<div >
@if (isset($label)&&$label)
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
@endif
</div>
<div >
@if (isset($class)&&$class)
{!! Form::textarea($var, isset($value)?$value:null, array('class'=>$class)) !!}
@else
{!! Form::textarea($var, isset($value)?$value:null, array('class'=>'mytextarea')) !!}
@endif
</div>

