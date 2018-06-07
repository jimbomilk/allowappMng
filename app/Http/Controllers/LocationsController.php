<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateLocationRequest;
use App\Http\Requests\CreateRightholderRequest;
use App\Http\Requests\EditLocationRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\EditRightholderRequest;
use App\Location;
use App\Multi;
use App\Person;
use App\Profile;
use App\Rightholder;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\RekognitionFacade;

class LocationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super');
    }

    public function index(Request $request)
    {
        $set=Location::all();
        return view('common.index', ['name' => 'locations', 'set' => $set]);
    }

    public function sendView(Request $req,$element=null)
    {
        if (isset($element)) {
            return view('common.edit', ['name' => 'locations', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'locations']);

    }


    public function edit(Request $req,$id)
    {
        $location = Location::find($id);
        if (isset ($location))
        {
            return $this->sendView($req,$location);
        }

    }

    public function create(Request $req)
    {
        return $this->sendView($req);
    }

    public function store(CreateLocationRequest $request,$location)
    {
        $location = new Location($request->all());
        $location->save();

        return redirect('locations');
    }

    public function update(EditLocationRequest $request, $loc , $id)
    {

        $location = Location::find($id);
        if (isset($location)) {
            $location->fill($request->all());
            $location->save();
        }

        return redirect('locations');
    }

    public function show($location,$collectionId=null)
    {
        $faces  = null;
        $collections = RekognitionFacade::ListCollections();
        $lugar = Location::find($location);
        //dd($collections);
        if (count($collections['CollectionIds'])>0 && isset($collectionId)) {
            try {
                $faces = RekognitionFacade::ListFaces($collectionId, 4096);
            }catch (Exception  $t){}
            //dd($faces);
        }
        return view('locations.show', ['name' => 'locations','location'=>$lugar,'set' => $collections,'collectionSel'=>$collectionId, 'faces'=> $faces]);

    }
    public function deleteCollection($location,$collectionId)
    {
        RekognitionFacade::DeleteCollection($collectionId);

        return redirect()->back();
    }


    public function destroy($id,Request $request)
    {
        $location = Location::findOrFail($id);


        Storage::disk('s3')->deleteDirectory($location->path);

        $location->delete();
        $message = $location->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Location::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }

}
