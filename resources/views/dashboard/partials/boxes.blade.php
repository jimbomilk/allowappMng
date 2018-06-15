
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{$user->countPhotosByStatus(10)}}</h3>
            <p>{{trans('labels.images-created')}}</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-body"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
    </div>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>{{$user->countPhotosByStatus(20)+$user->countPhotosByStatus(30)}}</h3>
            <p>{{trans('labels.images-pending')}}</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-clock"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
    </div>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{$user->countPhotosByStatus(200)}}</h3>
            <p>{{trans('labels.images-approved')}}</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-checkbox"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
    </div>
</div><!-- ./col -->
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{$user->countPhotosByStatus(100)}}</h3>
            <p>{{trans('labels.images-rejected')}}</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-bug"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
    </div>
</div>