<table class="table table-responsive table-striped">
    <tr>
        <th>#</th>
        <th>{{trans('label.locations.name')}}</th>
        <th>{{trans('label.locations.description')}}</th>
        <th>{{trans('label.locations.logo')}}</th>
        <th></th>

    </tr>

    @foreach($set as $element)
        <tr data-id="{{$element->id}}">
            <td>{{$element->id}}</td>
            <td>{{$element->name}}</td>
            <td>{{$element->description}}</td>
            <td>
                <div class="col-sm-offset-1 col-sm-10"><img style="width: 20%" class="img-responsive" src={{$element->icon}} alt="logo"></div>
            </td>
            <td>
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_show",array('var'=>$element))
                @include("common.controls.btn_other",array('route'=> 'excel/show','onlyicon'=>true,'icon'=>'fa fa-file-excel-o','small'=>'true','var'=>$element,'label'=>'excel','style'=>'btn-info'))
                @include("common.controls.btn_delete",array('var'=>$element))

            </td>


        </tr>
    @endforeach

</table>