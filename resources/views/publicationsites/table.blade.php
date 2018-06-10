<table class="table table-responsive table-striped">
    <tr>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.url")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <th>{{$element->name}}</th>
            <td>{{$element->url}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>