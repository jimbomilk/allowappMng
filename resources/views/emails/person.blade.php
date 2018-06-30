@component('mail::message')
{!!$text!!}
<br>
<h2>Datos de registro:</h2>
@component('mail::panel', ['width' => '100%'])
![photo]({{$element->photo}})
<div style="float: left">
    <table >
        <tr>
            <td>
                <table>
                    <tr><td><strong>#Id: </strong>{{$element->id}}</td></tr>
                    <tr><td><strong>#Nombre : </strong>{{$element->name}}</td></tr>
                    <tr><td><strong>#Curso : </strong>{{$element->group->name}}</td></tr>
                    <tr><td><strong>#Menor de edad: </strong> {{$element->minor?"si":"no"}}</td></tr>

                @if(!$element->minor)
                    <tr><td><strong>#Email: </strong> {{$element->email}}</td></tr>
                    <tr><td><strong>#Documento identificativo: </strong> {{$element->documentId}}</td></tr>
                    <tr><td><strong>#Teléfono </strong> {{$element->phone}}</td></tr>
                @endif
                </table>

            </td>
            <td>
                <table>
                    <tr><td><strong>Padres y tutores: </strong></td></tr>
                    <tr><td>
                        @foreach($element->rightholders as $index=>$rh)
                            {{$rh->name}}({{$rh->relation}})<br>
                            @include("common.controls.consents_table",['consents'=>$consents,'element'=>$rh])
                        @endforeach
                    </td></tr>
                </table>
            </td>
        </tr>
    </table>
</div>
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
