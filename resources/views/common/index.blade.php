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
                        <div class="col-md-6"><h4>{{trans("labels.$name")}}</h4></div>
                        @if(!isset($hide_new) || !$hide_new)
                            <div class="col-md-6" style="text-align:right">
                                @if(View::exists("$name.buttons"))
                                    @include("$name.buttons")
                                @endif

                                <a class="btn btn-info" href="{{ url("$name/create") }}" role="button">
                                    {{trans('labels.new')}} {{trans('label.'.$name)}}
                                </a>

                            </div>
                        @endif


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


