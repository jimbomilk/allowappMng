<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.relation")}}</th>
        <th>{{Lang::get("label.$name.consents")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->name}}</td>
            <td>{{$element->relation}} de {{$element->person->name}}</td>
            <td> @if($element->status==\App\Status::RH_PROCESED)
                    @foreach(json_decode($element->consent) as $share)
                        <span class="fa glyphicon-globe fa-envelope-o fa-{{$share->name}}"  style=" font-size: 20px; color:{{ ($share->value?'rgb(136,177,75)':'grey') }}" title="{{$share->name}}:{{$share->value?'ok':'ko'}} "></span>
                    @endforeach
                @elseif($element->status==\App\Status::RH_NOTREQUESTED)
                    <span style="color: blue " aria-hidden="true">no solicitado</span>
                @else
                    <span style="color: red " aria-hidden="true">no recibido</span>
                @endif

            </td>

            <td>
                @include("common.controls.btn_other",array('var'=>$element,'route'=>'show','label'=>'request', 'onlyicon'=>'true','small'=>'true','icon'=>'glyphicon-download-alt'))
            </td>


        </tr>
    @endforeach

</table>