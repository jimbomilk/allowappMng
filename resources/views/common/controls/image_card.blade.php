
<div class="col-sm-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-4">{{$imagen->created}}</div>
                <div class="col-xs-5">{{$imagen->label}}#{{$imagen->id}}</div>
                <div class="col-xs-2"> <span class="label {{$imagen->statuscolor}}">{{$imagen->statustext}}</span> </div>
            </div>


        </div>
        <div class="card">
            <!--Card content-->
            <div class="card-body" id="front{{$imagen->id}}">
                <!--Card image-->
                <img class="img-responsive" src={{$imagen->getData('src')}} alt="imagen">
                <div><strong>{{trans('labels.responsable')}}: </strong>{{$imagen->user->name}}</div>
                <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$imagen->getSharingAsText()}}</div>
                <div><strong>{{trans('labels.legitimacion')}}: </strong>{{trans('labels.legitimacion_text')}}</div>
                <div><strong>{{trans('labels.destinatario')}}: </strong>{{trans('labels.destinatario_text')}}</div>
                <div><strong>{{trans('labels.derechos')}}: </strong>{{trans('labels.derechos_text')}}</div>
            </div>

            <div class="card-body" id="back{{$imagen->id}}" style="display: none">
                <div><strong>{{trans('labels.responsable')}}: </strong>{{$imagen->user->name}}</div>
                <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$imagen->getSharingAsText()}}</div>
                <div><strong>{{trans('labels.legitimacion')}}: </strong>{{trans('labels.legitimacion_text')}}</div>
                <div><strong>{{trans('labels.destinatario')}}: </strong>{{trans('labels.destinatario_text')}}</div>
                <div><strong>{{trans('labels.derechos')}}: </strong>{{trans('labels.derechos_text')}}</div>
            </div>

            <div class="text-right"  style="margin: 8px">
                @include("common.controls.btn_other",array('route'=> 'recognition','icon'=>'glyphicon-eye-open','var'=>$element,'label'=>'faces','style'=>'btn-danger'))
                <a href="#" id="details{{$imagen->id}}" style="margin-left: 5px" class="btn-sm btn-primary">Detalles</a>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $("#details{{$imagen->id}}").click(function () {
            $("#back{{$imagen->id}}").toggle("slow");
            $("#front{{$imagen->id}}").toggle("slow");
            $('html, body').animate({
                scrollTop: $("#details{{$imagen->id}}").offset().top-600
            }, 1000);

        });
    })

</script>