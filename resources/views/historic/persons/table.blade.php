<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.photo")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <th>{{$element->group->name}}</th>
            <td>{{$element->name}}</td>
            <td>{!! Html::image($element->photo, 'photo',array( 'width' => 100, 'height' => 100 )) !!}</td>
            <td>
                @include("common.controls.btn_other",array('var'=>$element,'route'=>'show','label'=>'request', 'onlyicon'=>'true','small'=>'true','icon'=>'glyphicon-download-alt'))
            </td>


        </tr>
    @endforeach

</table>