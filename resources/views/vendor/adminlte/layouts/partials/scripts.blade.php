<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<!-- JavaScripts -->


<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script src="/js/laravel.js"></script>


<script src="{{ asset('/plugins/tinymce/js/tinymce/tinymce.min.js') }}" type="text/javascript"></script>
<script>
    var tm_fonts = "Andale Mono=andale mono,times;"+
            "Arial=arial,helvetica,sans-serif;"+
            "Arial Black=arial black,avant garde;"+
            "Book Antiqua=book_antiquaregular,palatino;"+
            "Corda Light=CordaLight,sans-serif;"+
            "Courier New=courier_newregular,courier;"+
            "Flexo Caps=FlexoCapsDEMORegular;"+
            "Lucida Console=lucida_consoleregular,courier;"+
            "Georgia=georgia,palatino;"+
            "Helvetica=helvetica;"+
            "Impact=impactregular,chicago;"+
            "Museo Slab=MuseoSlab500Regular,sans-serif;"+
            "Museo Sans=MuseoSans500Regular,sans-serif;"+
            "Oblik Bold=OblikBoldRegular;"+
            "Sofia Pro Light=SofiaProLightRegular;"+
            "Symbol=webfontregular;"+
            "Tahoma=tahoma,arial,helvetica,sans-serif;"+
            "Terminal=terminal,monaco;"+
            "Tikal Sans Medium=TikalSansMediumMedium;"+
            "Times New Roman=times new roman,times;"+
            "Trebuchet MS=trebuchet ms,geneva;"+
            "Verdana=verdana,geneva;"+
            "Webdings=webdings;"+
            "Wingdings=wingdings,zapf dingbats"+
            "Aclonica=Aclonica, sans-serif;"+
            "Michroma=Michroma;"+
            "Paytone One=Paytone One, sans-serif;"+
            "Andalus=andalusregular, sans-serif;"+
            "Arabic Style=b_arabic_styleregular, sans-serif;"+
            "Andalus=andalusregular, sans-serif;"+
            "KACST_1=kacstoneregular, sans-serif;"+
            "Mothanna=mothannaregular, sans-serif;"+
            "Nastaliq=irannastaliqregular, sans-serif;"+
            "Samman=sammanregular;";
    tinymce.init({
        selector: '.mytextarea',
        menubar: '',
        language: 'es',
        branding: false,
        statusbar: false,
        plugins: 'lists,link,image,preview,media,visualchars,table,textcolor',
        relative_urls: true,
        remove_script_host: true,
        protocol: 'https',
        toolbar: 'fontselect fontsizeselect | forecolor backcolor | italic bold underline | link | alignleft aligncenter alignright alignjustify | bullist numlist',
        font_formats: tm_fonts,
        media_live_embeds: true,
        fontsize_formats: "8pt 9pt 10pt 11pt 12pt 13pt 14pt 16pt 18pt 20pt 22pt",
        height:200

    });
</script>


