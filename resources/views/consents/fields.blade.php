@include("common.controls.input_text",array('var'=>'description'))
@include("common.controls.input_textarea",array('var'=>'legitimacion','value'=>trans("label_desc.$name.legitimacion"),'label'=>true))
@include("common.controls.input_textarea",array('var'=>'destinatarios','value'=>trans("label_desc.$name.destinatarios"),'label'=>true))
@include("common.controls.input_textarea",array('var'=>'derechos','value'=>trans("label_desc.$name.derechos"),'label'=>true))


