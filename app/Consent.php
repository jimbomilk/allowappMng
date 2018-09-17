<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consent extends Model
{
    protected $table='consents';

    protected $fillable = ['description','legitimacion','destinatarios','derechos','additional','location_id'];

    public function location(){
        return $this->belongsTo('App\Location');
    }
}
