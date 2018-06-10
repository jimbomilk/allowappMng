<table class="table table-responsive table-striped">
    <tr>
        <th>Alumno</th>
        <th>{{Lang::get("label.$name.minor")}}</th>
        <th>{{Lang::get("label.$name.email")}}</th>
        <th>{{Lang::get("label.$name.documentId")}}</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th>{{Lang::get("label.$name.rightholders")}}</th>
        @if($user->checkRole('admin')) <th>{{Lang::get("label.$name.FaceId")}}</th> @endif
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td><div class="person" >
                    <div style="margin-left: auto; margin-right: auto; width: 40%;text-align: center" ><img class="img-responsive" src={{$element->photo}} alt="imagen">
                    {{$element->name}}</div>
                </div> </td>
            <td>{{$element->minor?'Si':''}}</td>
            <td>{{$element->email}}</td>
            <td>{{$element->documentId}}</td>
            <td>{{$element->group->name}}</td>

            <th>@include("common.controls.emphasis_label",array('var'=>$element->numRightholders,'color'=>($element->numRightholders>0)?'primary':'danger'))</th>
            @if($user->checkRole('admin')) <td>{{$element->faceId}}</td> @endif
            <td>
                <div style="float: right">
                @include("common.controls.btn_edit",array('var'=>$element))
                </div>
                <div style="float: right;padding: 0px">
                @include("common.controls.btn_show",array('var'=>$element))
                </div>
                <div style="float: right">
                @include("common.controls.btn_delete",array('var'=>$element))
                </div>
            </td>



        </tr>
    @endforeach

</table>