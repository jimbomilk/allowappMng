<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get("label.$name.group_id")}}</th>
        <th>{{Lang::get("label.$name.rightholders")}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td><div class="person">
                    <img class="img-responsive" src={{$element->photo}} alt="imagen">
                    <div>{{$element->name}}</div>
                </div> </td>
            <th>{{$element->group->name}}</th>



            <th>@include("common.controls.emphasis_label",array('var'=>$element->numRightholders,'color'=>($element->numRightholders>0)?'primary':'danger'))</th>
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