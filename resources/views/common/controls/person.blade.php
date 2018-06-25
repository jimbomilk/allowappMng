<div class="col-lg-4 col-md-4 col-sm-6 person group{{$element->group->id}}">
    <div class="panel panel-default userlist">
        <div style="margin-top: 12px">
            <div class="col-sm-4 text-left " >
                <span class="label label-primary" >{{$element->group->name}}&nbsp;</span>
            </div>
            <div class="small col-sm-offset-4 col-sm-4 text-right">
                @if (!$element->minor)
                <span> <i class="fa fa-vcard-o text-primary"></i> {{$element->documentId}} </span>
                @endif
            </div>
        </div>
        <div class="panel-body text-center">
            <div class="userprofile ">
                <div class="userpic"> <img src="{{$element->photo}}" alt="" class="userpicimg"> </div>
                <h3 class="username">{{$element->name}}</h3>
                <div style="margin-bottom: 10px">
                @if ($element->minor)
                    <p class="page-subtitle small"><i class="fa fa-check"></i> Menor de edad </p>

                @endif
                </div>

                <div style="height: 70px">
                    @if ($element->minor)
                    <strong>Responsables</strong><br>

                        @foreach($element->rightholders as $rh)
                            {{$rh->name}} ({{$rh->relation}}) <br>
                        @endforeach
                        @if (count($element->rightholders)<=0)
                            Ningún responsable asignado.
                        @endif
                    @endif
                    @if (!$element->minor)
                    <p><i class="fa fa-envelope text-primary"></i> {{$element->email}} <br>
                        <i class="fa fa-phone text-primary"></i> {{$element->phone}} </p>
                    @endif
                </div>
            </div>

        </div>
        <div class="panel-footer">

            <div class="btn btn-link">
                @include("common.controls.btn_show",array('var'=>$element))
            </div>

            <div class="btn btn-link pull-right">
                @include("common.controls.btn_edit",array('var'=>$element))
                @include("common.controls.btn_delete",array('var'=>$element))
            </div>
        </div>
    </div>
</div>