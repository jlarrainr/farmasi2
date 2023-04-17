<?php
require_once('conexion.php');

$sqlX = "SELECT codpro,desprod from producto_luzfarma1 order by codpro ";
$resultX = mysqli_query($conexion, $sqlX);
if (mysqli_num_rows($resultX)) {
    while ($rowX = mysqli_fetch_array($resultX)) {
        $codpro  = $rowX[0];
        $desprod  = $rowX[1];


        mysqli_query($conexion, "UPDATE producto set desprod = '$desprod' where codpro = '$codpro'");
    }
}
