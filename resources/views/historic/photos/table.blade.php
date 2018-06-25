<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans("label.$name.photo")}}</th>
        <th>{{trans("label.$name.name")}}</th>
        <th>{{trans("label.$name.date")}}</th>
        <th>{{trans("label.$name.people")}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td><div style="width: 8vw">
                    <img class="img-responsive" src={{$element->url}} alt="imagen">

                </div> </td>
            <th>{{$element->label}}</th>
            <td>{{$element->created}}</td>
            <td>
                <div class="row">
                    @foreach($element->people as $person)
                    <div class="col-sm-6">
                        <span><i class='fa fa-users'></i></span> {{\App\Person::find($person->id)->name}}
                    </div>
                    @endforeach
                </div>
            </td>

            <td>
                <div class="col-sm-12">
                <a href="{{ url(str_replace(".","/",$name)."/show/$element->id") }}" class="btn-sm btn-warning" title="{{trans("label.$name")}}"><span class="glyphicon glyphicon-download-alt"></span> {{trans("label.$name.download")}} </a>
                </div>

            </td>


        </tr>
    @endforeach

</table>