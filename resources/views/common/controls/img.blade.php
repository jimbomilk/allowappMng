@if (!isset($src))
    <img class="center-block" style="width: 20%" class="img-responsive" src={{('/img/allowapp400x100.png')}} alt="imagen">
@else
    <img class="center-block" style="width: 20%" class="img-responsive" src={{$src}} alt="imagen">
@endif