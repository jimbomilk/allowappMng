@if (isset($var))
    <a href="{{ url("$name/$route/$var->id") }}" class="btn{{(isset($small)&&$small)?"-sm":""}} btn-warning" style="margin-left: 5px" title="{{trans("label.$name.$label")}}"><span class="glyphicon {{$icon}}"></span> {{(isset($onlyicon)&&$onlyicon)?"":trans("label.$name.$label")}} </a>
@else
    <a href="{{ url("$name/$route/all") }}" class="btn{{(isset($small)&&$small)?"-sm":""}} btn-warning" style="margin-left: 5px" title="{{trans("label.$name.$label")}}"><span class="glyphicon {{$icon}}"></span> {{(isset($onlyicon)&&$onlyicon)?"":trans("label.$name.$label")}} </a>

@endif