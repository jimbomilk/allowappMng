<table @if(isset($class)) class="{{$class}}" @else class="panel" @endif width="{{$width}}" @if(isset($height)) height="{{$height}}" @endif cellpadding="0" cellspacing="0">
    <tr>
        <td class="panel-content" height="100%">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="panel-item">
                        {{ Illuminate\Mail\Markdown::parse($slot) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
