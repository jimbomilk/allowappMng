<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\EditGroupRequest;
use App\Location;
use App\Group;
use App\Profile;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class GroupsController extends Controller
{
    //

    public function index(Request $request)
    {
        return view('common.index', [ 'name' => 'groups','hide_new'=>!$request->user()->checkRole('admin'), 'set' => $request->user()->getGroups()]);
    }

    public function sendView(Request $request,$element=null)
    {
        $tutors = $request->user()->getGroupTutors()->pluck('name','id');
        if (isset($element)) {
            return view('common.edit', ['name' => 'groups', 'element' => $element,'tutors'=>$tutors]);
        }
        else
            return view('common.create',['name'=>'groups','tutors'=>$tutors]);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }



    protected function groupAWSDown($group){
        try {
            //dd($group->path);
            Storage::disk('s3')->deleteDirectory($group->path);
            \Rekognition::deleteCollection($group->collection);
        }catch(Exception  $t){}
    }

    public function store(CreateGroupRequest $request,$location)
    {
        $group = new Group($request->all());
        //$group->user_id = $request->get('user_id');
        $group->location_id = $request->get('location');
        $group->save();



        return redirect('groups');
    }

    public function edit(Request $request,$location,$id)
    {
        $group = Group::find($id);
        if (isset ($group))
        {
            return $this->sendView($request,$group);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('PersonsController@index',['location'=>$location,'group'=>$id]);

    }


    public function update(EditGroupRequest $request, $location , $id)
    {
        $group = Group::find($id);
        if (isset($group)) {
            $group->fill($request->all());
            $group->save();
        }

        return redirect('groups');
    }

    public function destroy($location,$id,Request $request)
    {
        $group = Group::findOrFail($id);

        $this->groupAWSDown($group);

        $group->delete();
        $message = $group->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Group::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect('groups');
    }
}
