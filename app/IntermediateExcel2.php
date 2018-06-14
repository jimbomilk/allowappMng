<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IntermediateExcel3;

class IntermediateExcel2 extends Model
{

    protected $table = 'intermediate_excel_2'; // RIGHTHOLDERS
    protected $persons =null;




    public function checkPerson($value){
        if(!isset($this->persons))
            $this->persons =array_unique(IntermediateExcel1::where('location_id',$this->location_id)->pluck('person_code')->toArray());
        return in_array($value,$this->persons);
    }


    public function check($key,$value,&$title){
        switch ($key) {

            case "rightholder_code" :
                if (!isset($value) || $value == "" || !ctype_digit($value)) {
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;

            case "rightholder_person_code" :

                if (!isset($value)||$value==""||!ctype_digit($value)){
                    $title = "Es un campo obligatorio";
                    return false;
                }else if (!$this->checkPerson($value)){
                    $title = "Este código de persona no existe";
                    return false;
                } break;
            case "rightholder_name" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "rightholder_relation" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }elseif ($value!="MADRE" &&
                        $value!="PADRE" &&
                        $value!="TUTOR" &&
                         $value!="PROPIO"){
                    $title = "No es un valor correcto. Los valores correctos son padre, madre, tutor o propio";
                    return false;
                }
                break;
            case "rightholder_email" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }elseif(!filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $title = "No es un email válido";
                    return false;
                }
                break;
            case "rightholder_phone" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "rightholder_document_id" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "status" :
                if ($value=='ko'){
                    $title = "No se ha podido importar. Se han de solucionar los errores previos";
                    return false;
                }
                break;
        }
        $title = "correcto";
        return true;
    }
}
