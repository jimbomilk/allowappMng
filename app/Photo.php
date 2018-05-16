<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Photo extends General
{

    protected $table = 'photos';
    protected $path = 'photo';

    //id,photo,location_id
    protected $fillable = ['name','origen','group_id'];

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
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($this->origen));
    }

    public function faces(){
        return $this->hasmany('App\Face');
    }

    public function newFace($x,$y,$w,$h){
        // Creamos una imagen por cada face
        $faceImg = Image::make($this->origen);
        $faceImg->crop($w,$h,$x,$y);

        $faceImg->rectangle(0,0,$w,$h, function ($draw) {

            $draw->border(6, '#ff0000');
        });
        $face = new Face();
        $faceFile = General::saveImage('photo',$face->path,$faceImg->stream()->__toString(),'jpg');
        if(isset($faceFile))
            $face->face = $faceFile;
        $face->photo_id = $this->id;
        $face->save();
        return ($face);
    }

    public function deleteFaces(){
        Storage::disk('s3')->delete($this->path.'/'.Face::tablename);
        foreach($this->faces as $face){
            $face->delete();
        }
    }
}
