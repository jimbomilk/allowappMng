<div class="col-sm-12">

        <div class="col-sm-3">
            @include("common.controls.input_file",array('var'=>'photo','width'=>200,'height'=>200))

        </div>
        <div class="col-sm-2">
            @include("common.controls.input_select",array('var'=>'group_id','col'=>$groups))
        </div>
        <div class="col-sm-7" style="padding-top: 30px;">
            @include("common.controls.input_check",array('var'=>'minor','default'=>1))
        </div>
        <div class="col-sm-9">
            @include("common.controls.input_text",array('var'=>'name'))
        </div>

        <div class="col-sm-4">
            @include("common.controls.input_text",array('var'=>'phone'))
        </div>

        <div class="col-sm-4">
            @include("common.controls.input_text",array('var'=>'email'))
        </div>
        <div class="col-sm-5">
            @include("common.controls.input_text",array('var'=>'documentId'))
        </div>
</div>