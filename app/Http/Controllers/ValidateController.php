<?php

namespace App\Http\Controllers;

use App\Ack;
use App\Contract;
use App\General;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\EditPhotoRequest;
use App\Location;
use App\Mail\RequestSignature;
use App\Photo;
use App\Rightholder;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\Rekognition;

class ValidateController extends Controller
{
    public function accept($photo_id,$ack_id,$token){

        $ack = Ack::find($ack_id);
        $photo = Photo::find($photo_id);

        //Primero comprobamos el token.
        if (isset($ack)&& isset($photo) && $ack->token==$token){
            $ack->status=1;
            $ack->token="";
            $ack->save();
            return view('photos.guest.validated',['element'=>$photo]);
        }

        return view('photos.guest.notallowed');

    }

    public function reject($photo_id,$ack_id,$token){

        $ack = Ack::find($ack_id);
        $photo = Photo::find($photo_id);

        //Primero comprobamos el token.
        if (isset($ack)&& isset($photo) && $ack->token==$token){
            $ack->status=0;
            $ack->token="";
            $ack->save();
            return view('photos.guest.rejected',['element'=>$photo]);
        }

        return view('photos.guest.notallowed');
    }

}
