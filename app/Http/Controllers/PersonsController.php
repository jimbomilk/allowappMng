<?php

namespace App\Http\Controllers;

use App\Group;
use App\Historic;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\EditPersonRequest;
use App\Jobs\PersonFaceUp;
use App\Person;
use App\Location;
use App\Rightholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\Rekognition;
use Larareko\Rekognition\RekognitionFacade;

class PersonsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $group_id  = $request->get('group');
        if (isset($group_id)){
            $set = $request->user()->getPersons($request->get('search'),$group_id)->paginate(15);
        }else{
            $set = $request->user()->getPersons($request->get('search'))->paginate(15);
        }
        $groups = ["Todos los grupos"];
        $groups += $request->user()->getGroups()->pluck('name','id')->toArray();
        return view('common.index', ['searchable' => '1','name' => 'persons', 'set' => $set,'groups'=>$groups,'group'=>$group_id,'arco'=>true]);

    }

    public function sendView(Request $request,$element=null)
    {
        $groups = $request->user()->getGroups()->pluck('name','id');
        if (isset($element)) {
            return view('common.edit', ['name' => 'persons', 'element' => $element,'groups'=>$groups]);
        }
        else
            return view('common.create',['name'=>'persons','groups'=>$groups]);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    protected function photoUp(Request $request,Person $person){
        $file = $request->file('photo');
        //dd($file);
        if(isset($file)) {
            $filename = $person->saveFile($file);

            if (isset($filename)) {
                $person->photo = $filename;
                $person->save();
                $this->dispatch(new PersonFaceUp($person));

            }
        }
    }



    public function store(CreatePersonRequest $request,$location)
    {

        $person = new Person($request->all());
        $person->location_id = $request->get('location');
        //dd($person);


        $this->photoUp($request,$person);

        // Si no es menor damos de alta un rightholder
        /*if (!$person->minor){
            $person->createRightholderPropio();

        }*/
        return redirect('persons');
    }

    public function edit(Request $request,$location,$id)
    {
        $person = Person::find($id);
        if (isset ($person))
        {
            return $this->sendView($request,$person);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('RightholdersController@index',['location'=>$location,'person'=>$id]);

    }


    public function update(EditPersonRequest $request, $location , $id)
    {
        $person = Person::find($id);
        if (isset($person)) {
            //2 casos : cambio de no minor a minor y al reves.

            // Si cambia de no minor a minor hay que eliminar el rightholder propio
            if (!$person->minor && $request->get('minor')==true)
            {
                foreach($person->rightholders as $rh)
                    $rh->delete();
            }
            // Si cambio de minor a no minor hay que crear el righholder propio, pero despues de asignarlo
            $create=false;
            if($person->minor && $request->get('minor')==false){
                $create = true;
            }
            $person->fill($request->all());
            $person->save();

            $this->photoUp($request,$person);


            /*if($create){
                $person->createRightholderPropio();
            }*/

        }
        return redirect('persons');
    }

    public function destroy($location,$id,Request $request)
    {
        $person = Person::findOrFail($id);

        $arco = $request->get('arco');
        if (isset($arco) && $arco){
            $h = new Historic();
            $h->register(Auth::user()->id,"$person->name y todos sus datos han sido eliminados del sistema en aplicación de sus derechos ARCO",null,$person->id,null,true);
        }
        $res = Storage::disk('s3')->delete($person->photopath);
        //dd($res);

        $person->delete();
        $message = $person->name. ' y todos sus datos han sido eliminados';
        if (isset($arco) && $arco)
            $message .= " en aplicación de los derechos ARCO.";
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Person::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }
}
