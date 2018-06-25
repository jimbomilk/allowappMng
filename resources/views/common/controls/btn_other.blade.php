@if (isset($var))
    <a href="{{ url("$name/$route/$var->id") }}" class="{{isset($class)?$class:((isset($small)&&$small)?"btn-sm":"btn")}} "  title="{{trans("label.$name.$label")}}">
@else
    <a href="{{ url("$name/$route/all") }}" class="{{isset($class)?$class:((isset($small)&&$small)?"btn-sm":"btn")}} btn-warning" style="margin-left: 5px" title="{{trans("label.$name.$label")}}">
@endif
<span>
    <i  class="glyphicon {{$icon}}"></i> {{(isset($onlyicon)&&$onlyicon)?"":trans("label.$name.$label")}}
</span>
</a>