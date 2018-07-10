<!-- TO DO List -->
<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-image"></i>
            <h3 class="box-title">{{trans('labels.images-pending')}}</h3>

        </div><!-- /.box-header -->
        <div class="box-body" style="height: 190px">
            <div class="col-sm-12 row-striped">
                @if(count($photos)<=0)
                    <p> {{trans('labels.no-data')}} </p>
                @endif

                @foreach($photos as $photo)
                <div class="row " style="margin-top: 10px;">
                    <div class="col-md-2" style="text-align: center;">
                        <img src="{{$photo->url}}" width="75" height="50" alt="add image" class="online"/>
                    </div>
                    <div class="col-md-2">
                        creada el {{ $photo->created_at }}
                    </div>
                    <div class="col-md-2">
                        por {{ $photo->user->name }}
                    </div>
                    <div class="col-md-2">
                        @include("common.controls.status",['status'=>$photo->status])
                    </div>
                </div>
                @endforeach
            </div>
            <span class="box-tools pull-right inline">
            {{ $photos->links() }}
            </span>


        </div><!-- /.box-body -->

    </div><!-- /.box -->
</div>