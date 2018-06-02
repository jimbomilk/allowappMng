
<div class="form-group @if (isset($class)) {{$class}} @endif">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::text($var, isset($val)?$val:null, array('id'=>$var,'class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}
</div>