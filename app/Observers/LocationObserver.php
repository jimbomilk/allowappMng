<?php

namespace App\Observers;

use App\Location;
use Larareko\Rekognition\RekognitionFacade;

class LocationObserver
{
    public function creating(Location $location)
    {
        //
    }

    public function created(Location $location)
    {
        //
    }

    public function updating(Location $location)
    {
        //
    }

    public function updated(Location $location)
    {
        //
    }

    public function saving(Location $location)
    {
        //
    }

    public function saved(Location $location)
    {
        //
    }

    public function deleting(Location $location)
    {
        //
    }

    public function deleted(Location $location)
    {

        try {
            foreach($location->groups as $group) {
                RekognitionFacade::deleteCollection($group->collection);
            }
        } catch (\Exception $t) {}
    }

    public function restoring(Location $location)
    {
        //
    }

    public function restored(Location $location)
    {
        //
    }


}