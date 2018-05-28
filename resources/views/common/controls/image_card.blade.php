
<div class="col-sm-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-12">{{$imagen->label}}#{{$imagen->id}}</div>
            </div>
            <div class="row">
                <div class="col-xs-4">{{$imagen->created}}</div>

                <div class="col-xs-offset-3 col-xs-5 " >
                    @include("common.controls.status",['status'=>$imagen->status])                 </div>
            </div>


        </div>
        <div class="card">
            <!--Card content-->
            <div class="card-body" id="front{{$imagen->id}}">
                <!--Card image-->
                <img class="img-responsive" src={{$imagen->url}} alt="imagen">
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
                @if($imagen->getData('status')==10)
                    @include(
                    "common.controls.btn_other",array('route'=> 'recognition','icon'=>'glyphicon-eye-open','var'=>$element,'label'=>'faces','style'=>'btn-danger'))
                @endif
                @if($imagen->getData('status')==200)
                    @include("common.controls.btn_other",array('route'=> 'sharing','icon'=>'glyphicon-share','var'=>$element,'label'=>'sharing','style'=>'btn-danger'))
                @endif
                <a href="#" data-imagenid="{{$imagen->id}}" style="margin-left: 5px" class="details btn-sm btn-primary">Detalles</a>
            </div>
        </div>
    </div>
</div>



