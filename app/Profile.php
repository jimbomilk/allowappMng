<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends General
{
    //id,phone,avatar,type,user_id,location_id
    protected $table='profiles';

    protected $fillable = ['type','avatar'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function getPathAttribute()
    {
        return $this->user->path;
    }

    public function getPhotopathAttribute()
    {
        return $this->user->path.'/'.basename(urldecode($this->avatar));
    }
}
