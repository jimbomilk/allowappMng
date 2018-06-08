
@include("common.controls.input_select",array('var'=>'group_id','col'=>$groups))

@include("common.controls.input_text",array('var'=>'name'))

@include("common.controls.input_check",array('var'=>'minor','default'=>1))

@include("common.controls.input_text",array('var'=>'email'))

@include("common.controls.input_text",array('var'=>'documentId'))

@include("common.controls.input_file",array('var'=>'photo','width'=>200,'height'=>200))
