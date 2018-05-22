@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-7 panel panel-default">
                <div class="row">
                    <div class="col-xs-6"><span style="padding-top: 15px">{{$element->label}}#{{$element->id}}</span></div>
                    <div class="col-xs-6"> <span style="margin: 10px" class="label {{$element->statuscolor}} pull-right">{{$element->statustext}}</span> </div>
                </div>

                  <img class="img-responsive" src={{$element->getData('src')}}>
                <div class="pull-right" style="margin: 12px">
                @include("common.controls.btn_other",array('route'=> 'run','icon'=>'glyphicon-eye-open', 'var'=>$element,'label'=>'recognition','style'=>'btn-info'))
                </div>
            </div>
            <div class="col-md-5 panel panel-default">
                <div class="panel-heading">{{ trans('labels.group')}}</div>
                @if($element->group )
                    <div class="panel-heading">{{ trans('labels.persons')." ".$element->group->name}} </div>
                    <div class="panel-body" style="padding: 8px">
                        @foreach($element->group->persons as $person)
                            <div style="float: left">
                                <div class="person" data-personid="{{$person->id}}" data-imagenid="{{$element->id}}" style="margin: 2px">
                                    <img width="60px" height="60px" src="{{$person->photo}}">
                                    <div>{{$person->name}}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div> <p> La foto no está asociada a ningún grupo</p></div>
                @endif

            </div>
        </div>
        <div  class="row">
            <div class="col-md-12 panel panel-default">
                <div class="panel-heading">{{ trans('labels.face_detected')}} </div>
                <div id="detected" class="panel-body" style="padding: 8px" >
                    @foreach($element->people as $person)
                        <div style="float: left">
                        @include("common.controls.input_image",array('var'=>$person->photo,'url'=>"deleteContract/$person->id",'width'=>'full','height'=>'80'))
                        </div>
                    @endforeach
                </div>
                <div class="pull-right" style="margin: 12px">
                @include("common.controls.btn_other",array('route'=> 'contracts','icon'=>'glyphicon-envelope','var'=>$element,'label'=>'requests','style'=>'btn-danger'))
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
@parent
<script>
    $(document).ready(function() {

        $(".person").click(function () {
            imagenId = $(this).data("imagenid");
            personId = $(this).data("personid");
            var form = $(this);
            var detected = $("#detected");
            $.ajax({
                type: "GET",
                url: '/addContract/'+imagenId+'/'+personId,
                data: "",
                success: function (res) {
                    $(form).fadeOut(800, function(){
                        $("#detected").load(location.href + " #detected");

                    });
                    console.log("añadido con exito:"+res);
                },
                error: function () {
                    console.log("error al añadir persona");
                }
            })
        })
    })
</script>
@endsection

