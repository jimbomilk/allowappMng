@extends('layouts.default')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 style="text-align: center;color: white">
                    Se ha producido un error. El dni proporcionado no coincide con los datos almacenados.
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="text-align: center">
                <h2><a href="{{ $link }}">Volver</a></h2>

            </div>
        </div>
    </div>

@stop