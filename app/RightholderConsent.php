<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RightholderConsent extends Model
{
    protected $fillable = ['consents','rightholder_id','consent_id','consents'];

    public function rightholder()
    {
        return $this->belongsTo('App\Rightholder','rightholder_id','id');
    }

    public function consent()
    {
        return $this->belongsTo('App\Consent','consent_id','id');
    }

    public function getLinkAttribute(){
        $token = Token::generateShared($this->id);
        $route = route('rightholder.link.shared', ['id' => $this->id,'token' => $token],true);

        return $route;
    }
}
