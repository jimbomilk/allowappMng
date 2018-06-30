<?php

namespace App\Jobs;

use App\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Larareko\Rekognition\RekognitionFacade;

class PersonFaceUp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $person;

    public function __construct(Person $person)
    {
        $this->person = $person;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $result= RekognitionFacade::indexFaces([ 'CollectionId'=>$this->person->collection,
            'DetectionAttributes'=>['DEFAULT'],
            'Image'=>['S3Object'=>[
                'Bucket'=>env('AWS_BUCKET'),
                'Name'=>$this->person->photopath]]]);
        $this->person->faceId = $result['FaceRecords'][0]['Face']['FaceId'];
        $this->person->save();

    }
}
