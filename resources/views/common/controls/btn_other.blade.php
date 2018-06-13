@if (isset($var))
    <a href="{{ url("$name/$route/$var->id") }}" class="btn{{(isset($small)&&$small)?"-sm":""}} " style="margin-left: 5px" title="{{trans("label.$name.$label")}}"><span><i class="glyphicon {{$icon}}"></i> {{(isset($onlyicon)&&$onlyicon)?"":trans("label.$name.$label")}}</span> </a>
@else
    <a href="{{ url("$name/$route/all") }}" class="btn{{(isset($small)&&$small)?"-sm":""}} " style="margin-left: 5px" title="{{trans("label.$name.$label")}}"><span><i class="{{$icon}}"></i> {{(isset($onlyicon)&&$onlyicon)?"":trans("label.$name.$label")}}</span> </a>

@endif