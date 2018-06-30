<table>
    <tr>
        <th>Consentimientos<th>
    </tr>



@foreach($consents as $consent)
    <tr>
        <td><strong>{{$consent->description}}:</strong>
        @if (($rhConsent = $element->getRhConsent($consent->id)))
            @if($rhConsent->status==\App\Status::RH_PROCESED && isset($rhConsent->consents) )
                <span>@include("common.controls.rhconsents_table",['rhconsents'=>json_decode($rhConsent->consents)])</span>
            @elseif($rhConsent->status==\App\Status::RH_NOTREQUESTED)
                <span style="color: blue " aria-hidden="true">no solicitado</span>
            @else
                <span style="color: red " aria-hidden="true">a la espera</span>
            @endif
        @else
            <span style="color: blue " aria-hidden="true">no solicitado</span>
        @endif
        </td>

    </tr>
@endforeach
</table>