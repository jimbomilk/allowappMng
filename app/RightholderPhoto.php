<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Waavi\UrlShortener\Facades\UrlShortener;

class RightholderPhoto extends Model
{
    protected $fillable = ['owner','name','rhphone','rhname','rhemail','link','sharing'];



    public function photo()
    {
        return $this->belongsTo('App\Photo','photo_id','id');
    }

    public function getLink(){
        $phone = ($this->phone=="")?"none":$this->phone;
        $token = Token::generate($this->photo_id,$this->owner,$this->name,$phone,$this->rhname,$this->rhphone);
        $route = route('photo.link', ['id' => $this->photo_id,'owner'=>$this->owner, 'name'=>$this->name, 'phone'=>$phone,'rhname'=>$this->rhname, 'rhphone' => $this->rhphone,'token' => $token],true);
        return  UrlShortener::shorten($route);

    }

    public function setValues($photo,$person,$rh){
        $generateLink = false;
        if($this->photo_id  != $photo->id)
        {
            $this->photo_id  = $photo->id;
            $generateLink=true;
        }
        $owner = $photo->getData('owner');
        if ($this->owner != $owner){
            $this->owner     = $owner;
            $generateLink=true;
        }
        if($this->name != $person->name){
            $this->name      = $person->name;
            $generateLink=true;
        }

        if($this->phone != $person->phone){
            $this->phone     = $person->phone;
            $generateLink=true;
        }

        if($this->rhphone != $rh->phone){
            $this->rhphone     = $rh->phone;
            $generateLink=true;
        }

        if($this->rhname != $rh->name){
            $this->rhname     = $rh->name;
            $generateLink=true;
        }

        if($this->rhemail != $rh->email){
            $this->rhemail     = $rh->email;
            $generateLink=true;
        }

        $this->status    = 0;
        if ($generateLink)
            $this->link      = $this->getLink();
    }
}
