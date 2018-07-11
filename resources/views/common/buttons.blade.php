
    @if(View::exists("$name.buttons"))
        @include("$name.buttons")
    @endif

    <a class="btn btn-info" href="{{ url("$name/create") }}" role="button">
        <i class="glyphicon glyphicon-plus-sign"></i>
        <span class="hide-mobile">{{trans('labels.new')}} {{trans('label.'.$name)}}</span>
    </a>
