@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection


@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12 nopadding-mobile">

                <!-- Default box -->
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-sm-3 col-xs-12">
                                <span style="font-size: 1.5em">
                                    <i class="{{trans("label.$name.fa_icon")}}"></i> {!!trans("label.title.$name")!!}
                                </span>
                            </div>
                            <div class="col-sm-9 col-xs-12 pull-right text-right">
                                @if(!isset($hide_new) || !$hide_new)
                                    @include ("common.buttons")
                                @endif

                                @if (isset($searchable))
                                    <div class="col-sm-4 col-xs-5 no-padding">
                                        @include ("common.searcher")
                                    </div>
                                @endif

                                <div class="col-sm-4 col-xs-5 no-padding">
                                    @includeIf("$name.filters")
                                </div>
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


