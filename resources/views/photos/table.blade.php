<div class="row">
@foreach($set as $element)
    @include("common.controls.image_card",array('imagen'=>$element))
@endforeach
</div>
<div class="row">
    <div class="col-sm-12">
    {{ $set->links() }}
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".details").click(function () {
            imagenId = $(this).data("imagenid");
            $("#back"+imagenId).toggle("slow");
            $("#front"+imagenId).toggle("slow");
            $('html, body').animate({
                scrollTop: $("*[data-imagenid="+imagenId+"]").offset().top-600
            }, 1000);

        });

        $(".preview").click(function () {
            imagenId = $(this).data("imagenid");
            $("#current"+imagenId).toggle("slow");
            $("#preview"+imagenId).toggle("slow");
            if ($(".preview a").text() == "Volver"){
                $(".preview a").text("Vista previa por plataforma de difusión");
            }else{
                $(".preview a").text("Volver");
            }

        });
    })
</script>
