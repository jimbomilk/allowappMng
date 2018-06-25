<table class="table table-responsive table-striped">
    <tr>

        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.relation")}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">

            <td>{{$element->name}}</td>
            <td>{{$element->relation}} de {{$element->person->name}}</td>

            <td>
                <div class="col-sm-12">
                <a href="{{ url(str_replace(".","/",$name)."/show/$element->id") }}" class="btn-sm btn-warning" title="{{trans("label.$name")}}"><span class="glyphicon glyphicon-download-alt"></span> {{trans("label.$name.download")}}</a>
                </div>
            </td>
        </tr>
    @endforeach

</table>