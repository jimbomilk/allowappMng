@component('mail::message')
{!!$text!!}
<br>


![logo]({{$url}})
<br>
<a href="{{$route}}"> Pulse aquí para descargarla y poder compartir</a>



@endcomponent
