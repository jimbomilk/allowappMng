<div class="form-group">
    <div class="row">
        <div class="col-sm-2">
        {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
        </div>
        <div class="col-sm-4">
        {!! Form::password($var, null, array('class'=>'form-control','placeholder'=>Lang::get('label_desc.'.$name.'.'.$var))) !!}
        </div>
    </div>
</div>