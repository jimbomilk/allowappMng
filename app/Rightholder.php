<?php

namespace App;

use Share;
use Illuminate\Database\Eloquent\Model;
use Waavi\UrlShortener\Facades\UrlShortener;

class Rightholder extends Model
{
    protected $fillable = ['name','relation','email','phone','person_id'];

    public function person(){
        return $this->belongsTo('App\Person');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function getLinkAttribute(){
        $token = Token::generateShared($this->id);
        $route = route('rightholder.link.shared', ['id' => $this->id,'token' => $token],true);

        return $route;
    }


}
