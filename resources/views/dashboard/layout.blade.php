
@extends('adminlte::layouts.app')

@section('main-content')

    <!-- Content Wrapper. Contains page content -->
        <!-- Content Header (Page header) -->

        @yield('dashboard_header')

        <div>&nbsp;</div>
        <!-- Main content -->

        @yield('dashboard_content')

@endsection