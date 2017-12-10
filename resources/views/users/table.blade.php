<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{Lang::get('label.users.name')}}</th>
        <th>{{Lang::get('label.users.email')}}</th>
        <th></th>

    </tr>

    @foreach($set as $user)
        <tr data-id="{{$user->id}}">
            <td>{{$user->id}}</td>
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$user))

                @include("common.controls.btn_show",array('var'=>$user))

                @include("common.controls.btn_delete",array('var'=>$user))
            </td>


        </tr>
    @endforeach

</table>