<?php

include('../../session_user.php');
require_once('../../../conexion.php');

$codcli = $_REQUEST['codcli'];
$val = $_REQUEST['val'];
$search = $_REQUEST['search'];



$sql1 = "SELECT fecha,usecod,codclic,despunto,pdescuento,estado,descontado FROM temp_puntos where codclic ='$codcli' and usecod ='$usuario'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $fecha = $row1['fecha'];
        $usecod = $row1['usecod'];
        $codclic = $row1['codclic'];
        $despunto = $row1['despunto'];
        $pdescuento = $row1['pdescuento'];
        $estado = $row1['estado'];
        $descontado = $row1['descontado'];
    }
}

mysqli_query($conexion, "UPDATE cliente set puntos = '$descontado' where codcli = '$codcli'");


$old = $pdescuento + $descontado;

mysqli_query($conexion, "INSERT INTO puntos (fecha,usecod,codclic,despunto,pdescuento,estado,puntosold) values ('$fecha','$usecod','$codclic','$despunto','$pdescuento','$estado','$old')");

// mysqli_query($conexion,"truncate TABLE temp_puntos");
mysqli_query($conexion, "DELETE FROM temp_puntos where codclic ='$codcli' and usecod ='$usuario' ");

header("Location:puntos2.php?search=$search&val=1");
?>