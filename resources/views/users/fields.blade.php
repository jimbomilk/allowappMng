@include("common.controls.input_text",array('var'=>'name'))
@include("common.controls.input_text",array('var'=>'email'))
@include("common.controls.input_text",array('var'=>'phone'))


    @include("common.controls.input_password",array('var'=>'password'))

    @include("common.controls.input_password",array('var'=>'password_confirmation'))

@if(isset($location))
    <input type="hidden" name="location_id" value="{{$location}}">
@endif