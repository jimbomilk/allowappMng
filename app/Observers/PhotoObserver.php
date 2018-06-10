<?php

namespace App\Observers;

use App\Photo;
use Larareko\Rekognition\RekognitionFacade;

class PhotoObserver
{
    public function creating(Photo $photo)
    {
        //
    }

    public function created(Photo $photo)
    {
        //
    }

    public function updating(Photo $photo)
    {
        //
    }

    public function updated(Photo $photo)
    {

    }

    public function saving(Photo $photo)
    {
        //
    }

    public function saved(Photo $photo)
    {

    }

    public function deleting(Photo $photo)
    {
        //
    }

    public function deleted(Photo $photo)
    {
        //
        $this->deleteCollection($photo->collection);
    }

    public function restoring(Photo $photo)
    {
        //
    }

    public function restored(Photo $photo)
    {
        //
    }

    private function deleteCollection($collection){
        try {
            RekognitionFacade::deleteCollection($collection);
        } catch (\Exception $t) {
        };
    }
}