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
        if ($this->checkRole('admin')) {
            return $this->location->groups;
        }
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            return $this->location->groups->where('user_id', $this->id);
        }
    }

    public function checkRole($reference)
    {
        if ($this->roleVal($this->profile->type) >= $this->roleVal($reference)) {
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
        if ($this->checkRole('admin')) {
            //dd($this);
            return $this->location->users;
        }
        else {
            return $this->location->users->where('id', $this->id);
        }
    }

    private function getUserPersonsGroup($groupId=null){
        if(isset($groupId))
            return Person::with('rightholders.location')->get();

    }

    public function getRightholders($search = null,$group_id=null){

        // Se selecciona el subconjunto de trabajo...

        $set = $this->location->rightholders()->whereIn('person_id', $this->getPersons(null,$group_id)->pluck('id'));
        //dd($this->location->rightholders()->pluck('person_id'));
        // Se aplican los search...
        if (isset($search) and $search != "") {
            $where = General::getRawWhere(Rightholder::$searchable,$search);
            $set = $set->whereRaw($where);
        }
        return $set;
    }

    public function getPersons($search = null,$group_id=null){
        $set = null;

        // Se selecciona el subconjunto de trabajo...
        if (isset($group_id) && $group_id!=0){
            $set =  $this->location->persons()->whereIn('group_id', $this->getGroups()->pluck('id'))
                                              ->where('group_id', $group_id);
        }
        else {
            $set =  $this->location->persons()->whereIn('group_id', $this->getGroups()->pluck('id'));
        }



        // Se aplican los search...
        if (isset($search) and $search != "") {
            //dd('hola');
            $where = General::getRawWhere(Person::$searchable,$search);
            $set = $set->whereRaw($where);
        }
        return $set;
    }

    public function getPhotos($search = null,$all=false){

        $set = null;

        // Se selecciona el subconjunto de trabajo...
        if ($this->checkRole('admin')) {
            $set =  !$all?$this->location->photos():$this->location->photos()->orderBy('created_at','desc');
        }
        else {
            //dd($this->location->groups->where('user_id', $this->id));
            $set = $all?$this->location->photos()->whereIn('group_id', $this->getGroups()->pluck('id')):$this->location->photos()->whereIn('group_id', $this->getGroups()->pluck('id'))->orderBy('created_at','desc');
        }
        // Se aplican los search...
        if (isset($search) and $search != "") {
            //dd($search);
            $where = General::getRawWhere(Photo::$searchable,$search);
            $set = $set->whereRaw($where);
        }
        return $set->paginate(15);
    }

    public function countPhotosByStatus($status){
        $count =0;

        $photos = $this->getPhotos(null,true);
        foreach($photos as $photo){
            $data = json_decode($photo->data);
            if($data->status==$status){
                $count++;
            }
        }
        return $count;
    }

    public function getRoleAttribute(){
        return $this->profile->type;
    }

    public function getPathAttribute()
    {
        return $this->location->path.'/'.$this->table;
    }

    public function links(){
        return RightholderPhoto::where('user_id',$this->id);
    }

}
