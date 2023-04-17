<?php
require_once('../conexion.php');
$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
       // $masPrecioVenta = $row['masPrecioVenta'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../precios_por_local.php';
}
$sqlDetalleVen = "SELECT DV.invnum,DV.codpro,DV.canpro,DV.costpr,DV.fraccion,V.sucursal FROM `detalle_venta` as DV INNER JOIN venta as V on V.invnum=DV.invnum where DV.invnum='224655' ORDER by DV.codpro,V.sucursal ";
$resultDetalleVen = mysqli_query($conexion, $sqlDetalleVen);
if (mysqli_num_rows($resultDetalleVen)) {
    while ($rowDetalleVen = mysqli_fetch_array($resultDetalleVen)) {
        $invnum    = $rowDetalleVen['invnum'];
        $codpro    = $rowDetalleVen['codpro'];
        $canpro    = $rowDetalleVen['canpro'];
        $costprDV    = $rowDetalleVen['costpr'];
        $fraccion    = $rowDetalleVen['fraccion'];
        $sucursal    = $rowDetalleVen['sucursal'];

        $sqlProducto = "SELECT factor,costpr,costre,utlcos,costpr/factor,codpro FROM `producto` WHERE codpro='$codpro'";
        $resultProducto = mysqli_query($conexion, $sqlProducto);
        if (mysqli_num_rows($resultProducto)) {
            while ($rowProducto = mysqli_fetch_array($resultProducto)) {
                $factor             = $rowProducto['factor'];
                $codpro             = $rowProducto['codpro'];

                if (($sucursal == 1) && ($precios_por_local == 1)) {
                    $costpr             = $rowProducto['costpr'];
                    $costre             = $rowProducto['costre'];
                    $utlcos             = $rowProducto['utlcos'];
                    $costprUnidad       = $rowProducto[4];
                } elseif ($precios_por_local == 0) {
                    $costpr             = $rowProducto['costpr'];
                    $costre             = $rowProducto['costre'];
                    $utlcos             = $rowProducto['utlcos'];
                    $costprUnidad       = $rowProducto[4];
                }
                if (($sucursal <> 1) && ($precios_por_local == 1)) {
                    $sql_precio = "SELECT $costpr_p,$costre_p ,$utlcos_p FROM precios_por_local where codpro = '$codpro'";
                    $result_precio = mysqli_query($conexion, $sql_precio);
                    if (mysqli_num_rows($result_precio)) {
                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                            $costpr = $row_precio[0];
                            $costre = $row_precio[1];
                            $utlcos = $row_precio[2];
                            $costprUnidad = $costpr / $factor;
                        }
                    }
                }
            }
        }
        if ($fraccion == 'T') {
            if ($costprDV > ($costprUnidad + 2)) {
                // echo $codpro . ' = costprDV = ' . $costprDV . ' --> costprUnidad + 2 = ' . ($costprUnidad + 2) . ' --> costprUnidad  verdad = ' . $costprUnidad . "<br>";
                mysqli_query($conexion, "UPDATE `detalle_venta` SET costpr='$costprUnidad' WHERE codpro='$codpro'  and  invnum ='$invnum' and fraccion='T' ");
            }
        } else {
            if ($costprDV == '0') {
                mysqli_query($conexion, "UPDATE `detalle_venta` SET costpr='$costpr' WHERE codpro='$codpro'  and  invnum ='$invnum' and fraccion='F' ");
            }
        }
    }
}
