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
    protected $fillable = ['name', 'email', 'password','phone'];
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

    public function checkRole($reference)
    {
        if ($this->roleVal($this->profile->type) > $this->roleVal($reference)) {
            return true;
        }
        return false;
    }

    private function roleVal($rol){
        switch($rol){
            case "super":return 100;
            case "admin":return 50;
            case "owner":return 10;
        }
        return 1;
    }

    public function getGroupTutors(){
        if ($this->profile->type == 'admin') {
            //dd($this);
            return $this->location->users;
        }
        else {
            return $this->location->users->where('id', $this->id);
        }
    }

    public function getTutors(){

        if ($this->profile->type == 'admin') {
            //dd($this);
            return $this->location->rightholders;
        }
        else {

            return $this->location->rightholders->whereIn('person_id', $this->getGroups()->pluck('id'));
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

    public function getPhotos($all=false){

        if ($this->profile->type == 'admin' || $this->profile->type == 'super'  ) {
            return $all?$this->location->photos:$this->location->photos()->orderBy('created_at','desc')->paginate(15);
        }
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            return $all?$this->location->photos->whereIn('group_id', $this->getGroups()->pluck('id')):$this->location->photos()->whereIn('group_id', $this->getGroups()->pluck('id'))->orderBy('created_at','desc')->paginate(15);
        }
    }

    public function countPhotosByStatus($status){
        $count =0;

        $photos = $this->getPhotos(true);
        foreach($photos as $photo){
            $data = json_decode($photo->data);
            if($data->status==$status){
                $count++;
            }
        }
        return $count;
    }

    public function getPathAttribute()
    {
        return $this->location->path.'/'.$this->table;
    }

    public function links(){
        return Link::where('owner',$this->phone);
    }

}
