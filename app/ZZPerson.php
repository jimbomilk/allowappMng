<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Http\Request;

class ZZPerson extends Model
{
     use Sortable;
     protected $visible = ['PERSONCODE','FAMILYNAME1','GIVENNAME','IDTYPE','PERSONID','email','BIRTHDATE'];
     protected $connection = 'sqlsrv';
     protected $table = 'person';

     protected $fillable = ['personcode'];
     public $sortable = ['FAMILYNAME1','GIVENNAME'];


}
