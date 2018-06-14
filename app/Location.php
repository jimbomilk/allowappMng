<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Location extends Model
{
    //id,name
    protected $table = 'locations';
    protected $path = 'location';

    protected $fillable = ['name'];

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

    public function rightholders(){
        return $this->hasMany('App\Rightholder');
    }

    public function getTimezoneAttribute(){
        return 'Europe/Madrid';
    }

    public function getPathAttribute()
    {
        return $this->table.'/'.$this->path.$this->id;
    }

    public function getCollectionAttribute(){
        return $this->table.$this->id;
    }

    public static function byName($location){
        return Location::where('name',$location)->first();
    }

}
