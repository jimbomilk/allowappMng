<div class="form-group">
    @include("common.controls.input_file",array('var'=>'avatar','width'=>70,'height'=>70))
    @include("common.controls.input_number",array('var'=>'phone'))
    @include("common.controls.input_select",array('var'=>'type','col'=>$types))
</div>

