<!-- Custom tabs (Charts with tabs)-->
<div class="box box-primary">
    <div class="box-header">
        <i class="fa fa-signal"></i>
        <h3 class="box-title">Gráficas</h3>

    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-sm-6">
        <div id="michart1"></div>
        </div>

        <div class="col-sm-6">
            <div id="michart2"></div>
        </div>
    </div>
</div>

{!!  \Lava::render('LineChart','chart1','michart1') !!}
{!!  \Lava::render('ColumnChart','chart2','michart2') !!}