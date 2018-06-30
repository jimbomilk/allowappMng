<?php

namespace App\Http\Controllers;

use App\Location;
use App\Mail\PersonEmail;
use App\Mail\PhotoEmail;
use App\Mail\RightholderEmail;
use App\Person;
use App\Photo;
use App\Rightholder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class HistoricController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:user');
    }

    public function indexPersons(Request $request)
    {
        $set = $request->user()->getPersons($request->get('search'))->get();
        return view('common.index', ['searchable' => '1', 'name' => 'historic.persons','hide_new'=>'true', 'set' => $set]);
    }

    public function indexPhotos(Request $request)
    {
        $set = $request->user()->getPhotos($request->get('search'));
        return view('common.index', ['searchable' => '1', 'name' => 'historic.photos', 'hide_new' => 'true', 'set' => $set]);
    }

    public function indexRightholders(Request $request)
    {
        $set = $request->user()->getRightholders($request->get('search'))->get();
        return view('common.index', ['searchable' => '1', 'name' => 'historic.rightholders','hide_new'=>'true', 'set' => $set]);
    }

    public function showRightholder($location,$id)
    {
        $element = Rightholder::find($id);
        $location = Location::where('name',$location)->first();
        if(isset($location)){
            $consents = $location->consents;
        }

        return view('historic.rightholders.show', ['name' => 'historic.rightholders.show', 'element' => $element,'consents'=>$consents]);
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

        $location = Location::where('name',$location)->first();
        if(isset($location)){
            $consents = $location->consents;
        }
        return view('historic.persons.show', ['name' => 'historic.person.show', 'element' => $element,'destinatarios'=>$destinatarios,'consents'=>$consents]);
    }

    public function emailsPerson(Request $req,$location)
    {
        //return json_encode($req->all());
        $loc = Location::byName($location);
        $person = Person::find($req->get('personId'));
        $to = $req->get('to');

        $emailsTo = explode(",",$to);

        $title = $req->get('title');
        $email_text = $req->get('email');
        $count=0;

        foreach($emailsTo as $emailTo){

            try {
                if (isset($person) ) {
                    Mail::to($emailTo)->queue(new PersonEmail($person,$title, $email_text, $req->user()->email,$loc->consents));
                    //Log::debug('email:'.$ret);
                    $count++;
                }

            }catch (Exception $e){
                Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
                return redirect()->back();
            }
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
    {
        //return json_encode($req->all());
        $photo = Photo::find($req->get('photoId'));
        $to = $req->get('to');
        $title = $req->get('title');
        $email_text = $req->get('email');
        //Log::debug('antes email');
        $count=0;

        $emailsTo = explode(",",$to);
        foreach($emailsTo as $emailTo) {
            try {
                if (isset($photo)) {
                    Mail::to($emailTo)->queue(new PhotoEmail($photo, $title, $email_text, $req->user()->email));
                    //Log::debug('email:'.$ret);
                    $count++;
                }

            } catch (Exception $e) {
                Session::flash('message', "¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:" . $e->getMessage());
                return redirect()->back();
            }
        }
        if ($count >0)
            Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails.");
        else {
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde.");
            return redirect()->back();
        }


        return redirect('historic/photos');


    }

    public function emailsRightholder(Request $req,$location)
    {
        //return json_encode($req->all());
        $rh = Rightholder::find($req->get('rightholderId'));
        $loc = Location::byName($location);
        $to = $req->get('to');
        $title = $req->get('title');
        $email_text = $req->get('email');
        //Log::debug('antes email');
        $count=0;

        $emailsTo = explode(",",$to);
        foreach($emailsTo as $emailTo) {
            try {
                if (isset($rh)) {
                    Mail::to($emailTo)->queue(new RightholderEmail($rh, $title, $email_text, $req->user()->email,$loc->consents));
                    //Log::debug('email:'.$ret);
                    $count++;
                }

            } catch (Exception $e) {
                Session::flash('message', "¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:" . $e->getMessage());
                return redirect()->back();
            }
        }
        if ($count >0)
            Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails.");
        else {
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde.");
            return redirect()->back();
        }


        return redirect('historic/rightholders');



    }

}
