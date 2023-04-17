<?php


for ($i = 1; $i <= 7; $i++) {


    $nuevosDias = 20 * $i;

    $date1 =  $comprobante['fecha_emision'];
    $fechaPago = date("Y-m-d", strtotime($date1 . "+ $nuevosDias days"));

    echo  $fechaPago . 'nuevosDias = ' . $nuevosDias . "<br>";
}
