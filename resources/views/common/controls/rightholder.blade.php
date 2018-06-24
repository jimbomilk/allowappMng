<div class="col-lg-4 col-md-4 col-sm-6">
    <div class="panel panel-default userlist">

        <div class="panel-body text-center">
            <div class="userprofile">
                <h3 class="username">{{$element->name}}</h3>
                <p>{{$element->relation}} de {{$element->person->name}}</p>
            </div>
            <strong>DNI/NIE/Pasaporte:</strong>{{$element->documentId}}<br>
            <p> {{$element->email}} | {{$element->phone}} </p>
            <div class="socials tex-center" style="margin-bottom: 40px">

                <strong>CONSENTIMIENTOS</strong><br>
                @foreach($consents as $consent)
                    <div style="margin-bottom: 20px">
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