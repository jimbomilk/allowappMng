<?php

namespace App\Http\Controllers;

use App\Ack;
use App\Contract;
use App\General;
use App\Http\Requests\CreateAckRequest;
use App\Http\Requests\EditAckRequest;
use App\Location;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class AcksController extends Controller
{
    //

    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $contract_id  = $request->get('contract');
        $set=null;


        if (isset($contract_id)){
            $set = Ack::where('contract_id',$contract_id)->get();
        }
        return view('common.index', ['name' => 'acks', 'set' => $set]);
    }

    public function sendView($element=null)
    {

        if (isset($element)) {
            return view('common.edit', ['name' => 'acks', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'acks']);
    }

    public function create()
    {
        return $this->sendView();
    }

    public function store(CreateAckRequest $request,$location)
    {
        $ack = new Ack($request->all());
        $ack->save();

        return redirect('persons');
    }

    public function edit(EditAckRequest $request,$location,$id)
    {
        $ack = Ack::find($id);
        if (isset ($ack))
        {
            //recoger la photo
            $photo = $ack->contract->photo;


            $img = Image::make($photo->photo);
            $img->pixelate(12);
            //$img->save('./public/img/temp.jpg');
            $filename = $request->saveImage('photo',$ack->path,$img->stream()->__toString(),'jpg');
            if (isset($filename)){
                $ack->photo = $filename;
                $ack->save();
            }

            return $this->sendView($ack);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('AcksController@index',['location'=>$location,'contract'=>$id]);

    }


    public function update(EditAckRequest $request, $location , $id)
    {
        $ack = Ack::find($id);
        if (isset($ack)) {
            $ack->fill($request->all());
            $ack->save();
        }

        return redirect('photos');
    }

    public function destroy($location,$id,Request $request)
    {
        $ack = Ack::findOrFail($id);


        //Storage::disk('s3')->delete($person->path);

        $ack->delete();
        $message = $ack->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Ack::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }
}
