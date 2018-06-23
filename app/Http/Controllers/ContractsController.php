<?php

namespace App\Http\Controllers;

use App\Contract;
use App\General;
use App\Location;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ContractsController extends Controller
{
    //

    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $photo_id  = $request->get('photo');
        $set=null;

        if (isset($photo_id)){
            $set = Contract::where('photo_id',$photo_id)->get();
        }else{
            $location = Location::find($location_id);
            if (isset($location)) {
                $set = $location->contracts;
            }
        }
        return view('common.index', ['name' => 'contracts', 'set' => $set]);
    }

    public function sendView($element=null)
    {

        if (isset($element)) {
            return view('common.edit', ['name' => 'contracts', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'contracts']);
    }

    public function create()
    {
        return $this->sendView();
    }

    public function store(CreateContractRequest $request,$location)
    {
        $contract = new Contract($request->all());
        $contract->save();

        return redirect('persons');
    }

    public function edit($location,$id)
    {
        $contract = Contract::find($id);
        if (isset ($contract))
        {
            return $this->sendView($contract);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('AcksController@index',['location'=>$location,'contract'=>$id]);

    }


    public function update(EditPersonRequest $request, $location , $id)
    {
        $contract = Contract::find($id);
        if (isset($contract)) {
            $contract->fill($request->all());
            $contract->save();
        }

        return redirect('persons');
    }

    public function destroy($location,$id,Request $request)
    {
        $contract = Contract::findOrFail($id);


        //Storage::disk('s3')->delete($person->path);

        $contract->delete();
        $message = $contract->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Contract::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }
}
