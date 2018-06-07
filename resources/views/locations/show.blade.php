@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans("labels.$name") }}
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">

        <div class="row">
            <div class="col-md-4 panel panel-default">
                <div class="panel-heading">Collections de  {{$location->name}}</div>
                <div class="panel-body">

                    @foreach($set['CollectionIds'] as $index=>$collectionId)
                    <div class="row" style="padding:4px ;margin-top: 6px; border-bottom: 1px solid grey">
                        <div class="col-sm-4">
                        {{$collectionId}}
                        </div>
                        <div class=" col-sm-8">
                            <a href="{{ url("$name/$location->id/$collectionId") }}" class="btn-sm btn-primary" style="margin-left: 5px" title="{{trans('label.'.$name.'.show')}}"><span ><i class="glyphicon glyphicon-list-alt"></i> {{trans('label.'.$name.'.show')}}</span></a>
                            <a href="{{ url("$name/$location->id/delete/$collectionId") }}" class="btn-sm btn-danger" style="margin-left: 5px" title="{{trans('label.'.$name.'.delete')}}"><span ><i class="glyphicon glyphicon-trash"></i> {{trans('label.'.$name.'.delete')}}</span></a>


                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class=" col-md-8 panel panel-default">
                <div class="panel-heading">Faces</div>
                <div class="panel-body">
                    @if(isset($faces))
                    @foreach($faces['Faces'] as $index=>$face)
                    <div class="row" style="padding:4px ;margin-top: 6px; border-bottom: 1px solid grey">
                        <div class="col-sm-12">
                            <strong>Face:</strong> {{$face['FaceId']}} |
                            <strong>Box:</strong> {{json_encode($face['BoundingBox'])}} |
                            <strong>Confidence:</strong> {{$face['Confidence']}}
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

            </div>
        </div>


    </div>
@endsection


@section('scripts')
@parent
@endsection

