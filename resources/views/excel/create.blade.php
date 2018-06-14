@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')

<div class="container-fluid spark-screen">
    <h2 class="text-center">
        Importación de Datos Allowapp - Excel
    </h2>

    @if ( Session::has('success') )
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('success') }}</strong>
        </div>
    @endif

    @if ( Session::has('error') )
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <strong>{{ Session::get('error') }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            <div>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif
    <br>
    <div class="row">
        <div class="col-md-offset-2 col-md-8" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    <h4> Elige el fichero que desees importar (xls/csv) : </h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(array('url' => "locations/excel/import", 'method' => 'POST', 'enctype' => 'multipart/form-data')) !!}
                        {{  Form::hidden('url',URL::previous())  }}
                        {{ csrf_field() }}

                        <div class=" col-sm-8" >
                            <input type="file" name="file" class="form-control">


                        </div>

                      <div class=" col-sm-2" >
                        <input value="Importar" type="submit" class="form-control btn btn-primary">
                        </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection