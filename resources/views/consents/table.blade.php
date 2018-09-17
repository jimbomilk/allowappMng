<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans('label.consents.description')}}</th>
        <th>{{trans('label.consents.legitimacion')}}</th>
        <th>{{trans('label.consents.destinatarios')}}</th>
        <th>{{trans('label.consents.derechos')}}</th>
        <th>{{trans('label.consents.additional')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td><strong>{{$element->description}}</strong></td>
            <td>{!!$element->legitimacion!!}</td>
            <td>{!!$element->destinatarios!!}</td>
            <td>{!!$element->derechos!!}</td>
            <td>{!!$element->additional!!}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_delete",array('var'=>$element))
            </td>
        </tr>
    @endforeach

</table>