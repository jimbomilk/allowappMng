<?php

namespace App\Observers;

use App\Group;
use Exception;
use Larareko\Rekognition\RekognitionFacade;

class GroupObserver
{
    public function creating(Group $group)
    {
        //
    }

    public function created(Group $group)
    {
        //
    }

    public function updating(Group $group)
    {
        //
    }

    public function updated(Group $group)
    {
        // dd('hola');
        $this->groupAWSUp($group);
    }

    public function saving(Group $group)
    {
        //
    }

    public function saved(Group $group)
    {
        $this->groupAWSUp($group);
    }

    public function deleting(Group $group)
    {
        //
    }

    public function deleted(Group $group)
    {
        try {
            foreach($group->photos as $photo){
                RekognitionFacade::deleteCollection($photo->collection);
            }
            RekognitionFacade::deleteCollection($group->collection);
        } catch (\Exception $t) {};
    }

    public function restoring(Group $group)
    {
        //
    }

    public function restored(Group $group)
    {
        //
    }

    protected function groupAWSUp($group){
        try {
            \Rekognition::deleteCollection($group->collection);
        }catch(\Exception  $t){}
        try{
            \Rekognition::createCollection($group->collection);
            //dd(\Rekognition::listCollections(100));
        }catch(\Exception  $t){}
    }

}