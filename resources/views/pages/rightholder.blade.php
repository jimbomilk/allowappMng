@extends('layouts.default')
@section('content')


<div class="row" >

    <div class="col-md-5 legal" >
        <div class="panel panel-default" >
            <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                <strong>Marco regulatorio</strong>
            </div>
            <div class="panel-body">
            <p>Ha recibido este enlaces como responsable de los derechos de imagen de {{$rightholder->person->name}}.</p>
            <p>Se solicita su consentimiento para compartir imágenes en las
                bla bla bla</p>
            <p>Recuerde que tiene derecho a revocar este permiso accediendo a este <a href="{{$rightholder->link}}">enlace</a> en cualquier momento. Por favor, guárdelo o descargue la aplicación móvil Allowapp para gestionar sus derechos de imagen.
            </p>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        {!! Form::open(['route'=> 'rightholder.link.response']) !!}


        @include("common.controls.input_hidden",['var'=>'token','val'=>$token])
        @include("common.controls.input_hidden",['var'=>'rightholderId','val'=>$rightholder->id])
        @foreach( $publicationsites as $site)

        <div class="row" style="margin-top:20px;color: white">
            <div class="row">
                <div class="col-sm-offset-3 col-sm-6">
                    <strong>Compartir en {{$site}} :</strong>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-2">
                    {!! Form::radio($site, '1') !!} Consiente
                </div>
                <div class="col-sm-2">
                    {!! Form::radio($site, '0') !!} No consiente
                </div>
            </div>
        </div>

        @endforeach
        <div class="row" style="margin-top: 20px">
            <div class="col-sm-offset-3 col-sm-5" style="padding: 0">
                @include("common.controls.input_text_nolabel",['var'=>'dni','class'=>'social'])
            </div>
            <div class="col-sm-2" style="padding: 0">
                <button type="submit" class="btn btn-default" style="display: inline;background-color: rgb(246,216,88);color: #000000">{{ trans('labels.send')}}</button>
            </div>
        </div>

        {!! Form::close() !!}
    </div>
</div>

@stop