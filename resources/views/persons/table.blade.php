
<div class="col-sm-12">
    <div class=""> {{ $set->appends(request()->input())->links() }} </div>
</div>

@foreach($set as $element)
    @include('common.controls.person',['element',$element])
@endforeach

