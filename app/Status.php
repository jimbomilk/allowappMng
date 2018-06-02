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

    //Status de los sharing de los rightholders
    const RH_NOTREQUESTED = 0;
    const RH_PENDING = 10;
    const RH_PROCESED = 20;

    public static $desc = array(10   =>'creada' ,
                                20  =>'pendiente',
                                30  =>'procesada' );


    public static $descRH = array(0   =>'pendiente' ,
                                    10  =>'procesado');

}

