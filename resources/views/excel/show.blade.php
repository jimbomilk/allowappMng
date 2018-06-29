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
                    @include("$name.partials.table",['title'=>'Excel de Lugares de publicación','sourceTable'=> 'intermediate_excel_3', 'idTable'=>'sites', 'set'=>$sites,'btnImport'=>true])
                    @include("$name.partials.table",['title'=>'Excel de Personas/Alumnos','sourceTable'=> 'intermediate_excel_1','idTable'=>'persons','set'=>$persons,'btnImages'=>true,'btnImport'=>true])
                    @include("$name.partials.table",['title'=>'Excel de Responsables','sourceTable'=> 'intermediate_excel_2','idTable'=>'rightholders','set'=>$rightholders,'btnImport'=>true])

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

        $('.editable').on('change', function(e){

            var key = $(this).attr('name');
            var value = $(this).val();
            var sourceTable = $(this).data('source');
            var table = $(this).data('table');
            var id = $(this).data('id');
            $(".loader").show();

            $.ajax({
                method: "POST",
                url:'updateImport',
                data: {_token: "{{ csrf_token() }}",key:key,value:value,table:sourceTable,id:id}
            }).done(function (e) {
                $(".loader").hide();
                location.reload();
            }).fail(function (e) {
                $(".loader").hide();
                alert("Error, no se ha podido completar la operación. Detalles:"+ e.statusText);
            }).always( function() {

            });

        });


        function readmultifiles(imgFiles,callback) {
            var files = imgFiles;
            var errors = [];

            $(".loader").show();
            $(".progress#intermediate_excel_1").show();
            var count=0;
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
                    }).done(function (e) {
                        if (e.response == true) {
                            count++;
                            if (count >= files.length) {
                                $(".progress#intermediate_excel_1").hide();
                                if (callback && errors.length >0)
                                    callback.call(errors);
                                else {
                                    //$(".loader").hide();
                                    location.reload();
                                }

                            } else {
                                newprogress = ((count * 100) / files.length) + '%';
                                $('.progress#intermediate_excel_1 .progress-bar').attr('style', "width:" + newprogress);
                                $('.progress#intermediate_excel_1 .label').text(count + " de " + files.length);
                            }
                        }
                    }).fail(function(response){
                        count++;
                        errors.push(file);
                    });
                };
                reader.readAsDataURL(file);
            });
        }

        function importdata(_this){

            var action = $(_this).data('table');
            $(".loader").show();
            $.ajax({
                method: "POST",
                url:'import'+action,
                data: {_token: "{{ csrf_token() }}"}
            }).done(function () {
                $(".loader").hide();
                location.reload();
            }).fail( function(e) {
                alert("Se ha producido un error: " + e.statusMessage);
            }).always( function() {
                location.reload();
            });
        }

        $('#input-images').change(function(e){
            readmultifiles(e.currentTarget.files,function(){
                readmultifiles(this,null);// hacemos una segunda llamada con los que dieron error.

            });

        });

        $('.import').on('click',function(e){
            importdata(this);
        });
    </script>

@endsection