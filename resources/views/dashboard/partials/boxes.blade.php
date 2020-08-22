
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>{{count($user->getPhotos()->get())}}</h3>
            <p>{{trans('labels.total_contacts')}}</p>
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
            <h3>{{$user->countPhotosByStatus(\App\Status::STATUS_PENDING)+$user->countPhotosByStatus(\App\Status::STATUS_PROCESED)}}</h3>
            <p>{{trans('labels.pending_contacts')}}</p>
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
            <h3>{{$user->countPhotosByStatus(\App\Status::STATUS_SHARED)}}</h3>
            <p>{{trans('labels.active_contacts')}}</p>
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
            <h3>{{$user->countPhotosByStatus(\App\Status::STATUS_REVIEW)}}</h3>
            <p>{{trans('labels.removed_contacts')}}</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-bug"></i>
        </div>
        <a href="#" class="small-box-footer"></a>
    </div>
</div>