<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    protected $table = 'historic_actions';

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function register($user_id, $texto,$photo_id=null,$person_id=null,$rightholder_id=null){

        $this->user_id = $user_id;
        $this->photo_id = $photo_id;
        $this->person_id = $person_id;
        $this->rightholder_id = $rightholder_id;
        $this->log = $texto;
        $this->save();
    }

    public function getCreatedAttribute()
    {
        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->created_at);
        $ret = $created->addHours($localoffset)->format('d-M-Y, H:i');
        return $ret;
    }
}
