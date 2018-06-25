
@include('common.controls.input_select',['var'=>'filter-grupos','col'=>$groups,'nolabel'=>true,'class'=>'select-control'])

@section('scripts')
    @parent
    <script>
        $('#filter-grupos').change(function() {
            sessionStorage.setItem("selected_group", this.value);
            $('.person').show();
            if (this.value!=0) {
                $('.person').hide();
                $('.group' + this.value).show();
            }
        });
    </script>
@endsection
