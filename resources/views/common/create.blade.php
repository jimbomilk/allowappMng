@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection


@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-11">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('label.create_new')}} {{ trans('label.'.$name)}} </div>

                    <div class="panel-body">

                        @include('common.partials.msgErrors')


                        {!! Form::open(array('url' => "$name", 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                            @include("$name.fields")
                            <button type="submit" class="btn btn-default">{{ trans('labels.create')}} {{ trans('label.'.$name)}} </button>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
