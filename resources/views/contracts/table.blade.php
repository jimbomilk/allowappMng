<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.photo")}}</th>
        <th>{{Lang::get("label.$name.person")}}</th>
        <th>{{Lang::get("label.$name.group")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->photo->name}}</td>
            <td>{{$element->person->name}}</td>
            <td>{{$element->person->group->name}}</td>
            <td>
                <div class="col-sm-12">
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_show",array('var'=>$element))

                @include("common.controls.btn_delete",array('var'=>$element))
                </div>
            </td>


        </tr>
    @endforeach

</table>