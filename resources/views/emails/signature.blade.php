@component('mail::message')
{!!$email_text!!}
<br>

![photo]({{$email_photo}})

<strong>ATENCIÓN:</strong> Si no es tutor de <strong>{{$rightholderphoto->name}}</strong> o los tres últimos dígitos de su teléfono no son <strong> {{substr($rightholderphoto->rhphone,-3,3)}}</strong>, no pulse el botón pues se trata de un correo fraudulento.
@component('mail::button', ['url' => $rightholderphoto->link])
Revisar
@endcomponent

@endcomponent
