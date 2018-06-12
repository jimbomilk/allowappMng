<?php

namespace App\Http\Controllers;

use App\Historic;
use App\Http\Requests\LinkPhotoRequest;
use App\Person;
use App\Photo;
use App\PhotoData;
use App\Rightholder;
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
                return view('pages.photo', ['name' => 'response', 'photo_id' => $photo->id, 'url'=>$photo->url , 'user_id' => $userId, 'person_id' => $person->id, 'person_name' => $person->name, 'rightholder_id' => $rightholderId, 'sh' => $sharing, 'token' => $token]);
            }
        }

        return view('pages.error');
    }

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
                    $sharing[]=[$share->name=>(int)$req->get($share->name,'0')];
                }
                $photoData  = new PhotoData($photo->data);
                if ($rh = $photoData->setRightholderSharing($dni,$rightholderId,$sharing)){
                    if ($photoData->allRightholdersProcessed())
                        $photoData->status = Status::STATUS_PROCESED;
                    $photo->data = json_encode($photoData);
                    $photo->save();

                    $h = new Historic();
                    $h->register($req->user()->id,"Solicitud recibida con DNI :".$dni." y contine los siguientes permisos: ".json_encode($sharing),$photo->id,$personId, $rightholderId);

                    return view('pages.photook',['link'=>$photo->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }


            }
        }

        return view('pages.error');

    }

    public function shared(LinkPhotoRequest $req,$photoId,$network,$token)
    {
        $resToken = Token::generateShared($photoId);
        $pixelate = [];


        if (hash_equals($resToken,$token)) {
            $photo = Photo::find($photoId);

            if (!isset($photo))
                return view('pages.error');

            $faces = json_decode($photo->faces);
            if (!isset($faces))
                return view('pages.error');

            //Recorremos cada cara de la imagen
            foreach($faces as $face){
                //1. Comprobar si la cara está asociada a una persona

                $person = $photo->findFacePerson($face->Face->FaceId);

                if (!isset($person)){
                    $pixelate[] = $face->Face->BoundingBox;
                }else{

                    //2. Comprobar si la persona tiene rightholders
                    if (!isset($person->rightholders)){
                        $pixelate[] = $face->Face->BoundingBox;

                    }else{
                        $global_consents = false;
                        //3. Comprobamos los permisos globales del los rightholders para esa red
                        foreach($person->rightholders as $rh){
                            $rightholder = Rightholder::find($rh->id);

                            if (isset($rightholder) && isset($rightholder->consent)){
                                $consents = json_decode($rightholder->consent);

                                $global_consents = $global_consents && $consents->$network;
                            }
                        }
                        if (!$global_consents){
                            //4. Comprobar los permisos de foto de los rightholders de la persona en esa red
                            $local_consents = false;

                            foreach($person->rightholders as $rh) {

                                if (isset($rh->sharing)){
                                    $local_consents = $local_consents && $rh->sharing->$network;
                                }
                            }
                            if (!$local_consents)
                                $pixelate[] = $face->Face->BoundingBox;
                            // FIN

                        }
                    }
                }
            }


            $req->pixelateSrc($photo,$pixelate);

            return view('pages.shared',['photo'=>$photo]);
        }

        return view('pages.error');
    }


    public function rightholder($rightholderId,$token)
    {
        $resToken = Token::generateShared($rightholderId);

        if (hash_equals($resToken,$token)) {
            $rightholder = Rightholder::find($rightholderId);
            $sites = $rightholder->publicationsites->pluck('name');
            return view('pages.rightholder',['name' => 'rightholder','rightholder'=>$rightholder,'publicationsites'=>$sites,'token'=>$token]);
        }

        return view('pages.error');
    }


    public function rightholderResponse(Request $req)
    {
        $token= $req->get('token');
        $rightholderId= $req->get('rightholderId');
        $dni = $req->get('dni');
        $resToken = Token::generateShared($rightholderId);
        if (hash_equals($resToken,$token)){
            $rightholder  = Rightholder::find($rightholderId);
            if (isset($rightholder)){
                $sites = $rightholder->publicationsites->pluck('name');
                $sharing = [];
                foreach ($sites as $site){
                    $sharing[$site]=(int)$req->get($site,'0');
                }
                if ($rightholder->documentId == $dni){
                    $rightholder->status = Status::RH_PROCESED;
                    $rightholder->consent = json_encode($sharing);
                    $rightholder->consent_date = Carbon::now();
                    $rightholder->save();

                    $h = new Historic();
                    $h->register($req->user()->id,"Solicitud recibida con DNI :".$dni." y contiene los siguientes permisos de valided anual: ".json_encode($sharing),null,$rightholder->person->id, $rightholderId);

                    return view('pages.photook',['link'=>$rightholder->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }
            }
        }
        return view('pages.error');
    }
}
