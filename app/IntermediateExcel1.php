<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntermediateExcel1 extends Model
{
    protected $table = 'intermediate_excel_1'; // PERSONS
    protected $groups = [];

    public function __construct (){
        $this->groups =array_unique(IntermediateExcel3::where('location_id',1)->pluck('site_group')->toArray());

    }

    public function checkGroup($value){
        return in_array($value,$this->groups);
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
                if(!isset($value)||$value==""||strpos($value,"SI")===false && strpos($value,"NO")===false && $value!=""){
                    $title = 'Valor incorrecto';
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
            case "person_photo_name" :
                if (!$this->person_photo_path || !isset($value)||$value=="") {
                    $title = "Es un campo obligatorio y debe asociarse a una ruta valida";
                    return false;
                }
                break;
        };

        $title = "correcto";
        return true;
    }

}
