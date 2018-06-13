@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')
<div class="container-fluid spark-screen">
    @include("$name.partials.logs")
    @include("$name.partials.table",['title'=>'Excel de Lugares de publicación','set'=>$sites])
    @include("$name.partials.table",['title'=>'Excel de Personas/Alumnos','set'=>$persons,'buttons'=>'btn_images','button'=>'btn_image'])
    @include("$name.partials.table",['title'=>'Excel de Responsables','set'=>$rightholders])

</div>

@endsection