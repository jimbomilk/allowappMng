<div class="panel panel-default" >
    <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
        <strong>Marco regulatorio</strong>
    </div>
    <div class="panel-body small" style="margin: 0px;height:50vh;overflow-y: scroll;overflow-x: hidden">
        Ha recibido este enlaces como responsable de los derechos de imagen de <strong> {{$person_name}} </strong> <br>

        <div class="col-sm-12 informacion-basica" style="text-align: justify"><br>
            <div><strong>{{trans('labels.responsable')}}: </strong><p>{{$photo->getData('accountable')}} con CIF {{$photo->getData('accountable_CIF')}}</p></div>
            <div><strong>{{trans('labels.finalidad')}}: </strong><p>{{trans('label.finalidad_text')}} {{$photo->getSharingAsText()}}</p></div>
            <div><strong>{{trans('labels.legitimacion')}}: </strong>{!!$photo->getData('consent_legitimacion')!!}</div>
            <div><strong>{{trans('labels.destinatario')}}: </strong>{!!$photo->getData('consent_destinatarios')!!}</div>
            <div><strong>{{trans('labels.derechos')}}: </strong>{!!$photo->getData('consent_derechos')!!}</div>
            <div><strong>{{trans('labels.adicional')}}: </strong>{!!$photo->getData('consent_additional')!!}</div>
        </div>
    </div>
</div>