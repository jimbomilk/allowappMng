@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')


    <div class="row" >

        <div class="col-md-6 legal" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Datos de registro <div style="float: right;color: darkgrey"> {{$element->created}}</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <img class="img-responsive" src={{$element->url}} alt="imagen">
                    </div>
                    <div class="col-sm-6">
                        <h5><strong>#Id:</strong> {{$element->id}}</h5>
                        <h5><strong>#Gestionada por :</strong> {{$element->user->name}}</h5>
                        <h5><strong>#Etiqueta :</strong> {{$element->label}}</h5>
                        <h5><strong>#Curso :</strong> {{$element->group->name}}</h5>
                        <h5><strong>#Personas identificadas en la imagen:</strong></h5>

                        @foreach($element->people as $index=>$person)
                                    <h6><strong>{{$index+1}}. {{\App\Person::find($person->id)->name}}</strong></h6>
                            @foreach(\App\Person::find($person->id)->rightholders as $rh)
                                <h7 style="text-align: justify;padding-left: 12px">
                                <strong> {{$rh->relation}}:</strong> {{$rh->name}} . Constentimiento anual


                                @if($rh->status == \App\Status::RH_NOTREQUESTED)
                                    no solicitado.
                                @elseif($rh->status == \App\Status::RH_PENDING)
                                    enviado, pendiente de respuesta.
                                @elseif($rh->status == \App\Status::RH_PROCESED)
                                    activo:{{$rh->consentDate}}<br>{{json_encode($rh->consent)}}
                                @endif
                                </h7>
                            @endforeach

                        @endforeach

                    </div>
                    <div class="col-sm-12">
                        <strong>#Acciones:</strong><br>
                        @foreach($element->getHistoric($element->id) as $index=>$h)
                            {{$index+1}}. <small>{{$h->created}} : {{$h->log}}</small><br>
                        @endforeach
                    </div>

                </div>
            </div>



        </div>

        <div class="col-md-6 legal" >
            <div class="panel panel-primary" >
                <div class="panel-heading" >
                    Envíar informe
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url' => 'historic/emails/byphoto', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                    {!! Form::hidden('photoId', $element->id) !!}

                    @include("common.controls.input_text",array('var'=>'to','val'=>$destinatarios))
                    @include("common.controls.input_text",array('var'=>'title','val'=>"Informe de $element->name"))
                    @include("common.controls.input_textarea",array('var'=>'email','value'=>"Les adjunto informe de los datos de $element->name"))

                    <p style="text-align: center;margin: 12px">
                        <button type="submit" class="btn btn-primary">{{ trans("label.$name.request")}} </button>
                    </p>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@endsection
