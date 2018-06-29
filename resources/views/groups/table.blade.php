<table class="table table-responsive table-striped">
    <tr>
        <th class="text-center">{{trans('label.groups.name')}}</th>
        @if(Auth::user()->checkRole('admin'))
        <th>{{trans('label.groups.user_id')}}</th>
        @endif
        <th class="text-center">{{trans('label.groups.count')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td class="text-center"><strong>{{$element->name}}</strong></td>
            @if(Auth::user()->checkRole('admin'))
            <td>{{$element->user->name}}</td>
            @endif
            <td class="text-center">{{count($element->persons)}}</td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))

                @include("common.controls.btn_show",array('var'=>$element))

                @include("common.controls.btn_other",array('route'=> 'publicationsites','onlyicon'=>true,'icon'=>'glyphicon-globe','var'=>$element,'label'=>'sites','style'=>'btn-info'))

                @include("common.controls.btn_delete",array('var'=>$element))
            </td>


        </tr>
    @endforeach

</table>