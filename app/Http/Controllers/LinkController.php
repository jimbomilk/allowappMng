<?php

namespace App\Http\Controllers;

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

    public function link($photoId,$owner,$name,$phone,$rhname,$rhphone,$token)
    {
        $resToken = Token::generate($photoId,$owner,$name,$phone,$rhname,$rhphone);

        if (hash_equals($resToken,$token)) {
            $photo = Photo::find($photoId);
            if (isset($photo)) {
                $sharing = $photo->getData('sharing');
                return view('pages.photo', ['name' => 'response', 'photo' => $photo, 'owner' => $owner, 'person_name' => $name, 'person_phone' => $phone, 'rhname' => $rhname, 'rhphone' => $rhphone, 'sh' => $sharing, 'token' => $token]);
            }
        }

        return view('pages.error',['photo'=>$photoId,'phone'=>$phone,'token'=>$token]);
    }

    public function response(Request $req)
    {
        $token= $req->get('token');
        $photoId = $req->get('photo');
        $owner = $req->get('owner');
        $name = $req->get('name');
        $phone = $req->get('phone');
        $rhname = $req->get('rhname');
        $rhphone = $req->get('rhphone');
        $dni = $req->get('dni');
        $resToken = Token::generate($photoId,$owner,$name,$phone,$rhname,$rhphone);
        if (hash_equals($resToken,$token)){
            $photo = Photo::find($photoId);
            if (isset($photo)){
                $sh= $photo->getData('sharing');
                $sharing = [];
                foreach ($sh as $share){
                    $sharing[]=[$share->name=>(int)$req->get($share->name,'0')];
                }
                return json_encode($sharing);
                $photoData  = new PhotoData($photo->data);
                if ($rh = $photoData->setRightholderSharing($dni,$rhphone,$sharing)){
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
