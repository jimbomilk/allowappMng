<!-- Custom tabs (Charts with tabs)-->
<div class="col-sm-6">
<div id="michart1"></div>
</div>

<div class="col-sm-6">
    <div id="michart2"></div>
</div>

{!!  \Lava::render('LineChart','chart1','michart1') !!}
{!!  \Lava::render('ColumnChart','chart2','michart2') !!}