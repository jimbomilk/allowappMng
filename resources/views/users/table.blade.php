<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans('label.users.name')}}</th>
        <th>{{trans('label.users.email')}}</th>
        <th>{{trans('label.users.type')}}</th>
        <th></th>

    </tr>

    @foreach($set as $user)
        <tr data-id="{{$user->id}}">
            <td>{{$user->name}}</td>
            <td>{{$user->email}}</td>
            <td>{{trans('label.profiles.'.$user->profile->type)}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$user))

                @include("common.controls.btn_show",array('var'=>$user))

                @include("common.controls.btn_delete",array('var'=>$user))
            </td>


        </tr>
    @endforeach

</table>