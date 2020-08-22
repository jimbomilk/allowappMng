<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Waavi\UrlShortener\Facades\UrlShortener;

class RightholderPhoto extends Model
{
    protected $fillable = ['link','status'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    public function photo()
    {
        return $this->belongsTo('App\Photo','photo_id','id');
    }

    public function person()
    {
        return $this->belongsTo('App\Person','person_id','id');
    }

    public function rightholder()
    {
        return $this->belongsTo('App\Rightholder','rightholder_id','id');
    }

    public function getLink(){
        $token = Token::generate($this->photo_id,$this->user_id,$this->person_id,$this->rightholder_id);
        $route = route('photo.link', ['id' => $this->photo_id,'user'=>$this->user_id, 'person'=>$this->person_id, 'rightholder'=>$this->rightholder_id,'token' => $token],true);
        //return  UrlShortener::shorten($route);

    }

    public function setValues($photo,$person,$rh){
        $this->user_id = $photo->user_id;
        $this->photo_id = $photo->id;
        $this->status = Status::RH_NOTREQUESTED;
        $this->person_id = $person->id;
        $this->rightholder_id = $rh->id;
        $this->link = $this->getLink();
    }

    public function getNameAttribute(){
        return $this->person->name;
    }

    public function getRhnameAttribute(){
        return $this->rightholder->name;
    }

    public function getRhphoneAttribute(){
        return $this->rightholder->phone;
    }

    public function getRhemailAttribute(){
        return $this->rightholder->email;
    }

    public function getRhrelationAttribute(){
        return $this->rightholder->relation;
    }
}
