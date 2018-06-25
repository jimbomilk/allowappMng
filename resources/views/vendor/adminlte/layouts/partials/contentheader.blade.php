<!-- Content Header (Page header) -->
<section class="content-header">
    @if(isset($name))
    <h1>
        <i class='{{trans("design.".$name)}}'></i>
        {{ trans('labels.'.(strpos($name,".")? substr($name,0,strpos($name,".")):$name))}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="/home"><i class="fa fa-dashboard"></i> {{ trans('labels.home')}}</a></li>
        <li class="active">{{ trans('labels.'.$name) }}</li>
    </ol>
    @endif
</section>