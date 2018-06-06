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
            <td><div class="person">
                    <img class="img-responsive" src={{$element->photo}} alt="imagen">
            </div></td>
            <td>
                <div class="col-sm-4">
                <a href="{{ url(str_replace(".","/",$name)."/show/$element->id") }}" class="btn-sm btn-warning" title="{{trans("label.$name")}}"><span class="glyphicon glyphicon-download-alt"></span> </a>
                </div>
            </td>


        </tr>
    @endforeach

</table>