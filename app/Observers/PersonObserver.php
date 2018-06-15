<?php

namespace App\Observers;

use App\Person;
use Larareko\Rekognition\RekognitionFacade;

class PersonObserver
{
    public function creating(Person $person)
    {
        //
    }

    public function created(Person $person)
    {
        //

    }

    public function updating(Person $person)
    {
        //
    }

    public function updated(Person $person)
    {
        //
        //$this->deleteExtraFaces($person->collection);
    }

    public function saving(Person $person)
    {
        //
    }

    public function saved(Person $person)
    {
        //
    }

    public function deleting(Person $person)
    {
        //
    }

    public function deleted(Person $person)
    {
        //
        $this->deleteExtraFaces($person->collection);
    }

    public function restoring(Person $person)
    {
        //
    }

    public function restored(Person $person)
    {
        //
    }

    private function deleteExtraFaces($collection){
        try {
            //dd($person->faceId);
            $faces=RekognitionFacade::ListFaces($collection, 4096);
            $todelete =[];
            foreach($faces['Faces'] as $face){
                $faceID = $face['FaceId'];
                $p= Person::where('faceId',$faceID)->first();

                if (!isset($p)){
                    $todelete[] = $faceID;

                }

            }

            $ret=RekognitionFacade::deleteFaces($collection, $todelete);

            //dd($ret);
        } catch (\Exception $t) {
            //dd($t);
        };
    }

}