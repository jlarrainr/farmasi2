<?php

require_once('../../session_user.php');
$venta = $_SESSION['venta'];
$_SESSION['cotizacion'] = '';
require_once ('../../../conexion.php');
$sql1 = "SELECT cuscod,invfec,usecod,sucursal,codmed FROM venta where invnum = '$venta'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $cuscod = $row1['cuscod'];
        $invfec = $row1['invfec'];
        $usecod = $row1['usecod'];
        $sucursal = $row1['sucursal'];
        $codmed = $row1['codmed'];
    }
}
require_once ('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
$mont5 = $monto_total;   ///TOTAL
$date = date("Y-m-d");
$hour = date('G');
//$date	= CalculaFechaHora($hour);
/////////////////////////////////////////////////////////////////////////////////////////////////////////
mysqli_query($conexion, "INSERT INTO venta_nosave(invnum,invfec,cuscod,usecod,invtot,sucursal,codmed) values ('$venta','$invfec','$cuscod','$usecod','$mont5','$sucursal','$codmed')");
/////////////////////////////////////////////////////////////////////////////////////////////////////////
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}
if (!empty($arr_detalle_venta)) {
    foreach ($arr_detalle_venta as $row) {
        $codpro = $row['codpro'];  /////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
        $canpro = $row['canpro'];  /////CODIGO DEL PRODUCTO
        $fraccion = $row['fraccion'];
        $prisal = $row['prisal'];
        $pripro = $row['pripro'];
        $factor1 = $row['factor'];
        $codmar = $row['codmar'];
        if (isset($row['bonif'])) {
            $bonif = $row['bonif'];
        } else {
            $bonif = '';
        }

        /////////////DATOS DEL PRODUCTO
        $sql1 = "SELECT stopro,factor,$tabla,codfam,coduso FROM producto where codpro = '$codpro'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $stopro = $row1['stopro'];
                $factor = $row1['factor'];
                $codfam = $row1['codfam'];
                $coduso = $row1['coduso'];
                $cant_loc = $row1[2];
            }
        }
        if ($bonif == 1) {
            $sql1 = "SELECT codkey,cajas FROM temp_vent_bonif where invnum = '$venta' and codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $codkey = $row1['codkey'];
                    $cajas = $row1['cajas'];
                    $sql2 = "SELECT cajas FROM ventas_bonif_unid where codkey = '$codkey'";
                    $result2 = mysqli_query($conexion, $sql2);
                    if (mysqli_num_rows($result2)) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $cajas1 = $row2['cajas'];
                        }
                    }
                    $totcaja = $cajas + $cajas1;
                    //-------------mysqli_query($conexion,"UPDATE ventas_bonif_unid set cajas = '$totcaja' where codkey = '$codkey'");
                }
            }
        }
        mysqli_query($conexion, "INSERT INTO venta_nosave_detalle(invnum,codpro,canpro,fraccion,prisal,pripro,factor,codmar,codfam,coduso,invfec) values ('$venta','$codpro','$canpro','$fraccion','$prisal','$pripro','$factor1','$codmar','$codfam','$coduso','$date')");
        if ($fraccion == "F") {
            $canpro = $canpro * $factor;
        }
        $total_general = $stopro + $canpro;
        $total_local = $cant_loc + $canpro;
        //-----------mysqli_query($conexion,"UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
    }
}
$sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codcli = $row['codcli'];
    }
}
mysqli_query($conexion, "UPDATE venta set cuscod = '$codcli' where invnum = '$venta'");
unset($_SESSION['arr_detalle_venta']);
mysqli_query($conexion, "DELETE from temp_vent_bonif where invnum = '$venta'");
mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$venta'");

//error_log("Borrando ventas ".$venta);

mysqli_close($conexion);
header("Location: venta_index.php?cancel=1");
