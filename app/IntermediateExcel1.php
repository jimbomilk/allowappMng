<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntermediateExcel1 extends Model
{
    protected $table = 'intermediate_excel_1'; // PERSONS
    protected $groups = null;


    public function checkGroup($value){
        if(!isset($this->groups))
            $this->groups =array_unique(IntermediateExcel3::where('location_id',$this->location_id)->pluck('site_group')->toArray());
        return in_array($value,$this->groups);
    }

    public function editable($key){
        switch ($key) {
            case "person_code" :
            case "person_photo_path" :
            case "status" :
                return false;
        };
        return true;
    }

    public function check($key,$value,&$title){
        switch ($key) {
            case "person_code" :
                if (!isset($value)||$value==""||!ctype_digit($value)){
                    $title = "Es un campo obligatorio";
                    return false;
                } break;
            case "person_group" :
                if (!isset($value)||$value==""||!is_string($value)||!$this->checkGroup($value)){
                    $title = "Es un campo obligatorio";
                    $title='Grupo incorrecto';
                    return false;
                };
                break;
            case "person_name" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "person_minor" :
                if(!isset($value)||$value=="" || ($value!="SI"&&$value!="NO")){
                    $title = 'Valor incorrecto. Los valores válidos son SI y NO';
                    return false;
                }
                break;
            case "person_dni" :
                if($this->person_minor=="NO"  && (!isset($value)||$value=="")){
                    $title = 'Valor incorrecto porque es un valor obligatorio para mayores de 16 años';
                    return false;
                }
                break;
            case "person_phone" :
                if($this->person_minor=="NO" && (!isset($value)||$value=="")){
                    $title = 'Valor incorrecto porque es un valor obligatorio para mayores de 16 años';
                    return false;
                }
                break;
            case "person_email" :
                if($this->person_minor=="NO" && (!isset($value)||$value=="")){
                    $title = 'Valor incorrecto porque es un valor obligatorio para mayores de 16 años';
                    return false;
                }
                if (isset($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $title = "No es un email válido";
                    return false;
                };
                break;
            case "person_photo_path" :
                if (!$this->person_photo_path || !isset($value)||$value=="") {
                    $title = "Es un campo obligatorio. Debe asignarse una foto";
                    return false;
                }
                break;
            case "status" :
                if ($value=='ko'){
                    $title = "No se ha podido importar. Se han de solucionar los errores previos";
                    return false;
                }
                break;
        };

        $title = "correcto";
        return true;
    }


    public function getPhotopathAttribute()
    {
        $path = 'locations/location'.$this->location_id.'/imports/import'. $this->import_id. '/' ;

        return $path.'/'.basename(urldecode($this->person_photo_path));
    }
}
