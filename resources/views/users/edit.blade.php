@include("common.controls.input_text",array('var'=>'name'))
@include("common.controls.input_text",array('var'=>'email'))
@include("common.controls.input_text",array('var'=>'phone'))
@if(isset($location))
    <input type="hidden" name="location_id" value="{{$location}}">
@endif