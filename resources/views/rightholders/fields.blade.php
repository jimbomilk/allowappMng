@include("common.controls.input_select",array('var'=>'person_id','col'=>$persons))
@include("common.controls.input_text",array('var'=>'name'))
@include("common.controls.input_select",array('var'=>'relation','col'=>$titles,'val'=>isset($element)?array_search("$element->relation",$titles):''))
@include("common.controls.input_text",array('var'=>'email'))
@include("common.controls.input_text",array('var'=>'phone'))

@if(isset($element))
@foreach( json_decode($element->consent) as $consent)

    <div class="row social">
        <div class="col-md-12 ">
            <strong>Compartir en {{$consent->name}} :</strong>
        </div>
        <div class="col-md-5">
            <input style="" type="radio" id="consent1" name="{{$consent->name}}" {{$consent->value?"checked":""}} disabled="true">
            <label for="consent1">Consiente</label>
        </div>
        <div class="col-md-5">
            <input type="radio" id="consent2" name="{{$consent->name}}" {{!$consent->value?"checked":""}} disabled="true">
            <label for="consent2">No consiente</label>
        </div>
    </div>

@endforeach
@endif