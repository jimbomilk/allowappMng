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


    public function saveWorkFile($field,$folder){

        if (!isset($field) || $field == '')
            return null;
        //dd($folder);
        $file = $this->file($field);

        $filename = null;
        if (isset($file)) {

            // Creamos la imagen de trabajo
            $img = Image::make(File::get($file));
            $watermark_pending = Image::make(public_path().'/img/watermark_pendiente.png');
            $img->insert($watermark_pending, 'top-left');
            $img->insert($watermark_pending, 'center');
            $img->insert($watermark_pending, 'bottom-right');

            $filename = $folder . '/working' .Carbon::now(). '.' . $file->getClientOriginalExtension();
            if (Storage::disk('s3')->put($filename, $img->stream()->__toString(),'public')) {
                return Storage::disk('s3')->url($filename);
            }

        }

        if ($this->input($field) == "")
            return "";
        return null;
    }


}
