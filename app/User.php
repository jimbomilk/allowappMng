<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $table = 'users';


    public function profile(){
        return $this->hasOne('App\Profile');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function getGroups(){
        if ($this->profile->type == 'admin')
            return $this->location->groups;
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            return $this->location->groups->where('user_id', $this->id);
        }
    }

    public function getTutors(){

        if ($this->profile->type == 'admin') {
            //dd($this);
            return $this->location->users;
        }
        else {

            return $this->location->users->where('id', $this->id);
        }
    }

    public function getPersons(){

        if ($this->profile->type == 'admin') {
            return $this->location->persons;
            }
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            return $this->location->persons->whereIn('group_id', $this->getGroups()->pluck('id'));
        }
    }

    public function getPhotos(){

        if ($this->profile->type == 'admin') {
            return $this->location->photos;
        }
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            return $this->location->photos->whereIn('group_id', $this->getGroups()->pluck('id'));
        }
    }

    public function getPathAttribute()
    {
        return $this->location->path.'/'.$this->table;
    }


}
