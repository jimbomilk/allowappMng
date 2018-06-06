@component('mail::message')
{!!$text!!}
<br>
<h2>Datos de registro:</h2>
@component('mail::panel', ['width' => '100%'])
<p style="float:left;margin-left: 15px">
    <strong>#Id:</strong> {{$element->id}}<br>
    <strong>#Nombre :</strong> {{$element->name}}<br>
    <strong>#Email :</strong> {{$element->email}}<br>
    <strong>#Teléfono:</strong>{{$element->phone}}<br>
    <strong>#{{$element->relation}} de</strong> {{$element->person->name}}<br>
    <strong>#Consentimiento anual: </strong>
    @if($element->status == \App\Status::RH_NOTREQUESTED)
        no solicitado.
    @elseif($element->status == \App\Status::RH_PENDING)
        enviado, pendiente de respuesta.
    @elseif($element->status == \App\Status::RH_PROCESED)
        activo:{{$element->consentDate}}<br>{{json_encode($element->consent)}}
    @endif

</p>
@endcomponent
<h2>Imagenes relacionadas:</h2>
<table>
<tr>
    @foreach($element->person->photos as $index=>$photo)
    @if (($index%2)==0)
    </tr><tr>
    @endif
    <td style="width: 50%">
        @component('mail::panel', ['width' => '100%','height'=>'200px','class'=>'mini_panel'])

![photo]({{$photo->url}})
        <p style="float:left;margin-left: 12px;font-size: 12px">
        <strong>#Id:</strong> {{$photo->id}}<br>
        <strong>#Fecha: </strong> {{$photo->created}}<br>
        <strong>#Etiqueta: </strong> {{$photo->label}}<br>
        <strong>#Responsable: </strong> {{$photo->user->name}}<br>
        <strong>#Acciones: </strong><br>
        @foreach($element->getHistoric($photo->id) as $index=>$h)
        {{$index+1}}.{{$h->created}} : {{$h->log}}<br>
        @endforeach
        </p>


        @endcomponent
    </td>
@endforeach
</tr>
</table>



@endcomponent
