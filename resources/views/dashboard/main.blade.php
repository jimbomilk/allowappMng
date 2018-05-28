@extends('dashboard.layout')

@section ('dashboard_header')
    <section class="content-header">
        <h1>
            <i class="fa {{trans('design.main')}}"></i>
            {{trans('labels.dashboard')}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="admin"><i class="fa fa-dashboard"></i> {{trans('labels.home')}}</a></li>
            <li class="active">{{trans('labels.main')}}</li>
        </ol>
    </section>
@endsection

@section('dashboard_content')
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @include ('dashboard.partials.boxes')


    </div><!-- /.row -->
    <div class="row">
        @include ('dashboard.partials.links')
    </div>

@endsection
