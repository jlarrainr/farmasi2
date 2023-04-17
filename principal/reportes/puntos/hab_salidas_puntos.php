<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
$codclic = $_REQUEST['codcli'];  ///codcli
$codpum = $_REQUEST['codpumnt'];  ///codpum
//echo $codclic."<br>";
//echo $codpum."<br>";

$sql = "SELECT codclic FROM `puntos` WHERE codpun='$codpum' ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codclicc = $row['codclic'];
    }
}
$sql = "SELECT puntos FROM `cliente` WHERE codcli =$codclicc ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $puntos = $row['puntos'];
    }
}



$sql = "SELECT pdescuento,estado FROM `puntos` WHERE codpun='$codpum' and codclic='$codclic'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $pdescuento = $row['pdescuento'];
        $estado = $row['estado'];

        if ($estado == '0') {
            $cantidad = $puntos - $pdescuento;
        }

        mysqli_query($conexion, "UPDATE cliente set puntos = '$cantidad' where codcli = '$codclic'");
    }
}
mysqli_query($conexion, "UPDATE puntos set estado = '1' where codpun = '$codpum'");
header("Location: puntos.php?codclire=$codclic&val22=2");
?>