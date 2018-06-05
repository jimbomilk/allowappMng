<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{

    /**
     * Generate a token
     *
     */


    public static function generate($photoId,$userId,$personId,$rightholderId)
    {
        return hash_hmac('sha256', $photoId.$userId.$personId.$rightholderId, config('allowapi_key'));

    }

    public static function generateShared($photoId)
    {
        return hash_hmac('sha256', $photoId, config('allowapi_key'));

    }
}
