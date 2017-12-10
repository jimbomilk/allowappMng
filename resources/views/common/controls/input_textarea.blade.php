<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
{!! Form::textarea($var, null, array('id'=>'mytextarea','class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}

</div>

