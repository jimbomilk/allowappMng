<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends General
{
    //id,name,group_id,location_id,photo,photo_id
    protected $table = 'persons';
    protected $path = 'person';

    protected $fillable = ['name','photo','group_id'];

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function rightholders(){
        return $this->hasMany('App\Rightholder');
    }

    public function contracts(){
        return $this->hasMany('App\Contract');
    }

    public function getCollectionAttribute(){
        return "$this->table-$this->id";
    }

    public function getNumRightholdersAttribute(){
        return count($this->rightholders);
    }

    public function getPathAttribute()
    {
        return $this->group->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($this->photo));
    }

    public function sendEmails()
    {

    }
}
