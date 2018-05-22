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


    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getSharingAsText(){
        $text = "";
        $data = json_decode($this->data);
        foreach ($data->sharing as $index=>$sharing){
            if ($index>1){
                $text .= ',';
            }
            $text .= $sharing;

        }
        return $text;
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

    public function getPeopleAttribute(){
        //return $this->hasmany('App\Face');
        $data = json_decode($this->data);

        return $data->people;

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

    public function getData($field){
        $data = json_decode($this->data);
        return $data->$field;
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getCreatedAttribute()
    {
        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->created_at);
        $ret = $created->addHours($localoffset)->format('d-M H:m');
        return $ret;
    }

    public function getStatuscolorAttribute()
    {
        $data = json_decode($this->data);
        if ($data->status==10)
            return 'label-primary';
        else if ($data->status==20)
            return 'label-warning';
        else if ($data->status==100)
            return 'label-danger';
        else if ($data->status==200)
            return 'label-success';
        else return 'label-default';
    }

    public function getStatustextAttribute()
    {
        $data = json_decode($this->data);
        if ($data->status==10)
            return trans('labels.created');
        else if ($data->status==20)
            return trans('labels.pending');
        else if ($data->status==100)
            return trans('labels.rejected');
        else if ($data->status==200)
             return trans('labels.success');
        else return trans('labels.unknown');
    }
}
