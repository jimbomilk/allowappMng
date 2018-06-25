@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">

                <!-- Default box -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                        <div class="col-md-4">
                            <h4>
                                <i class="{{trans("label.$name.fa_icon")}}"></i> {{trans("label.title.$name")}}
                            </h4>
                        </div>
                            <div class="col-md-8" style="text-align:right">

                            @include ("common.filters")


                            @if (isset($searchable))
                                {!! Form::model(Request::all(), array('url' => str_replace(".","/",$name), 'method' => 'GET', 'enctype' => 'multipart/form-data')) !!}
                                <div  class="col-md-6" style="text-align:right">
                                    {!! Form::text('search', null, ['class' => 'form-control', 'placeholder'=>trans("labels.search.$name")]) !!}

                                </div>
                                <div  class="col-md-2" >
                                    <button type="submit" class="btn btn-default">{{trans('labels.search')}}</button>
                                </div>
                                {!! Form::close() !!}
                            @endif

                            @if(!isset($hide_new) || !$hide_new)

                                @if(View::exists("$name.buttons"))
                                    @include("$name.buttons")
                                @endif

                                <a class="btn btn-info" href="{{ url("$name/create") }}" role="button">
                                    <span>
                                        <i class="glyphicon glyphicon-plus-sign"></i>
                                        {{trans('labels.new')}} {{trans('label.'.$name)}}
                                    </span>
                                </a>
                            @endif
                            </div>



                        </div>
                    </div>
                    <div class="panel-body">


                        @include("$name.table")

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
        </div>
    </div>

@endsection


