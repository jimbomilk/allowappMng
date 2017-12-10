<?php

namespace App\Http\Controllers;

use App\General;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\EditUserRequest;
use App\Location;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }


    public function index(Request $request)
    {

        $location_id  = $request->get('location');
        $location = Location::find($location_id);

        if (isset($location)) {
            $users = User::whereIn('id',$location->profiles->pluck('user_id'))->paginate();
            //dd($location->profiles);
            return view('common.index', [ 'name' => 'users', 'set' => $users]);
        }

        return abort(404,'Operación no autorizada');
    }

    public function sendView($element=null)
    {

        if (isset($element)) {
            return view('common.edit', ['name' => 'users', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'users']);
    }

    public function create()
    {
        return $this->sendView();
    }

    public function store(CreateUserRequest $request,$location)
    {
        $user = new User($request->all());
        $user->location_id=$request->get('location');
        $user->save();

        // Además del usuario hay que crear su profile
        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->location_id = $request->get('location');
        $profile->save();

        return redirect('users');
    }

    public function edit($location,$id)
    {
        $user = User::find($id);
        if (isset ($user))
        {
            return $this->sendView($user);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('ProfilesController@edit',['location'=>$location,'user_id'=>$id]);
    }


    public function update(EditUserRequest $request, $location , $id)
    {
        $user = User::find($id);
        if (isset($user)) {
            $user->fill($request->all());
            $user->save();
        }

        return redirect('users');
    }

    public function destroy($location,$id,Request $request)
    {
        $user = User::findOrFail($id);


        Storage::disk('s3')->deleteDirectory($user->path);

        $user->delete();
        $message = $user->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => User::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect('users');
    }
}
