<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';
    protected $path = 'group';
    //id,name,location_id,user_id

    protected $fillable = ['name','user_id','location_id'];

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function persons(){
        return $this->hasMany('App\Person');
    }

    public function rightholders(){
        return $this->hasManyThrough('App\Rightholder','App\Person');
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

    public function getPersons($search = null){
        if (isset($search) and $search != "") {

            $where = General::getRawWhere(Person::$searchable,$search);
            $set = $this->persons()->whereRaw($where);
            return $set;
        }
        return $this->persons()->paginate(15);

    }

    public function getPhotos($search = null){
        if (isset($search) and $search != "") {

            $where = General::getRawWhere(Photo::$searchable,$search);
            $set = $this->photos()->whereRaw($where);
            return $set;
        }
        return $this->photos()->paginate(15);

    }

    public function getRightholders($search = null){
        if (isset($search) and $search != "") {

            $where = General::getRawWhere(Photo::$searchable,$search);
            $set = $this->rightholders()->whereRaw($where);
            return $set;
        }

        return $this->rightholders();

    }

}
