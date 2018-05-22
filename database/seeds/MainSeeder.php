<?php

use App\Person;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;


class MainSeeder extends Seeder {

    private $faker = null;
    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        //Empty the countries table
        DB::table('users')->delete();

        $this->faker = Faker::create();

        // ** LOCATIONS **
        $idlocation = DB::table('locations')->insertGetId( array(
            'name' => 'colegio1'

        ) );

        // ** USERS **
        $id = DB::table('users')->insertGetId( array(
            'name' => 'jose',
            'email' => 'jmgarciacarrasco@gmail.com',
            'phone' => '637455827',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!')
        ) );

        $id1 = DB::table('users')->insertGetId( array(
            'name' => 'test1',
            'email' => 'test1@gmail.com',
            'phone' => '637455826',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!'),
        ) );

        $id2 = DB::table('users')->insertGetId( array(
            'name' => 'test2',
            'email' => 'test2@gmail.com',
            'phone' => '637455828',
            'location_id' => $idlocation,
            'password' => Hash::make('tec_002!'),
        ) );

        // ** PROFILES **
        DB::table('profiles')->delete();
        $this->createProfile($id,$idlocation,'super');
        $this->createProfile($id1,$idlocation,'admin');
        $this->createProfile($id2,$idlocation,'owner');

        // ** GROUPS **
        DB::table('groups')->delete();
        $group1 = $this->createGroup($idlocation,$id1,'2B');
        $g1_twitter = $this->addPublicationSite($group1,'twitter');
        $g1_facebook = $this->addPublicationSite($group1,'facebook');
        $g1_instagram = $this->addPublicationSite($group1,'instagram');
        $group2 = $this->createGroup($idlocation,$id1,'3A');
        $g2_twitter = $this->addPublicationSite($group2,'twitter');
        $g2_facebook = $this->addPublicationSite($group2,'facebook');
        $g2_instagram = $this->addPublicationSite($group2,'instagram');


        // ** PERSONS **
        $this->addPersons($idlocation,$group1);
        $this->addPersons($idlocation,$group2);


        // ** PHOTOS **
        // GROUP 1
        $persons1 = DB::table('persons')->where('group_id',$group1);

        for($j=0; $j< 10 ; $j++) {
            $idPhoto = $this->addPhoto($idlocation,$id1,$group1);


        }

        // GROUP 1
        $persons2 = DB::table('persons')->where('group_id',$group2);
        for($j=0; $j< 10 ; $j++) {
            $idPhoto = $this->addPhoto($idlocation,$id1,$group2);


        }


    }

    function createProfile($userId,$locationid,$type){
        DB::table('profiles')->insertGetId( array (
            'user_id'   => $userId,
            'phone'     => $this->faker->phoneNumber,
            'avatar'    => str_replace('http','https',$this->faker->imageUrl(64, 48)),
            'location_id' => $locationid,
            'type'          => $type
        ));
    }

    function createGroup($idlocation,$userId,$name){
        $id = DB::table('groups')->insertGetId( array (
            'user_id'       => $userId,
            'location_id'   => $idlocation,
            'name'          => $name ));
        return $id;
    }

    function addPersons($idlocation,$groupId){
        for($i=0; $i< 20 ; $i++) {
            $idPerson = DB::table('persons')->insertGetId( array (
                'location_id'      => $idlocation,
                'group_id'      => $groupId,
                'photo'         => $this->faker->imageUrl(200,200,'people'),
                'name'          => $this->faker->text(10)));

            // ** RIGHTHOLDERS **
            $rightholder1 = $this->addRightHolders($idlocation,$idPerson);
            $rightholder2 = $this->addRightHolders($idlocation,$idPerson);


        }
    }

    function addRightHolders($idlocation,$idPerson){
        $id = DB::table('rightholders')->insertGetId( array (
            'location_id'      => $idlocation,
            'person_id'      => $idPerson,
            'name'           => $this->faker->text(10),
            'title'          => $this->faker->randomElement(['mother','father','tutor']),
            'email'          => $this->faker->email,
            'phone'          => $this->faker->phoneNumber ));
        return $id;
    }

    function addPhoto($idlocation,$user_id,$group_id){


        $idPhoto = DB::table('photos')->insertGetId( array (
            'location_id'      => $idlocation,
            'label'          =>$this->faker->text(10),
            'user_id'       =>$user_id,
            'group_id'      =>$group_id
            ));
        $path = $this->faker->image($dir = '/tmp',$width = 640, $height = 480);
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        $people = [];
        $sharing = [];
        $log=[];
        $data = ['rowid'=>-1,
            'remoteid'=>$idPhoto,
            'name'=>$this->faker->text(10),
            'src'=>$base64,
            'owner'=>'637455827',
            'status'=>20,
            'people'=>$people,
            'sharing'=>$sharing,
            'log'=>$log,
            'remoteSrc'=>$path];
        $json_data = json_encode($data);
        DB::table('photos')
            ->where('id', $idPhoto)
            ->update(['data' => $json_data]);
        return $idPhoto;
    }



    function addPublicationSite($idGroup,$url){

        $id = DB::table('publicationsites')->insertGetId( array (
            'group_id'      => $idGroup,
            'name'          => $this->faker->text(10),
            'url'           => $url
        ));
        return $id;
    }

}
