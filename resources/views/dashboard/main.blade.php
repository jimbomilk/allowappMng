@extends('dashboard.layout')

@section('dashboard_content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12 nopadding-mobile">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3>
                        <i class="fa {{trans('design.main')}}"></i>
                        {{trans('labels.dashboard')}}
                        </h3>
                    </div>
                    <div class="panel-body">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            @include ('dashboard.partials.boxes')
                        </div><!-- /.row -->

                        <div class="row">
                            <div class="col-sm-12">
                            @include ('dashboard.partials.graphs')
                            </div>

                        </div>

                        <div class="row" >
                            @include ('dashboard.partials.links')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
