@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')


    <div class="row" >

        <div class="col-md-6 legal" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    {{trans("label.$name.data")}} <div style="float: right;color: darkgrey"> {{$element->created}}</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-4">
                        <img class="img-responsive" src={{$element->photo}} alt="imagen">
                    </div>
                    <div class="col-sm-8">
                        <strong>#Id: {{$element->id}}<br></strong>
                        <strong>#Nombre : {{$element->name}}<br></strong>
                        <strong>#Curso : {{$element->group->name}}<br></strong>
                        <strong>#Padres y tutores: <br></strong>

                        @foreach($element->rightholders as $rh)
                            <div class="col-sm-12 text-center">{{$rh->name}}({{$rh->relation}})</div>
                            <div class="col-sm-12 text-center">
                                @include("common.controls.consents",['consents'=>$consents,'element'=>$rh])
                            </div>
                        @endforeach

                    </div>

                </div>
            </div>


            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Otras fotografías en las que aparece y de las que ha solicitado consentimiento: {{count($element->photos)}}
                </div>
                <div class="panel-body">
                    @foreach($element->photos as $photo)
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <img class="img-responsive" src={{$photo->url}} alt="imagen">
                            </div>
                            <div class="col-sm-6">
                                <strong>#Id:</strong> {{$photo->id}} <br>
                                <strong>#Fecha :</strong> {{$photo->created}}<br>
                                <strong>#Nombre :</strong> {{$photo->label}}<br>
                                <strong>#Gestionada por :</strong> {{$photo->user->name}}<br>
                            </div>
                            <div class="col-sm-12">
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
