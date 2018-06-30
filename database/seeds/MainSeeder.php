<?php

use App\Person;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Larareko\Rekognition\RekognitionFacade;

class MainSeeder extends Seeder {

    private $faker = null;
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //Delete collections
        $collections = RekognitionFacade::ListCollections();
        foreach($collections['CollectionIds'] as $collection){
            RekognitionFacade::DeleteCollection($collection);
        }

        //Empty the tables
        DB::table('users')->delete();
        DB::table('locations')->delete();
        $this->faker = Faker::create();

        // ** LOCATIONS **
        $idlocation = DB::table('locations')->insertGetId( array(
            'name' => 'colegio1',
            'description'=> 'Colegio Virgen de la Montaña',
            'accountable'=> 'Director Jesús Latrecci Mardin',
            'CIF'=> '31389238F',
            'email'=> 'jmgarciacarrasco@gmail.com',
            'address' => 'Calle de Martillo nº 45',
            'city'=> 'Cáceres',
            'CP'=> '10001'

        ) );

        $idlocation2 = DB::table('locations')->insertGetId( array(
            'name' => 'colegio2',
            'description'=> 'Colegio San Antonio',
            'accountable'=> 'Director Carlos Rodriguez',
            'CIF'=> '31389238F',
            'email'=> 'director@gmail.com',
            'address' => 'Calle de Pez nº 5',
            'city'=> 'Valencia',
            'CP'=> '23440'

        ) );

        // ** USERS **
        $id = DB::table('users')->insertGetId( array(
            'name' => 'jose',
            'email' => 'jmgarciacarrasco@gmail.com',
            'phone' => '637455827',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!')
        ) );

        $id0 = DB::table('users')->insertGetId( array(
            'name' => 'director',
            'email' => 'director1@gmail.com',
            'phone' => '637755827',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!')
        ) );

        $id1 = DB::table('users')->insertGetId( array(
            'name' => 'Profesor1',
            'email' => 'profesor1@gmail.com',
            'phone' => '637455826',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!'),
        ) );

        $id2 = DB::table('users')->insertGetId( array(
            'name' => 'Profesor2',
            'email' => 'profesor2@gmail.com',
            'phone' => '637455828',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!'),
        ) );

        $id3 = DB::table('users')->insertGetId( array(
            'name' => 'director',
            'email' => 'director2@gmail.com',
            'phone' => '637455427',
            'location_id' => $idlocation2,
            'password' => Hash::make('tec_002!')
        ) );

        $id4 = DB::table('users')->insertGetId( array(
            'name' => 'Profesor21',
            'email' => 'profesor21@gmail.com',
            'phone' => '637415826',
            'location_id' => $idlocation2,
            'password' => Hash::make('tec_002!'),
        ) );

        $id5 = DB::table('users')->insertGetId( array(
            'name' => 'Profesor22',
            'email' => 'profesor22@gmail.com',
            'phone' => '607455828',
            'location_id' => $idlocation2,
            'password' => Hash::make('tec_002!'),
        ) );
        // ** PROFILES **
        DB::table('profiles')->delete();
        $this->createProfile($id,$idlocation,'super');
        $this->createProfile($id0,$idlocation,'admin');
        $this->createProfile($id1,$idlocation,'owner');
        $this->createProfile($id2,$idlocation,'owner');
        $this->createProfile($id3,$idlocation2,'admin');
        $this->createProfile($id4,$idlocation2,'owner');
        $this->createProfile($id5,$idlocation2,'owner');

        // ** GROUPS **
        DB::table('groups')->delete();

        // ** AMBITOS LEGALES
        DB::table('consents')->delete();
        $this->createConsent("General",$idlocation);
        $this->createConsent("Extraescolar",$idlocation);
        $this->createConsent("General",$idlocation2);
        $this->createConsent("Extraescolar",$idlocation2);


        /*$group1 = $this->createGroup($idlocation,$id1,'2B');
        $g1_twitter = $this->addPublicationSite($group1,'twitter');
        $g1_facebook = $this->addPublicationSite($group1,'facebook');
        //$g1_instagram = $this->addPublicationSite($group1,'instagram');
        $group2 = $this->createGroup($idlocation,$id1,'3A');
        $g2_twitter = $this->addPublicationSite($group2,'twitter');
        $g2_facebook = $this->addPublicationSite($group2,'facebook');
        //$g2_instagram = $this->addPublicationSite($group2,'instagram');
*/

        // ** PERSONS **
        //$this->addPersons($idlocation,$group1);
        //$this->addPersons($idlocation,$group2);


        // ** PHOTOS **
        // GROUP 1
        /*
        $persons1 = DB::table('persons')->where('group_id',$group1);

        for($j=0; $j< 10 ; $j++) {
            $idPhoto = $this->addPhoto($idlocation,$id1,$group1);


        }

        // GROUP 1
        $persons2 = DB::table('persons')->where('group_id',$group2);
        for($j=0; $j< 10 ; $j++) {
            $idPhoto = $this->addPhoto($idlocation,$id1,$group2);


        }
*/

    }


    function createConsent($title, $locationId){
        DB::table('consents')->insertGetId( array (
            'description'   => $title,
            'legitimacion'  => 'texto de legitimacion',
            'destinatarios' => 'texto de destinatarios',
            'derechos'      => 'texto de derechos',
            'location_id'   => $locationId

        ));
    }

    function createProfile($userId,$locationid,$type){
        DB::table('profiles')->insertGetId( array (
            'user_id'   => $userId,
            'phone'     => $this->faker->phoneNumber,
            'location_id' => $locationid,
            'type'          => $type
        ));
    }

    function createGroup($idlocation,$userId,$name){
        $id = DB::table('groups')->insertGetId( array (
            'user_id'       => $userId,
            'location_id'   => $idlocation,
            'name'          => $name ));

        try{
            \Larareko\Rekognition\RekognitionFacade::deleteCollection('locations'.$idlocation."_"."groups".$id);
        }catch(Exception $e){}
        try{
        \Larareko\Rekognition\RekognitionFacade::createCollection('locations'.$idlocation."_"."groups".$id);
        }catch(Exception $e){}
        return $id;
    }

    function addPersons($idlocation,$groupId){


        for($i=0; $i< 1 ; $i++) {

            $path = $this->faker->imageUrl(200,200,'people');
            $idPerson = DB::table('persons')->insertGetId( array (
                'location_id'      => $idlocation,
                'group_id'      => $groupId,
                'photo'         => $path,
                'name'          => $this->faker->name()));

            // ** RIGHTHOLDERS **
            $rightholder1 = $this->addRightHolders($idlocation,$idPerson);
            //$rightholder2 = $this->addRightHolders($idlocation,$idPerson);
            $collection = 'locations'.$idlocation."_"."groups".$groupId;

            RekognitionFacade::indexFaces([ 'CollectionId'=>$collection,
                'DetectionAttributes'=>['DEFAULT'],
                'Image'=>['S3Object'=>[
                    'Bucket'=>env('AWS_BUCKET'),
                    'Name'=>$path]]]);

        }
    }

    function addRightHolders($idlocation,$idPerson){

        $consents = [['name'=>'twitter','value'=>1],['name'=>'facebook','value'=>1],['name'=>'instagram','value'=>0]];

        $id = DB::table('rightholders')->insertGetId( array (
            'location_id'    => $idlocation,
            'person_id'      => $idPerson,
            'documentId'     =>'28959436k',
            'name'           => $this->faker->name(),
            'relation'       => $this->faker->randomElement(['MADRE','PADRE','TUTOR']),
            'email'          => "jmgarciacarrasco@gmail.com",
            'phone'          => $this->faker->phoneNumber,
            'consent'       => json_encode($consents)
        ));
        return $id;
    }

    function addPhoto($idlocation,$user_id,$group_id){


        $idPhoto = DB::table('photos')->insertGetId( array (
            'location_id'      => $idlocation,
            'label'          =>$this->faker->text(10),
            'user_id'       =>$user_id,
            'group_id'      =>$group_id
            ));
        $imagen = $this->faker->image($dir = '/tmp',$width = 640, $height = 480);
        $path = 'locations/location'.$idlocation; // location
        $path .= '/groups/group'.$group_id; // group
        $path .= '/photos';
        $filename=$this->saveFile('origen',$imagen,$path);
        $people = [];
        $sharing = [];
        $log=[];
        $data = ['rowid'=>-1,
            'remoteid'=>$idPhoto,
            'name'=>$this->faker->text(10),
            'src'=>'',
            'owner'=>'637455827',
            'status'=>10,
            'people'=>$people,
            'sharing'=>$sharing,
            'log'=>$log,
            'remoteSrc'=>$filename];
        $json_data = json_encode($data);
        DB::table('photos')
            ->where('id', $idPhoto)
            ->update(['data' => $json_data]);
        return $idPhoto;
    }



    function addPublicationSite($idGroup,$url){

        $id = DB::table('publicationsites')->insertGetId( array (
            'group_id'      => $idGroup,
            'name'          => $url,
            'url'           => $url
        ));
        return $id;
    }

    public function saveFile($name,$file,$folder)
    {

        $filename = '';
        if (isset($file)) {
            $filename = $folder . '/' . $name .Carbon::now(). '.jpg';
            if (Storage::disk('s3')->put($filename,file_get_contents($file),'private')) {
                return Storage::disk('s3')->url($filename);
            }

        }

        return $filename;
    }


}
