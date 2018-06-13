<div class="row">
    <div class="col-md-12" >
        <div class="panel panel-default" >
            <div class="panel-heading" style="background-color: rgb(246,216,88);color: #000000">
                Log Importaciones
            </div>
            <div class="panel-body">

                <table class="table table-responsive table-striped">


                    @foreach($excels as $index=>$element)
                        @if ($index == 0)
                            <tr>

                                @foreach($element->getAttributes() as $key=>$value)

                                    <th>{{$key}}</th>
                                @endforeach
                            </tr>
                        @endif
                        <tr data-id="{{$element->id}}">
                            @foreach($element->getAttributes() as $key=>$value)
                                <td>{{$value}}</td>
                            @endforeach

                        </tr>
                    @endforeach

                </table>
                <div class="row">
                    <div class="col-sm-offset-10 col-sm-2">
                        <a class="btn btn-info" href="{{ url("locations/$name/create") }}" role="button">
                            {{trans('labels.new')}} {{trans('label.'.$name)}}

                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>