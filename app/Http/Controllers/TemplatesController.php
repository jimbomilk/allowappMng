<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTemplateRequest;
use App\Http\Requests\EditTemplateRequest;
use App\Location;
use App\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TemplatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index(Request $request)
    {
        $location_id  = $request->get('location');

        $set=null;
        $location = Location::find($location_id);
        if (isset($location)) {
            $set = $location->templates;
        }

        return view('common.index', ['name' => 'templates', 'set' => $set]);
    }

    public function sendView(Request $request,$element=null)
    {
        if (isset($element)) {
            return view('common.edit', ['name' => 'templates', 'element' => $element]);
        }
        else
            return view('common.create',['name'=>'templates']);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    public function store(CreateTemplateRequest $request,$location)
    {
        try {
            $template = new Template($request->all());
            $template->location_id = $request->get('location');
            $template->save();
        }catch (\Illuminate\Database\QueryException $e){
            return false;
        }
        return redirect('templates');
    }

    public function edit($location,$id)
    {
        $template = Template::find($id);
        if (isset ($template))
        {
            return $this->sendView($template);
        }

    }

    public function update(EditTemplateRequest $request, $location , $id)
    {
        $template = Template::find($id);
        if (isset($consent)) {
            $template->fill($request->all());
            $template->save();
        }

        return redirect('consents');
    }

    public function destroy($location,$id)
    {
        $template = Template::findOrFail($id);
        $template->delete();
        $message = 'Template: ' .$template->description. ' borrado';
        Session::flash('message',$message);
        return redirect('templates');
    }

}
