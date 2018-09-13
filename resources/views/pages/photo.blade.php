@extends('layouts.default')
@section('content')


    <div class="row" >

        <div class="col-md-5 legal" >
            <div class="panel panel-default" >
                <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                    <strong>Marco regulatorio</strong>
                </div>
                <div class="panel-body small" style="margin: 0px;height:50vh;overflow-y: scroll;overflow-x: hidden">
                    Ha recibido este enlaces como responsable de los derechos de imagen de <strong> {{$person_name}} </strong> <br>

                    <div class="col-sm-12" style="text-align: justify"><br>
                        <div><strong>{{trans('labels.responsable')}}: </strong>{{$photo->getData('accountable')}} con CIF {{$photo->getData('accountable_CIF')}}</div><br>
                        <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('label.finalidad_text')}} {{$photo->getSharingAsText()}}</div><br>
                        <strong>{{trans('labels.legitimacion')}}: </strong>{!!$photo->getData('consent_legitimacion')!!}
                        <strong>{{trans('labels.destinatario')}}: </strong>{!!$photo->getData('consent_destinatarios')!!}
                        <strong>{{trans('labels.derechos')}}: </strong>{!!$photo->getData('consent_derechos')!!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">

            {!! Form::open(['route'=> 'photo.link.response']) !!}

            @include("common.controls.input_hidden",['var'=>'token','val'=>$token])
            @include("common.controls.input_hidden",['var'=>'photo','val'=>$photo->id])
            @include("common.controls.input_hidden",['var'=>'user_id','val'=>$user_id])
            @include("common.controls.input_hidden",['var'=>'person_id','val'=>$person_id])
            @include("common.controls.input_hidden",['var'=>'rightholder_id','val'=>$rightholder_id])

            <div class="panel col-md-12">
                <div  class="row" style="margin-top: 10px">
                    <div class="col-sm-5">
                        <img class="img-responsive center" src="{{$url}}">
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
                    <div class="col-sm-offset-2 col-sm-10">
                        <p>{{ trans('label.persons.label_enviar')}}</p>
                    </div>
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