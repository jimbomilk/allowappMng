<div class="form-group">

{!! Form::hidden($var, 0) !!}
{!! Form::checkbox($var, 1,isset($element)?$element->$var:$default,array('id'=>$var)) !!}
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!} <br>
</div>