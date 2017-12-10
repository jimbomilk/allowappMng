<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
</div>
<div class="form-group">
{!! Form::input('datetime-local', $var,isset($default)?$default:null); !!}
</div>