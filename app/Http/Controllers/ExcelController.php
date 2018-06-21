<?php

namespace App\Http\Controllers;

use App\ExcelImport;
use App\Group;
use App\IntermediateExcel1;
use App\IntermediateExcel2;
use App\IntermediateExcel3;
use App\Location;
use App\Person;
use App\Publicationsite;
use App\Rightholder;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;


class ExcelController extends Controller
{

    public function index(Request $request,$location,$locationId)
    {
        $excels = ExcelImport::where('location_id',$locationId)->get();
        $persons = IntermediateExcel1::where('location_id',$locationId)->get();
        $rightholders = IntermediateExcel2::where('location_id',$locationId)->get();
        $sites = IntermediateExcel3::where('location_id',$locationId)->get();

        $current_import = isset($excels->last()->id)?$excels->last()->id:0;

        return view('excel.show',['name'=>'excel','excels'=>$excels,'persons'=>$persons,'rightholders'=>$rightholders,'sites'=>$sites,'current_import'=>$current_import]);
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

                    // Creamos una entrada en la tabla de importaciones
                    $import = new ExcelImport();
                    $import->user_id = $request->user()->id;
                    $import->location_id = $loc->id;
                    $import->save();

                    foreach ($data as $page) {

                        if (strpos(strtolower($page->getTitle()),"publicar")!==false){
                            $insertSitesRes = $this->processSites($import->id,$page,$loc);
                        }

                        else if (strpos(strtolower($page->getTitle()),"personas")!==false){
                            $insertPersonsRes = $this->processPersons($import->id,$page,$loc);
                        }
                        else if (strpos(strtolower($page->getTitle()),"responsables")!==false){
                            $insertRightholdersRes = $this->processRightholders($import->id,$page,$loc);
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

    public function importPhoto(Request $request,$location){
        $photo = $request->get('file');
        $name = $request->get('name');
        $importId = $request->get('importId');
        $loc = Location::where('name',$location)->first();

        $img = Image::make($photo);

        $filename = 'locations/location'.$loc->id.'/imports/import'. $importId. '/' . $name;
        if (Storage::disk('s3')->put($filename, $img->stream()->__toString(),'public')) {
            $fileUrl= ( Storage::disk('s3')->url($filename));

            // busco la imagen en las personas
            $importPerson = IntermediateExcel1::where('person_photo_name',$name)->first();
            if (isset($importPerson)) {
                $importPerson->person_photo_path = $fileUrl;
                $importPerson->save();
            }
        }

    }

    public function importsites(Request $request,$location)
    {
        $loc = Location::byName($location);
        //Vamos a recorrer cada entry y ejecutamos un insert o un update
        $sites2import = IntermediateExcel3::where('location_id',$loc->id)->get();
        $groups =array_unique(IntermediateExcel3::where('location_id',$loc->id)->pluck('site_group')->toArray());
        //1º insertamos los grupos
        foreach($groups as $group){
            $group = Group::firstOrCreate(
                ['user_id'=>$request->user()->id,'location_id'=>$loc->id,'name'=>$group]);

        }
        //2º insertamos los sites
        foreach($sites2import as $site){
            $site->status='ko';
            $check_status=true;
            $title="uuu";
            foreach($site->getAttributes() as $key=>$value){
                if ($key!="status")
                    $check_status = $check_status && $site->check($key,$value,$title);
            }

            $group = Group::where('name',$site->site_group)->first();
            if (isset($group)&&$check_status) {
                Publicationsite::firstOrCreate([
                'name' => $site->site_name,'url' => $site->site_url,'group_id' => $group->id]);
                $site->status='ok';
            }
            $site->save();
        }

    }

    public function importpersons(Request $request,$location)
    {

        $loc = Location::byName($location);

        //Vamos a recorrer cada entry y ejecutamos un insert o un update
        $persons2import = IntermediateExcel1::where('location_id',$loc->id)->get();

        foreach($persons2import as $person) {
            $person->status = 'ko';
            $check_status = true;
            $title = "uuu";
            foreach ($person->getAttributes() as $key => $value) {
                if ($key!="status")
                    $check_status = $check_status && $person->check($key, $value, $title);
            }

            $group = Group::where('name',$person->person_group)->first();
            if (isset($group)&&$check_status) {
                $insertPerson = Person::firstOrNew([
                    'name' => $person->person_name,
                    'location_id' => $loc->id,
                    'group_id' => $group->id]);
                $insertPerson->code = $person->person_code;
                $insertPerson->minor = ($person->person_minor == "SI"||$person->person_minor=="")?1:0;
                $filename = $insertPerson->path."/".$person->person_photo_name . Carbon::now();

                if (Storage::disk('s3')->copy($person->photopath,$filename,'public')){
                    $insertPerson->photo = Storage::disk('s3')->url($filename);
                }
                $insertPerson->documentId = $person->person_dni;
                $insertPerson->email = $person->person_email;
                $insertPerson->phone = $person->person_phone;

                $insertPerson->faceUp();
                //dd($insertPerson);
                $insertPerson->save();

                if (!$insertPerson->minor)
                    $insertPerson->createRightholderPropio();

                $person->status='ok';
            }
            $person->save();
        }


    }

    public function importrightholders(Request $request,$location)
    {
        $loc = Location::byName($location);
        //Vamos a recorrer cada entry y ejecutamos un insert o un update
        $rh2import = IntermediateExcel2::where('location_id',$loc->id)->get();

        foreach($rh2import as $rh) {
            $rh->status = 'ko';
            $check_status = true;
            $title = "uuu";
            foreach ($rh->getAttributes() as $key => $value) {
                if ($key!="status")
                    $check_status = $check_status && $rh->check($key, $value, $title);
            }

            $person = Person::where('code',$rh->rightholder_person_code)->first();
            if (isset($person)&&$check_status) {
                $insertRh = Rightholder::firstOrNew([
                    'name' => $rh->rightholder_name,
                    'location_id'=>$loc->id,
                    'person_id' => $person->id,
                    'email' => $rh->rightholder_email]);
                $insertRh->relation = $rh->rightholder_relation;
                $insertRh->documentId = $rh->rightholder_documentId;
                $insertRh->phone = $rh->rightholder_phone;

                $insertRh->save();
                $rh->status='ok';
            }
            $rh->save();
        }
    }

    private function processSites($importId,$page,$location){
        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertSites[] = [
                    'import_id' => $importId,
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


    private function processPersons($importId,$page,$location){

        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertPersons[] = [
                    'import_id' => $importId,
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

    private function processRightholders($importId,$page,$location){

        foreach($page as $index=>$row) {
            if ($row->nombre != "") {
                $insertRightholders[] = [
                    'import_id' => $importId,
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
