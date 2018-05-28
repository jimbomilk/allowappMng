<!doctype html>
<html>
<head>
    @include('layouts.partials.head')
</head>
<body>
<div class="container">

    <header class="row">
        @include('layouts.partials.header')
    </header>

    <div id="main" class="row">

        @yield('content')

    </div>

    <footer class="row">
        @include('layouts.partials.footer')
    </footer>

</div>
</body>
</html>