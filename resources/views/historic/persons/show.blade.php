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
                        <img class="img-responsive" src={{$element->photo}} alt="imagen">
                    </div>
                    <div class="col-sm-6">
                        <strong>#Id: {{$element->id}}<br></strong>
                        <strong>#Nombre : {{$element->name}}<br></strong>
                        <strong>#Curso : {{$element->group->name}}<br></strong>
                        <strong>#Padres y tutores: <br></strong>

                        @foreach($element->rightholders as $rh)
                            &emsp;{{$rh->relation}}:{{$rh->name}}<br>
                            <strong>#Consentimiento anual: <br></strong>
                            @if($rh->status == \App\Status::RH_NOTREQUESTED)
                                No solicitado.
                            @elseif($rh->status == \App\Status::RH_PENDING)
                                Enviado, pendiente de respuesta.
                            @elseif($rh->status == \App\Status::RH_PROCESED)
                                Activo:{{$rh->consentDate}}<br>{{json_encode($rh->consent)}}
                            @endif
                        @endforeach

                    </div>

                </div>
            </div>


            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Fotografías en las que aparece: {{count($element->photos)}}
                </div>
                <div class="panel-body">
                    @foreach($element->photos as $photo)
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-12">
                            <strong>#Id:</strong> {{$photo->id}} / <strong>#Fecha :</strong> {{$photo->created}}<br>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <img class="img-responsive" src={{$photo->url}} alt="imagen">
                            </div>
                            <div class="col-sm-6">

                                <strong>#Nombre :</strong> {{$photo->label}}<br>
                                <strong>#Gestionada por :</strong> {{$photo->user->name}}<br>
                                <strong>#Acciones:</strong><br>
                                @foreach($element->getHistoric($photo->id) as $index=>$h)
                                    {{$index+1}}. <small>{{$h->created}} : {{$h->log}}</small><br>
                                @endforeach

                            </div>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>
        </div>

        <div class="col-md-6 legal" >
            <div class="panel panel-primary" >
                <div class="panel-heading" >
                    Envíar informe
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url' => 'historic/emails/byperson', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                    {!! Form::hidden('personId', $element->id) !!}

                    @include("common.controls.input_text",array('var'=>'to','val'=>implode(",",$element->rightholders->pluck('email')->toArray()).",".$element->email))
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
