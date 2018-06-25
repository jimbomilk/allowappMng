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
                        <img class="img-responsive" src={{$element->url}} alt="imagen">
                    </div>
                    <div class="col-sm-8">
                        <strong>#Id:</strong> {{$element->id}}<br>
                        <strong>#Gestionada por :</strong> {{$element->user->name}}<br>
                        <strong>#Etiqueta :</strong> {{$element->label}}<br>
                        <strong>#Curso :</strong> {{$element->group->name}}<br>
                        <strong>#Personas identificadas en la imagen:</strong><br>

                        @foreach($element->people as $index=>$person)
                            <div class="col-sm-6">
                                {{$index+1}}. {{\App\Person::find($person->id)->name}}
                            </div>
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
