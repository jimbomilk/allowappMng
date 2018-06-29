<?php

namespace App\Http\Controllers;

use App\General;
use App\Group;
use App\Http\Requests\CreateRightholderRequest;
use App\Http\Requests\EditRightholderRequest;
use App\Location;
use App\Multi;
use App\Person;
use App\Rightholder;
use App\Mail\RequestSignatureRightholder;
use App\RightholderConsent;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RightholdersController extends Controller
{
    //
    public $titles = ['PADRE','MADRE','TUTOR','PROPIO'];
    public function index(Request $request)
    {
        $location_id  = $request->get('location');
        $person_id = $request->get('person');
        $group_id = $request->get('group');
        $request->session()->put('person_id',$person_id);

        $location = Location::find($location_id);
        if(isset($location)){
            $consents = $location->consents;
        }

        $set = null;
        if(isset($person_id)) {
            $set = Rightholder::where('person_id',$person_id)->paginate(15);
        }else if (isset($group_id)){
            $set = $request->user()->getRightholders($request->get('search'),$group_id)->paginate(15);
        }else{
            $set = $request->user()->getRightholders($request->get('search'))->paginate(15);
        }

        $groups = ["Todos los grupos"];
        $groups += $request->user()->getGroups()->pluck('name','id')->toArray();

        return view('common.index', ['name' => 'rightholders', 'set' => $set,'person_id'=>$person_id,'consents'=>$consents,'groups'=>$groups,'group'=>$group_id]);

    }

    public function sendView(Request $req,$element=null)
    {
        $person_id = $req->session()->get('person_id');
        if (isset($person_id))
            $persons = Person::where('id',$person_id)->pluck('name','id');
        else
            $persons = $req->user()->getPersons()->pluck('name','id');


        if (isset($element)) {
            return view('common.edit', ['name' => 'rightholders', 'element' => $element,'titles'=>$this->titles,'persons'=>$persons]);
        }
        else
            return view('common.create',['name'=>'rightholders','titles'=>$this->titles,'persons'=>$persons]);
    }

    public function create(Request $req)
    {
        return $this->sendView($req);
    }

    public function store(CreateRightholderRequest $request,$location)
    {

        $rightholder = new Rightholder($request->all());
        $rightholder->location_id= $request->get('location');
        $rightholder->relation = $this->titles[$request->get('relation')];
        $rightholder->save();

        return redirect('rightholders');
    }

    public function edit(Request $req,$location,$id)
    {
        $rightholder = Rightholder::find($id);
        if (isset ($rightholder))
        {
            return $this->sendView($req,$rightholder);
        }
    }

    public function show($location,$id)
    {
        return redirect()->action('RightholdersController@index',['location'=>$location,'rightholder'=>$id]);
    }

    public function consentimientos(Request $request,$location,$id=null)
    {
        $group_id = $request->get('group');
        $person_id = $request->session()->get('person_id');
        $loc = Location::find($request->get('location'));
        $tiposConsentimientos = [];
        if(isset($loc))
            $tiposConsentimientos = $loc->consents->pluck('description','id');

        $set = null;
        if(isset($id)) {
            $set [] = Rightholder::find($id);
        }
        else if(isset($person_id))
            $set =  Rightholder::where('person_id',$person_id)->get();
        elseif (isset($group_id)) {
            $group = Group::find($group_id);
            $set = $group->getRightholders(null)->get();
        }else{
            $set = $request->user()->getRightholders(null)->get();
        }


        $template = trans('label.rightholders.template');
        return view('rightholders.consentimiento',['name' => 'rightholders','template'=>$template,'set'=>$set,'consents'=>$tiposConsentimientos]);
    }

    public function update(EditRightholderRequest $request, $location , $id)
    {

        $rightholder = Rightholder::find($id);
        if (isset($rightholder)) {
            $rightholder->fill($request->all());
            $rightholder->location_id= $request->get('location');
            $rightholder->relation = $this->titles[$request->get('relation')];
            $rightholder->save();
        }

        return redirect('rightholders');
    }

    public function destroy($location,$id,Request $request)
    {
        $rightholder = Rightholder::findOrFail($id);


        //Storage::disk('s3')->delete($rightholder->path);

        $rightholder->delete();
        $message = $rightholder->name. ' deleted';
        if ($request->ajax())
        {
            return response()->json([
                'id' => $id,
                'message' =>$message,
                'total' => Rightholder::All()->count()
            ]);
        }

        Session::flash('message',$message);
        return redirect()->back();
    }

    private function sendEmail($rh,$consent_id,$email_text,$from){
        //Antes de enviar el email guardamos un registro del tipo de solicitud
        $rhConsent = RightholderConsent::firstOrNew(['rightholder_id'=>$rh->id,'consent_id'=>$consent_id]);
        //dd($rhConsent);
        $rhConsent->status=Status::RH_PENDING;
        $rhConsent->save();
        //dd($rhConsent);

        Mail::to($rh->email)->queue(new RequestSignatureRightholder($rhConsent, $email_text,$from));
    }

    public function emails(Request $req)
    {
        //return json_encode($req->all());
        $element = $req->get('rightholderId');
        $email_text = $req->get('email');
        $consent_id = $req->get('consent_id');
        //dd($consent_id);
        $count=0;
        try {
            if ($element == 'all'){
                foreach ($req->user()->getRightholders()->get() as $rh){
                    $this->sendEmail($rh,$consent_id,$email_text,$req->user()->email);
                    $count++;
                }
            }else{
                $rh = Rightholder::find('element');
                $this->sendEmail($rh,$consent_id,$email_text,$req->user()->email);
                $count++;
            }
        }catch (Exception $e){
            Session::flash('message',"¡Error!, se ha producido un error en el envio, inténtelo más tarde. Detalles:".$e->getMessage());
            return redirect()->back();
        }
        Session::flash('message',"¡Felicidades!, se han enviado correctamente ".$count." emails solicitando el consentimiento.");

        return redirect('rightholders');

    }

}
