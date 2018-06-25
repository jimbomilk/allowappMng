
@include('common.controls.input_select',['var'=>'filter-consents','col'=>$consents,'nolabel'=>true,'class'=>'select-control'])

@section('scripts')
    @parent
    <script>

        $('#filter-consents').change(function() {
            $('#filter-grupos').prop('selectedIndex', 0);
            $(".photo").show();
            if (this.value!=0) {
                $(".photo").hide();
                $('.consent' + this.value).show();
            }
        });
    </script>
@endsection
