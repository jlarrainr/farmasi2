<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
//error_log("Ventas 5");
$id                 = $_REQUEST['id'];
$date               = $_REQUEST['date'];
$cuscod             = $_REQUEST['cuscod'];
$usuario            = $_REQUEST['usuario'];
$codpro        = $_REQUEST['codpro'];
$codprobonif        = $_REQUEST['codprobonif'];
$tipo_a_bonificar   = $_REQUEST['tipo_a_bonificar'];
$factorB            = $_REQUEST['factorB'];
$factor_pasa        = $_REQUEST['factor_pasa'];
$text1              = $_REQUEST['text1'];
$stock_de_local     = $_REQUEST['stock_de_local'];
$suma_de_cantidades     = $_REQUEST['suma_de_cantidades'];


if ($codpro  == $codprobonif) {
    // CUANDO SON LOS MISMOS PRODUCTO BONIFICABLES
    if ($tipo_a_bonificar == 'F') {
        $cantbonificable = (($stock_de_local - $text1) / $factor_pasa);
        $cantbonificable = ((int) ($cantbonificable));
    } else {
        if ($suma_de_cantidades > $stock_de_local) {
            $cantbonificable_1 = ($stock_de_local - $text1);
            $cantbonificable = $cantbonificable_1;
        }
    }
} else {
    // CUANDO EL PRODUCTO A BONIFICAR ES DISTONTO AL QUE ESTA VENDIENDO

    if ($tipo_a_bonificar == 'F') {
        if ($suma_de_cantidades > $stock_de_local) {
            $cantbonificable = ($stock_de_local / $factor_pasa);
            $cantbonificable = ((int) ($cantbonificable));
        }
    } else {
        if ($suma_de_cantidades > $stock_de_local) {
            $cantbonificable = ($stock_de_local);
            $cantbonificable = ((int) ($cantbonificable));
        }
    }
}


if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

$detalle_venta['invnum']    = $venta;
$detalle_venta['invfec']    = $date;
$detalle_venta['cuscod']    = $cuscod;
$detalle_venta['usecod']    = $usuario;
$detalle_venta['codpro']    = $codprobonif;
$detalle_venta['canpro']    = $cantbonificable;
$detalle_venta['fraccion']  = $tipo_a_bonificar;
$detalle_venta['factor']    = $factorB;
$detalle_venta['prisal']    = '0';
$detalle_venta['pripro']    = '0';
$detalle_venta['codmar']    = $codmarB;
$detalle_venta['cospro']    = '0';
$detalle_venta['costpr']    = '0';
$detalle_venta['bonif2']    = '1';

$arr_detalle_venta[] = $detalle_venta;
$_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
header("Location: venta_index2.php");
