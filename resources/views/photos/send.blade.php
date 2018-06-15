@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-sm-12 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                         <div class="col-xs-6">  Errores detectados: {{count($errors)}}  </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class=" col-md-12 ">
                        @foreach($errors as $index=>$error)
                           <div class="@if($error['type']=='error') text-danger @else text-warning @endif">{{$index+1}}. {{strtoupper($error['type'])}}: {!!$error['text']!!}</div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-12 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6"><span style="padding-top: 15px">Destinatarios: </span></div>
                        <div class="col-xs-6">  {{$element->statuslabel}} </div>

                    </div>
                </div>
                <div class="panel-body">
                    <div class=" col-md-4 ">
                        <img  class="img-responsive center-block " src={{$element->url}}>
                    </div>
                    <div class=" col-md-8 ">
                        <div class="row">
                            <div class="col-xs-4"><strong>{{trans("label.$name.name-rightholder")}}</strong></div>
                            <div class="col-xs-5"><strong>{{trans("label.$name.name-email")}}</strong></div>
                        </div>
                        @if(count($rhs)>0)
                            @foreach($rhs as $rh)
                                <div class="row">
                                    <div class="col-xs-4"><small>{{$rh->rhname}} ({{$rh->rhrelation}} de {{$rh->name}})</small></div>
                                    <div class="col-xs-5"><small>{{$rh->rhemail}}</small></div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-xs-12 text-danger"> <p> {{trans('labels.no-rightholders')}}</p></div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>


            <div  class="col-sm-12 panel panel-default">
                <div class="panel-heading">{{ trans('labels.message')}}  </div>

                {!! Form::open(array('url' => 'photos/emails', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                {!! Form::hidden('photoId', $element->id) !!}

                @include("common.controls.input_textarea",array('var'=>'email','value'=>$template))


                <div><strong>{{trans('labels.responsable')}}: </strong>{{$element->user->name}}</div>
                <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$element->getSharingAsText()}}</div>
                <div><strong>{{trans('labels.legitimacion')}}: </strong>{{trans('labels.legitimacion_text')}}</div>
                <div><strong>{{trans('labels.derechos')}}: </strong>{{trans('labels.derechos_text')}}</div>

                <p style="text-align: center;margin: 12px">
                    <a href="#" class="btn btn-primary {{$enabled}}" data-toggle="modal" data-target="#modal" >
                        {{ trans("label.$name.request")}}
                    </a>
                </p>



                @include('adminlte::layouts.partials.modal',['text'=>"Se va a proceder a enviar ". count($rhs)." emails. "])


                {!! Form::close() !!}

            </div>
        </div>


    </div>
@endsection


@section('scripts')
@parent
@endsection

