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
