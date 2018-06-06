@component('mail::message')
{!!$text!!}
<br>
<h2>Datos de registro:</h2>
@component('mail::panel', ['width' => '100%'])
![photo]({{$element->photo}})
<p style="float:left;margin-left: 80px">
    <strong>#Id: {{$element->id}}<br></strong>
    <strong>#Nombre : {{$element->name}}<br></strong>
    <strong>#Curso : {{$element->group->name}}<br></strong>
    <strong>#Padres y tutores: </strong>
    @foreach($element->rightholders as $index=>$rh)
        &emsp;{{$rh->name}}({{$rh->relation}}) @if ($index+1>count($element->rightholders)) , @endif <br>
        <strong>#Consentimiento anual: <br></strong>
        @if($rh->status == \App\Status::RH_NOTREQUESTED)
            No solicitado.
        @elseif($rh->status == \App\Status::RH_PENDING)
            Enviado, pendiente de respuesta.
        @elseif($rh->status == \App\Status::RH_PROCESED)
            Activo:{{$rh->consentDate}}<br>{{json_encode($rh->consent)}}
        @endif
    @endforeach
</p>
@endcomponent
<h2>Imagenes en las que aparece:</h2>
<table>
<tr>
@foreach($element->photos as $index=>$photo)
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
