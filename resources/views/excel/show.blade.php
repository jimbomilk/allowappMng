@extends('adminlte::layouts.app')


@section('main-content')
<div class="container-fluid spark-screen">

    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4>
                        <i class="{{trans("label.$name.fa_icon")}}"></i> {{trans("labels.$name")}}
                    </h4>
                </div>

                <div class="panel-body">
                    <div class="col-md-12">
                    @include("$name.partials.logs")
                    @include("$name.partials.table",['title'=>'Excel de Lugares de publicación','idTable'=>'sites', 'set'=>$sites,'btnImport'=>true])
                    @include("$name.partials.table",['title'=>'Excel de Personas/Alumnos','idTable'=>'persons','set'=>$persons,'btnImages'=>true,'btnImport'=>true])
                    @include("$name.partials.table",['title'=>'Excel de Responsables','idTable'=>'rightholders','set'=>$rightholders,'btnImport'=>true])

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')
    @parent

    <script>
        function readmultifiles(e) {
            const files = e.currentTarget.files;
            Object.keys(files).forEach(i => {
                const file = files[i];
                const reader = new FileReader();
                reader.onload = (e) => {
                    //server call for uploading or reading the files one-by-one
                    //by using 'reader.result' or 'file'
                    $.ajax({
                        method: "POST",
                        url:'importPhoto',
                        data: {
                        _token: "{{ csrf_token() }}",
                        contentType: "multipart/form-data",
                        name: file.name,
                        file: e.target.result,
                        importId:"{{$current_import}}"}
                    }).done(function () {
                        location.reload();

                    }).always( function() {
                        //$("#loader").hide();
                    });
                }
                reader.readAsDataURL(file);
            })
        };

        function importdata(_this){
            var action = $(_this).data('table');

            $.ajax({
                method: "POST",
                url:'import'+action,
                data: {_token: "{{ csrf_token() }}"}
            }).done(function () {
                location.reload();
            }).always( function() {
                //$("#loader").hide();
            });
        }

        $('#input-images').change(function(e){
            readmultifiles(e);
        });

        $('.import').on('click',function(e){
            importdata(this);
        });
    </script>

@endsection