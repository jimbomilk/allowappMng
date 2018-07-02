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
    public $accountable;
    public $accountable_CIF;
    public $accountable_email;
    public $accountable_address;
    public $accountable_city;
    public $accountable_cp;
    public $consent_legitimacion;
    public $consent_destinatarios;
    public $consent_derechos;
    public $timestamp;
    public $sharing = [];
    public $people=[];
    public $log=[];

    public function __construct ($data){
        $data = json_decode($data);
        $this->rowid                = $data->rowid;
        $this->remoteId             = $data->remoteId;
        $this->remoteSrc            = $data->remoteSrc;
        $this->name                 = $data->name;
        $this->src                  = $data->src;
        $this->owner                = $data->owner;
        $this->status               = $data->status;
        $this->accountable          = $data->accountable;
        $this->accountable_CIF      = $data->accountable_CIF;
        $this->accountable_email    = $data->accountable_email;
        $this->accountable_address  = $data->accountable_address;
        $this->accountable_city     = $data->accountable_city;
        $this->accountable_cp       = $data->accountable_cp;
        $this->consent_legitimacion = $data->consent_legitimacion;
        $this->consent_destinatarios= $data->consent_destinatarios;
        $this->consent_derechos     = $data->consent_derechos;
        $this->timestamp            = $data->timestamp;
        $this->sharing              = $data->sharing;
        $this->people               = $data->people;
        $this->log                  = $data->log;

    }
    public function setRightholderSharing($documentid,$rhId,$sharing){
        foreach($this->people as $person){
            foreach($person->rightholders as $rh){
                if ($rh->id == $rhId) {
                    $rightholder = Rightholder::find($rh->id);
                    if (isset($rightholder) && strtoupper($rightholder->documentId) == strtoupper($documentid)) {
                        $rh->sharing = $sharing;
                        $rh->status = Status::RH_PROCESED; //procesed
                        return $rh;
                    }
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