<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
//error_log("Ventas 5");
$venta = $_SESSION['cotiz'];
$id                 = $_REQUEST['id'];
$date               = $_REQUEST['date'];
$cuscod             = $_REQUEST['cuscod'];
$usuario            = $_REQUEST['usuario'];
$codpro             = $_REQUEST['codpro'];
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


mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','$tipo_a_bonificar','$factorB','0','0','$codmarB','0','0','1')");



header("Location: venta_index2.php");
