<div class="form-group">
{!! Form::label($var, Lang::get('label.'.$name.'.'.$var)) !!}

    <div id="imgdata" class="form-group" style="display:none">
        {!! Html::image(isset($element)?$element->$var:null, $var,array('id'=>$var.'-image-tag', 'width' => $width, 'height' => $height,'float'=>'left')) !!}
        <span style="position: absolute;top: 30px;right: 20px">
            <a class="btn btn-remove" id="{{$var}}-remove"><span class="glyphicon glyphicon-trash form-control-feedback"></span></a>
        </span>
    </div>
    <div id="imgfile" class="form-group dash-box center inputfile" style="text-align:center;height: {{$height}}px; width:{{$width}}px ">
        <input type="file" name="{{$var}}" id="{{$var}}" class="hidden"/>
        <label for="{{$var}}">Selecciona un fichero</label>
    </div>
</div>
<br>


@section('scripts')
    @parent
    <script type="text/javascript">

        function readURL(input,tag) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(tag).attr('src', e.target.result);
                    $('#imgdata').css('display','block');
                    $('#imgfile').css('display','none');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $('#{{$var}}-image-tag').one('load', function() {
            s=$('#{{$var}}-image-tag').attr('src');
            if (s != "") {
                $('#{{$var}}-remove').show();
                $('#imgdata').css('display', 'block');
                $('#imgfile').css('display', 'none');
            }

            $("#{{$var}}file").val(s);
        }).each(function() {
            if(this.complete){

            }
        });

        $('#{{$var}}-remove').click(function(){
            $('#{{$var}}-image-tag').attr('src', "");
            $("#{{$var}}file").val("");
            $('#{{$var}}-remove').hide();
            $('#imgdata').css('display','none');
            $('#imgfile').css('display','block');
        });

        $('#{{$var}}').change(function(){
            readURL(this,'#{{$var}}-image-tag');
            $('#{{$var}}-remove').show();
        });
    </script>
@endsection