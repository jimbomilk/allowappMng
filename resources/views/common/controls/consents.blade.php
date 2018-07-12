<strong>CONSENTIMIENTOS</strong><br>
@foreach($consents as $consent)
    <div class="col-sm-6 col-xs-6">
        <h5>{{$consent->description}}</h5>

        @if (($rhConsent = $element->getRhConsent($consent->id)))

            @if($rhConsent->status==\App\Status::RH_PROCESED && isset($rhConsent->consents) )
                @include("common.controls.rhconsents",['rhconsents'=>json_decode($rhConsent->consents)])


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