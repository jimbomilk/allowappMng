<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.date")}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <th>{{$element->label}}</th>
            <td>{{$element->created}}</td>

            <td>
                @include("common.controls.btn_other",array('var'=>$element,'route'=>'show','label'=>'request', 'onlyicon'=>'true','small'=>'true','icon'=>'glyphicon-download-alt'))
            </td>


        </tr>
    @endforeach

</table>