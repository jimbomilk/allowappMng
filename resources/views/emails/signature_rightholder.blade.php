@component('mail::message')
{!!$email_text!!}
<br>


<strong>ATENCIÓN:</strong> Si no es tutor de {{$rightholder->person->name}} y los tres últimos dígitos de su teléfono no son <strong> {{substr($rightholder->phone,-3,3)}}</strong>, no pulse el botón pues se trata de un correo fraudulento.
@component('mail::button', ['url' => $rightholder->link])
Revisar
@endcomponent

@endcomponent
