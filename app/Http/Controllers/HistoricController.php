<?php

namespace App\Http\Controllers;

use App\Mail\PersonEmail;
use App\Person;
use App\Photo;
use App\Rightholder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
        $destinatarios = implode(",",$element->rightholderphotos->pluck('rhemail')->toArray());


        return view('historic.photos.show', ['name' => 'historic.photo.show', 'element' => $element,'destinatarios'=>$destinatarios]);
    }

    public function showPerson($location,$id)
    {
        $element = Person::find($id);
        $destinatarios = implode(",",$element->rightholders->pluck('email')->toArray());
        if (isset($element->email) && $element->email!=""){
            $destinatarios .=",";
            $destinatarios .=$element->email;
        }

        return view('historic.persons.show', ['name' => 'historic.person.show', 'element' => $element,'destinatarios'=>$destinatarios]);
    }

    public function emailsPerson(Request $req,$location)
    {
        //return json_encode($req->all());
        $person = Person::find($req->get('personId'));
        $to = $req->get('to');
        $title = $req->get('title');
        $email_text = $req->get('email');
        //Log::debug('antes email');
        $count=0;

        try {
            if (isset($person) ) {
                Mail::to($to)->queue(new PersonEmail($person,$title, $email_text, $req->user()->email));
                //Log::debug('email:'.$ret);
                $count++;
            }

        }catch (Exception $e){
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
            return redirect()->back();
        }

        if ($count >0)
            Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails.");
        else {
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde.");
            return redirect()->back();
        }


        return redirect('historic/persons');

    }

    public function emailsPhoto(Request $req,$location)
    {}

    public function emailsRightholder(Request $req,$location)
    {}

}
