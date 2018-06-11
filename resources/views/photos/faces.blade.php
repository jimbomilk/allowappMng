@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div id='loader' style='display: none;'>
            <img src="{{asset('img/loading.gif')}}" width='100px' height='100px'>
        </div>

        <div class="row">
            <div class="col-md-12 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6"><span style="padding-top: 15px">{{$element->label}}#{{$element->id}}</span></div>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-3"  >

                            <img id="foto" class="img-responsive" src={{$element->urlFinal}}>

                            @foreach(json_decode($element->faces) as $face)
                                <div class="facebox" id="{{$face->Face->FaceId}}" style="background:rgba(0,0,0,0.2); position: absolute;border: solid 3px red"
                                     data-width="{{$face->FaceDetail->BoundingBox->Width}}"
                                     data-height="{{$face->FaceDetail->BoundingBox->Height}}"
                                     data-top="{{$face->FaceDetail->BoundingBox->Top}}"
                                     data-left="{{$face->FaceDetail->BoundingBox->Left}}">
                                </div>
                            @endforeach


                            <div style="margin-top: 22px;">
                            @include('adminlte::layouts.partials.modal_wait',['text'=>"Realizando análisis facial, por favor espere..."])

                                <a href="#" class="facial_recognition btn btn-warning center-block" data-action="run" data-photoid="{{$element->id}}" data-toggle="modal" data-target="#modal">
                                    <span> <i class="glyphicon glyphicon-eye-open"></i> {{trans("label.$name.recognition")}}</span>
                                </a>

                            </div>
                        </div>


                        <div class=" col-sm-5  panel panel-default">

                            @if($element->group )
                                <div class="panel-heading">{{ trans('labels.persons')." ".$element->group->name}} - Pulse en las personas para añadirlas a la fotografía</div>
                                <div id = "panel-group" class="detected panel-body"  style="padding: 8px">

                                    @foreach($element->group->persons as $person)
                                        @if(!in_array($person->id,$element->assigned))
                                            <a href="#" class="faces-person" data-action="add" data-personid="{{$person->id}}" data-imagenid="{{$element->id}}" data-faceid="{{$person->faceId}}" style="margin: 2px;float: left">
                                                <img width="60px" height="60px" src="{{$person->photo}}">
                                                <div style="text-align: center"><small>{{$person->name}} </small>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <div> <p> La foto no está asociada a ningún grupo</p></div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div  class="row">
            <div  class="col-md-12 panel panel-default">
                <div class="panel-heading">{{ trans('labels.face_detected')}} - Para eliminar una persona de la imagen, pulse sobre ella  </div>
                <div id="panel-detected" class="detected panel-body" style="padding: 8px" >
                    @foreach($element->people as $person)
                        <a href="#" class="faces-person" data-action="remove" data-personid="{{$person->id}}" data-imagenid="{{$element->id}}" data-photoface="{{isset($person->face)?$person->face->facePhotoId:""}}" style="margin: 2px;float: left">
                            <img width="60px" height="60px" src="{{\App\Person::find($person->id)->photo}}">
                            <div>{{\App\Person::find($person->id)->name}}</div>
                        </a>
                    @endforeach
                </div>
                <div class="pull-right" style="margin: 12px">
                @include("common.controls.btn_other",array('route'=> 'send','icon'=>'glyphicon-envelope','var'=>$element,'label'=>'requests','style'=>'btn-danger'))
                </div>
            </div>
        </div>

    </div>
@endsection


@section('scripts')
@parent
<script>

    function photoBoxes(){
        var img = document.getElementById('foto');
        var width = img.clientWidth;
        var height = img.clientHeight;

        $(".facebox").each( function (){
            var w=this.dataset.width*width +10;
            var h=this.dataset.height*height+10;
            var t=this.dataset.top*height-5;
            var l=this.dataset.left*width+10;
            this.style.width = w+'px';
            this.style.height = h+'px';
            this.style.top = t+'px';
            this.style.left = l+'px';
            this.style.color = "blue";
            this.style.border= "3px solid red";
            $(this).removeClass('blink');

            _this = this;
            $("a[data-photoface="+this.id+"]").each( function (){
                _this.style.border= "3px solid green";
            });

        });

    }

    $( window ).on("load resize", function(){
        // Change the width of the div
        photoBoxes();
    });

    $(".facebox,#panel-detected .faces-person,#panel-group .faces-person").on('click',function (e){

        if ($(this).is(".facebox")) {
            $(".facebox").each(function () {
                $(this).removeClass('blink');
            });
        }

        if ($(this).is("#panel-detected .faces-person")) {
            $("#panel-detected .faces-person").each(function () {
                $(this).removeClass('blink');
            });
        }

        if ($(this).is("#panel-group .faces-person")) {
            $("#panel-group .faces-person").each(function () {
                $(this).removeClass('blink');
            });
        }

        $(this).addClass('blink');
    });

    $(".facial_recognition").on('click',function (e){
        var photoid = $(".facial_recognition").data('photoid');
        var action = $(".facial_recognition").data('action');
        var update = action=='run'?'#panel-detected':'#panel-group';
        $("#loader").show();
        $.ajax({
            type: "GET",
            url: action+'/'+photoid,
            data: "",
            success: function (res) {
                $("#loader").hide();
                location.reload();
                $('#modal').hide();
                $('#modal').modal('hide');

                //console.log("exito:"+res);
            },
            error: function (e) {
                $("#loader").hide();
                console.log("error:"+e);
                $('#modal').hide();
                $('#modal').modal('hide');
            }
        })
    });

    $(".detected,.facebox").on('click',function (e) {
        var imagenId = $('.faces-person.blink').data('imagenid');
        var personId = $('.faces-person.blink').data('personid');
        var action = $('.faces-person.blink').data('action');
        var faceId = $('.faces-person.blink').data('faceid');

        var faceBlinking = $('.facebox.blink').attr('id');
        var boxFaceBlinkingHeight = $('.facebox.blink').data('height');
        var boxFaceBlinkingWidth = $('.facebox.blink').data('width');
        var boxFaceBlinkingTop = $('.facebox.blink').data('top');
        var boxFaceBlinkingLeft = $('.facebox.blink').data('left');

        //Si estamos añadiendo y no se han seleccionado una cara y una persona...nos vamos
        if ((typeof action === 'undefined' || action == 'add') && (typeof imagenId === "undefined" || typeof faceBlinking === "undefined"))
            return;

        var update = action == 'add' ? '#panel-detected' : '#panel-group';
        verb = ( action == 'add') ? 'addContract' : 'deleteContract';
        $("#loader").show();
        $.post(verb, {
            "_token": "{{ csrf_token() }}",
            'imagenId': imagenId,
            'personId': personId,
            'faceId': faceId,
            'photoFace': faceBlinking,
            'boxHeight': boxFaceBlinkingHeight,
            'boxWidth': boxFaceBlinkingWidth,
            'boxTop': boxFaceBlinkingTop,
            'boxLeft': boxFaceBlinkingLeft
        })
                .done(function () {

                    location.reload();

                })
                .always( function() {
                    $("#loader").hide();
                });



    });

</script>
@endsection

