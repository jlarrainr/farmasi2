<?php

 ini_set('display_errors', 1);
 ini_set("log_errors", 1);
require_once('../conexion.php');

$localInicio="2";

$localDestino="3";


$sqlInicio = "SELECT nomloc,nombre,seriebol,seriefac,serietic,numbol,numfac,numtic FROM xcompa where codloc = '$localInicio'";
$resultInicio = mysqli_query($conexion, $sqlInicio);
if (mysqli_num_rows($resultInicio)) {
    while ($row = mysqli_fetch_array($resultInicio)) {
        $nomlocalG = $row['nomloc'];
        $nombre = $row['nombre'];
        $seriebol = $row['seriebol'];
        $seriefac = $row['seriefac'];
        $serietic = $row['serietic'];
        $numbol = $row['numbol'];
        $numfac = $row['numfac'];
        $numtic = $row['numtic'];

    }
}
$numero_xcompaInicio = substr($nomlocalG, 5, 2);
$stockInicio = "s" . str_pad($numero_xcompaInicio, 3, "0", STR_PAD_LEFT);


$sqlDestino = "SELECT nomloc,nombre FROM xcompa where codloc = '$localDestino'";
$resultDestino = mysqli_query($conexion, $sqlDestino);
if (mysqli_num_rows($resultDestino)) {
    while ($row = mysqli_fetch_array($resultDestino)) {
        $nomlocalG = $row['nomloc'];
        $nombre = $row['nombre'];
    }
}
$numero_xcompaDestino = substr($nomlocalG, 5, 2);
$stockDestino = "s" . str_pad($numero_xcompaDestino, 3, "0", STR_PAD_LEFT);


echo '$stockInicio = '.$stockInicio."<br>";
echo '$stockDestino = '.$stockDestino."<br>";
//mysqli_query($conexion, "TRUNCATE temp_detalle_venta");


$producto="UPDATE producto set $stockDestino = $stockInicio ";
mysqli_query($conexion, $producto);

mysqli_query($conexion, "UPDATE venta set sucursal = '$localDestino' where sucursal = '$localInicio'");


  



mysqli_query($conexion, "UPDATE venta_resumen set sucursal = '$localDestino' where sucursal = '$localInicio'");

mysqli_query($conexion, "UPDATE venta_nosave set sucursal = '$localDestino' where sucursal = '$localInicio'");

mysqli_query($conexion, "UPDATE kardex set sucursal = '$localDestino' where sucursal = '$localInicio'");

mysqli_query($conexion, "UPDATE movmae set sucursal = '$localDestino' where sucursal = '$localInicio'");

mysqli_query($conexion, "UPDATE movmov set codloc = '$localDestino' where codloc = '$localInicio'");

mysqli_query($conexion, "UPDATE usuario set codloc = '$localDestino' where codloc = '$localInicio'");

mysqli_query($conexion, "UPDATE movlote set codloc = '$localDestino' where codloc = '$localInicio'");

mysqli_query($conexion, "UPDATE reporteunico set codloc = '$localDestino' where codloc = '$localInicio'");


mysqli_query($conexion, "UPDATE xcompa set seriebol='$seriebol',seriefac='$seriefac',serietic='$serietic',numbol='$numbol',numfac='$numfac',numtic='$numtic'  where codloc = '$localInicio");

mysqli_query($conexion, "UPDATE agotados set sucursal = '$localDestino' where sucursal = '$localInicio'");

mysqli_query($conexion, "UPDATE cotizacion set sucursal = '$localDestino' where sucursal = '$localInicio'");

?>