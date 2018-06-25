<div class="col-lg-4 col-md-4 col-sm-6 person group{{$element->person->group->id}}">
    <div class="panel panel-default userlist">
        <div style="margin-top: 12px">
            <div class="col-sm-4 text-left" >
                <span class="label label-primary" >{{$element->person->group->name}}&nbsp;</span>
            </div>
            <div class="small col-sm-offset-4 col-sm-4 text-right">
                <span> <i class="fa fa-vcard-o text-primary"></i> {{$element->documentId}} </span>
            </div>
        </div>

        <div class="panel-body text-center">
            <div class="userprofile">
                <h3 class="username">{{$element->name}}</h3>
                <p>{{$element->relation}} de {{$element->person->name}}</p>


                <p><i class="fa fa-envelope text-primary"></i> {{$element->email}}</p>
               <p> <i class="fa fa-phone text-primary"></i> {{$element->phone}} </p>

            <div class="socials tex-center" style="margin-bottom: 120px">
                <strong>CONSENTIMIENTOS</strong><br>
                @foreach($consents as $consent)
                    <div class="col-sm-6">
                    <h5>{{$consent->description}}</h5>

                        @if (($rhConsent = $element->getRhConsent($consent->id)))

                            @if($rhConsent->status==\App\Status::RH_PROCESED && isset($rhConsent->consents) )
                                @foreach(json_decode($rhConsent->consents) as $key=>$value)
                                    <a href="" class="btn btn-circle btn-{{$value?'success':'default'}} "><i class="fa fa-{{$key}}"></i></a>
                                @endforeach

                            @elseif($rhConsent->status==\App\Status::RH_NOTREQUESTED)
                                <p style="color: blue " aria-hidden="true">no solicitado</p>
                            @else
                                <p style="color: red " aria-hidden="true">a la espera</p>
                            @endif
                        @else
                            <p style="color: blue " aria-hidden="true">no solicitado</p>
                        @endif

                    </div>
                @endforeach

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