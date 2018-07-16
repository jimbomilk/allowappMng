<?php

namespace App\Http\Controllers;
use App\Location;
use App\Status;
use App\Task;
use Carbon\Carbon;
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
    public function index(Request $request,$location)
    {
        $photos = Auth::user()->getPhotos()->paginate(12);
        $tasks = Task::all()->where('done',0)->whereIn('group_id', Auth::user()->getGroups()->pluck('id'))->sortBy('priority');


        $loc = Location::byName($location);
        $this->graph1($loc);
        foreach($loc->consents as $consent){
            $this->graph2($loc,$consent);
        }

        return view('dashboard.main',['photos'=>$photos,'tasks'=>$tasks,'consents'=>$loc->consents]);
    }

    public function graph1($loc){
        $tableData = \Lava::DataTable();  // Lava::DataTable() if using Laravel
        $tableData->addDateColumn('Day');

        $datas = Auth::user()->getPhotos()->get()->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
        //dd($datas);

        foreach($loc->consents as $consent){
            $tableData->addNumberColumn($consent->description);
        }

        $tableData->setDateTimeFormat('Y-m-d');

        foreach($datas as $key=>$value){
            $values = $value->groupBy('consent_id');
            $output = [$key];
            foreach($values as $key=>$data){
                $output[] = count($data);
            }
            //dd($output);
            $tableData->addRow($output);
        }



        $chart = \Lava::LineChart('chart1', $tableData,[
            'height'=>300,
            'legend'=>'bottom',
            'title' => 'Imagenes por consentimiento',
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);

        return $chart;
    }
    public function graph2($loc,$consent)
    {
        $consentimientos = \Lava::DataTable();
        $consentimientos->addStringColumn('Desc')
            ->addNumberColumn('Values');


        $datas = Auth::user()->getRightholderConsents($consent->id)->groupBy('status');
        $output = [];
        $total = 0;
        foreach($datas as $key=>$data){
            $output[] = [Status::descRH($key),count($data)];
            $total +=  count($data);
        }


        //dd($output);
        foreach ($output as $out){
            $consentimientos->addRow($out);
        }



        //dd($datas);


        \Lava::DonutChart('chartConsent'.$consent->id, $consentimientos, [
            'height'=>150,
            'legend'=>'bottom',
            'title' => 'Ambito '.$consent->description,
            'titleTextStyle' => [
                'color' => '#eb6b2c',
                'fontSize' => 14
            ]
        ]);
    }

}
