<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::text($var, isset($val)?$val:null, array('id'=>$var,'class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}
</div>