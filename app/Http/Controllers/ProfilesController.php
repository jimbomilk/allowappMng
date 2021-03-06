<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateRightholderRequest;
use App\Http\Requests\EditProfileRequest;
use App\Http\Requests\EditRightholderRequest;
use App\Location;
use App\Multi;
use App\Person;
use App\Profile;
use App\Rightholder;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }


    public function sendView(Request $req,$element=null)
    {

        $types = Multi::getEnumValues('profiles','type') ;
        unset($types['super']);
        return view('common.edit', ['name' => 'profiles', 'element' => $element,'types'=>$types]);

    }


    public function edit(Request $req,$location,$id)
    {
        $user = User::find($id);
        if (isset ($user))
        {
            return $this->sendView($req,$user->profile);
        }

    }

    public function update(EditProfileRequest $request, $location , $id)
    {

        $profile = Profile::find($id);
        if (isset($profile)) {
            $profile->fill($request->all());
            $profile->location_id= $request->get('location');
            $file = $request->file('avatar');
            $filename = $profile->saveFile($file);
            if (isset($filename))
                $profile->avatar = $filename;
            $profile->save();
        }

        return redirect('users');
    }

}
