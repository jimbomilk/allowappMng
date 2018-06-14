<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class IntermediateExcel3 extends Model
{
    protected $table = 'intermediate_excel_3';// SITES
    protected $services;

    public function __construct (){
        $this->services = Config::get('social-share.services');
    }

    public function check($key,$value,&$title){
        switch ($key) {
            case "site_code" :
                if (!isset($value)||$value=""||!ctype_digit($value)){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "site_group" :
                if (!isset($value)||$value=""||!is_string($value)){
                    $title = "Es un campo obligatorio";
                    return false;
                }
                break;
            case "site_name" :
                if (!isset($value)||$value=""||!isset($this->services[$value])) {
                    $title = "Es un campo obligatorio y debe ser un nombre de sitio válido";
                    return false;
                };
                break;
            case "site_url" :
                if (!isset($value)||$value=""||filter_var($value, FILTER_VALIDATE_URL)===FALSE){
                    $title = "Es un campo obligatorio que debe ser una url válida";
                    return false;
                };
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
}
