@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('labels.edit')}} {{trans("label.$name")}}</div>

                    <div class="panel-body">

                        @include('common.partials.msgErrors')

                        {!! Form::model($element, array('url' => "$name/$element->id", 'method' => 'PUT', 'enctype' => 'multipart/form-data')) !!}
                            @include("$name.fields")
                            <button type="submit" class="btn btn-default">{{ trans('labels.update')}}</button>
                        {!! Form::close() !!}


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
