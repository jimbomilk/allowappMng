<?php

namespace App\Http\Controllers;

use App\Ack;
use App\Contract;
use App\Face;
use App\General;
use App\Group;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\EditPhotoRequest;
use App\Location;
use App\Mail\RequestSignature;
use App\Person;
use App\Photo;
use App\RightholderPhoto;
use App\Status;
use App\Token;
use App\User;
use Share;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Larareko\Rekognition\Rekognition;

class PhotosController extends Controller
{
    //

    public function index(Request $request)
    {
        //dd($request->user()->getPhotos());
        return view('common.index', [ 'name' => 'photos', 'set' => $request->user()->getPhotos()]);

    }

    public function sendView(Request $request,$element=null)
    {
        $groups = $request->user()->getGroups()->pluck('name','id');
        if (isset($element)) {
            return view('common.edit', ['name' => 'photos', 'element' => $element, 'groups'=>$groups]);
        }
        else
            return view('common.create',['name'=>'photos', 'groups'=>$groups]);
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    public function store(CreatePhotoRequest $request,$location)
    {
        $photo = new Photo();
        $photo->label = $request->get('label');
        $photo->location_id = $request->get('location');
        $photo->user_id = $request->user()->id;
        $photo->group_id = $request->get('group_id');
        $photo->save();
        $filename = $request->saveFile('origen',$photo->path);
        $workingfile = $request->saveWorkFile('origen',$photo->path);



        $group = Group::find($request->get('group_id'));
        $sharing = [];
        if (isset($group)){
            foreach ($group->publicationsites as $site)
                $sharing[] = ['name'=>$site->name,'url'=>$site->url];
        }

        $data = ['rowid'=>-1,
            'remoteId'=>$photo->id,
            'remoteSrc'=>$workingfile,
            'name'=>$photo->label,
            'src'=>$filename,
            'owner'=>$request->user()->phone,
            'status'=>Status::STATUS_CREADA,
            'timestamp'=>$photo->created_at,
            'sharing'=>$sharing,
            'people'=>[],
            'log'=>[]];
        $photo->data = json_encode($data);
        /*
        if (isset($filename)) {
            $photo->origen = $filename;
            $photo->photo = $filename;
        }*/
        $photo->save();

        return redirect($request->get('redirects_to'));
    }

    public function edit(Request $request,$location,$id)
    {
        $photo = Photo::find($id);
        if (isset ($photo))
        {
            return $this->sendView($request,$photo);
        }

    }

    public function show($location,$id)
    {
        return redirect()->action('ContractsController@index',['location'=>$location,'photo'=>$id]);

    }

    public function update(EditPhotoRequest $request, $location , $id)
    {
        $photo = Photo::find($id);
        if (isset($photo)) {
            $photo->fill($request->all());
            $filename = $request->saveFile('origen',$photo->path);
            if (isset($filename)) {
                $photo->origen = $filename;
                $photo->photo = $filename;
            }
            $photo->save();
        }

        return redirect($request->get('redirects_to'));
    }

    public function destroy($location,$id,Request $request)
    {
        $photo = Photo::findOrFail($id);


        Storage::disk('s3')->delete($photo->photopath);

        $photo->delete();
        $message = $photo->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Photo::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }

    public function send(Request $req, $location,$id){

        $photo = Photo::find($id);
        $people = $photo->getData('people');
        $rhs = array();
        //RightholderPhoto::where('photo_id', $photo->id)->delete();
        foreach($people as $person){
            foreach($person->rightholders as $rh){
                $rhphoto = RightholderPhoto::where([['photo_id', $photo->id],['name',$person->name],['phone',$person->phone],['rhphone',$rh->phone]])->first();
                if (!isset($rhphoto)) {
                    $rhphoto = new RightholderPhoto();
                }
                $rhphoto->setValues($photo,$person,$rh);
                $rhphoto->save();
                array_push($rhs,$rhphoto);
            }
        }
        $template_email = trans('labels.template.consentimiento').$req->user()->name;

        return view('photos.send', ['name' => 'photos', 'element' => $photo,'rhs'=>$rhs,'template'=>$template_email]);
    }

    public  function recognition(Request $req,$location,$id)
    {
        $photo = Photo::find($id);

        return view('photos.faces', ['name' => 'photos', 'element' => $photo]);

    }

    public function makeRecognition(Request $req,$location,$photo_id){

        $photo = Photo::find($photo_id);

        if (isset ($photo))
        {
            try {
                \Rekognition::deleteCollection($photo->collection);
            }catch(Exception  $t){}
            try {
                \Rekognition::createCollection($photo->collection);
            }catch(Exception  $t){}

            // borrar todas las faces de la imagen
            $photo->deleteFaces();

            $result= \Rekognition::indexFaces([ 'CollectionId'=>$photo->group->collection,
                                                'DetectionAttributes'=>['DEFAULT'],
                                                'Image'=>['S3Object'=>[
                                                    'Bucket'=>env('AWS_BUCKET'),
                                                    'Name'=>$photo->photopath]]]);

            //dd($result);

            $img = Image::make($photo->origen);

            $faces = $result['FaceRecords'];
            $matches=array();

            // Recorremos por cada cara encontrada en la imagen
            foreach($faces as $i=>$face){
                $x = $face['Face']['BoundingBox']['Left']*$img->width();
                $y = $face['Face']['BoundingBox']['Top']*$img->height();
                $w = $face['Face']['BoundingBox']['Width']*$img->width();
                $h = $face['Face']['BoundingBox']['Height']*$img->height();


                $img->rectangle($x,$y,$x+$w,$y+$h, function ($draw) {
                    $draw->background('rgba(255, 255, 255, 0.2)');
                    $draw->border(2, '#000');
                });

                $faceObj = $photo->newFace($x,$y,$w,$h);

                $params = \Rekognition::setSearchFacesParams($photo->group->collection,$face['Face']['FaceId'],40,100);
                $results= \Rekognition::searchFaces($params);
                // Nos devuelve una matriz de coincidencias
                if (count($results['FaceMatches'])>0) {

                    $faceID=$results['FaceMatches'][0]['Face']['FaceId']; // OJO sólo cojo el primero!!!

                    $person = $photo->group->findPerson($faceID);
                    //dd($req->get('location'));
                    if (isset($person)) {
                        $this->newContract($req->get('location'),$photo->id,$person->id);
                        $faceObj->person_id = $person->id;

                        $faceObj->save();
                    }
                    $matches[] = $results;

                }
            }
            $filename = General::saveImage('photo',$photo->path,$img->stream()->__toString(),'jpg');
            //dd($filename);
            if(isset($filename))
                $photo->photo = $filename;

            $photo->findings=count($matches);
            $photo->save();
            return back();
        }
    }

    public function newContract($photoId,$personId){
        // abrir la people y meterle una nueva persona
        $photo = Photo::find($photoId);
        $person = Person::find($personId);
        if (isset($photo)&&isset($person)) {

            $data = json_decode($photo->data);
            // ahora vamos a la people
            $rightholders = array();
            foreach($person->rightholders as $rightholder){
                $rh_data = ['id'=>$rightholder->id,
                    'documentId'=>$rightholder->documentId,
                    'relation'=>$rightholder->relation,
                    'name'=>$rightholder->name,
                    'phone'=>$rightholder->phone,
                    'email'=>$rightholder->email,
                    'person_id'=>$person->id,
                    'location_id'=>$rightholder->location->id,
                    'status'=>0];
                $rightholders[] = $rh_data;
            }
            $person_data = ['id'=>$person->id,'name'=>$person->name,'phone'=>'','photo'=>$person->photo,'rightholders'=>$rightholders];
            if (isset($data->people)) {
                $data->people[] = $person_data;
            }
            $photo->data = json_encode($data);
            $photo->save();
            return $photo->data;

        }
    }

    public function deleteContract(Request $req,$location,$photo_id,$person_id){

        $photo = Photo::find($photo_id);
        $person = Person::find($person_id);
        if (isset($photo)&&isset($person)) {
            $data = json_decode($photo->data);
            $this->array_remove_object($data->people,$person_id,'id');
            $data->people = array_values($data->people);
            $photo->data = json_encode($data);
            $photo->save();
            return $data->people;
        }


        return back();
    }

    function array_remove_object(&$array, $value, $prop)
    {
        foreach($array as $index=>$elem){
            if($elem->$prop == $value) {
                unset($array[$index]);
                return;
            }
        }
    }

    public function addContract(Request $req,$location,$photo_id,$person_id){

        $this->newContract($photo_id,$person_id);
        return back();
    }

    public function emails(Request $req,$location)
    {
        //return json_encode($req->all());
        $photo = Photo::find($req->get('photoId'));
        $email_text = $req->get('email');
        //Log::debug('antes email');
        $count=0;

        try {
            foreach ($photo->rightholderphotos as $rhp) {
                //Log::debug('antes email' . json_encode($rhp));
                if ($rhp->rhemail && $rhp->rhemail != "") {

                    $ret = Mail::to($rhp->rhemail)->queue(new RequestSignature($rhp, $email_text,$req->user()->email,$photo->getData('remoteSrc')));
                    //Log::debug('email:'.$ret);
                    $count++;
                }
            }
        }catch (Exception $e){
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
            return redirect()->back();
        }
        $photo->setData('status',Status::STATUS_PENDING);
        $photo->save();
        Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails solicitando el consentimiento.");

        return redirect('photos');

    }

    public function share(Request $req,$location,$photoId,$share){
        $photo = Photo::find($photoId);

        return  Share::load($photo->getSharedLink(),'Example')->$share();
    }

}
