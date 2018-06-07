<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $path = 'group';
    //id,name,location_id,user_id

    protected $fillable = ['name','user_id'];

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function persons(){
        return $this->hasMany('App\Person');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public function publicationsites(){
        return $this->hasMany('App\Publicationsite');
    }

    public function getCollectionAttribute(){
        return $this->location->collection."_"."$this->table"."$this->id";
    }

    public function findPerson($faceId){
        return $this->persons->where('faceId',$faceId)->first();
    }

    public function getPathAttribute()
    {
        return $this->location->path.'/'.$this->table.'/'.$this->path.$this->id;
    }

}
