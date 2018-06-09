@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-5 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6"><span style="padding-top: 15px">{{$element->label}}#{{$element->id}}</span></div>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-11"  >

                        <img id="foto" class="img-responsive" src={{$element->urlFinal}}>

                        @foreach(json_decode($element->faces) as $face)

                            <div class="face" style="background:rgba(0,0,0,0.8); position: absolute;border: solid 3px red"
                                 data-width="{{$face->FaceDetail->BoundingBox->Width}}"
                                 data-height="{{$face->FaceDetail->BoundingBox->Height}}"
                                 data-top="{{$face->FaceDetail->BoundingBox->Top}}"
                                 data-left="{{$face->FaceDetail->BoundingBox->Left}}">

                            </div>
                        @endforeach


                        <div style="margin-top: 22px;text-align: center">
                        @include('adminlte::layouts.partials.modal_wait',['text'=>"Realizando análisis facial, por favor espere..."])

                            <a href="#" class="facial_recognition btn btn-warning" data-action="run" data-photoid="{{$element->id}}" data-toggle="modal" data-target="#modal">
                                <span> <i class="glyphicon glyphicon-eye-open"></i> {{trans("label.$name.recognition")}}</span>
                            </a>

                        </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class=" col-md-7 panel panel-default">

                @if($element->group )
                    <div class="panel-heading">{{ trans('labels.persons')." ".$element->group->name}} - Pulse en las personas para añadirlas a la fotografía</div>
                    <div id = "panel-group" class="detected panel-body"  style="padding: 8px">

                        @foreach($element->group->persons as $person)
                            @if(!in_array($person->id,$element->assigned))
                            <a href="#" class="faces-person" data-action="add" data-personid="{{$person->id}}" data-imagenid="{{$element->id}}" style="margin: 2px;float: left">
                                <img width="60px" height="60px" src="{{$person->photo}}">
                                <div>{{$person->name}} </div>
                            </a>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div> <p> La foto no está asociada a ningún grupo</p></div>
                @endif

            </div>
        </div>
        <div  class="row">
            <div  class="col-md-12 panel panel-default">
                <div class="panel-heading">{{ trans('labels.face_detected')}} - Para eliminar una persona de la imagen, pulse sobre ella  </div>
                <div id="panel-detected" class="detected panel-body" style="padding: 8px" >
                    @foreach($element->people as $person)
                        <a href="#" class="faces-person" data-action="remove" data-personid="{{$person->id}}" data-imagenid="{{$element->id}}" style="margin: 2px;float: left">
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

    $('.face').on("change", function(e) {
        var width = e.target.parentElement.dataset.width;
        alert('face w:',width);
    });

    $( window ).on("load resize", function(){
        // Change the width of the div
        var img = document.getElementById('foto');
        var width = img.clientWidth;
        var height = img.clientHeight;

        $(".face").each( function (){
            var w=this.dataset.width*width +10;
            var h=this.dataset.height*height;
            var t=this.dataset.top*height;
            var l=this.dataset.left*width+10;
            this.style.width = w+'px';
            this.style.height = h+'px';
            this.style.top = t+'px';
            this.style.left = l+'px';
            this.style.color = "blue";
        });

    });

    $(".facial_recognition").on('click',function (e){
        var photoid = e.target.parentElement.dataset.photoid;
        var action = e.target.parentElement.dataset.action;
        var update = action=='run'?'#panel-detected':'#panel-group';
        $.ajax({
            type: "GET",
            url: action+'/'+photoid,
            data: "",
            success: function (res) {
                $('#panel-detected').load(window.location.href + " "+ '#panel-detected');
                $('#panel-group').load(window.location.href + " "+ '#panel-group');
                $('#modal').hide();
                $('#modal').modal('hide');



                console.log("exito:"+res);
            },
            error: function () {
                console.log("error");
            }
        })
    });

    $(".detected").on('click',function (e) {
        console.log(e);
        var imagenId = e.target.parentElement.dataset.imagenid;
        var personId = e.target.parentElement.dataset.personid;
        var action = e.target.parentElement.dataset.action;
        var update = action=='add'?'#panel-detected':'#panel-group';
        verb = ( action == 'add')?'addContract':'deleteContract';
        $.ajax({
            type: "GET",
            url: '/'+verb+'/'+imagenId+'/'+personId,
            data: "",
            success: function (res) {
                $(e.target.parentElement).fadeOut(600, function(){
                    $(update).load(window.location.href + " "+ update);

                });

                $('html, body').animate({
                    scrollTop: $(e.target.parentElement).offset().top-200
                }, 1000);



                console.log("exito:"+res);
            },
            error: function () {
                console.log("error");
            }
        })
    });

</script>
@endsection

