<?php

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}
$invnum = "";
$sql = "SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,fecven,sucursal FROM venta2 where invnum = '$tventa'";
$result = mysqli_query($conexion, $sql);
//error_log($sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
        $nrovent = $row['nrovent'];
        $invfec = $row['invfec'];
        $cuscod = $row['cuscod'];
        $usecod = $row['usecod'];
        $codven = $row['codven'];
        $forpag = $row['forpag'];
        $fecven = $row['fecven'];
        $sucursal = $row['sucursal'];
    }
}

//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}

$TablaPrevtaMain = "prevta";
$TablaPreuniMain = "preuni";
if ($nomlocalG <> "") {
    if ($nomlocalG == "LOCAL1") {
        $TablaPrevta = "prevta1";
        $TablaPreuni = "preuni1";
    } else {
        if ($nomlocalG == "LOCAL2") {
            $TablaPrevta = "prevta2";
            $TablaPreuni = "preuni2";
        } else {
            $TablaPrevta = "prevta";
            $TablaPreuni = "preuni";
        }
    }
} else {
    $TablaPrevta = "prevta";
    $TablaPreuni = "preuni";
}
//**FIN_CONFIGPRECIOS_PRODUCTO**//

$count = 0;
$sql1 = "SELECT count(*) FROM detalle_venta2 where invnum = '$invnum'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $count = $row1[0];
    }
}

$count1 = 0;
$sql2 = "SELECT count(*) FROM detalle_venta2 where invnum = '$invnum' and canpro = '0'";
$result2 = mysqli_query($conexion, $sql2);
if (mysqli_num_rows($result2)) {
    while ($row2 = mysqli_fetch_array($result2)) {
        $count1 = $row2[0];
    }
}

$count2 = 0;
$sql3 = "SELECT count(*) FROM detalle_venta2 where invnum = '$invnum' and canpro <> '0'";
$result3 = mysqli_query($conexion, $sql3);
if (mysqli_num_rows($result3)) {
    while ($row3 = mysqli_fetch_array($result3)) {
        $count2 = $row3[0];
    }
}

$sql4 = "SELECT porcent FROM datagen";
$result4 = mysqli_query($conexion, $sql4);
if (mysqli_num_rows($result4)) {
    while ($row4 = mysqli_fetch_array($result4)) {
        $porcent = $row4['porcent'];
    }
}

$sql5 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result5 = mysqli_query($conexion, $sql5);
if (mysqli_num_rows($result5)) {
    while ($row5 = mysqli_fetch_array($result5)) {
        $user = $row5['nomusu'];
    }
}

$sql6 = "SELECT descli FROM cliente where codcli = '$cuscod'";
$result6 = mysqli_query($conexion, $sql6);
if (mysqli_num_rows($result6)) {
    while ($row6 = mysqli_fetch_array($result6)) {
        $descli = $row6['descli'];
    }
}

$monto_total = 0;
//error_log("Monto total : " . $monto_total);
$valor_vent1 = 0;
$mont_bruto = 0;
$sql7 = "SELECT codpro,canpro,fraccion,factor,prisal,pripro,costpr,codmar,bonif FROM detalle_venta2 where invnum = '$invnum'";

//error_log("SQL : " . $sql7);
$result7 = mysqli_query($conexion, $sql7);
if (mysqli_num_rows($result7)) {
    while ($row7 = mysqli_fetch_array($result7)) {
        //        error_log("Monto total : " . $pripro);
        $codpro = $row7['codpro'];
        $canpro = $row7['canpro'];
        $fraccion = $row7['fraccion'];
        $factor = $row7['factor'];
        $prisal = $row7['prisal'];
        $pripro = $row7['pripro'];
        $costpr = $row7['costpr'];
        $codmar = $row7['codmar'];
        $bonif = $row7['bonif'];
        //        error_log("Monto total : " . $pripro);
        if ($bonif <> 1) {
            $sql2 = "SELECT igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,codpro FROM producto where codpro = '$codpro'";
            $result2 = mysqli_query($conexion, $sql2);
            if (mysqli_num_rows($result2)) {
                while ($row2 = mysqli_fetch_array($result2)) {
                    $igv = $row2['igv'];
                    $factor = $row2['factor'];
                    $codpro = $row2['codpro'];

                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                        $referencial = $row2['prelis'];
                        $margene = $row2['margene'];
                        $prevtaMain = $row2['PrevtaMain'];
                        $preuniMain = $row2['PreuniMain'];
                        $prevta = $row2[6];
                        $preuni = $row2[7];
                    } elseif ($precios_por_local == 0) {
                        $referencial = $row2['prelis'];
                        $margene = $row2['margene'];
                        $prevtaMain = $row2['PrevtaMain'];
                        $preuniMain = $row2['PreuniMain'];
                        $prevta = $row2[6];
                        $preuni = $row2[7];
                    }


                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $prelis_p,$margene_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $referencial = $row_precio[0];
                                $margene = $row_precio[1];
                                $prevtaMain = $row_precio[2];
                                $preuniMain = $row_precio[3];
                                $prevta = $row_precio[2];
                                $preuni = $row_precio[3];
                            }
                        }
                    }
                }
            }

            //**CONFIGPRECIOS_PRODUCTO**//
            if (($prevta == "") || ($prevta == 0)) {
                $prevta = $prevtaMain;
            }
            if (($preuni == "") || ($preuni == 0)) {
                $preuni = $preuniMain;
            }

            //**FIN_CONFIGPRECIOS_PRODUCTO**//

            if ($factor == 0) {
                $factor = 1;
            }
            // Determina si debe calcular precio referencial
            if (($referencial <> 0) and ($referencial <> $prevta)) {
                $margenes = ($margene / 100) + 1;
                $precio_ref = $referencial * $margenes;
                //$precio_ref	= $precio_ref * $margenes;
            } else {
                $precio_ref = $preuni;
            }
            // Calcular cantidad y precios sub-totales
            $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0
            // Si el producto se vende fraccionado
            if ($fraccion == 'T') {
                $cantidad_comp = $canpro;
                $sum_mont1 = ($precio_ref / $factor) * $cantidad_comp;
                $mont_bruto = $mont_bruto + $sum_mont1;
                $valor_vent = ($prisal / (($porcent_igv / 100) + 1)) * $cantidad_comp;
            } else {
                $cantidad_comp = $canpro * $factor;
                $sum_mont1 = $precio_ref * $canpro;
                $mont_bruto = $mont_bruto + $sum_mont1;
                $valor_vent = $pripro / (($porcent_igv / 100) + 1);
                //$valor_vent	= ($prisal/(($porcent_igv/100)+1))*$cantidad_comp;
            }

            $valor_vent1 = $valor_vent1 + $valor_vent;
            $monto_total = $monto_total + $pripro;
        }
    }
}
$t = 0.0;
//error_log("Monto total2 : " . $monto_total);
$r = $monto_total;
$total_des = $mont_bruto - $valor_vent1;
$sum_igv = ($monto_total - $valor_vent1);
$redondeo = $monto_total - $r;
//error_log("Monto total2 : " . $monto_total);
//error_log("Monto total_des : " . $total_des);
//error_log("Monto sum_igv : " . $sum_igv);
//error_log("Monto redondeo : " . $redondeo);
