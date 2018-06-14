<?php

namespace App;

use Carbon\Carbon;
use Share;
use Illuminate\Database\Eloquent\Model;
use Waavi\UrlShortener\Facades\UrlShortener;

class Rightholder extends Model
{
    protected $fillable = ['name','relation','email','phone','person_id','documentId','location_id'];
    static $searchable = ['name','email','phone'];

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

    public function getPublicationsitesAttribute(){
        return Publicationsite::where('group_id',$this->person->group_id)->get();
    }

    public function getHistoric($personId=null,$photoId=null){
        if ($photoId == null && $personId==null){
            return Historic::where(['rightholder_id',$this->id])->orderBy('created_at')->get();
        }
        else if ($photoId == null){
            return Historic::where([['rightholder_id',$this->id],['person_id',$personId]])->orderBy('created_at')->get();
        }

        return Historic::where([['rightholder_id',$this->id],['photo_id',$photoId]])->orderBy('created_at')->get();

    }

    public function getConsentDateAttribute(){

        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->consent_date);
        $ret = $created->addHours($localoffset)->format('d-M-Y, H:i');
        return $ret;
    }

}
