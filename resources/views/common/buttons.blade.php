<div style="float: right">
    @if(View::exists("$name.buttons"))
        @include("$name.buttons")
    @endif

    <a class="btn btn-info" href="{{ url("$name/create") }}" role="button">
        <span>
            <i class="glyphicon glyphicon-plus-sign"></i>
            {{trans('labels.new')}} {{trans('label.'.$name)}}
        </span>
    </a>
</div>