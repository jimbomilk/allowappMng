<div class="col-lg-4 col-md-4 col-sm-6">
    <div class="panel panel-default userlist">

        <div class="panel-body text-center">
            <div class="userprofile">
                <div class="userpic"> <img src="{{$element->photo}}" alt="" class="userpicimg"> </div>
                <h3 class="username">{{$element->name}}</h3>
                <p>Grupo: {{$element->group->name}}</p>

                <div style="height: 70px">
                @if ($element->minor)
                    <p class="page-subtitle small">Menor de edad</p>
                    <a href="" class="availablity btn btn-circle btn-success"><i class="fa fa-check"></i></a>
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
                    <p>{{$element->email}} | {{$element->phone}} </p>
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