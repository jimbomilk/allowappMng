@extends('layouts.imagen')
@section('content')

<div class="row">
    <div class="col-md-12">
        <h1>Title</h1>
    </div>
</div>
<div class="row" >
    <div class="col-md-12" >
        <div style="text-align: center">
            <img class="img-responsive center" src="{{$photo->url}}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <p>Text legal</p>
    </div>
</div>


@stop