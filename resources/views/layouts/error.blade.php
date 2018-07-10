<!doctype html>
<html>
<head>
    @include('layouts.partials.head')
</head>
<body>

<div class="container">
    <header class="row">
        @include('layouts.partials.header_error')
    </header>
    <div id="main" class="row">

        @yield('content')

    </div>
</div>
<footer class="row">
    @include('layouts.partials.footer')
</footer>
</body>
</html>