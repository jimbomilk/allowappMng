<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Face extends Model
{
    const tablename = 'faces';
    protected $table = Face::tablename;
    protected $path = 'face';

    public function photo()
    {
        return $this->belongsTo('App\Photo');
    }

    public function person()
    {
        return $this->belongsTo('App\Person');
    }

    public function getPathAttribute()
    {
        return $this->photo->path.'/'.$this->table;
    }

}
