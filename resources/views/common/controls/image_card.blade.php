
<div class="col-sm-3">
    <div class="panel panel-{{$imagen->status['color']}}">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-4">{{$imagen->label}}#{{$imagen->id}}</div>
                <div class="col-xs-8">
                    <span style="float: right">@include("common.controls.btn_delete",array('var'=>$element))</span>

                    <a class="btn-card" ><span data-toggle="tooltip" title="{{trans('labels.explanation.badgepending')}}" class="badge badge-secondary">{{$imagen->pendingRightholders()}}</span></a>


                </div>
            </div>
            <div class="row">
                <div class="col-xs-4" style="font-size: 0.7vw;">{{$imagen->created}}</div>

                <div class="col-xs-offset-3 col-xs-5 ">
                    @include("common.controls.status",['status'=>$imagen->status])
                </div>
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
                    <a href="{{ url("$name/recognition/$imagen->id") }}" data-imagenid="{{$imagen->id}}" class="details btn btn-block btn-social btn-foursquare">
                        <span class="fa fa-eye"></span> {{trans("label.$name.faces")}}
                    </a>
                @endif

                @foreach($imagen->cumulativeSharingRightholders() as $share)
                    @if($share[key($share)])
                    <a  target="_blank" href="{{$imagen->getSharedLink(key($share)) }}" class="btn btn-block btn-social btn-{{key($share)}}  btn-reddit">
                        <span class="fa glyphicon-globe fa-envelope-o fa-{{key($share)}}"></span> Compartir en {{key($share)}}
                       </a>
                    @endif

                @endforeach

                <a href="#" data-imagenid="{{$imagen->id}}" class="details btn btn-block btn-social btn-openid">
                    <span class="fa fa-info-circle"></span> Detalles
                </a>

            </div>
        </div>
    </div>
</div>



