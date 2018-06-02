@extends('layouts.default')
@section('content')


    <div class="row" >

        <div class="col-md-5 legal" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    <strong>Marco regulatorio</strong>
                </div>
                <div class="panel-body">
                    <p>Ha recibido este enlaces como responsable de los derechos de imagen de {{$person_name}}.</p>
                    <p>Se solicita su consentimiento para compartir imágenes en las
                        bla bla bla</p>

                </div>
            </div>
        </div>
        <div class="col-md-7">

            {!! Form::open(['route'=> 'photo.link.response']) !!}

            @include("common.controls.input_hidden",['var'=>'token','val'=>$token])
            @include("common.controls.input_hidden",['var'=>'photo','val'=>$photo->id])
            @include("common.controls.input_hidden",['var'=>'owner','val'=>$owner])
            @include("common.controls.input_hidden",['var'=>'name','val'=>$person_name])
            @include("common.controls.input_hidden",['var'=>'phone','val'=>$person_phone])
            @include("common.controls.input_hidden",['var'=>'rhname','val'=>$rhname])
            @include("common.controls.input_hidden",['var'=>'rhphone','val'=>$rhphone])

            <div class="panel col-md-12">
                <div  class="row" style="margin-top: 10px">
                    <div class="col-sm-5">
                        <img class="img-responsive center" src="{{$photo->url}}">
                    </div>


                    <div class="col-sm-7">
                    @foreach( $sh as $share)

                        <div class="row" style="font-size:12px; padding-left:10px;margin-top:10px;color: #000000">
                            <div class="col-sm-5">
                                <strong>Compartir en {{$share->name}} :</strong>
                            </div>
                            <div class="col-sm-3">
                                {!! Form::radio($share->name, '1') !!} Consiente
                            </div>
                            <div class="col-sm-4">
                                {!! Form::radio($share->name, '0') !!} No consiente
                            </div>
                        </div>

                    @endforeach
                    </div>

                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col-sm-offset-2 col-sm-7" style="padding: 0">
                        @include("common.controls.input_text_nolabel",['var'=>'dni','class'=>'social'])
                    </div>
                    <div class="col-sm-2" style="padding: 0">
                        <button type="submit" class="btn btn-default" style="display: inline;background-color: rgb(246,216,88);color: #000000">{{ trans('labels.send')}}</button>
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>



@stop