<?php
require_once('../conexion.php');
mysqli_query($conexion, "UPDATE venta set  correlativo_venta = '0' ");
 mysqli_query($conexion, "UPDATE xcompa set correlativo_venta = '0' ");

$sqlX = "SELECT invnum,sucursal from venta  WHERE estado='0' and nrofactura <>'' ORDER BY invfec,hora,sucursal   ";
$resultX = mysqli_query($conexion, $sqlX);
if (mysqli_num_rows($resultX)) {
    while ($rowX = mysqli_fetch_array($resultX)) {
        
        
        $venta  = $rowX[0];
        $sucursal  = $rowX[1];
         
        $NuevoCorrelativo = 0;
        //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
        $sqlXCOM = "SELECT correlativo_venta  FROM xcompa where codloc = '$sucursal'";
        $resultXCOM = mysqli_query($conexion, $sqlXCOM);
        if (mysqli_num_rows($resultXCOM)) {
            while ($row = mysqli_fetch_array($resultXCOM)) {
                $correlativo_venta = $row['correlativo_venta'];
                
                    $NuevoCorrelativo = $correlativo_venta + 1;
                    mysqli_query($conexion, "UPDATE xcompa set correlativo_venta = '$NuevoCorrelativo' where codloc = '$sucursal'");
                
            }
            
            mysqli_query($conexion, "UPDATE venta set  correlativo_venta = '$NuevoCorrelativo' where invnum = '$venta'");
        }
        
        
        
    }
    
}