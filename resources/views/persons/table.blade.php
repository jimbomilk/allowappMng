@foreach($set as $element)
    @include('common.controls.person',['element',$element])
@endforeach
<div class="row">
    <div class="col-sm-12">
        <div class="pagination"> {{ $set->appends(request()->input())->links() }} </div>
    </div>
</div>
