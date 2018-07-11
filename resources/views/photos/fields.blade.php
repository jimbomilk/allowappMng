
<div class="col-sm-12">
    <div class="col-sm-4">
    @include("common.controls.input_file",array('var'=>'origen','width'=>'100%','height'=>200))
    </div>
    <div class="col-sm-2 ">
    @include("common.controls.input_select",array('var'=>'group_id','col'=>$groups))
    </div>
    <div class="col-sm-6 ">
    @include("common.controls.input_select",array('var'=>'consent_id','col'=>$consents))
    </div>
    <div class="col-sm-8 ">
    @include("common.controls.input_text",array('var'=>'label'))
    </div>

</div>


