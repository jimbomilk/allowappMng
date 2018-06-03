@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
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
                            <h4>A:</h4>
                        </div>
                    </div>
                    @if(isset($element))
                        <div class="col-md-6" style="border-bottom: solid 1px black;float:left;height: 50px;padding-top: 10px">
                            <div data-id="{{$element->id}}" style="white-space: nowrap">
                                {{$element->name}}
                            </div>

                        </div>
                    @else
                        @foreach($set as $rh)
                        <div class="col-md-6" style="border-bottom: solid 1px black;float:left;height: 50px;padding-top: 6px">
                            <div data-id="{{$rh->id}}" style="white-space: nowrap">
                                <strong>{{$rh->name}}</strong><br><small>({{$rh->email}})</small>
                            </div>

                        </div>
                        @endforeach
                    @endif

                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12">
                        <h4>Mensaje:</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">

                                {!! Form::open(array('url' => "$name/emails", 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                                {!! Form::hidden('rightholderId', isset($element)?$element->id:'all') !!}

                                @include("common.controls.input_textarea",array('var'=>'email','value'=>$template))

                                <p style="text-align: center;margin: 12px">
                                    <button type="submit" class="btn btn-primary">{{ trans("label.$name.request")}} </button>
                                </p>
                                {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
@parent
@endsection