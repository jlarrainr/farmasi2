<?php
require_once('../conexion.php');

$sqlDetalleVen = "SELECT codpro FROM producto  ORDER by  codpro  ";
$resultDetalleVen = mysqli_query($conexion, $sqlDetalleVen);
if (mysqli_num_rows($resultDetalleVen)) {
    while ($rowDetalleVen = mysqli_fetch_array($resultDetalleVen)) {
        $codpro    = $rowDetalleVen['codpro'];

        $sqlProducto = "SELECT COUNT(*) FROM kardex WHERE codpro='$codpro' GROUP BY codpro ";
        $resultProducto = mysqli_query($conexion, $sqlProducto);
        if (mysqli_num_rows($resultProducto)) {
        } else {
           // echo 'eliminad = '. $codpro.'<br>';
        mysqli_query($conexion, "DELETE FROM producto  WHERE codpro='$codpro' and stopro='0' ");
        }
    }
}
