<div class="panel panel-default" >
    <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
        <strong>Marco regulatorio</strong>
    </div>
    <div class="panel-body small" style="margin: 0px;height:50vh;overflow-y: scroll;overflow-x: hidden">
        Ha recibido este enlaces como responsable de los derechos de imagen de <strong> {{$person_name}} </strong> <br>

        <div class="col-sm-12 informacion-basica" style="text-align: justify"><br>
            <div><strong>{{trans('labels.responsable')}}: </strong>{{$photo->getData('accountable')}} con CIF {{$photo->getData('accountable_CIF')}}</div><br>
            <div><strong>{{trans('labels.finalidad')}}: </strong>{{trans('label.finalidad_text')}} {{$photo->getSharingAsText()}}</div><br>
            <strong>{{trans('labels.legitimacion')}}: </strong>{!!$photo->getData('consent_legitimacion')!!}
            <strong>{{trans('labels.destinatario')}}: </strong>{!!$photo->getData('consent_destinatarios')!!}
            <strong>{{trans('labels.derechos')}}: </strong>{!!$photo->getData('consent_derechos')!!}
        </div>
    </div>
</div>