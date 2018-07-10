<?php
/**
 * Created by PhpStorm.
 * User: jimbomilk
 * Date: 3/10/2017
 * Time: 7:46 AM
 */

namespace App;



class Status {

    const STATUS_CREADA = 10;
    const STATUS_PENDING = 20;
    const STATUS_PROCESED = 30;
    const STATUS_SHARED = 40;
    const STATUS_REVIEW = 50;

    //Status de los sharing de los rightholders
    const RH_NOTREQUESTED = 0;
    const RH_PENDING = 10;
    const RH_PROCESED = 20;

    public static $desc = array(10  => 'creada' ,
                                20  => 'pendiente',
                                30  => 'procesada',
                                40  => 'compartida',
                                50  => 'en revision');




    public static $descRH = array(0   =>'pendiente' ,
                                    10  =>'procesado');

    public static function color($status){
        switch($status) {
            case 10:
                return '#99ccff';
            case 20 :
                return '#ffcc00';
            case 30 :
                return '#ccff66';
            case 40 :
                return '#e600e6';
            case 50 :
                return '#ff5050';
        }
    }
}

