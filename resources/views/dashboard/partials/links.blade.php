<!-- TO DO List -->
<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-image"></i>
            <h3 class="box-title">{{trans('labels.images-created')}}</h3>

        </div><!-- /.box-header -->
        <div class="box-body" >

                @if(count($photos)<=0)
                    <p> {{trans('labels.no-data')}} </p>
                @endif

                <div class="col-sm-12">
                    <div > {{ $photos->links() }} </div>
                </div>
                @foreach($photos as $photo)
                <div class="col-sm-1 col-xs-6" >

                        <div style="position: absolute;top: 0px; left:20px"> @include("common.controls.status",['status'=>$photo->status])</div>
                        <img src="{{$photo->url}}" width="110px" height="110px"/>
                        <p class="text-left small">{{ $photo->created_at }}</p>

                </div>

                @endforeach







        </div><!-- /.box-body -->

    </div><!-- /.box -->
</div>