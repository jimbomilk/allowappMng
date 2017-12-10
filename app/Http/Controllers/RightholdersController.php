<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateRightholderRequest;
use App\Http\Requests\EditRightholderRequest;
use App\Location;
use App\Multi;
use App\Person;
use App\Rightholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RightholdersController extends Controller
{
    //

    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $person_id = $request->get('person');
        $request->session()->put('person_id',$person_id);

        $set = null;

        if(isset($person_id)) {
            $set = Rightholder::where('person_id',$person_id)->get();
        }
        else{
            $location = Location::find($location_id);
            if (isset($location)) {
                $set = $location->rightholders;
            }
        }

        return view('common.index', ['name' => 'rightholders', 'set' => $set,'person_id'=>$person_id]);

    }

    public function sendView(Request $req,$element=null)
    {
        $person_id = $req->session()->get('person_id');
        if (isset($person_id))
            $persons = Person::where('id',$person_id)->pluck('name','id');
        else
            $persons = Person::pluck('name','id');
        $titles = Multi::getEnumValues('rightholders','title') ;
        if (isset($element)) {
            return view('common.edit', ['name' => 'rightholders', 'element' => $element,'titles'=>$titles,'persons'=>$persons]);
        }
        else
            return view('common.create',['name'=>'rightholders','titles'=>$titles,'persons'=>$persons]);
    }

    public function create(Request $req)
    {
        return $this->sendView($req);
    }

    public function store(CreateRightholderRequest $request,$location)
    {
        $rightholder = new Rightholder($request->all());
        $rightholder->location_id= $request->get('location');
        $rightholder->save();

        return redirect('rightholders');
    }

    public function edit(Request $req,$location,$id)
    {
        $rightholder = Rightholder::find($id);
        if (isset ($rightholder))
        {
            return $this->sendView($req,$rightholder);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('RightholdersController@index',['location'=>$location,'rightholder'=>$id]);

    }


    public function update(EditRightholderRequest $request, $location , $id)
    {

        $rightholder = Rightholder::find($id);
        if (isset($rightholder)) {
            $rightholder->fill($request->all());
            $rightholder->location_id= $request->get('location');
            $rightholder->save();
        }

        return redirect('rightholders');
    }

    public function destroy($location,$id,Request $request)
    {
        $rightholder = Rightholder::findOrFail($id);


        //Storage::disk('s3')->delete($rightholder->path);

        $rightholder->delete();
        $message = $rightholder->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Rightholder::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }
}
