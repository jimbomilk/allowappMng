<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.photo")}}</th>
        <th>{{Lang::get("label.$name.rightholders")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <th>{{$element->group->name}}</th>
            <td>{{$element->name}}</td>
            <td>{!! Html::image($element->photo, 'photo',array( 'width' => 100, 'height' => 100 )) !!}</td>
            <th>@include("common.controls.emphasis_label",array('var'=>$element->numRightholders,'color'=>($element->numRightholders>0)?'primary':'danger'))</th>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_show",array('var'=>$element))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>