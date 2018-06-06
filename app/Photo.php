<?php

namespace App;


use Carbon\Carbon;
use Share;
use Illuminate\Support\Facades\Storage;
use Waavi\UrlShortener\Facades\UrlShortener;

class Photo extends General
{

    protected $table = 'photos';
    protected $path = 'photo';
    static $searchable = ['label'];

    //id,photo,location_id
    protected $fillable = ['label','data','group_id'];


    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function rightholderphotos(){
        return $this->hasMany('App\RightholderPhoto');
    }

    public function getHistoric(){
        return Historic::where('photo_id',$this->id)->orderBy('created_at')->get();

    }


    public function getSharingAsText(){
        $text = ": ";
        $data = json_decode($this->data);
        foreach ($data->sharing as $index=>$share){
            if ($index>0){
                $text .= ',';
            }
            $text .= $share->name;
        }
        return $text;
    }


    public function getCollectionAttribute(){
        return "$this->table-$this->id";
    }

    public function getPathAttribute()
    {
        return $this->group->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        $data = json_decode($this->data);
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($data->remoteSrc));
    }

    public function getPhotoFinalpathAttribute()
    {
        $data = json_decode($this->data);
        return $this->group->path.'/'.$this->table.'/'.basename(urldecode($data->src));
    }

    public function getPeopleAttribute(){
        //return $this->hasmany('App\Face');
        $data = json_decode($this->data);

        return $data->people;

    }

    public function newFace($x,$y,$w,$h){
        // Creamos una imagen por cada face
        $faceImg = Image::make($this->origen);
        $faceImg->crop($w,$h,$x,$y);

        $faceImg->rectangle(0,0,$w,$h, function ($draw) {

            $draw->border(6, '#ff0000');
        });
        $face = new Face();
        $faceFile = General::saveImage('photo',$face->path,$faceImg->stream()->__toString(),'jpg');
        if(isset($faceFile))
            $face->face = $faceFile;
        $face->photo_id = $this->id;
        $face->save();
        return ($face);
    }

    public function deleteFaces(){
        Storage::disk('s3')->delete($this->path.'/'.Face::tablename);
        foreach($this->faces as $face){
            $face->delete();
        }
    }

    public function getData($field){
        $data = json_decode($this->data);
        return $data->$field;
    }

    public function setData($field,$value){
        $data = json_decode($this->data);
        $data->$field=$value;
        $this->data = json_encode($data);
    }

    //Recogemos el valor UTC de la BBDD y devolvemos el valor local.
    public function getCreatedAttribute()
    {
        $localoffset = Carbon::now()->offsetHours;
        $created = Carbon::parse($this->created_at);
        $ret = $created->addHours($localoffset)->format('d-M-Y, H:i');
        return $ret;
    }

    public function getStatusAttribute()
    {
        $data = json_decode($this->data);
        $label_color="";$label_text="";
        if ($data->status==10) {
            $label_color = 'info';
            $label_text = trans('labels.created');
        }
        else if ($data->status==20) {
            $label_color = 'warning';
            $label_text = trans('labels.pending');
        }
        elseif ($data->status==30) {
            $label_color = 'success';
            $label_text = trans('labels.processed');
        }
        else if ($data->status==100) {
            $label_color = 'danger';
            $label_text = trans('labels.rejected');
        }
        else if ($data->status==200) {
            $label_color = 'success';
            $label_text = trans('labels.success');
        }
        else{
            $label_color = 'default';
            $label_text = trans('labels.unknown');
        }

        return ['color'=>$label_color,'text' => $label_text];
    }


    public function getStatuspendingtxtAttribute()
    {
        $text = ": ";
        $total=0;
        $pending=0;
        $data = json_decode($this->data);
        if($data->status==20||$data->status==30){
            foreach($data->people as $person) {
                foreach ($person->rightholders as $rh) {
                    $total++;
                    if ($rh->status>0)
                        $pending++;
                }
            }
            return $text.$pending .'/'.$total;
        }
        return "";

    }

    public function getAssignedAttribute()
    {
        $data = json_decode($this->data);
        return array_column($data->people, 'id');
    }

    public function getUrlAttribute(){

    return  Storage::disk('s3')->temporaryUrl($this->getPhotopathAttribute(),Carbon::now()->addMinutes(5));


}

    public function getUrlfinalAttribute(){

        return  Storage::disk('s3')->temporaryUrl($this->getPhotoFinalpathAttribute(),Carbon::now()->addMinutes(5));


    }

    public function pendingRightholders(){
        $data = json_decode($this->data);
        $total = 0;$processed=0;
        if (isset($data->people)) {
            foreach ($data->people as $person) {
                foreach ($person->rightholders as $rh) {
                    $total++;
                    if ($rh->status == Status::RH_PROCESED)
                        $processed++;
                }
            }
        }
        return  $processed."/".$total;
    }

    private function combineSharing($sharing1,$sharing2){
        $sharing_ret = [];
        $new_share =null;
        foreach($sharing1 as $index=>$share){
            foreach($share as $key=>$value) {
                if (isset($sharing2[$index]))
                    $new_share = [$key => $value && $sharing2[$index][$key]];
                else
                    $new_share = [$key => $value];
                $sharing_ret[] = $new_share;
            }
        }
        return $sharing_ret;
    }

    public function cumulativeSharingRightholders(){
        $data = json_decode($this->data);
        $sharing_ret =[];

        foreach($data->people as $person){
            foreach($person->rightholders as $rh){
                if (isset($rh->sharing))
                    $sharing_ret=$this->combineSharing($rh->sharing,$sharing_ret);
            }
        }

        return $sharing_ret;
    }


    public function getSharedLink($share){
        $token = Token::generateShared($this->id);
        $route = route('photo.link.shared', ['id' => $this->id,'token' => $token],true);

        return Share::load($route,$this->name)->$share();

    }




}
