<?php
require_once('conexion.php');
//mysqli_query($conexion, "UPDATE venta SET tipdoc='4' WHERE invfec BETWEEN '2020-08-17' and '2020-09-19'  AND estado='0' and tipdoc='2'");
// esto corremos en forma unica no con programa- ctrl C = ctrl V

$sqlX = "SELECT invnum,tipdoc,sucursal from venta WHERE estado='0' and tipdoc='2' ";
$resultX = mysqli_query($conexion, $sqlX);
if (mysqli_num_rows($resultX)) {
    while ($rowX = mysqli_fetch_array($resultX)) {
        $venta  = $rowX[0];
        $tipdoc  = $rowX[1];
        $sucursal  = $rowX[2];
        $NuevoCorrelativo = 0;
        //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
        $sqlXCOM = "SELECT seriebol,seriefac,serietic,numbol,numfac,numtic FROM xcompa where codloc = '$sucursal'";
        $resultXCOM = mysqli_query($conexion, $sqlXCOM);
        if (mysqli_num_rows($resultXCOM)) {
            while ($row = mysqli_fetch_array($resultXCOM)) {
                $seriebol = $row['seriebol'];
                $seriefac = $row['seriefac'];
                $serietic = $row['serietic'];
                $numbol = $row['numbol'];
                $numfac = $row['numfac'];
                $numtic = $row['numtic'];
                // BOLETA
                if ($tipdoc == 1) {
                    $serie = "F" . $seriefac;
                    $NuevoCorrelativo = $numbol + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numbol = '$NuevoCorrelativo' where codloc = '$sucursal'");
                }
                // FACTURA
                if ($tipdoc == 2) {
                    $serie = "B" . $seriebol;
                    $NuevoCorrelativo = $numfac + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numfac = '$NuevoCorrelativo' where codloc = '$sucursal'");
                }
                //TICKET
                if ($tipdoc == 4) {
                    $serie = "T" . $serietic;
                    $NuevoCorrelativo = $numtic + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numtic = '$NuevoCorrelativo' where codloc = '$sucursal'");
                }
            }
            $PrintSerie = $serie . '-' . $NuevoCorrelativo;
            mysqli_query($conexion, "UPDATE venta set nrovent = '$NuevoCorrelativo', correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie' where invnum = '$venta'");
        }
    }
}
