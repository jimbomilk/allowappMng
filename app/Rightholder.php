<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rightholder extends Model
{
    //id,name,title,email,phone,person_id
    protected $fillable = ['name','title','email','phone','person_id'];

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }
}
