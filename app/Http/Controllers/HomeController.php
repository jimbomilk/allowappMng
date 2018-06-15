<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = Auth::user()->links()->paginate(10);
        $this->graph1();
        $this->graph2();
        return view('dashboard.main',['links'=>$links]);
    }

    public function graph1(){
        $tableData = \Lava::DataTable();  // Lava::DataTable() if using Laravel

        $tableData->addDateColumn('Day of Month')
            ->addNumberColumn('Creadas')
            ->addNumberColumn('Enviadas');

        // Random Data For Example
        for ($a = 1; $a < 30; $a++) {
            $tableData->addRow([
                '2018-06-' . $a, rand(800,1000), rand(800,1000)
            ]);
        }

        $chart = \Lava::LineChart('chart1', $tableData,[
            'height'=>300,
            'legend'=>'bottom',
            'title' => 'Imagenes',
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        return $chart;
    }
    public function graph2()
    {

        $finances = \Lava::DataTable();

        $finances->addDateColumn('Year')
            ->addNumberColumn('Enviados')
            ->addNumberColumn('Recibidos')
            ->setDateTimeFormat('Y')
            ->addRow(['2017', 1000, 400])
            ->addRow(['2018', 1170, 460])
            ->addRow(['2019', 660, 1120])
            ->addRow(['2020', 1030, 54]);

        \Lava::ColumnChart('chart2', $finances, [
            'height'=>300,
            'legend'=>'bottom',
            'title' => 'Consentimientos',
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

}
