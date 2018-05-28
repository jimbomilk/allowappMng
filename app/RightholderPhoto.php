<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Waavi\UrlShortener\Facades\UrlShortener;

class RightholderPhoto extends Model
{
    protected $fillable = ['owner','name','phone','rhphone','rhname','link','sharing'];

    public function photo()
    {
        return $this->belongsTo('App\Photo','photo_id','id');
    }

    public function getLink(){
        $phone = ($this->phone=="")?"none":$this->phone;
        $token = Token::generate($this->photo_id,$this->owner,$this->name,$phone,$this->rhname,$this->rhphone);
        $route = route('photo.link', ['id' => $this->photo_id,'owner'=>$this->owner, 'name'=>$this->name, 'phone'=>$phone,'rhname'=>$this->rhname, 'rhphone' => $this->rhphone, 'sharing' => $this->sharing, 'token' => $token],true);
        return  UrlShortener::shorten($route);

    }
}
