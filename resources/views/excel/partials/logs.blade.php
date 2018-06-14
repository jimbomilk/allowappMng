<div class="row">
    <div class="col-sm-offset-3 col-sm-6" >
        <div class="panel panel-default" >
            <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                Log Importaciones
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-responsive table-striped">


                            @foreach($excels as $index=>$element)
                                @if ($index == 0)
                                    <tr>

                                        @foreach($element->getAttributes() as $key=>$value)
                                            @if ($key!='location_id' && $key!='updated_at')
                                            <th>{{trans("label.".$name.".".$key)}}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endif
                                <tr data-id="{{$element->id}}">
                                    @foreach($element->getAttributes() as $key=>$value)
                                        @if ($key!='location_id' && $key!='updated_at')
                                        <td>@if($key=='user_id'){{App\User::find($value)->name}}@else {{$value}} @endif</td>
                                        @endif
                                    @endforeach

                                </tr>
                            @endforeach

                        </table>
                    </div>
                    <div class="col-sm-12 ">
                        <a class="btn btn-info center-block" href="{{ url("locations/$name/create") }}" role="button">
                            {{trans('labels.new')}} {{trans('label.'.$name)}}

                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>