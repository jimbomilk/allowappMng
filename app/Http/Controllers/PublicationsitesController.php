<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateGroupRequest;
use App\Http\Requests\CreatePublicationsiteRequest;
use App\Http\Requests\EditGroupRequest;
use App\Http\Requests\EditPublicationsiteRequest;
use App\Location;
use App\Group;
use App\Profile;
use App\Publicationsite;
use App\User;
use Illuminate\Support\Facades\Config;
use Share;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PublicationsitesController extends Controller
{

    public function index(Request $request,$location,$group_id=null)
    {
        if (isset($group_id))
            $request->session()->put('group_id',$group_id);
        else
            $group_id = $request->session()->get('group_id');
        $group = Group::find($group_id);

        return view('common.index', [ 'name' => 'publicationsites', 'set' => $group->publicationsites]);

    }

    public function sendView(Request $request,$element=null)
    {
        $services = array_keys(Config::get('social-share.services'));
        if (isset($element)) {
            $val = array_search ($element->name,$services);
            return view('common.edit', ['name' => 'publicationsites', 'element' => $element,'services'=>$services,'selected'=>$val]);
        }
        else
            return view('common.create',['name'=>'publicationsites','services'=>$services]);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    public function store(CreatePublicationsiteRequest $request,$location)
    {
        $services = array_keys(Config::get('social-share.services'));
        $psite = new Publicationsite($request->all());
        $group_id = $request->session()->get('group_id');
        $psite->name=$services[$request->get('name')];
        $psite->group_id=$group_id;
        $psite->save();

        return redirect('publicationsites');
    }

    public function edit(Request $request,$location,$id)
    {

        $psite = Publicationsite::find($id);
        if (isset ($psite))
        {
            return $this->sendView($request,$psite);
        }

    }



    public function update(EditPublicationsiteRequest $request, $location , $id)
    {
        $services = array_keys(Config::get('social-share.services'));
        $psite = Publicationsite::find($id);
        if (isset($psite)) {
            $psite->fill($request->all());
            $group_id = $request->session()->get('group_id');
            $psite->group_id=$group_id;
            $psite->name=$services[$request->get('name')];
            $psite->save();
        }

        return redirect('publicationsites');
    }

    public function destroy($location,$id,Request $request)
    {
        $psite = Publicationsite::findOrFail($id);
        $psite->delete();
        $message = $psite->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Publicationsite::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect('publicationsites');
    }
}
