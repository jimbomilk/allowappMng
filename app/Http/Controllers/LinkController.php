<?php

namespace App\Http\Controllers;

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
                    return view('pages.photook',['link'=>$photo->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }


            }
        }

        return view('pages.error');

    }

    public function shared($photoId,$token)
    {
        $resToken = Token::generateShared($photoId);

        if (hash_equals($resToken,$token)) {
            $photo = Photo::find($photoId);
            return view('pages.shared',['photo'=>$photo]);
        }

        return view('pages.error');
    }


    public function rightholder($rightholderId,$token)
    {
        $resToken = Token::generateShared($rightholderId);

        if (hash_equals($resToken,$token)) {
            $rightholder = Rightholder::find($rightholderId);
            return view('pages.rightholder',['name' => 'rightholder','rightholder'=>$rightholder,'token'=>$token]);
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
                $sh= json_decode($rightholder->consent);
                $sharing = [];
                foreach ($sh as $share){
                    $sharing[]=['name'=>$share->name, 'value' =>(int)$req->get($share->name,'0')];
                }
                if ($rightholder->documentId == $dni){
                    $rightholder->status = Status::RH_PROCESED;
                    $rightholder->consent = json_encode($sharing);
                    $rightholder->consent_date = Carbon::now();
                    $rightholder->save();
                    return view('pages.photook',['link'=>$rightholder->link]);
                }else{
                    return view('pages.errordni',['link'=>URL::previous()]);
                }
            }
        }
        return view('pages.error');
    }
}
