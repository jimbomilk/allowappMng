<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.date")}}</th>
        <th>{{Lang::get("label.$name.people")}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td><div style="width: 10vw">
                    <img class="img-responsive" src={{$element->url}} alt="imagen">

                </div> </td>
            <th>{{$element->label}}</th>
            <td>{{$element->created}}</td>
            <td>
                <div class="row">
                    @foreach($element->people as $person)
                    <div class="col-sm-6">
                        <span><i class='fa fa-users'></i></span> {{$person->name}}
                    </div>
                    @endforeach
                </div>
            </td>

            <td>
                <div class="col-sm-4">
                <a href="{{ url(str_replace(".","/",$name)."/show/$element->id") }}" class="btn-sm btn-warning" title="{{trans("label.$name")}}"><span class="glyphicon glyphicon-download-alt"></span> </a>
                </div>

            </td>


        </tr>
    @endforeach

</table>