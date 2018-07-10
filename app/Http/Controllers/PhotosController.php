<?php

namespace App\Http\Controllers;


use App\Consent;
use App\Group;
use App\Historic;
use App\Http\Requests\CreatePhotoRequest;
use App\Http\Requests\EditPhotoRequest;
use App\Http\Requests\SendPhotoRequest;
use App\Location;
use App\Mail\OnlyPhotoEmail;
use App\Mail\RequestSignature;
use App\Person;
use App\PersonPhoto;
use App\Photo;
use App\Photonetwork;
use App\Publicationsite;
use App\Relations;
use App\Rightholder;
use App\RightholderPhoto;
use App\Status;
use Carbon\Carbon;
use Chencha\Share\Share;
use Illuminate\Support\Facades\Response;
use Larareko\Rekognition\RekognitionFacade;
use Chencha\Share\ShareFacade;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


class PhotosController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:owner');
    }

    public function index(Request $request)
    {
        $groups = ["Todos los grupos"];
        $groups += $request->user()->getGroups()->pluck('name','id')->toArray();
        $group_id  = $request->get('group');
        $now = Carbon::now()->timestamp;

        $group = Group::find($group_id);
        if (isset($group)){
            $set = $group->getPhotos($request->get('search'));
        }else{
            $set = $request->user()->getPhotos($request->get('search'));
        }

        $locId = $request->get('location');
        $location = Location::find($locId);
        if (isset($location)){
            $consents = $location->consents->pluck('description','id')->toArray();
        }



        array_unshift($consents,"Todos los consentimientos");
        return view('common.index', [ 'name' => 'photos','searchable'=>1, 'set' => $set,'groups'=>$groups,'group'=>$group_id,'consents'=>$consents,'now'=>$now,'arco'=>true]);
    }

    public function sendView(Request $request,$element=null)
    {
        $groups = $request->user()->getGroups()->pluck('name','id');
        $loc = Location::find($request->get('location'));
        $tiposConsentimientos = [];
        if(isset($loc))
            $tiposConsentimientos = $loc->consents->pluck('description','id');

        if (isset($element)) {
            return view('common.edit', ['name' => 'photos', 'element' => $element, 'groups'=>$groups,'consents'=>$tiposConsentimientos]);
        }
        else {
            return view('common.create', ['name' => 'photos', 'groups' => $groups, 'consents'=>$tiposConsentimientos]);
        }
    }

    public function create(Request $request)
    {
        return $this->sendView($request);
    }

    public function update(EditPhotoRequest $request,$location,$id)
    {
        $photo = Photo::find($id);
        if (isset($photo)) {
            $photo->label = $request->get('label');
            $photo->save();
        }

        return redirect('photos');
    }

    public function store(CreatePhotoRequest $request,$location)
    {
        $loc =Location::byName($location);
        $consent = Consent::find($request->get('consent_id'));

        $photo = new Photo();
        $photo->label = $request->get('label');
        $photo->location_id = $loc->id;
        $photo->user_id = $request->user()->id;
        $photo->group_id = $request->get('group_id');
        $photo->consent_id = $consent->id ;
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

        /*** VIP : si cambias algo aquí recuerda modificar la clase PhotoData **/
        $data = ['rowid'=>-1,
            'remoteId'=>$photo->id,
            'remoteSrc'=>$workingfile,
            'name'=>$photo->label,
            'src'=>$filename,
            'owner'=>$request->user()->id,
            'status'=>Status::STATUS_CREADA,
            'accountable'=> $loc->accountable,
            'accountable_CIF'=> $loc->CIF,
            'accountable_email'=> $loc->email,
            'accountable_address'=> $loc->address,
            'accountable_city'=> $loc->city,
            'accountable_cp'=> $loc->CP,
            'consent_legitimacion'=> $consent->legitimacion,
            'consent_destinatarios'=> $consent->destinatarios,
            'consent_derechos' => $consent->derechos,
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

    public function destroy($location,$id,Request $request)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('s3')->delete($photo->photopath);

        $arco = $request->get('arco');
        $h = new Historic();
        if (isset($arco) && $arco){
            $h->register($request->user()->id,"$photo->name($photo->id) y todos sus datos han sido eliminados del sistema en aplicación de sus derechos ARCO",$photo->id,null,null,true);
        }else {
            $h->register($request->user()->id, "$photo->name($photo->id) y todos sus datos han sido eliminados", $id);
        }

        $photo->delete();
        $message = "Imagen ". $photo->name. " y todos sus datos han sido eliminados";
        if (isset($arco) && $arco)
            $message .= " en aplicación de los derechos ARCO.";
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
        $loc = Location::byName($location);
        $count=0;

        try {
            foreach ($photo->rightholderphotos as $rhp) {
                $rh = Rightholder::find($rhp->rightholder_id);
                if (isset($rh) && $rh->email != "") {
                    Mail::to($rh->email)->queue(new RequestSignature($rhp, $email_text, $loc->email, $photo->getData('remoteSrc')));
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
            $photo->setStatus(Status::STATUS_SHARED);
            $photo->save();
            $group = $photo->group;
            $sites = $group->publicationsites;
            $site = $sites->where('name',$share)->first();
            if (isset($share)) {
                $h = new Historic();
                $h->register($req->user()->id, "Imagen compartida en " . $site->name . ": ".$site->url, $photoId);
                //dd($h);

                return redirect($photo->getSharedLink($site->name));

            }
        }

        Session::flash('message',"¡Error!, se ha producido un error, inténtelo más tarde.");
        return redirect('photos');
    }

    public function byemail(Request $req,$location,$photoId,$share){

        $photo = Photo::find($photoId);
        if (isset($photo)) {
            $photo->setStatus(Status::STATUS_SHARED);
            $photo->save();
            $group = $photo->group;
            $sites = $group->publicationsites;
            $site = $sites->where('name',$share)->first();
            if (isset($share)) {
                $h = new Historic();
                $h->register($req->user()->id, "Imagen compartida en " . $site->name . ": ".$site->url, $photoId);
                //dd($h);
                $photoNetwork = Photonetwork::where([['publicationsite_id',$site->id],['photo_id',$photo->id]])->first();

                if ($photoNetwork && $site->name == "instagram") {
                    Mail::to($req->user()->email)->queue(new OnlyPhotoEmail($photoNetwork->url,$photo->route,"Imagen compartida para instagram","Estimado/a: <br>Le enviamos esta imagen para que pueda compartirla en instagram. <br> Un saludo.", $req->user()->email));
                }
            }
        }

        Session::flash('message',"¡Error!, se ha producido un error, inténtelo más tarde.");
        return redirect('photos');
    }

}


