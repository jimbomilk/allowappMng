
@include('common.controls.input_select',['var'=>'filter-grupos','col'=>$groups,'nolabel'=>true,'class'=>'select-control'])

@section('scripts')
    @parent
    <script>
        $('#filter-grupos').change(function() {
            $('#filter-consents').prop('selectedIndex', 0);
            $(".person,.photo").show();
            if (this.value!=0) {
                $(".person,.photo").hide();
                $('.group' + this.value).show();
            }
        });
    </script>
@endsection
