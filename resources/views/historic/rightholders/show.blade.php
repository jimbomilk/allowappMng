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

                    <div class="col-sm-10">
                        <strong>#Id: </strong>{{$element->id}}<br>
                        <strong>#Nombre : </strong>{{$element->name}}<br>
                        <strong>#Email : </strong>{{$element->email}}<br>
                        <strong>#Phone :</strong> {{$element->phone}}<br>
                        <strong>#ID :</strong> {{$element->documentId}}<br>


                        <strong>#{{$element->relation}} de</strong> {{$element->person->name}} <br>


                        <strong>#Consentimiento anual: </strong>
                        @if($element->status == \App\Status::RH_NOTREQUESTED)
                            No solicitado.
                        @elseif($element->status == \App\Status::RH_PENDING)
                            Enviado, pendiente de respuesta.
                        @elseif($element->status == \App\Status::RH_PROCESED)
                            Activo desde :{{$element->consentDate}}<br>{{json_encode($element->consent)}}
                        @endif


                    </div>

                </div>
            </div>


            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Fotografías relacionadas: {{count($element->person->photos)}}
                </div>
                <div class="panel-body">
                    @foreach($element->person->photos as $photo)
                        <div class="col-sm-6">

                            <div class="row">
                                <div class="col-sm-6">
                                    <img class="img-responsive" src={{$photo->url}} alt="imagen">
                                </div>
                                <div class="col-sm-6">
                                    <strong>#Id:</strong> {{$photo->id}}<br>
                                    <strong>#Fecha :</strong> {{$photo->created}}<br>
                                    <strong>#Nombre :</strong> {{$photo->label}}<br>
                                    <strong>#Gestionada por :</strong> {{$photo->user->name}}<br>


                                </div>
                                <div class="col-sm-12">
                                    <strong style="float:left;">#Acciones:</strong><br>
                                    @if(count($element->getHistoric($photo->id))==0)
                                        <small>De momento no se han realizado acciones sobre esta imagen.</small>
                                    @endif
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
                    {!! Form::open(array('url' => 'historic/emails/byrightholder', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                    {!! Form::hidden('rightholderId', $element->id) !!}

                    @include("common.controls.input_text",array('var'=>'to','val'=>$element->email))
                    @include("common.controls.input_text",array('var'=>'title','val'=>"Informe para $element->name"))
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

