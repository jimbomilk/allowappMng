<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Photonetwork extends Model
{
    const tablename = 'photonetwork';
    protected $table = Photonetwork::tablename;
    protected $path = 'network';

    protected $fillable = ['publicationsite_id','photo_id'];

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function network()
    {
        return $this->belongsTo('App\Publicationsite');
    }

    public function getPathAttribute()
    {
        return $this->photo->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        return $this->photo->path.'/'.$this->table.'/'.basename(urldecode($this->url));
    }



    public function pixelatePhoto($network){

        $pixelate = [];

        $faces = json_decode($this->photo->faces);
        if (!isset($faces))
            return false;
        //Recorremos cada cara de la imagen
        foreach($faces as $face){
            //1. Comprobar si la cara está asociada a una persona

            $person = $this->photo->findFacePerson($face->Face->FaceId);

            if (!isset($person)){
                $pixelate[] = $face->Face->BoundingBox;
            }else{

                //2. Comprobar si la persona tiene rightholders
                if (!isset($person->rightholders)){
                    $pixelate[] = $face->Face->BoundingBox;

                }else{
                    $global_consents = true;
                    //3. Comprobamos los permisos globales del los rightholders para esa red
                    if (isset($person->rightholders) && count($person->rightholders)>0) {
                        foreach ($person->rightholders as $rh) {
                            $rightholder = Rightholder::find($rh->id);
                            if (isset($rightholder) && isset($rightholder->consent)) {
                                $consents = json_decode($rightholder->consent);
                                if (isset($consents->$network))
                                    $global_consents = $global_consents && $consents->$network;
                                else
                                    $global_consents = false;
                            } else {
                                $global_consents = false;
                            }
                        }
                    }else{
                        $global_consents = false;
                    }
                    if (!$global_consents){

                        //4. Comprobar los permisos de foto de los rightholders de la persona en esa red
                        $local_consents = true;
                        if (isset($person->rightholders) && count($person->rightholders)>0) {
                            foreach($person->rightholders as $rh) {

                                if (isset($rh->sharing) && isset($rh->sharing->$network)){
                                    $local_consents = $local_consents && $rh->sharing->$network;
                                }else{
                                    $local_consents = false;
                                }
                            }

                        }else{
                            $local_consents = false;
                        }

                        if (!$local_consents)
                            $pixelate[] = $face->Face->BoundingBox;
                        // FIN

                    }
                }
            }
        }

        return $this->pixelate($pixelate);
    }

    private function pixelate($faces2Pixelate){

        // Extraemos la imagen original
        $photoData = json_decode($this->photo->data);
        $img = Image::make($photoData->src);
        $pixelated = Image::make($photoData->src);

        $pixelated->pixelate(12);
        $streamPixelated = $pixelated->stream();

        $img_width = $img->width();
        $img_height = $img->height();


        //Recorremos las caras a pixelar
        foreach($faces2Pixelate as $index=>$face){

            $x = round($face->Left * $img_width);
            $y = round($face->Top * $img_height);
            $width = ceil($face->Width * $img_width);
            $height = ceil($face->Height * $img_height);
            $crop = Image::make($streamPixelated);
            $crop->crop($width, $height, $x, $y);
            $img->insert($crop, 'top-left', $x, $y);
        }

        if (Storage::disk('s3')->put($this->getPhotopathAttribute(), $img->stream()->__toString(),'public')) {
            return ( Storage::disk('s3')->url($this->getPhotopathAttribute()));
        }
        return null;
    }
}
