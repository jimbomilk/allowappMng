<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 29/05/2018
 * Time: 14:30
 */

namespace App;


class PhotoData {

    public $rowid;
    public $remoteId;
    public $remoteSrc;
    public $name;
    public $src;
    public $owner;
    public $status;
    public $timestamp;
    public $sharing = [];
    public $people=[];
    public $log=[];

    public function __construct ($data){
        $data = json_decode($data);
        $this->rowid = $data->rowid;
        $this->remoteId = $data->remoteId;
        $this->remoteSrc = $data->remoteSrc;
        $this->name = $data->name;
        $this->src = $data->src;
        $this->owner = $data->owner;
        $this->status = $data->status;
        $this->timestamp = $data->timestamp;
        $this->sharing = $data->sharing;
        $this->people = $data->people;
        $this->log = $data->log;

    }
    public function setRightholderSharing($documentid,$rhId,$sharing){
        foreach($this->people as $person){
            foreach($person->rightholders as $rh){
                $rightholder = Rightholder::find($rh->id);
                if (isset($rightholder) && $rightholder->documentId == $documentid){
                    $rh->sharing = $sharing;
                    $rh->status = Status::RH_PROCESED; //procesed
                    return $rh;
                }

            }
        }
        return null;

    }

    public function allRightholdersProcessed(){
        $total = 0;$processed=0;
        foreach($this->people as $person) {
            foreach ($person->rightholders as $rh) {
                $total++;
                if ($rh->status == Status::RH_PROCESED)
                    $processed++;
            }
        }
        return  $total == $processed;
    }


}