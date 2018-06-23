<div class="form-group">
@if (isset($label)&&$label)
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
@endif
{!! Form::textarea($var, $value, array('class'=>'mytextarea','placeholder'=>$value)) !!}

</div>

