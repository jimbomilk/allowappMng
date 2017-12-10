<div class="form-group">

    <a href="{{url(isset($url)?$url:'#')}}">
       {!! Html::image($var, $var,array('width' => $width, 'height' => $height,'float'=>'left','class'=>'center-block')) !!}
        <a class="btn-remove" id="{{$var}}-remove" style="position:absolute;float:left;display: none"><i class="btn btn-primary">x</i></a>
    </a>
</div>

