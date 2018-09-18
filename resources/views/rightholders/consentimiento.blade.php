@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    {!! Form::open(array('url' => "$name/emails", 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
    {!! Form::hidden('rightholderId', isset($rightholder_id)?$rightholder_id:'all') !!}
    {!! Form::hidden('personId', isset($person_id)?$person_id:null) !!}
    {!! Form::hidden('groupId', isset($group_id)?$group_id:null) !!}
<div class="container-fluid spark-screen">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h4> Se van a solicitar consentimiento por EMAIL a los siguientes tutores:</h4>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-6">

                    <div class="row">
                        <div class="col-sm-12">
                            <h4>Enviar a:</h4>
                        </div>
                    </div>
                    @if(isset($element))
                        <div class="col-md-6" style="border-bottom: solid 1px black;float:left;height: 50px;padding-top: 10px">
                            <div data-id="{{$element->id}}" style="white-space: nowrap">
                                {{$element->name}}
                            </div>
                        </div>
                    @else
                        <div class="col-xs-12 nopadding">
                            @foreach($set as $rh)
                            <div class="col-md-4 col-xs-6" style="border-bottom: solid 1px black;float:left;height: 50px;padding-top: 6px">
                                <div data-id="{{$rh->id}}" style="white-space: nowrap">
                                    <strong>{{$rh->name}}</strong><br><small>({{$rh->email}})</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-sm-6">
                    <div class="row" >
                        <div class="col-sm-12">
                            <h4>Tipo de consentimiento a solicitar:</h4>
                        </div>
                        <div class="col-sm-12" >
                            @include("common.controls.input_select",array('var'=>'consent_id','nolabel'=>true,'col'=>$consents))


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                        <h4>Mensaje:</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            @include("common.controls.input_textarea",array('var'=>'email','value'=>$template))
                            <p style="text-align: center;margin: 12px">
                                 <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#modal" >
                                    {{ trans("label.$name.request")}}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @include('adminlte::layouts.partials.modal',['text'=>"Se va a proceder a enviar ". count($set)." emails.¿Desea continuar? "])
    {!! Form::close() !!}
@endsection

