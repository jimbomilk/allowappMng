@include("common.controls.input_select",array('var'=>'group_id','col'=>$groups))
@include("common.controls.input_number",array('var'=>'priority'))
@include("common.controls.input_textarea",array('var'=>'description','class'=>'form-control','label'=>"$name.description"))
@include("common.controls.input_check",array('var'=>'done','default'=>0))
@include("common.controls.input_check",array('var'=>'arco','default'=>0))
