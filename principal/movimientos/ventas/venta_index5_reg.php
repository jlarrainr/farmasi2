<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
//error_log("Ventas 5");
$id = $_REQUEST['id'];

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}
$arrAux = array();
$intAux = 0;
foreach ($arr_detalle_venta as $detalle) {
    // if ($intAux != $id) {
    $arrAux[] = $detalle;
    // }
    $intAux++;
}
$_SESSION['arr_detalle_venta'] = $arrAux;

header("Location: venta_index2.php");
