<?php

namespace App\Http\Controllers;

use App\Consent;
use App\Http\Requests\CreateConsentRequest;
use App\Http\Requests\EditConsentRequest;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class ConsentController extends Controller
{
    public function index(Request $request)
    {
        $location_id  = $request->get('location');

        $set=null;
        $location = Location::find($location_id);
        if (isset($location)) {
            $set = $location->consents;
        }

        return view('common.index', ['name' => 'consents', 'set' => $set]);
    }

    public function sendView($element=null)
    {

        if (isset($element)) {
            return view('common.edit', ['name' => 'consents', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'consents']);
    }

    public function create()
    {
        return $this->sendView();
    }

    public function store(CreateConsentRequest $request,$location)
    {
        try {
            $consent = new Consent($request->all());
            $consent->location_id = $request->get('location');
            $consent->save();
        }catch (\Illuminate\Database\QueryException $e){
            dd('hola');
            return false;
        }
        return redirect('consents');
    }

    public function edit($location,$id)
    {
        $consent = Consent::find($id);
        if (isset ($consent))
        {
            return $this->sendView($consent);
        }

    }

    public function update(EditConsentRequest $request, $location , $id)
    {
        $consent = Consent::find($id);
        if (isset($consent)) {
            $consent->fill($request->all());
            $consent->save();
        }

        return redirect('consents');
    }

    public function destroy($location,$id)
    {
        $consent = Consent::findOrFail($id);
        $consent->delete();
        $message = 'Consentimiento: ' .$consent->description. ' borrado';
        Session::flash('message',$message);
        return redirect('consents');
    }
}
