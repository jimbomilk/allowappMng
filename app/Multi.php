<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


class Multi {

    public $path = '';




    public static function getEnumValues($table, $column) {
        $type = DB::select(DB::raw("SHOW COLUMNS FROM $table WHERE Field = '{$column}'"))[0]->Type ;
        preg_match('/^enum\((.*)\)$/', $type, $matches);
        $enum = array();
        foreach( explode(',', $matches[1]) as $i=>$value )
        {
            $v = trim( $value, "'" );
            $enum = array_add($enum, $v, trans('label.'.$table.'.'.$v));
            //dd($enum);
        }
        return $enum;
    }



}

