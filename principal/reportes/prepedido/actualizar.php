<?php

require_once ('../../../conexion.php'); //CONEXION A BASE DE DATOS

$idpreped = $_REQUEST['idpreped'];
$numpagina = $_REQUEST['numpagina'];
$iddetalle = $_REQUEST['iddetalle'];
$codpro = $_REQUEST['codpro'];
$cantidad = $_REQUEST['cantidad'];
$number = $_REQUEST['number'];  // si es 1 no es numero ; si es 0 es numero 
$factor = $_REQUEST['factor'];
$almacen = $_REQUEST['almacen'];
$idprepedido = $_REQUEST['idpreped'];

//echo '$iddetalle' . "..." . $iddetalle . "<br>";
//echo '$codpro' . "..." . $codpro . "<br>";
//echo '$cantidad' . "..." . $cantidad . "<br>";
//echo '$number' . "..." . $number . "<br>";

if ($number == 1) {

    function convertir_a_numero($str) {
        $legalChars = "%[^0-9\-\. ]%";

        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

    $cant = convertir_a_numero($cantidad);
} else {
    $cant = ($cantidad * $factor);
}
//echo '$cantidad' . "..." . $cantidad . "<br>";
//echo '$cant' . "..." . $cant . "<br>";
//echo '$almacen' . "..." . $almacen . "<br>";
if (($cant <= $almacen)&&($cant <> 0)&&($cant <> "") ){
    $sql = "UPDATE detalle_prepedido DP SET solicitado='$cantidad',idcantidad='$cantidad',fraccion='$number' WHERE DP.idprepedido = '$idprepedido' AND DP.iddetalle='$iddetalle' and DP.idprod='$codpro'";
    $result = mysqli_query($conexion, $sql);
    $paso = 1;
} else {
    $paso = 2;
}

header("Location: prepedido.php?idpreped=$idpreped&numpagina=$numpagina&paso=$paso"); 