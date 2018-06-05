<?php

namespace App\Http\Controllers;

use App\Person;
use App\Photo;
use App\Rightholder;
use Illuminate\Http\Request;

class HistoricController extends Controller
{
    //
    public function indexPersons(Request $request)
    {
        $set = $request->user()->getPersons($request->get('search'));


        return view('common.index', ['searchable' => '1', 'name' => 'historic.persons','hide_new'=>'true', 'set' => $set]);
    }

    public function indexPhotos(Request $request)
    {
        $set = $request->user()->getPhotos($request->get('search'));
        return view('common.index', ['searchable' => '1', 'name' => 'historic.photos', 'hide_new' => 'true', 'set' => $set]);
    }

    public function indexRightholders(Request $request)
    {
        $set = $request->user()->getRightholders($request->get('search'));
        return view('common.index', ['searchable' => '1', 'name' => 'historic.rightholders','hide_new'=>'true', 'set' => $set]);
    }

    public function showRightholder($location,$id)
    {
        $element = Rightholder::find($id);
        return view('historic.rightholders.show', ['name' => 'historic.rightholders.show', 'element' => $element]);
    }

    public function showPhoto($location,$id)
    {
        $element = Photo::find($id);
        return view('historic.photos.show', ['name' => 'historic.photo.show', 'element' => $element]);
    }

    public function showPerson($location,$id)
    {
        $element = Person::find($id);
        return view('historic.persons.show', ['name' => 'historic.person.show', 'element' => $element]);
    }
}
