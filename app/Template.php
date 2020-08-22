<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table='templates';

    protected $fillable = ['title','body','location_id'];

    public function location(){
        return $this->belongsTo('App\Location');
    }
}
