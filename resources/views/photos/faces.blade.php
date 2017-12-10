@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('labels.$name') }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
                <div class="col-md-7 panel panel-default">
                    <div class="panel-heading">{{ trans('labels.recognition')}}: {{$element->name}}</div>


                    @include("common.controls.input_image",array('var'=>$element->photo,'width'=>'full','height'=>'300'))

                    <div class="price-slider">
                        <h4 class="great">Amount</h4>
                        <span>Minimum 10 is required</span>
                        <div class="col-sm-12">
                            <div id="slider"></div>
                        </div>
                    </div>

                </div>
                <div class="col-md-5 panel panel-default">
                    <div class="panel-heading">{{ trans('labels.persons')." ".$element->group->name}} </div>
                    <div class="panel-body" style="padding: 8px">
                        @foreach($element->group->persons as $person)
                            <div style="float: left">
                                @include("common.controls.input_image",array('var'=>$person->photo,'url'=>"addContract/$element->id/$person->id",'width'=>'full','height'=>'80'))
                            </div>
                        @endforeach
                    </div>


                </div>
        </div>
        <div class="row">
            <div class="col-md-12 panel panel-default">
                <div class="panel-heading">{{ trans('labels.face_detected')}} </div>
                <div class="panel-body" style="padding: 8px" >
                    @foreach($contracts as $contract)
                        <div style="float: left">
                        @include("common.controls.input_image",array('var'=>$contract->person->photo,'url'=>"deleteContract/$contract->id",'width'=>'full','height'=>'80'))
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="box-tools pull-right">
            @include("common.controls.btn_other",array('route'=> 'run','icon'=>'glyphicon-eye-open', 'var'=>$element,'label'=>'recognition','style'=>'btn-info'))

            @include("common.controls.btn_other",array('route'=> 'contracts','icon'=>'glyphicon-envelope','var'=>$element,'label'=>'requests','style'=>'btn-danger'))
        </div>
    </div>
@endsection


@section('scripts')
@parent
<script>
    $(document).ready(function() {
        $("#slider").slider({
            animate: true,
            value:1,
            min: 0,
            max: 1000,
            step: 10,
            slide: function(event, ui) {
                update(1,ui.value); //changed
            }
        });


        //Added, set initial value.
        $("#amount").val(0);
        $("#duration").val(0);
        $("#amount-label").text(0);
        $("#duration-label").text(0);

        update();
    });

    function update(slider,val) {
        var $amount = slider == 1?val:$("#amount").val();
        $( "#amount" ).val($amount);
        $( "#amount-label" ).text($amount);
        $('#slider a').html('<label><span class="glyphicon glyphicon-chevron-left"></span> '+$amount+' <span class="glyphicon glyphicon-chevron-right"></span></label>');
    }
</script>
@endsection

