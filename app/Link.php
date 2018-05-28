<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'rightholder_photos';

    //contract_id,holder_id,status
    protected $fillable = ['owner','name','phone','rhphone','rhname','link','status'];

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

}
