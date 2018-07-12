
<div style="float: right">
    {!! Form::model(Request::all(), array('url' => str_replace(".","/",$name), 'method' => 'GET', 'enctype' => 'multipart/form-data')) !!}
    <div  class="col-md-8 col-xs-7 nopadding" style="margin:0">
        {!! Form::text('search', null, ['class' => 'search-control', 'placeholder'=>trans("labels.search.$name")]) !!}
    </div>
    <div  class="col-md-1 col-xs-1 nopadding"  >
        <button style="margin-top: 1px;padding-top: 5px" type="submit" class="btn btn-default">{{trans('labels.search')}}</button>
    </div>
    {!! Form::close() !!}
</div>
