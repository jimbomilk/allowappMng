<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.date")}}</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th>{{Lang::get("label.$name.name")}}</th>

        <th>{{Lang::get("label.$name.photo")}}</th>


        <th>{{Lang::get("label.$name.detected")}}</th>
        <th>{{Lang::get("label.$name.findings")}}</th>
        <th>{{Lang::get("label.$name.requests_received")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->createdate}}</td>
            <td>{{$element->group->name}}</td>
            <td>{{$element->name}}</td>
            <td>{!! Html::image($element->origen, 'photo',array( 'width' => 100, 'height' => 100 )) !!}</td>
            <td>{{count($element->faces)}}</td>
            <td>{{$element->findings}}</td>
            <td>{{count($element->acksOk).'/'.count($element->acks)}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_show",array('var'=>$element))

                @include("common.controls.btn_other",array('route'=> 'recognition','icon'=>'glyphicon-eye-open','var'=>$element,'label'=>'faces','style'=>'btn-danger'))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>