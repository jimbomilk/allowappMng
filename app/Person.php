<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\RekognitionFacade;

class Person extends General
{
    //id,name,group_id,location_id,photo,photo_id
    protected $table = 'persons';
    static $searchable = ['name'];

    protected $fillable = ['name','location_id','photo','group_id','email','phone','minor','documentId'];

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function group(){
        return $this->belongsTo('App\Group');
    }

    public function rightholders(){
        return $this->hasMany('App\Rightholder');
    }

    public function contracts(){
        return $this->hasMany('App\Contract');
    }

    public function getCollectionAttribute(){
        return $this->group->collection;
    }

    public function getNumRightholdersAttribute(){
        return count($this->rightholders);
    }

    public function getPathAttribute()
    {
        return $this->group->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($this->photo));
    }

    public function getCreatedAttribute()
    {
        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->created_at);
        $ret = $created->addHours($localoffset)->format('d-M-Y, H:m');
        return $ret;
    }



    public function getPhotosAttribute(){
        $photos = Photo::all();
        $photos = $photos->filter(function ($value){
            $data = json_decode($value->data);
            foreach($data->people as $person)
            {
                if ($person->id == $this->id)
                    return true;
            }
            return false;
        });
        return $photos;
    }

    public function getHistoric($photoId){
        return Historic::where([['person_id',$this->id],['photo_id',$photoId]])->orderBy('created_at')->get();

    }

    public function getUrlAttribute(){
        return  Storage::disk('s3')->temporaryUrl($this->getPhotopathAttribute(),Carbon::now()->addMinutes(5));
    }

    public function checkRighholderConsent($rhId, $network){
        $rightholder = Rightholder::find($rhId);
        if (isset($rightholder) && $rightholder->status == Status::RH_PROCESED) {
            $consents = json_decode($rightholder->consent);
            if (isset($consents) && isset($consents->$network) && $consents->$network)
                return true;
        }
    }

    public function createRightholderPropio(){
        $rh = Rightholder::firstOrNew(['name'=>$this->name,
            'documentId'=>$this->documentId,
            'person_id'=>$this->id,
            'location_id'=>$this->location_id]);
        $rh->relation='PROPIO';
        $rh->email=$this->email;
        $rh->phone = $this->phone;
        $rh->save();
    }
}
