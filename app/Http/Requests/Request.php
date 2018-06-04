<?php

namespace App\Http\Requests;

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
    public function saveWatermarkFile($field,$folder,$height='full', $watermark = 'working'){

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

            $watermark = Image::make(public_path() . '/img/watermark_' . $watermark.'.png');
            $watermark->resize(100, 40);
            if ($watermark == 'final' ) {
                $img->insert($watermark, 'bottom-right');

            }else {
                $img->insert($watermark, 'top-left');
                $img->insert($watermark, 'center');
                $img->insert($watermark, 'bottom-right');
            }

            $filename = $folder . '/'. $watermark .Carbon::now(). '.' . $file->getClientOriginalExtension();
            if (Storage::disk('s3')->put($filename, $img->stream()->__toString(),'public')) {
                return Storage::disk('s3')->url($filename);
            }

        }

        if ($this->input($field) == "")
            return "";
        return null;
    }


}
