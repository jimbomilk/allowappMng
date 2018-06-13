<?php

namespace App\Http\Controllers;

use App\ExcelImport;
use App\IntermediateExcel1;
use App\IntermediateExcel2;
use App\IntermediateExcel3;
use App\Location;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{

    public function index(Request $request,$location,$locationId)
    {
        $excels = ExcelImport::where('location_id',$locationId)->get();
        $persons = IntermediateExcel1::where('location_id',$locationId)->get();
        $rightholders = IntermediateExcel2::where('location_id',$locationId)->get();
        $sites = IntermediateExcel3::where('location_id',$locationId)->get();
        return view('excel.show',['name'=>'excel','excels'=>$excels,'persons'=>$persons,'rightholders'=>$rightholders,'sites'=>$sites]);
    }

    public function create(Request $request){

        return view('excel.create');
    }

    public function import(Request $request, $location){
        //validate the xls file
        $this->validate($request, array(
            'file'      => 'required'
        ));
        $loc = Location::where('name',$location)->first();

        if($request->hasFile('file')){
            $path = pathinfo($request->file->getClientOriginalName());
            if ($path['extension'] == "xlsx" || $path['extension'] == "xls" || $path['extension'] == "csv") {

                $path = $request->file->getRealPath();
                $data = Excel::load($path, function($reader) {
                })->get();
                if(!empty($data) && $data->count()){
                    $insertSitesRes = false;
                    $insertPersonsRes = false;
                    $insertRightholdersRes = false;

                    foreach ($data as $page) {

                        if (strpos(strtolower($page->getTitle()),"publicar")!==false){
                            $insertSitesRes = $this->processSites($page,$loc);
                        }

                        else if (strpos(strtolower($page->getTitle()),"personas")!==false){
                            $insertPersonsRes = $this->processPersons($page,$loc);
                        }
                        else if (strpos(strtolower($page->getTitle()),"responsables")!==false){
                            $insertRightholdersRes = $this->processRightholders($page,$loc);
                        }
                    }
                }

                if ($insertSitesRes && $insertPersonsRes && $insertRightholdersRes) {
                    $url = $request->input('url');
                    return redirect($url)->with('success', 'Se ha completado la 1ª fase de la importación satisfactoriamente.');
                }else {
                    Session::flash('error', 'Error insertando datos...');
                }
                return back();


            }else {
                Session::flash('error', 'La extensión '.$path['extension'].' del fichero es incorrecta!! Por favor elija un tipo de fichero valido: xls o csv');
                return back();
            }
        }
    }


    private function processSites($page,$location){
        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertSites[] = [
                    'site_code' => $index + 1,
                    'site_name' => $row->nombre,
                    'site_url' => $row->web,
                    'site_group' => strtoupper($row->grupo),
                    'location_id' => $location->id
                ];
            }
        }

        if(!empty($insertSites)){
            DB::delete('delete from intermediate_excel_3 where location_id='.$location->id);
            return DB::table('intermediate_excel_3')->insert($insertSites);
        }
        return false;
    }


    private function processPersons($page,$location){

        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertPersons[] = [
                    'person_code' => strtoupper($row->codigo),
                    'person_group' => strtoupper($row->grupo),
                    'person_name' => $row->nombre,
                    'person_minor' => strtoupper($row->menor),
                    'person_dni' => strtoupper($row->documento),
                    'person_phone' => $row->telefono,
                    'person_email' => $row->email,
                    'person_photo_name' => $row->foto,
                    'location_id' => $location->id
                ];
            }
        }

        if(!empty($insertPersons)){
            DB::delete('delete from intermediate_excel_1 where location_id='.$location->id);
            return DB::table('intermediate_excel_1')->insert($insertPersons);
        }
        return false;
    }

    private function processRightholders($page,$location){

        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertRightholders[] = [

                    'rightholder_code' => strtoupper($row->codigo),
                    'rightholder_person_code' => strtoupper($row->codigo_de_persona),
                    'rightholder_name' => $row->nombre,
                    'rightholder_relation' => strtoupper($row->relacion),
                    'rightholder_email' => $row->email,
                    'rightholder_phone' => $row->telefono,
                    'rightholder_documentId' => strtoupper($row->documento),
                    'location_id' => $location->id
                ];
            }
        }



        if(!empty($insertRightholders)){
            DB::delete('delete from intermediate_excel_2 where location_id='.$location->id);
            return DB::table('intermediate_excel_2')->insert($insertRightholders);
        }
        return false;
    }

}
