<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 29/05/2018
 * Time: 14:30
 */

namespace App;


class PersonPhoto {

    public $id;
    public $face;
    public $rightholders;


    public function __construct ($id,$rightholders,$face=null){
        $this->id = $id;
        $this->rightholders = $rightholders;
        $this->face = $face;

    }


}