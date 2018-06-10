<?php

namespace App\Http\Controllers;

use App\Ack;
use App\Contract;
use App\Face;
use App\General;
use App\Group;
use App\Historic;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\EditPhotoRequest;
use App\Http\Requests\SendPhotoRequest;
use App\Location;
use App\Mail\RequestSignature;
use App\Person;
use App\PersonPhoto;
use App\Photo;
use App\Rightholder;
use App\RightholderPhoto;
use App\Status;
use App\Token;
use App\User;
use Larareko\Rekognition\RekognitionFacade;
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
        $box_original=null;
        $box_working=null;
        $filename = $request->saveWatermarkFile($box_original,'origen',$photo->path,'final',400);
        $workingfile = $request->saveWatermarkFile($box_working,'origen',$photo->path,'working',300);

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
            'owner'=>$request->user()->id,
            'status'=>Status::STATUS_CREADA,
            'timestamp'=>$photo->created_at,
            'sharing'=>$sharing,
            'people'=>[],
            'log'=>[]];
        $photo->data = json_encode($data);
        $photo->box = json_encode($box_original);
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

    private function deleteFaces($photo){
        if($photo->faces) {
            $toDelete = [];
            $faces=json_decode($photo->faces);
            foreach($faces as $face)
                $toDelete[] = $face->Face->FaceId;

            //dd($toDelete);
            try {

                RekognitionFacade::deleteFaces($photo->group->collection, $toDelete); // se borran las imagenes de la foto q se habían añadido para la búsqueda.
            } catch (Exception  $t) {
            }
        }
    }

    public function send(Request $req, $location,$id){
        $enabled = false;
        $photo = Photo::find($id);

        if(!isset($photo))
            return;

        // Borramos las faces del grupo para que se vuelvan a utilizar en la siguiente.
        $this->deleteFaces($photo);
        $people = $photo->getData('people');

        $rhs = array();
        //RightholderPhoto::where('photo_id', $photo->id)->delete();
        foreach($people as $person){
            $person_rhs=0;
            $person_ok=false;
            foreach($person->rightholders as $rh){
                $rh_real = Rightholder::find($rh->id);

                $rhphoto = RightholderPhoto::where([['user_id', $photo->user_id],['photo_id', $photo->id],['person_id',$person->id],['rightholder_id',$rh->id]])->first();
                if (!isset($rhphoto)) {
                    $rhphoto = new RightholderPhoto();
                    $rhphoto->setValues($photo,$person,$rh_real);
                    $rhphoto->save();
                    $person_rhs++;
                    if ($rh_real->relation=='tutor')
                     $person_ok=true; // al menos tiene un rightholder
                }

                array_push($rhs,$rhphoto);
            }
            $person_ok = $person_ok?true:($person_rhs>=2);//

        }
        $template_email = trans('labels.template.consentimiento').$req->user()->name;



        return view('photos.send', ['name' => 'photos', 'element' => $photo,'rhs'=>$rhs,'template'=>$template_email,'enabled'=>$enabled]);
    }

    public  function recognition(Request $req,$location,$id)
    {
        $photo = Photo::find($id);
        if (isset ($photo)) {

            // borrar todas las faces de la imagen
            //dd($photo->group->collection);
            $result = RekognitionFacade::indexFaces(['CollectionId' => $photo->group->collection,
                'DetectionAttributes' => ['DEFAULT'],
                'Image' => ['S3Object' => [
                    'Bucket' => env('AWS_BUCKET'),
                    'Name' => $photo->photoFinalpath]]]);

            //dd($result);
            $faces = $result['FaceRecords'];
            $photo->faces = json_encode($faces);
            $photo->save();

        }
        return view('photos.faces', ['name' => 'photos', 'element' => $photo, 'faces'=>$faces]);

    }

    public function makeRecognition(Request $req,$location,$photo_id){

        $photo = Photo::find($photo_id);

        if (isset ($photo))
        {
            $faces =  json_decode($photo->faces);
            // Recorremos por cada cara encontrada en la imagen
            foreach($faces as $i=>$face){
                $facePhotoID = $face->Face->FaceId;
                $box = $face->Face->BoundingBox;
                $results= null;
                try {
                    $params = RekognitionFacade::setSearchFacesParams($photo->group->collection,$face->Face->FaceId,70,40);
                    $results= RekognitionFacade::searchFaces($params);
                }catch(Exception  $t){dd($t);};
                // Nos devuelve una matriz de coincidencias
                if (count($results['FaceMatches'])>0) {
                    $faceID=$results['FaceMatches'][0]['Face']['FaceId']; // OJO sólo cojo el primero!!!
                    $person = $photo->group->findPerson($faceID);
                    if (isset($person) ) {
                        $this->newContract($req,$photo->id,$person->id,['faceID'=>$faceID,'box'=>$box,'facePhotoId'=>$facePhotoID]);
                    }
                }
            }
            $photo->save();
            return back();
        }
    }

    public function newContract(Request $req, $photoId,$personId,$face=null){
        // abrir la people y meterle una nueva persona
        $photo = Photo::find($photoId);
        $person = Person::find($personId);
        if (isset($photo)&&isset($person) &&!$photo->findPerson($personId)) {

            $data = json_decode($photo->data);
            // ahora vamos a la people
            $rightholders = array();
            foreach($person->rightholders as $rightholder){
                $rh_data = ['id'=>$rightholder->id,
                    'person_id'=>$person->id,
                    'location_id'=>$rightholder->location->id,
                    'status'=>0];
                $rightholders[] = $rh_data;
            }
            if (isset($data->people)) {
                $data->people[] = new PersonPhoto($person->id,$rightholders,$face);
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

        $this->newContract($req,$photo_id,$person_id);
        return back();
    }

    public function emails(SendPhotoRequest $req,$location)
    {
        //return json_encode($req->all());
        $photo = Photo::find($req->get('photoId'));
        $email_text = $req->get('email');
        //Log::debug('antes email');
        $count=0;

        try {
            foreach ($photo->rightholderphotos as $rhp) {
                $rh = Rightholder::find($rhp->rightholder_id);
                if (isset($rh) && $rh->email != "") {
                    Mail::to($rh->email)->queue(new RequestSignature($rhp, $email_text, $req->user()->email, $photo->getData('remoteSrc')));
                    //Log::debug('email:'.$ret);
                    $count++;
                    $h = new Historic();
                    $h->register($req->user()->id,"Solicitud de consentimiento enviada a ". $rh->person->name,$photo->id,$rh->person->id, $rh->id);
                }

            }
        }catch (Exception $e){
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
            return redirect()->back();
        }
        $photo->setData('status',Status::STATUS_PENDING);
        $photo->save();

        if ($count >0)
            Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails solicitando el consentimiento.");
        else {
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde.");
            return redirect()->back();
        }


        return redirect('photos');

    }

    public function share(Request $req,$location,$photoId,$share){
        $photo = Photo::find($photoId);

        return  Share::load($photo->getSharedLink(),'Example')->$share();
    }

}
