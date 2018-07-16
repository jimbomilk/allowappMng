<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends General
{
    //id,name
    protected $table = 'locations';

    protected $fillable = ['name','description','accountable','CIF','email','address','city','CP','delegate_name','delegate_email'];

    public function users(){
        return $this->hasMany('App\User');
    }

    public function groups(){
        return $this->hasMany('App\Group');
    }

    public function profiles(){
        return $this->hasMany('App\Profile');
    }


    public function persons(){
        return $this->hasMany('App\Person');
    }

    public function photos(){
        return $this->hasMany('App\Photo');
    }

    public function contracts(){
        return $this->hasMany('App\Contract');
    }

    public function consents(){
        return $this->hasMany('App\Consent');
    }

    public function rightholders(){
        return $this->hasMany('App\Rightholder');
    }

    public function rightholderconsents()
    {
        return $this->hasManyThrough('App\RightholderConsent', 'App\Rightholder');
    }

    public function getTimezoneAttribute(){
        return 'Europe/Madrid';
    }

    public function getPathAttribute()
    {
        return $this->table.'/location'.$this->id;
    }

    public function getCollectionAttribute(){
        return $this->table.$this->id;
    }

    public static function byName($location){
        return Location::where('name',$location)->first();
    }



}
