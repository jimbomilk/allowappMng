<!doctype html>
<html>
<head>
    @include('layouts.partials.head')
</head>
<body>

<div class="container">
    <div id="main" class="row">

        @yield('content')

    </div>
</div>
<footer class="row">
    @include('layouts.partials.footer')
</footer>
</body>
</html>