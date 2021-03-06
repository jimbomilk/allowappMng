<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publicationsite extends Model
{
    //name,url,group_id
    protected $fillable = ['name','url','group_id',];

    public function group(){
        return $this->belongsTo('App\Group');
    }
}
