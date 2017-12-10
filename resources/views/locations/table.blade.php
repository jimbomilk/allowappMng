<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get('label.groups.name')}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->name}}</td>

            <td>
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>