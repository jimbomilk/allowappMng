<div class="col-md-12" >
    <div class="panel panel-default" >
        <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
            {{$title}}

            @if(isset($buttons))
                <span style="float:right">
                @include("$name.partials.$buttons",['var'=>'images'])
                </span>
            @endif
        </div>
        <div class="panel-body">

            <table class="table table-responsive table-striped">


                @foreach($set as $index=>$element)
                    @if ($index == 0)
                        <tr>

                            @foreach($element->getAttributes() as $key=>$value)
                                @if($key!='id'&&$key!='created_at'&&$key!='updated_at'&&$key!='location_id')
                                <th style="border:1px solid grey;">{{$key}}</th>
                                @endif
                            @endforeach
                        </tr>
                    @endif
                    <tr data-id="{{$element->id}}">
                        @foreach($element->getAttributes() as $key=>$value)
                            @if($key!='id'&&$key!='created_at'&&$key!='updated_at'&&$key!='location_id')
                            <td style="border:1px solid grey;background-color:{{$element->check($key,$value,$title)?"rgba(180,255,180,0.2)":"rgba(255,90,90,0.5)"}}" title="{{$title}}">
                                {{$value}}
                                @if (strpos($key,"path")==true)
                                    <span style="text-align: center">
                                        @include("$name.partials.$button",['var'=>$element->id])
                                    </span>
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