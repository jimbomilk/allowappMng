@extends('layouts.default')
@section('content')

<div class="row">
    <div class="col-md-12">
        <p>Ha recibido esta imagen como responsable de los derechos de imagen de {{$name}}.</p>
    </div>
</div>
<div class="row" >
    <div class="col-md-6" >
        <div style="text-align: center">
            <img class="img-responsive center" src="{{$photo->url}}">
        </div>
    </div>
    <div class="col-md-6">
        <p>
            El propietario de la imagen solicita su consentimiento para compartirla en las
            siguientes redes sociales:
        </p>
        @foreach( $sh as $key=>$value)
            @if($value)
                <div class="col-md-12">
                    <br><p><strong>Compartir en {{$key}} :</strong></p><br>
                </div>
                <div class="col-md-6">
                    <input type="radio" name="{{$key}}" value="consiente"> Consiente
                </div>
                <div class="col-md-6">
                    <input type="radio" name="{{$key}}" value="noconsiente"> No consiente
                </div>
            @endif
        @endforeach

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <p class="text-black">
            Recuerde que tiene derecho a revocar este permiso accediendo a este <a href="{{$photo->link}}">enlace</a> en cualquier momento. Por favor, guárdelo o descargue la aplicación móvil Allowapp para gestionar sus derechos de imagen.
        </p>
    </div>
</div>


@stop