<?php

namespace App;


use Carbon\Carbon;

class Photo extends General
{

    protected $table = 'photos';
    protected $path = 'photo';

    //id,photo,location_id
    protected $fillable = ['name','photo','group_id'];

    public function photosites(){
        return $this->hasmany('App\Photosite');
    }

    public function contracts(){
        return $this->hasmany('App\Contract');
    }

    public function acks(){
        return $this->hasManyThrough('App\Ack','App\Contract');
    }

    public function acksOk(){
        return $this->hasManyThrough('App\Ack','App\Contract')->where('acks.status','=',1);
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }


    public function getCollectionAttribute(){
        return "$this->table-$this->id";
    }

    public function getPathAttribute()
    {
        return $this->group->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($this->photo));
    }
}
