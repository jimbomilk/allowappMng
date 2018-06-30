@component('mail::message')
{!!$text!!}
<br>
<h2>Datos de registro:</h2>
@component('mail::panel', ['width' => '100%'])
<table width="100%">
    <tr>
        <td width="50%">
            <table>
                <tr><td><strong>#Id:</strong> {{$element->id}}</td></tr>
                <tr><td><strong>#Nombre :</strong> {{$element->name}}</td></tr>
                <tr><td><strong>#Email :</strong> {{$element->email}}</td></tr>
                <tr><td><strong>#Teléfono:</strong>{{$element->phone}}</td></tr>
                <tr><td><strong>#{{$element->relation}} de</strong> {{$element->person->name}}</td></tr>
            </table>
        </td>
        <td width="50%">
            <table>
                <tr><td>@include("common.controls.consents_table",['consents'=>$consents,'element'=>$element])</td></tr>
            </table>
        </td>
    </tr>
</table>
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
