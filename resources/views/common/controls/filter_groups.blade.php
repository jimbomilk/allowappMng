
@include('common.controls.input_select',['var'=>'filter-grupos','val'=>$group,'col'=>$groups,'nolabel'=>true,'class'=>'select-control'])

@section('scripts')
    @parent
    <script>
        $('#filter-grupos').change(function() {

            var pageURL = $(location).attr("href");
            if($('#filter-grupos').val() == "0")
                pageURL=pageURL.replace(/[\?#].*|$/,"");
            else
                pageURL=pageURL.replace(/[\?#].*|$/, '?group='+ $('#filter-grupos').val() );
            //alert(pageURL);
            window.location=pageURL;

            /*
            $('#filter-consents').prop('selectedIndex', 0);
            $(".person,.photo").show();
            if (this.value!=0) {
                $(".person,.photo").hide();
                $('.group' + this.value).show();
            }*/
        });
    </script>
@endsection
