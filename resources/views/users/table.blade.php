<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans('label.users.name')}}</th>
        @if (Auth::user()->checkRole('super'))
            <th>{{trans('label.users.location')}}</th>
        @endif
        <th>{{trans('label.users.email')}}</th>
        <th>{{trans('label.users.type')}}</th>
        <th></th>

    </tr>

    @foreach($set as $user)
        <tr data-id="{{$user->id}}">
            <td>{{$user->name}}</td>
            @if (Auth::user()->checkRole('super'))
                <td>{{$user->location->name}}</td>
            @endif
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