<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ack extends Model
{
    protected $table = 'acks';

    //contract_id,holder_id,status
    protected $fillable = ['status'];

    public function contract(){
        return $this->belongsTo('App\Contract');
    }

    public function rightholder(){
        return $this->belongsTo('App\Rightholder');
    }

    public function getStatusDesc(){
        if ($this->status==-1)
            return trans('label.acks.status_pending');
        else if ($this->status==0)
            return trans('label.acks.status_rejected');
        else if ($this->status==1)
            return trans('label.acks.status_accepted');
    }

    public function getCollectionAttribute(){
        return "$this->table-$this->id";
    }

    public function getPathAttribute()
    {
        return $this->contract->path.'/'.$this->table;
    }

    public function getPhotopathAttribute()
    {
        return $this->contract->path.'/'.$this->table.'/'.basename(urldecode($this->photo));
    }
}
