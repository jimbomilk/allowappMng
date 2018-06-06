@component('mail::message')
{!!$text!!}
<br>
<h2>Datos de registro:</h2>
@component('mail::panel', ['width' => '80%','height'=>'400px','class'=>'mini_panel'])
![photo]({{$element->url}})
<div style="float:left;margin-left:20px">
<strong>#Id:</strong> {{$element->id}}<br>
<strong>#Gestionada por :</strong> {{$element->user->name}}<br>
<strong>#Etiqueta :</strong> {{$element->label}}<br>
<strong>#Curso :</strong> {{$element->group->name}}<br>
<strong>#Personas identificadas en la imagen:</strong>
    @foreach($element->people as $index=>$person)
        <strong>{{$index+1}}. {{\App\Person::find($person->id)->name}}</strong><br>
        @foreach(\App\Person::find($person->id)->rightholders as $rh)
                <strong> {{$rh->relation}}:</strong> {{$rh->name}} . Constentimiento anual
                @if($rh->status == \App\Status::RH_NOTREQUESTED)
                    no solicitado.
                @elseif($rh->status == \App\Status::RH_PENDING)
                    enviado, pendiente de respuesta.
                @elseif($rh->status == \App\Status::RH_PROCESED)
                    activo:{{$rh->consentDate}}<br>{{json_encode($rh->consent)}}
                @endif
                <br><br>
        @endforeach
    @endforeach
</div>
<div style="float:left;margin-left: 20px">
    <br><h3><strong>#Acciones:</strong></h3>
    @foreach($element->getHistoric($element->id) as $index=>$h)
        {{$index+1}}. {{$h->created}} : {{$h->log}}<br>
    @endforeach
</div>

@endcomponent




@endcomponent
