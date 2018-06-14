<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.name")}}</th>
        <th>{{Lang::get("label.$name.email")}}</th>
        <th>{{Lang::get("label.$name.phone")}}</th>
        <th>{{Lang::get("label.$name.documentId")}}</th>
        <th>{{Lang::get("label.$name.relation")}}</th>
        <th>{{Lang::get("label.$name.consents")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->name}}</td>
            <td>{{$element->email}}</td>
            <td>{{$element->phone}}</td>
            <td>{{$element->documentId}}</td>
            <td>{{$element->relation}} de {{$element->person->name}}</td>
            <td> @if($element->status==\App\Status::RH_PROCESED && isset($element->consent) )
                    @foreach(json_decode($element->consent) as $key=>$value)
                        <span class="fa glyphicon-globe fa-envelope-o fa-{{$key}}"  style=" font-size: 20px; color:{{ ($value?'rgb(136,177,75)':'grey') }}" title="{{$key}}:{{$value?'ok':'ko'}} "></span>
                    @endforeach
                @elseif($element->status==\App\Status::RH_NOTREQUESTED)
                    <span style="color: blue " aria-hidden="true">no solicitado</span>
                @else
                    <span style="color: red " aria-hidden="true">no recibido</span>
                @endif

            </td>

            <td>
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_other",array('var'=>$element,'route'=>'consentimientos','label'=>'request', 'onlyicon'=>'true','small'=>'true','icon'=>'glyphicon-thumbs-up'))
                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>