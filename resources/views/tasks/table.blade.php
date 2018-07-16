<table class="table table-responsive table-striped">
    <tr>
        <th>{{trans('label.tasks.description')}}</th>
        <th class="text-center">{{trans('label.tasks.priority_short')}}</th>
        <th></th>

    </tr>

@foreach($set as $element)
    <tr data-id="{{$element->id}}" style="@if($element->done) background-color: lightgreen @endif">
        <td>{{$element->description}}</td>
        <td class="text-center">
            @if($element->priority <=10)
                <span class="label label-danger">{{trans('label.tasks.priority_high')}}</span>
            @elseif ($element->priority <=20)
                <span class="label label-warning">{{trans('label.tasks.priority_medium')}}</span>
            @else
                <span class="label label-default">{{trans('label.tasks.priority_low')}}</span>
            @endif
        </td>
        <td class="nopadding">
            @include("common.controls.btn_edit",array('var'=>$element))
            @include("common.controls.btn_delete",array('var'=>$element))
        </td>
    </tr><!-- end task item -->
@endforeach
</table>
