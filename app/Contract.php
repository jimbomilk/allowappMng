<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table='contracts';
    //photo_id,person_id

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function acks(){
        return $this->hasMany('App\Ack');
    }

    public function getCollectionAttribute(){
        return "$this->table-$this->id";
    }

    public function getPathAttribute()
    {
        return $this->photo->path.'/'.$this->table;
    }


}
