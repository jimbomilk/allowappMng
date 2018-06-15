@extends('dashboard.layout')

@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class="fa {{trans('design.main')}}"></i>
            {{trans('labels.dashboard')}}

        </h1>

    </section>
@endsection

@section('dashboard_content')
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

@endsection
