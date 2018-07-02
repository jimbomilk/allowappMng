@extends('layouts.default')
@section('content')


<div class="row" >

    <div class="col-md-5 legal" >
        <div class="panel panel-default" >
            <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                <strong>Marco regulatorio</strong>
            </div>
            <div class="panel-body" style="margin: 0px;height:50vh;overflow-y: scroll;overflow-x: hidden">
            Ha recibido este enlace como responsable de los derechos de imagen de <strong>{!!$rhConsent->rightholder->person->name!!}.</strong><br><br>
            <strong>Finalidad:</strong>
                <p>
                    {{trans('labels.finalidad_text')}} {{$rhConsent->rightholder->group->getSharingAsText()}}<br>
                </p>
            <strong>Legitimación:</strong> {!!$rhConsent->consent->legitimacion!!}<br>
            <strong>Destinatarios:</strong> {!!$rhConsent->consent->destinatarios!!}<br>
            <strong>Derechos:</strong> {!!$rhConsent->consent->derechos!!}<br>

            </div>
        </div>
    </div>
    <div class="col-md-7">
        {!! Form::open(['route'=> 'rightholder.link.response']) !!}


        @include("common.controls.input_hidden",['var'=>'token','val'=>$token])
        @include("common.controls.input_hidden",['var'=>'consentId','val'=>$rhConsent->id])
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