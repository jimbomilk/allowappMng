<table class="table table-responsive table-striped">
    <tr>
        <th>{{Lang::get("label.$name.photo")}}</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">

            <td>
                <div style="width: 4vw">
                    <img class="img-responsive" src={{$element->photo}} alt="imagen">
                </div>
            </td>
            <td>{{$element->name}}</td>
            <th>{{$element->group->name}}</th>


            <td>
                <div class="col-sm-12">
                <a href="{{ url(str_replace(".","/",$name)."/show/$element->id") }}" class="btn-sm btn-warning" title="{{trans("label.$name")}}"><span class="glyphicon glyphicon-download-alt"></span> {{trans("label.$name.download")}}</a>
                </div>
            </td>


        </tr>
    @endforeach

</table>