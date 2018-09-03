
{!! Form::model(Request::all(), array('url' => str_replace(".","/",$name), 'method' => 'GET', 'enctype' => 'multipart/form-data')) !!}
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder={{trans("labels.search.$name")}}>

      <span class="input-group-btn">
        <button class="btn btn-default" type="submit">{{trans('labels.search')}}</button>
      </span>
    </div><!-- /input-group -->
{!! Form::close() !!}

