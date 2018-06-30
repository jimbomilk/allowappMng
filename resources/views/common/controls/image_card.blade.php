
<div class="col-sm-4 photo group{{$imagen->group->id}} consent{{$imagen->consent->id}}">
    <div class="panel panel-{{$imagen->status['color']}}">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <span class="label label-primary" >{{$element->group->name}}&nbsp;</span><br>
                    {{$imagen->label}}#{{$imagen->id}}<br>
                    {{$imagen->consent->description}} : <span>{{$imagen->pendingRightholders()}}</span>

                </div>
                <div class="col-xs-6 text-right">
                    <div >{{$imagen->created}}</div>
                    <div style="margin-right: -14px">
                        @include("common.controls.btn_edit",array('var'=>$element))
                        @include("common.controls.btn_delete",array('var'=>$element,'small'=>true))
                    </div>


                </div>
            </div>



        </div>
        <div class="card">
            <!--Card content-->
            <div class="card-body" id="front{{$imagen->id}}" >
                <!--Card image-->
                <div class="row">
                    <div class="col-sm-offset-1 col-sm-10">
                        <img class="img-responsive center-block" src={{$imagen->url}} alt="imagen">
                    </div>
                </div>

            </div>

            <div class="card-body" id="back{{$imagen->id}}" style="display: none;margin: 0px;height:40vh;overflow-y: scroll;overflow-x: hidden">
                <div class="row">
                    <div class="col-xs-12"><h4>Información básica:</h4></div>
                    <div class="col-sm-12 small" style="text-align: justify"><br>
                        <p><strong>{{trans('labels.responsable')}}: </strong>{{$imagen->getData('accountable')}}</p>
                        <p><strong>{{trans('labels.finalidad')}}: </strong>{{trans('labels.finalidad_text')}} {{$imagen->getSharingAsText()}}</p>
                        <p><strong>{{trans('labels.legitimacion')}}: </strong>{!!$imagen->getData('consent_legitimacion')!!}</p>
                        <p><strong>{{trans('labels.destinatario')}}: </strong>{!!$imagen->getData('consent_destinatarios')!!}</p>
                        <p><strong>{{trans('labels.derechos')}}: </strong>{!!$imagen->getData('consent_derechos')!!}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12"><h4>Acciones realizadas:</h4></div>
                    <div class="col-xs-12"><small><strong>{{$imagen->created}}</strong> - Creación de la imagen</small></div>
                </div>
                @foreach($imagen->getHistoric() as $action)
                    <div class="row">
                    <div class="col-xs-12"><small><strong>{{$action->created}}</strong> - {{$action->log}}</small></div>
                    </div>
                @endforeach

            </div>

            <div class="text-right"  style="margin: 8px">
                @if($imagen->getData('status')==10)
                    <a href="{{ url("$name/recognition/$imagen->id") }}" data-imagenid="{{$imagen->id}}" class="details btn btn-block btn-social btn-foursquare">
                        <span class="fa fa-eye"></span> {{trans("label.$name.faces")}}
                    </a>
                @else
                    <a href="{{ url("$name/recognition/$imagen->id") }}" data-imagenid="{{$imagen->id}}" class="details btn btn-block btn-social btn-foursquare">
                        <span class="fa fa-eye"></span> Enviar recordatorio
                    </a>
                @endif

                @if($imagen->getData('status')>10)
                    @foreach($imagen->getData('sharing') as $share)

                        <a  target="_blank" href="{{url("$name/share/$imagen->id/$share->name") }}" class="btn btn-block btn-social btn-{{$share->name}}  btn-reddit">
                            <span class="fa glyphicon-globe fa-envelope-o fa-{{$share->name}}"></span> Compartir en {{$share->name}}
                       </a>


                    @endforeach
                @endif

                <a href="#" data-imagenid="{{$imagen->id}}" class="details btn btn-block btn-social btn-openid">
                    <span class="fa fa-info-circle"></span> Información adicional
                </a>

            </div>
        </div>
    </div>
</div>



