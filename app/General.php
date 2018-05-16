<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


class General extends Model{


    public function __construct($attributes = array())  {
        parent::__construct($attributes); // Eloquent



    }


    public function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $i=>$value )
        {
            $v = trim( $value, "'" );
            $enum = array_add($enum, $value, trans('label.'.$v));
        }
        return $enum;
    }


    public static function getRawWhere($searchable,$search)
    {
        $where = " (1 = 2 ";
        foreach($searchable as $searchfield)
        {
            $where .= " or ";
            $where .= $searchfield;
            $where .= " like '%";
            $where .= $search;
            $where .= "%'";
        }
        $where .= ")";
        return $where;
    }

    public function getCreateDateAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        //dd($localoffset);
        $startgame = Carbon::parse($this->created_at);
        $ret = $startgame->addHours($localoffset)->format('d-M-Y');
        return $ret;
    }

    public function getUpdateDateAttribute()
    {
        $localoffset = Carbon::now($this->location->timezone)->offsetHours;
        $startgame = Carbon::parse($this->update_at);
        $ret = $startgame->addHours($localoffset)->format('d-M-Y');
        return $ret;
    }


    public static function saveImage($field,$folder,$image,$extension)
    {
        if (!isset($field) || $field == '')
            return null;

        $filename = $folder . '/' . $field .Carbon::now(). '.' . $extension;
        if (Storage::disk('s3')->put($filename, $image,'public')) {
            return Storage::disk('s3')->url($filename);
        }
        return null;
    }

}

