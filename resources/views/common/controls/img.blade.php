@if (!isset($src))
    <img class="img-responsive" src={{('/img/allowapp400x100.png')}} alt="imagen">
@else
    <img class="img-responsive" src={{$src}} alt="imagen">
@endif