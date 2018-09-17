<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans('label.locations.name')}}</th>
        <th class="text-center">{{trans('label.locations.logo')}}</th>

        <th>{{trans('label.locations.description')}}</th>
        <th>{{trans('label.locations.accountable')}}</th>
        <th>{{trans('label.locations.CIF')}}</th>
        <th>{{trans('label.locations.email')}}</th>
        <th>{{trans('label.locations.address')}}</th>
        <th>{{trans('label.locations.city')}}</th>
        <th>{{trans('label.locations.CP')}}</th>
        <th>{{trans('label.locations.delegate_name')}}</th>

        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->name}}</td>
            <td width="100px">
                @include("common.controls.img",["src"=>$element->icon])
            </td>

            <td>{{$element->description}}</td>
            <td>{{$element->accountable}}</td>
            <td>{{$element->CIF}}</td>
            <td>{{$element->email}}</td>
            <td>{{$element->address}}</td>
            <td>{{$element->city}}</td>
            <td>{{$element->CP}}</td>
            <td>{{$element->delegate_name}}</td>

            <td>
                <div class="col-sm-12">
                    @if(Auth::user()->checkRole('super'))
                        @include("common.controls.btn_edit",array('var'=>$element))
                        @include("common.controls.btn_show",array('var'=>$element))
                    @endif
                    @include("common.controls.btn_other",array('route'=> 'excel/show','onlyicon'=>true,'icon'=>'glyphicon-save','var'=>$element,'label'=>'excel','style'=>'btn-info'))
                    @if(Auth::user()->checkRole('super'))
                        @include("common.controls.btn_delete",array('var'=>$element))
                    @endif
                </div>
            </td>


        </tr>
    @endforeach

</table>