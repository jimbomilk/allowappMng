@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6"><span style="padding-top: 15px">{{$element->label}}#{{$element->id}}</span></div>
                        <div class="col-xs-6">  {{$element->statuslabel}} </div>

                    </div>
                </div>
                <div class="panel-body">
                    <img  class="img-responsive" src={{$element->url}}>

                </div>
            </div>
            <div class=" col-md-6 panel panel-default">
                <div class="panel-heading">{{ trans('labels.rightholders')}}</div>
                @if($element->group )
                    <strong>
                        <div class="col-xs-4">{{trans("label.$name.name-person")}}</div>
                        <div class="col-xs-4">{{trans("label.$name.name-rightholder")}}</div>
                        <div class="col-xs-4">{{trans("label.$name.link")}}</div>
                    </strong>

                    <div id = "panel-group" class="detected panel-body"  style="padding: 8px">

                        @foreach($rhs as $rh)
                            <div class="col-xs-4">{{$rh->name}}</div>
                            <div class="col-xs-4">{{$rh->rhname}}</div>
                            <div class="col-xs-4">{{$rh->link}}</div>
                        @endforeach
                    </div>
                @else
                    <div> <p> {{trans('labels.no-rightholders')}}</p></div>
                @endif

            </div>

            <div  class="col-md-6 panel panel-default">
                <div class="panel-heading">{{ trans('labels.message')}}  </div>
                Estimados padres/madres y tutores,</br>
                Por la presente y como propietario de esta imagen solicito vuestro consentimiento para la publicación de esta imagen. A continuación se establecen las
                condiciones de publicación y los derechos adquiridos de acuerdo al Reglamento Europeo de Protección de Datos:

                <div><strong>{{trans('labels.responsable')}}: </strong>{{$element->user->name}}</div>
                <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$element->getSharingAsText()}}</div>
                <div><strong>{{trans('labels.legitimacion')}}: </strong>{{trans('labels.legitimacion_text')}}</div>
                <div><strong>{{trans('labels.derechos')}}: </strong>{{trans('labels.derechos_text')}}</div>


                <div class="pull-right" style="margin: 12px">
                    @include("common.controls.btn_other",array('route'=> 'contracts','icon'=>'glyphicon-envelope','var'=>$element,'label'=>'requests','style'=>'btn-danger'))
                </div>
            </div>
        </div>


    </div>
@endsection


@section('scripts')
@parent
@endsection

