<div class="col-lg-3 col-md-3 col-sm-6 person group{{$element->person->group->id}}">
    <div class="panel panel-default userlist">
        <div style="margin-top: 12px">
            <div class="col-sm-4 text-left" >
                <span class="label label-primary">{{$element->person->group->name}}&nbsp;</span>
            </div>
            <div class="small col-sm-offset-2 col-sm-6 text-right">
                <span class="small"> <i class="fa fa-vcard-o text-primary"></i> {{$element->documentId}} </span>
            </div>
        </div>
        <div class="panel-body text-center">
            <div class="userprofile">
                <h3 class="username">{{$element->name}}</h3>
                <p>{{$element->relation}} de {{$element->person->name}}</p>
                <p><i class="fa fa-envelope text-primary"></i> {{$element->email}}</p>
                <p><i class="fa fa-phone text-primary"></i> {{$element->phone}} </p>
                <div class="socials tex-center" style="margin-bottom: 120px">
                    @include("common.controls.consents",['consents'=>$consents,'element'=>$element])
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="btn btn-link">
                @include("common.controls.btn_other",array('var'=>$element,'route'=>'consentimientos','label'=>'request', 'onlyicon'=>'true','small'=>'true','icon'=>'glyphicon-thumbs-up'))
            </div>
            <div class="btn btn-link pull-right">
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_delete",array('var'=>$element))
            </div>
        </div>
    </div>
</div>