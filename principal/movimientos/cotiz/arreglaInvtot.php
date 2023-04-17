<?php

function arreglarSql($temp)
{
    //error_log("---------sql Antiguo--------------");
    //error_log($temp);
    //error_log("---------sql Nuevo---------");

    $tempNuevo = preg_replace("/,(?!(?:[^']*'[^']*')*[^']*$)/", '.', $temp);

    //error_log($tempNuevo);

    return $tempNuevo;
}

?>