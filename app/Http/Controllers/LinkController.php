<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Http\Requests\LinkPhotoRequest;
use App\Person;
use App\Photo;
use App\PhotoData;
use App\Photonetwork;
use App\Publicationsite;
use App\Rightholder;
use App\RightholderConsent;
use App\RightholderPhoto;
use App\Status;
use App\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LinkController extends Controller
{

    public function link($photoId,$userId,$personId,$rightholderId,$token)
    {
        $resToken = Token::generate($photoId,$userId,$personId,$rightholderId);

        if (hash_equals($resToken,$token)) {
            $photo = Photo::find($photoId);
            $person = Person::find($personId);
            if (isset($photo)) {
                $sharing = $photo->getData('sharing');
                return view('pages.photo', ['name' => 'response', 'photo' => $photo, 'url'=>$photo->url , 'user_id' => $userId, 'person_id' => $person->id, 'person_name' => $person->name, 'rightholder_id' => $rightholderId, 'sh' => $sharing, 'token' => $token]);
            }
        }

        return view('pages.error');
    }

    // Guardamos los datos que nos ha enviado un rightholder para una determinada foto
    public function response(Request $req)
    {
        $token= $req->get('token');
        $photoId = $req->get('photo');
        $userId = $req->get('user_id');
        $personId = $req->get('person_id');
        $rightholderId = $req->get('rightholder_id');
        $dni = $req->get('dni');


        $resToken = Token::generate($photoId,$userId,$personId,$rightholderId);
        if (hash_equals($resToken,$token)){
            $photo = Photo::find($photoId);
            if (isset($photo)){
                $sh= $photo->getData('sharing');

                $sharing = [];
                foreach ($sh as $share){
                    $sharing[$share->name]=(int)$req->get($share->name,'0');
                }
                $photoData  = new PhotoData($photo->data);

                if ($rh = $photoData->setRightholderSharing($dni,$rightholderId,$sharing)){

                    if ($photoData->allRightholdersProcessed())
                        $photoData->status = Status::STATUS_PROCESED;
                    $photo->data = json_encode($photoData);
                    $photo->save();
                    $photo->updatePhotobyNetwork();

                    $userId = $req->user()?$req->user()->id:null;
                    $rightholder = Rightholder::find($rightholderId);
                    $h = new Historic();
                    $h->register($userId,"Solicitud recibida de $rightholder->name con DNI : $dni y contiene los siguientes permisos: ".$this->sharingText($sharing),$photo->id,$personId, $rightholderId);

                    return view('pages.photook',['link'=>$photo->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }
            }
        }
        return view('pages.error');
    }


    private function sharingText($sharing){
        $text = "";
        foreach ($sharing as $key=>$value){
            $text .= $key.":".($value?"consiente":"no consiente")."; ";
        }
        return $text;
    }

    public function shared(LinkPhotoRequest $req,$photoId,$network,$token)
    {
        $resToken = Token::generateShared($photoId);

        if (hash_equals($resToken,$token)) {
            $photo = Photo::find($photoId);

            if (!isset($photo))
                return view('pages.error');



            $site = Publicationsite::where([['group_id',$photo->group_id],['name',$network]])->first();

            if (!isset($site))
                return view('pages.error');

            $photoNetwork = Photonetwork::where([['publicationsite_id',$site->id],['photo_id',$photo->id]])->first();

            return view('pages.shared',['photo'=>$photoNetwork]);
        }

        return view('pages.error');
    }




    public function rightholder($rightholderConsentId,$token)
    {

        $resToken = Token::generateShared($rightholderConsentId);

        if (hash_equals($resToken,$token)) {
            $rhConsent = RightholderConsent::find($rightholderConsentId);
            //dd($rhConsent->rightholder);
            if (isset($rhConsent) && isset($rhConsent->rightholder)) {
                $rh = $rhConsent->rightholder;
                $sites = $rh->publicationsites->pluck('name');
                return view('pages.rightholder', ['name' => 'rightholder', 'rhConsent' => $rhConsent, 'publicationsites' => $sites, 'token' => $token]);

            }
        }

        return view('pages.error');
    }


    public function rightholderResponse(Request $req)
    {
        $token= $req->get('token');
        $rhConsentId= $req->get('consentId');
        $dni = $req->get('dni');
        $resToken = Token::generateShared($rhConsentId);
        if (hash_equals($resToken,$token)){
            $rhConsent  = RightholderConsent::find($rhConsentId);

            if (isset($rhConsent)){
                $sites = $rhConsent->rightholder->publicationsites->pluck('name');
                $sharing = [];
                foreach ($sites as $site){
                    $sharing[$site]=(int)$req->get($site,'0');
                }
                if (strtoupper($rhConsent->rightholder->documentId) == strtoupper($dni)){

                    $rhConsent->status = Status::RH_PROCESED;
                    $rhConsent->consents = json_encode($sharing);
                    $rhConsent->save();
                    $userId = $req->user()?$req->user()->id:null;

                    // Hay que buscar las imagenes relacionadas
                    $rhphotos = RightholderPhoto::where('rightholder_id',$rhConsent->rightholder->id);
                    foreach($rhphotos as $rhphoto){
                        $rhphoto->photo->updatePhotobyNetwork();
                    }


                    $h = new Historic();
                    $h->register($userId,"Solicitud del consentimiento" .$rhConsent->description . " verificada con DNI :".$dni." y con los siguientes permisos: ".json_encode($sharing),null,$rhConsent->rightholder->person->id, $rhConsent->rightholder->id);

                    return view('pages.photook',['link'=>$rhConsent->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }
            }
        }
        return view('pages.error');
    }
}
