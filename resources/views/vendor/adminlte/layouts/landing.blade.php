<!DOCTYPE html>
<!--
Landing page based on Pratt: http://blacktie.co/demo/pratt/
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }} ">
    <meta name="author" content="Sergi Tur Badenas - acacha.org">

    <meta property="og:title" content="Adminlte-laravel" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Adminlte-laravel - {{ trans('adminlte_lang::message.landingdescription') }}" />
    <meta property="og:url" content="http://demo.adminlte.acacha.org/" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE.png" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x600.png" />
    <meta property="og:image" content="http://demo.adminlte.acacha.org/img/AcachaAdminLTE600x314.png" />
    <meta property="og:sitename" content="demo.adminlte.acacha.org" />
    <meta property="og:url" content="http://demo.adminlte.acacha.org" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@acachawiki" />
    <meta name="twitter:creator" content="@acacha1" />

    <title>{{ trans('adminlte_lang::message.landingdescriptionpratt') }}</title>

    <!-- Custom styles for this template -->
    <link href="{{ asset('/css/all-landing.css') }}" rel="stylesheet">

    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

</head>

<body data-spy="scroll" data-target="#navigation" data-offset="50">

<div id="app" v-cloak>
    <!-- Fixed navbar -->
    <div id="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><b>AllowApp</b></a>
            </div>
            <div class="navbar-collapse collapse">

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    @else
                        <li><a href="/home">{{ Auth::user()->name }}</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>


    <section id="home" name="home">
        <div id="headerwrap">
            <div class="container">
                <div class="row centered">
                    <div class="col-lg-12">
                        <h1> <b>Allow<a href="https://www.allowapp.com">App</a></b></h1>
                        <h3>Sistema de <a href="https://laravel.com/">Protección de Derechos</a>  de imagen</h3>
                        <h3><a href="{{ url('/register') }}" class="btn btn-lg btn-success">Descargar</a></h3>
                    </div>
                    <div class="col-lg-3">
                        <h5>Controla donde se publican las fotos</h5>
                        <p>Gestiona los poseedores de los derechos de imagen</p>
                        <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow1.png') }}">
                    </div>
                    <div class="col-lg-6">
                        <img class="img-responsive" src="{{ asset('/img/allowapp_photo.png') }}" alt="">
                    </div>
                    <div class="col-lg-3">
                        <br>
                        <img class="hidden-xs hidden-sm hidden-md" src="{{ asset('/img/arrow2.png') }}">
                        <h5>Reconocimiento facial!</h5>
                        <p>Tan sencillo como hacer una foto</p>
                    </div>
                </div>
            </div> <!--/ .container -->
        </div><!--/ #headerwrap -->
    </section>



    <section id="showcase" name="showcase">
        <div id="showcase">
            <div class="container">
                <br>
                <br>
                <br>
            </div><!-- /container -->
        </div>
    </section>

    <section id="contact" name="contact">
        <div id="footerwrap">
            <div class="container">
                <div class="col-lg-5">
                    <h3>{{ trans('adminlte_lang::message.address') }}</h3>
                    <p>
                        Paseo de la Castellana 35,<br/>
                        Madrid,<br/>
                        28028<br/>
                        Spain
                    </p>
                </div>

                <div class="col-lg-7">
                    <h3>Si deseas utilizar nuestro sistema escríbenos</h3>
                    <br>
                    <form role="form" action="#" method="post" enctype="plain">
                        <div class="form-group">
                            <label for="name1">{{ trans('adminlte_lang::message.yourname') }}</label>
                            <input type="name" name="Name" class="form-control" id="name1" placeholder="{{ trans('adminlte_lang::message.yourname') }}">
                        </div>
                        <div class="form-group">
                            <label for="email1">{{ trans('adminlte_lang::message.emailaddress') }}</label>
                            <input type="email" name="Mail" class="form-control" id="email1" placeholder="{{ trans('adminlte_lang::message.enteremail') }}">
                        </div>
                        <div class="form-group">
                            <label>{{ trans('adminlte_lang::message.yourtext') }}</label>
                            <textarea class="form-control" name="Message" rows="3"></textarea>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-large btn-success">{{ trans('adminlte_lang::message.submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div id="c">
            <div class="container">
                <p>
                    <a href="https://github.com/acacha/adminlte-laravel"></a><b>AllowApp</b> 2017. Todos los derechos reservados</a>.
                </p>

            </div>
        </div>
    </footer>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ url (mix('/js/app-landing.js')) }}"></script>
<script>
    $('.carousel').carousel({
        interval: 3500
    })
</script>
</body>
</html>
