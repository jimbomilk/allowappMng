@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection


@section('main-content')
<div class="container">

    <div class="row" >

        <div class="col-md-5 legal" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Datos de registro <div style="float: right;color: darkgrey"> {{$element->created}}</div>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6">
                        <img class="img-responsive" src={{$element->photo}} alt="imagen">
                    </div>
                    <div class="col-sm-6">
                    #Id: {{$element->id}}<br>
                    #Nombre : {{$element->name}}<br>
                    #Curso : {{$element->group->name}}<br>
                    #Padres y tutores: <br>
                    @foreach($element->rightholders as $rh)
                        &emsp;{{$rh->relation}}:{{$rh->name}}<br>
                    @endforeach

                    </div>

                </div>
            </div>


            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    Fotografías en las que aparece: {{count($element->photos)}}
                </div>
                <div class="panel-body">
                    @foreach($element->photos as $photo)
                    <div class="row">
                        <div class="col-sm-6">
                            <img class="img-responsive" src={{$photo->url}} alt="imagen">
                        </div>
                        <div class="col-sm-6">
                            <strong>#Id:</strong> {{$photo->id}}<br>
                            <strong>#Fecha :</strong> {{$photo->created}}<br>
                            <strong>#Nombre :</strong> {{$photo->label}}<br>
                            <strong>#Añadida por :</strong> {{$photo->user->name}}<br>
                            <strong></strong>

                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
