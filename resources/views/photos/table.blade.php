<div class="row">
@foreach($set as $element)
    @include("common.controls.image_card",array('imagen'=>$element))
@endforeach
</div>
<div class="row">
    <div class="col-sm-12">
    {{ $set->links() }}
    </div>
</div>

