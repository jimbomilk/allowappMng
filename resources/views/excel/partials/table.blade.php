<div class="col-md-12" >
    <div class="panel panel-default" >
        <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
            {{$title}}
            @if(isset($btnImport))
                <span style="margin-left:20px;float:right">
                @include("$name.partials.btn_import",['var'=>'toddbb','idTable'=>$idTable,'text'=>'Importar tabla','icon'=>'fa fa-download'])
                </span>
            @endif
            @if(isset($btnImages))
                <span style="margin-left:20px;float:right">
                @include("$name.partials.btn_images",['var'=>'images','text'=>'Asignar fotos','icon'=>'fa fa-photo'])
                </span>
            @endif

        </div>
        <div class="panel-body">

            <table class="table table-responsive table-striped">


                @foreach($set as $index=>$element)
                    @if ($index == 0)
                        <tr>

                            @foreach($element->getAttributes() as $key=>$value)
                                @if($key!='id'&&$key!='created_at'&&$key!='updated_at'&&$key!='location_id'&&$key!='import_id')
                                <th style="border:1px solid grey;">{{trans("label.".$name.".".$key)}}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                    <tr data-id="{{$element->id}}">
                        @foreach($element->getAttributes() as $key=>$value)
                            @if($key!='id'&&$key!='created_at'&&$key!='updated_at'&&$key!='location_id'&&$key!='import_id')
                            <td style="border:1px solid grey;background-color:{{$element->check($key,$value,$title)?"rgba(180,255,180,0.2)":"rgba(255,90,90,0.5)"}}" title="{{$title}}">

                                @if (strpos($key,"path")==true)
                                    @if (isset($value))
                                        <div class="person" style="margin-left: auto;margin-right: auto;width: 30%">
                                            <img class="img-responsive" src={{$value}} alt="imagen">
                                        </div>
                                    @endif

                                @else
                                    {{$value}}
                                @endif
                            </td>
                            @endif
                        @endforeach

                    </tr>
                @endforeach

            </table>
        </div>
    </div>
</div>