<!-- TO DO List -->
<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-image"></i>
            <h3 class="box-title">{{trans('labels.images-pending')}}</h3>

        </div><!-- /.box-header -->
        <div class="box-body" style="height: 190px">
            <div style="margin: 0px;height:100%;overflow-y: scroll;overflow-x: hidden">
                @if(count($links)<=0)
                    <p> {{trans('labels.no-data')}} </p>
                @endif
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                    <div class="col-md-2"></div>
                </div>
                @foreach($links as $link)
                <div class="row">
                    <div class="col-md-2" style="text-align: center">
                        <img src="{{$link->photo->url}}" width="75" height="50" alt="add image" class="online"/>
                    </div>
                    <div class="col-md-2">
                        creada el {{ $link->created_at }}
                    </div>
                    <div class="col-md-2">
                        por {{ $link->user->name }}
                    </div>
                    <div class="col-md-2">
                        @include("common.controls.status",['status'=>$link->photo->status])
                    </div>
                </div>
                @endforeach
            </div>
            <span class="box-tools pull-right inline">
            {{ $links->links() }}
            </span>


        </div><!-- /.box-body -->

    </div><!-- /.box -->
</div>