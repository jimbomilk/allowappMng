<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\IntermediateExcel3;

class IntermediateExcel2 extends Model
{

    protected $table = 'intermediate_excel_2'; // RIGHTHOLDERS
    protected $groups =[];


    public function __construct (){
    //    $this->groups = IntermediateExcel3::where('location_id',$this->location_id)->pluck('site_group');

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
                }
                break;
            case "rightholder_email" :
                if (!isset($value)||$value==""){
                    $title = "Es un campo obligatorio";
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
        }
        $title = "correcto";
        return true;
    }
}
