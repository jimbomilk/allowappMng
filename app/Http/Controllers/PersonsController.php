<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\CreatePersonRequest;
use App\Http\Requests\EditPersonRequest;
use App\Person;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\Rekognition;

class PersonsController extends Controller
{
    //

    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $group_id  = $request->get('group');
        $set=null;
        $group = Group::find($group_id);
        if (isset($group)){
            $set = $group->persons;
        }else{
            $set = $request->user()->getPersons();
        }
        return view('common.index', ['name' => 'persons', 'set' => $set]);

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
        $filename = $request->saveFile('photo',$person->path);
        if (isset($filename)) {
            $person->photo = $filename;
            //Borramos las faces
            try{

                \Rekognition::deleteFaces($person->group->collection,array($person->photoId));
            }catch (\Exception $t){};

            try{
                $result= \Rekognition::indexFaces([ 'CollectionId'=>$person->group->collection,
                'DetectionAttributes'=>['DEFAULT'],
                'Image'=>['S3Object'=>[
                    'Bucket'=>env('AWS_BUCKET'),
                    'Name'=>$person->photopath]]]);

                $person->photoId = $result['FaceRecords'][0]['Face']['FaceId'];
                //dd($person->photoId);
            }catch (\Exception $t){};


        }
    }

    public function store(CreatePersonRequest $request,$location)
    {
        $person = new Person($request->all());
        $person->location_id = $request->get('location');
        //dd($person);
        $this->photoUp($request,$person);
        $person->save();
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
            $person->fill($request->all());
            $this->photoUp($request,$person);
            $person->save();
        }
        return redirect('persons');
    }

    public function destroy($location,$id,Request $request)
    {
        $person = Person::findOrFail($id);


        $res = Storage::disk('s3')->delete($person->photopath);
        //dd($res);

        $person->delete();
        $message = $person->name. ' deleted';
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
