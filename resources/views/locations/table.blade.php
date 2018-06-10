<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{trans('label.locations.name')}}</th>
        <th>{{trans('label.locations.description')}}</th>
        <th>{{trans('label.locations.logo')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->name}}</td>
            <td>{{$element->description}}</td>
            <td>
                <div class="col-sm-offset-1 col-sm-10"><img class="img-responsive" src={{$element->icon}} alt="logo"></div>
            </td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_show",array('var'=>$element))
                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>