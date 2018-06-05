@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-6 panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6"><span style="padding-top: 15px">{{$element->label}}#{{$element->id}}</span></div>
                        <div class="col-xs-6"> @include("common.controls.status",['status'=>$element->status]) </div>

                    </div>
                </div>
                <div class="panel-body">
                    <img  class="img-responsive" src={{$element->url}}>
                    <div class="pull-right" style="margin: 12px">
                    @include("common.controls.btn_other",array('route'=> 'run','icon'=>'glyphicon-eye-open', 'var'=>$element,'label'=>'recognition','style'=>'btn-info'))
                    </div>
                </div>
            </div>
            <div class=" col-md-6 panel panel-default">
                <div class="panel-heading">{{ trans('labels.group')}}</div>
                @if($element->group )
                    <div class="panel-heading">{{ trans('labels.persons')." ".$element->group->name}} </div>
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
                <div class="panel-heading">{{ trans('labels.face_detected')}}  </div>
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

