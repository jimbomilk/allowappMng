@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4>
                            <i class="{{trans("label.$name.icon")}}"></i> {{ trans('labels.edit')}} {{trans("labels.$name")}}
                        </h4>
                    </div>

                    <div class="panel-body">

                        @include('common.partials.msgErrors')

                        {!! Form::model($element, array('url' => "$name/$element->id", 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                            @include("$name.fields")
                            <div style="float: right">
                            <button type="submit" class="btn btn-primary">{{ trans('labels.update')}}</button>
                            </div>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
