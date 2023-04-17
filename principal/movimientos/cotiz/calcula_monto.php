<?php
require '../../../titulo_sist.php';
////////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT invnum,invfec,cuscod,usecod,forpag,sucursal FROM cotizacion where invnum = '$venta'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];  //codgio
        $invfec = $row['invfec'];
        $cuscod = $row['cuscod'];
        $usecod = $row['usecod'];
        $forpag = $row['forpag'];
        $sucursal = $row['sucursal'];
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
$count1 = 0;
$count2 = 0;
$sql = "SELECT count(*) FROM cotizacion_det where invnum = '$invnum'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $count = $row[0]; ////CANTIDAD DE REGISTROS EN EL GRID
    }
} else {
    $count = 0; ////CUANDO NO HAY NADA EN EL GRID
}
///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
$sql = "SELECT count(*) FROM cotizacion_det where invnum = '$invnum' and canpro = '0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $count1 = $row[0]; ////CUANDO HAY UN GRID PERO CON DATOS VACIOS
    }
} else {
    $count1 = 0; ////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
}
///////CONTADOR PARA CONTROLAR LOS TOTALES
$sql = "SELECT count(*) FROM cotizacion_det where invnum = '$invnum' and canpro <> '0'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $count2 = $row[0];
    }
} else {
    $count2 = 0;
}
$sql1 = "SELECT porcent FROM datagen";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $porcent = $row1['porcent'];
    }
}
$sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $user = $row1['nomusu'];
    }
}
$sql1 = "SELECT descli FROM cliente where codcli = '$cuscod'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $descli = $row1['descli'];
    }
}

$monto_total = 0;
$valor_vent1 = 0;
$mont_bruto = 0;

$sql1 = "SELECT codpro,canpro,fraccion,factor,prisal,pripro,costpr,codmar,bonif FROM cotizacion_det where invnum = '$invnum'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codpro = $row1['codpro'];
        $canpro = $row1['canpro'];
        $fraccion = $row1['fraccion'];
        $factor = $row1['factor'];
        $prisal = $row1['prisal'];  ////PRECIO UNITARIO
        $pripro = $row1['pripro'];  ////MONTO VENTA
        $costpr = $row1['costpr'];
        $codmar = $row1['codmar'];
        $bonif = $row1['bonif'];
        if ($bonif <> 1) {
            //	$sql2="SELECT igv,prelis,factor,prevta,preuni,margene FROM producto where codpro = '$codpro'";////SI ESTA ACTIVADO EL IGV PARA ESTE PRODUCTO
            $sql2 = "SELECT igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,preblister,blister,codpro FROM producto where codpro = '$codpro'";
            $result2 = mysqli_query($conexion, $sql2);
            if (mysqli_num_rows($result2)) {
                while ($row2 = mysqli_fetch_array($result2)) {
                    $igv = $row2['igv'];
                    $factor = $row2['factor'];
                    $codpro         = $row2['codpro'];

                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                        $referencial = $row2['prelis'];
                        $prevta         = $row2['prevta'];
                        $preuni         = $row2['preuni'];
                        $margene        = $row2['margene'];
                        $prevtaMain     = $row2['PrevtaMain'];
                        $preuniMain     = $row2['PreuniMain'];
                        $prevta         = $row2[6];
                        $preuni         = $row2[7];
                        $preblister     = $row2['preblister'];
                        $blister        = $row2['blister'];
                    } elseif ($precios_por_local == 0) {

                        $referencial    = $row2['prelis'];
                        $prevta         = $row2['prevta'];
                        $preuni         = $row2['preuni'];
                        $margene        = $row2['margene'];
                        $prevtaMain     = $row2['PrevtaMain'];
                        $preuniMain     = $row2['PreuniMain'];
                        $prevta         = $row2[6];
                        $preuni         = $row2[7];
                        $preblister     = $row2['preblister'];
                        $blister        = $row2['blister'];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $prelis_p,$prevta_p,$preuni_p,$margene_p,$preblister_p,$blister_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $referencial    = $row_precio[0];
                                $prevta         = $row_precio[1];
                                $preuni         = $row_precio[2];
                                $margene        = $row_precio[3];
                                $prevtaMain     = $row_precio[1];
                                $preuniMain     = $row_precio[2];
                                $prevta         = $row_precio[1];
                                $preuni         = $row_precio[2];
                                $preblister     = $row_precio[4];
                                $blister        = $row_precio[5];
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

            //////////PRECIO REFERENCIAL UNITARIO
            if (($referencial <> 0) and ($referencial <> $prevta)) {
                $margenes = ($margene / 100) + 1;
                $precio_ref = $referencial / $factor;
                $precio_ref = $precio_ref * $margenes;
                //$precio_ref		= number_format($precio_ref,2,',','.');
            } else {
                $precio_ref = $preuni;
            }

            // Calcular cantidad y precios sub-totales
            $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0

            // Si el producto se vende fraccionado
            //////////CANTIDAD COMPRADA

            if (($fraccion == 'T') && ($factor <> 1)) {
                if (($blister <> 0) && ($preblister <> 0)) {
                    if ($canpro >= $blister) {
                        //   $prisal = $preblister;
                    }
                }
            }

            // Si el producto se vende fraccionado
            if ($fraccion == 'T') {
                $cantidad_comp = $canpro;
                $sum_mont1 = ($precio_ref / $factor) * $cantidad_comp;
                $mont_bruto += $sum_mont1;
                $valor_vent = ($prisal / (($porcent_igv / 100) + 1)) * $cantidad_comp;
            } else {
                $cantidad_comp = $canpro * $factor;
                $sum_mont1 = $precio_ref * $canpro;
                $mont_bruto += $sum_mont1;
                $valor_vent = ($pripro / (($porcent_igv / 100) + 1));
                //$valor_vent	= ($prisal/(($porcent_igv/100)+1))*$cantidad_comp;
            }

            $valor_vent1 += $valor_vent;
            $monto_total += $pripro;
        }
    }
}
/////////////////////////////////////////
$t = 0.0;
$r = $monto_total;
$total_des = $valor_vent1 - $mont_bruto;
$sum_igv = ($monto_total - $valor_vent1);
$redondeo = $monto_total - $r;
