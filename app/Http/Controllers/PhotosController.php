<?php

namespace App\Http\Controllers;


use App\Group;
use App\Historic;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\SendPhotoRequest;
use App\Mail\RequestSignature;
use App\Person;
use App\PersonPhoto;
use App\Photo;
use App\Relations;
use App\Rightholder;
use App\RightholderPhoto;
use App\Status;
use Larareko\Rekognition\RekognitionFacade;
use Share;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class PhotosController extends Controller
{
    public function index(Request $request)
    {
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
        $filename = $request->saveWatermarkFile($box_original,'origen',$photo->path,'final',800);
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

    public function destroy($location,$id,Request $request)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('s3')->delete($photo->photopath);

        $h = new Historic();
        $h->register($request->user()->id,"Imagen borrada" ,$id);

        $photo->delete();
        $message = "Imagen ". $photo->name. " borrada";
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

        $people = $photo->getData('people');

        $rhs = array();
        //RightholderPhoto::where('photo_id', $photo->id)->delete();
        $numFaces = count($photo->facesCollection);
        $errors =[];
        foreach($people as $person){

            $realPerson = Person::find($person->id);
            if (isset($realPerson)){
                $person_ok=false;
                $person_rhs=0;
                foreach($person->rightholders as $rh){
                    $rh_real = Rightholder::find($rh->id);
                    if ($rh_real) {
                        $rhphoto = RightholderPhoto::where([['user_id', $photo->user_id], ['photo_id', $photo->id], ['person_id', $person->id], ['rightholder_id', $rh->id]])->first();
                        if (!isset($rhphoto)) {
                            $rhphoto = new RightholderPhoto();
                            $rhphoto->setValues($photo, $person, $rh_real);
                            $rhphoto->save();
                            $person_rhs++;
                            if ($rh_real->relation == Relations::TUTOR || $rh_real->relation == Relations::PROPIO)
                                $person_ok = true; // al menos tiene un rightholder
                        }else{
                            $person_rhs++;
                            if ($rh_real->relation == Relations::TUTOR || $rh_real->relation == Relations::PROPIO)
                                $person_ok = true; // al menos tiene un rightholder
                        }
                        array_push($rhs,$rhphoto);
                    }else{
                        $errors[] = ['type'=>'error', 'text'=>"Uno de los responsables de <strong>$realPerson->name</strong> ha sido eliminado del sistema y no se dispone de datos."];

                    }
                }
                $person_ok = $person_ok?true:($person_rhs>=2);
                if(!$person_ok){
                    if($person_rhs==0)
                        $errors[] = ['type'=>'error', 'text'=>"<strong>$realPerson->name</strong> no tiene asignado ningún responsable"];
                    elseif ($person_rhs<2)
                        $errors[] = ['type'=>'warning', 'text'=>"<strong>$realPerson->name</strong> sólo tiene asignado un responsable.En caso de menores deben ser padre y madre o un tutor."];
                }

            }else{
                $errors[] = ['type'=>'error', 'text'=>"La persona<strong>($person->id)</strong> asignada a la fotografía ha sido eliminada del sistema y no se dispone de datos."];
            }


        }
        $template_email = trans('labels.template.consentimiento').$req->user()->name;

        $numPeople = count($people);
        if ($numFaces>$numPeople){
            $errors[] = ['type'=>'warning', 'text'=>"El nº de caras de la fotografía <strong> ($numFaces) </strong> no se corresponde con el nº de personas detectadas <strong>($numPeople). </strong>"];
        }

        return view('photos.send', ['name' => 'photos', 'element' => $photo,'rhs'=>$rhs,'template'=>$template_email,'enabled'=>$enabled,'errors'=>$errors]);
    }

    public  function recognition(Request $req,$location,$id)
    {
        $photo = Photo::find($id);
        $faces = [];
        if (isset ($photo)) {

            // borrar todas las faces de la imagen
            //dd($photo->group->collection);
            try {
                $result = RekognitionFacade::indexFaces(['CollectionId' => $photo->group->collection,
                    'DetectionAttributes' => ['DEFAULT'],
                    'Image' => ['S3Object' => [
                        'Bucket' => env('AWS_BUCKET'),
                        'Name' => $photo->photoFinalpath]]]);
                //dd($result);
                $faces = $result['FaceRecords'];
                $photo->faces = json_encode($faces);
                $photo->save();
            }catch (Exception $e){
                dd($e);
            }
            return view('photos.faces', ['name' => 'photos', 'element' => $photo, 'faces'=>$faces]);

        }
        Session::flash('message',"¡Error!, no se puede mostrar la fotografía, inténtelo más tarde.");
        return redirect('photos');

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
            return true;
        }
    }

    public function deleteContract(Request $req,$location){
        $photoId= $req->get('imagenId');
        $personId= $req->get('personId');
        $photo = Photo::find($photoId);
        $person = Person::find($personId);
        if (isset($photo)&&isset($person)) {
            $photo->removePerson($personId);
            $photo->save();
            return true;
        }
        return back();
    }



    public function addContract(Request $req,$location){
        $photoId= $req->get('imagenId');
        $personId= $req->get('personId');
        $faceId = $req->get('faceId');
        $photoFaceId = $req->get('photoFace');
        $boxHeight= $req->get('boxHeight');
        $boxWidth= $req->get('boxWidth');
        $boxTop= $req->get('boxTop');
        $boxLeft= $req->get('boxLeft');
        $this->newContract($req,$photoId,$personId,['faceID'=>$faceId,'box'=>['Width'=>$boxWidth, 'Height'=>$boxHeight, 'Top' => $boxTop, 'Left'=> $boxLeft],'facePhotoId'=>$photoFaceId]);
        return back();
    }

    public function emails(SendPhotoRequest $req,$location)
    {
        //return json_encode($req->all());
        $photo = Photo::find($req->get('photoId'));
        $email_text = $req->get('email');
        $count=0;

        try {
            foreach ($photo->rightholderphotos as $rhp) {
                $rh = Rightholder::find($rhp->rightholder_id);
                if (isset($rh) && $rh->email != "") {
                    Mail::to($rh->email)->queue(new RequestSignature($rhp, $email_text, $req->user()->email, $photo->getData('remoteSrc')));
                    //Log::debug('email:'.$ret);
                    $count++;
                    $h = new Historic();
                    $h->register($req->user()->id,"Solicitud de consentimiento enviada a ". $rh->name,$photo->id,$rh->person->id, $rh->id);
                }

            }
        }catch (Exception $e){
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
            return redirect()->back();
        }
        $photo->setData('status',Status::STATUS_PENDING);
        $photo->save();

        // Cuando se envia la imagen se generan todas las mini imagenes para cada una de las redes.
        $photo->updatePhotobyNetwork();

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

        if (isset($photo)) {
            $photo->setStatus (Status::STATUS_SHARED);
            $photo->save();
            $h = new Historic();
            $h->register($req->user()->id, "Imagen compartida en " . $share, $photoId);
            return Share::load($photo->getSharedLink(), 'Example')->$share();
        }

        Session::flash('message',"¡Error!, se ha producido un error, inténtelo más tarde.");
        return redirect('photos');
    }

}
