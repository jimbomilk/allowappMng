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
                        <div class="col-xs-4"></div>
                    </strong>

                    <div id = "panel-group" class="detected panel-body"  style="padding: 8px">

                        @foreach($rhs as $rh)
                            <div class="col-xs-4">{{$rh->name}}</div>
                            <div class="col-xs-4">{{$rh->rhname}}</div>
                            <div class="col-xs-4"><a target="_blank"  href="{{$rh->link}}">{{trans("label.$name.link")}}</a></div>
                        @endforeach
                    </div>
                @else
                    <div> <p> {{trans('labels.no-rightholders')}}</p></div>
                @endif

            </div>

            <div  class="col-md-6 panel panel-default">
                <div class="panel-heading">{{ trans('labels.message')}}  </div>

                {!! Form::open(array('url' => 'photos/emails', 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                {!! Form::hidden('photoId', $element->id) !!}

                @include("common.controls.input_textarea",array('var'=>'email','value'=>$template))


                <div><strong>{{trans('labels.responsable')}}: </strong>{{$element->user->name}}</div>
                <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$element->getSharingAsText()}}</div>
                <div><strong>{{trans('labels.legitimacion')}}: </strong>{{trans('labels.legitimacion_text')}}</div>
                <div><strong>{{trans('labels.derechos')}}: </strong>{{trans('labels.derechos_text')}}</div>

                <p style="text-align: center;margin: 12px">
                    <button type="submit" class="btn btn-primary">{{ trans("label.$name.request")}} </button>
                </p>

                {!! Form::close() !!}

            </div>
        </div>


    </div>
@endsection


@section('scripts')
@parent
@endsection

