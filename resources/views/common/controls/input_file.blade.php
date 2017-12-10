<div class="form-group">
    @if(isset($element))
        {!! Html::image($element->$var, $var,array('id'=>$var.'-image-tag', 'width' => $width, 'height' => $height,'float'=>'left')) !!}
        <a class="btn-remove" id="{{$var}}-remove" style="position:absolute;float:left;display: none"><i class="btn btn-primary">x</i></a>
    @endif
</div>

<div class="form-group">
    {!! Form::hidden($var.'file', null, array('name'=>$var,'id'=>$var.'file')) !!}
    {!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}
    <span>{!! Form::file($var, null) !!}</span>

</div>
<br>


@section('scripts')
    @parent
    <script type="text/javascript">
        $('#{{$var}}-image-tag').one('load', function() {
            s=$('#{{$var}}-image-tag').attr('src');
            if (s != "")
                $('#{{$var}}-remove').show();

            $("#{{$var}}file").val(s);
        }).each(function() {
            if(this.complete) $(this).load();
        });

        $('#{{$var}}-remove').click(function(){
            $('#{{$var}}-image-tag').attr('src', "");
            $("#{{$var}}file").val("");
            $('#{{$var}}-remove').hide();
        });

        $('#{{$var}}').change(function(){
            readURL(this,'#{{$var}}-image-tag');
            $('#{{$var}}-remove').show();
        });
    </script>
@endsection