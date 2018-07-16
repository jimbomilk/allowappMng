<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['description','group_id','priority','done','arco'];

    public function group(){
        return $this->belongsTo('App\Group');
    }
}
