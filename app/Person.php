<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Person extends General
{
    //id,name,group_id,location_id,photo,photo_id
    protected $table = 'persons';
    protected $path = 'person';
    static $searchable = ['name'];

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
        return $this->group->collection;
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

    public function getCreatedAttribute()
    {
        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->created_at);
        $ret = $created->addHours($localoffset)->format('d-M-Y, H:m');
        return $ret;
    }



    public function getPhotosAttribute(){
        $photos = Photo::all();
        $photos = $photos->filter(function ($value){
            $data = json_decode($value->data);
            foreach($data->people as $person)
            {
                if ($person->id == $this->id)
                    return true;
            }
            return false;
        });
        return $photos;
    }

    public function getHistoric($photoId){
        return Historic::where([['person_id',$this->id],['photo_id',$photoId]])->orderBy('created_at')->get();

    }

    public function getUrlAttribute(){

        return  Storage::disk('s3')->temporaryUrl($this->getPhotopathAttribute(),Carbon::now()->addMinutes(5));


    }

}
