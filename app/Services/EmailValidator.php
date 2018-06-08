<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 29/05/2018
 * Time: 14:30
 */

namespace App\Services;


use App\Photo;

class EmailValidator {

    public static function validate_rhs($attribute, $value, $parameters, $validator)
    {
        //dd($validator);
        $photo = Photo::find($value);
        $rhp = $photo->rightholderphotos;
        //dd(count($rhp));
        $value = isset($rhp) && count($rhp)>0;
        return $value;
    }

}