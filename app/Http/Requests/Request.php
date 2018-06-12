<?php

namespace App\Http\Requests;

use App\Photo;
use App\Rightholder;
use App\Status;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Request extends FormRequest
{
    public function saveFile($field,$folder)
    {
        if (!isset($field) || $field == '')
            return null;
        //dd($folder);
        $file = $this->file($field);

        $filename = null;
        if (isset($file)) {
            $filename = $folder . '/' . $field .Carbon::now(). '.' . $file->getClientOriginalExtension();
            if (Storage::disk('s3')->put($filename, File::get($file),'public')) {
                return Storage::disk('s3')->url($filename);
            }

        }

        if ($this->input($field) == "")
            return "";
        return null;
    }

    /**** Watermak values : working, final */
    public function savePixelateImagen($photoId){

        $photo = Photo::find($photoId);
        if (!isset($photo))
            return null;
        $photoData = json_decode($photo->data);
        // Creamos la imagen de trabajo
        $img = Image::make($photoData->src);


        // Recorremos las caras de la imagen
        $photoFaces = json_decode($photo->faces);
        foreach($photoFaces as $face){
            // Tenemos que comprobar si esa cara está identificada en personFaces y si tienen todos los permisos de
            // los rightholders
            $person = $photo->findFacePerson();

            // si hemos encontrado una persona comprobamos sus rightholders
            $person->checkRighholdersConsents($network);
            if (isset($person)){

            }

        }

        return null;
    }


    /**** Watermak values : working, final */
    public function saveWatermarkFile(&$box,$field,$folder, $watermark_type = 'working',$height='full'){

        if (!isset($field) || $field == '')
            return null;
        //dd($folder);
        $file = $this->file($field);

        $filename = null;
        if (isset($file)) {

            // Creamos la imagen de trabajo
            $img = Image::make(File::get($file));

            if ($height != 'full') {
                $img->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $watermark = Image::make(public_path() . '/img/watermark_' . $watermark_type.'.png');
            $watermark->resize(100, 40);
            if ($watermark_type == 'final' ) {
                $img->insert($watermark, 'top-right');
                //$img->brightness(35);

            }else {
                $img->insert($watermark, 'top-left');
                $img->insert($watermark, 'center');
                $img->insert($watermark, 'bottom-right');
            }

            $box = ['width'=>$img->width(),'height'=>$img->height()];
            $filename = $folder . '/'. $watermark_type .Carbon::now(). '.' . $file->getClientOriginalExtension();
            if (Storage::disk('s3')->put($filename, $img->stream()->__toString(),'public')) {
                return Storage::disk('s3')->url($filename);
            }

        }

        if ($this->input($field) == "")
            return "";
        return null;
    }


    public function pixelateSrc($photo,$faces2Pixelate){
        // Extraemos la imagen original
        $photoData = json_decode($photo->data);
        $img = Image::make($photoData->src);
        $pixelated = Image::make($photoData->remoteSrc);

        $pixelated->pixelate(4);
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

        if (Storage::disk('s3')->put($photo->getPhotopathAttribute(), $img->stream()->__toString(),'public')) {
            return ( Storage::disk('s3')->url($photo->getPhotopathAttribute()));
        }
        return null;
    }
}
