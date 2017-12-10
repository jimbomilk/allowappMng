<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get('label.acks.photo')}}</th>
        <th>{{Lang::get('label.acks.rightholder')}}</th>
        <th>{{Lang::get('label.acks.status_short')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->contract->photo->name}}</td>
            <td>{{$element->rightholder->name}}</td>
            <td>{{$element->getStatusDesc()}}</td>

            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>