<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get('label.groups.name')}}</th>
        <th>{{Lang::get('label.groups.user_id')}}</th>
        <th>{{Lang::get('label.groups.count')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td><strong>{{$element->name}}</strong></td>
            <td>{{$element->user->name}}</td>
            <td>{{count($element->persons)}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_show",array('var'=>$element))

                @include("common.controls.btn_other",array('route'=> 'publicationsites','icon'=>'glyphicon-thumbs-up','small'=>'true','var'=>$element,'label'=>'sites','style'=>'btn-info'))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>