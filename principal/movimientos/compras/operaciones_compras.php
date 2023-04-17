<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

if ($igv == 0) {
    $ckigv = 1;
} else {
    $ckigv = $ckigv;
}

if ($factor == 1) {
    $comparativa = 4;
} else {
    $comparativa = 1;
}
if (($zzcodloc == 1) && ($precios_por_local == 1)) {
    $costpr = $row['pcostouni'];  ///COSTO PROMEDIO
    $costod = $row['costod'];
} elseif ($precios_por_local == 0) {
    $costpr = $row['pcostouni'];  ///COSTO PROMEDIO
    $costod = $row['costod'];
}

if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

    $sql_precio = "SELECT $costpr_p,$costod_p FROM precios_por_local where codpro = '$codpro'";
    $result_precio = mysqli_query($conexion, $sql_precio);
    if (mysqli_num_rows($result_precio)) {
        while ($row_precio = mysqli_fetch_array($result_precio)) {
            $costpr = $row_precio[0];  ///COSTO PROMEDIO
            $costod = $row_precio[1];
        }
    }
}
$convert = $cant_loc / $factor;
$div = floor($convert);
$mult = $factor * $div;
$tot = $stopro - $mult;

$sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $ltdgen = $row1['ltdgen'];
    }
}
$sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $marca = $row1['destab'];
    }
}
$sql1 = "SELECT qtypro,qtyprf,prisal FROM tempmovmov where invnum = '$invnum' and codpro = '$codpro'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $qtypro1 = $row1['qtypro'];
        $qtyprf1 = $row1['qtyprf'];
        $prisal1 = $row1['prisal'];
    }
}
$sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$codpro' and invnum = '$invnum'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    $control = 0;
} else {
    $control = 0;
}


////////////////////////////  pcosto = document.form1.text2.value;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                        
$sqlP = "SELECT porcent,Preciovtacostopro FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $porcent = $row['porcent'];
        $tipocosto = $row['Preciovtacostopro'];
    }
}
// echo $tipocosto;
// echo $porcent;
// sleep(3);

$sql = "SELECT codpro,desprod,factor,margene,prevta,preuni,tcosto,tmargene,tprevta,tpreuni,igv,costpr,tcostpr,costre,utlcos,prelis, s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015 as stoctal FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codpro = $row['codpro'];
        $desprod = $row['desprod'];
        $factor = $row['factor'];
        $igv = $row['igv'];
        $stoctal = $row['stoctal'];

        if ($igv == 0) {
            $ckigv = 1;
        } else {
            $ckigv = $ckigv;
        }

        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
            $prevta = $row['prevta'];
            $preuni = $row['preuni'];
            $tcosto = $row['tcosto'];
            $tmargene = $row['tmargene'];
            $amargene = $row['margene'];
            $tprevta = $row['tprevta'];
            $tpreuni = $row['tpreuni'];
            $costpr = $row['costpr'];
            $tcostpr = $row['tcostpr'];
            $costre = $row['costre'];
            $utlcos = $row['utlcos'];
            $prelis = $row['prelis'];
        } elseif ($precios_por_local == 0) {
            $prevta = $row['prevta'];
            $preuni = $row['preuni'];
            $tcosto = $row['tcosto'];
            $tmargene = $row['tmargene'];
            $amargene = $row['margene'];
            $tprevta = $row['tprevta'];
            $tpreuni = $row['tpreuni'];
            $costpr = $row['costpr'];
            $tcostpr = $row['tcostpr'];
            $costre = $row['costre'];
            $utlcos = $row['utlcos'];
            $prelis = $row['prelis'];
        }

        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

            $sql_precio = "SELECT $prevta_p,$preuni_p,$tcosto_p,$tmargene_p,$margene_p,$tprevta_p,$tpreuni_p,$costpr_p,$tcostpr_p,$costre_p,$utlcos_p,$prelis_p FROM precios_por_local where codpro = '$codpro'";
            $result_precio = mysqli_query($conexion, $sql_precio);
            if (mysqli_num_rows($result_precio)) {
                while ($row_precio = mysqli_fetch_array($result_precio)) {
                    $prevta = $row_precio[0];
                    $preuni = $row_precio[1];
                    $tcosto = $row_precio[2];
                    $tmargene = $row_precio[3];
                    $amargene = $row_precio[4];
                    $tprevta = $row_precio[5];
                    $tpreuni = $row_precio[6];
                    $costpr = $row_precio[7];
                    $tcostpr = $row_precio[8];
                    $costre = $row_precio[9];
                    $utlcos = $row_precio[10];
                    $prelis = $row_precio[11];
                }
            }
        }
    }

    $tmargene2 = 0;

    // Si es en base a costo promedio
    if ($tipocosto == 1) {
        if ($costpr > 0) {
            $margene = round($prevta / $costpr * 100, 2) - 100;
            $margene2 = round($preuni / $costpr / $factor * 100, 2) - 100;
        } else {
            $margene = 5;
            $margene2 = 5;
        }

        // Si es en base a costre, costo de reposicion
    } else {

        if ($costre > 0) {
            $margene = round($prevta / $costre * 100, 2) - 100;
            $margene2 = round($preuni / ($costre / $factor) * 100, 2) - 100;
        } else {
            $margene = 5;
            $margene2 = 5;
        }
    }

    // Aqui se hace los precios unitarios?????
    if ($preuni == "" and $factor <> 1) {
        $preuni = $prevta / $factor;
    }
    // $tpreuni=0 si es la primera vez que se abre esta ventana
    if ($tpreuni <= 0) {
        //Calculo Si tmargene2=0 es base a costo promedio
        if ($tipocosto >= 1) {
            if ($costpr > 0) {
                $tmargene2 = (($preuni / ($costpr / $factor)) - 1) * 100;
            }
        } else {
            // si es en base al costo de compra real
            if ($costre > 0) {
                $tmargene2 = (($preuni / ($costre / $factor)) - 1) * 100;
            } else {
                $costre = 1;
                $tmargene2 = (($preuni / ($costre / $factor)) - 1) * 100;
                //                     $tmargene2=0;
            }
        }
    }
}
$stoctal = $stoctal / $factor;

if ($costo <> 0) {
    if ($pigv !== "1" && $igv == 1) {
        $costo = $costo * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100)) * (1 + ($porcent / 100));
    } else {
        $costo = $costo * (1 - ($desc1 / 100)) * (1 - ($desc2 / 100)) * (1 - ($desc3 / 100));
    }
}

//nuevo costo promedio
//    echo $costo . " <-cos| " . $text1 . " <-tex| " . $costpr . " <-copr| " . $stoctal;

if ($costo == 0) {
    $tcostpr = $costod;
} else {
    $tcostpr = (($costo * $text1) + ($costpr * $stoctal)) / ($text1 + $stoctal);
}

//    echo $tcostpr;
//******** Para cuando calculo es en base a costo promedio **********
// echo  'costo '.$costo.'cantidad '.$text1.'Costpr'.$costpr.'Stocal '.$stoctal.'Factor '.$factor.'Tcostpr'.$tcostpr;

if ($tipocosto >= 1) {
    // echo "Costo promedio";
    // sleep(1);
    $tprevta = round($tcostpr * (1 + $tmargene / 100), 2);
    //Productos fraccionados
    if ($factor > 1) {
        if ($tpreuni <= 0) { //Para cuando calculo es en base a costo promedio 
            $tpreuni = round($tcostpr / $factor * (1 + $tmargene2 / 100), 2);
            $tmargene2 = (($tpreuni / ($tcostpr / $factor)) - 1) * 100;
        } else {
            $tmargene2 = (($tpreuni / ($tcostpr / $factor)) - 1) * 100;
        }
    } else {
        // Productos no fraccionados
        $tmargene2 = $tmargene;
    }

    ///echo $tcostpr2;
}
/// **** Cuando el calculo es sobre el costo de compra ****
else {
    if ($factor >= 1 & $costre >= 1) {
        $tmargene2 = ((($tpreuni / ($costre / $factor)) - 1)) * 100;
        $tpreuni = round($costo * (1 + $tmargene2 / 100) / $factor, 2);
        //echo $tpreuni2;
        // sleep(1); // Se detiene 2 segundos en continuar la ejecuci�0�10�0�71�0�10�0�56n
    } else {
        $tmargene2 = $tmargene;
        $tpreuni = $tprevta;
    }
}
//$costo     = number_format($costo, 2, '.', ' ');
$tcostpr = number_format($tcostpr, 2, '.', ' ');
$tprevta = number_format($prevta, 2, '.', ' ');
$tpreuni = number_format($tpreuni, 3, '.', ' ');
$tmargene2 = number_format($tmargene2, 2, '.', ' ');



$sql = "SELECT desprod,codmar,factor FROM producto where codpro = '$codpro'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $desprod = $row['desprod'];
        $codmar = $row['codmar'];
        $factor = $row['factor'];
        $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $marca = $row1['destab'];
            }
        }
    }
}
$sql1 = "SELECT desprod FROM producto where codpro = '$codpro'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $desproducto = $row1["desprod"];
    }
}
$sql1 = "SELECT $lotenombre FROM producto where codpro = '$producto'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $lote2 = $row1[0]; ///STOCK EN UNIDADES 
    }
}
//////////////////////////////////////////////7stock minimo/////////////////////////////
$sqlP = "SELECT codpro,desprod,stopro,factor,m00,m01,m02,m03,m04,m05,m06,m07,m08,m09,m10,m11,m12,m13,m14,m15,m16,blister,preblister FROM producto where codpro = '$codpro'";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $codpro = $row['codpro'];
        //			$desprod    = $row['desprod'];
        $stopro = $row['stopro'];
        $factor = $row['factor'];
        $m00 = $row['m00'];
        $m01 = $row['m01'];
        $m02 = $row['m02'];
        $m03 = $row['m03'];
        $m04 = $row['m04'];
        $m05 = $row['m05'];
        $m06 = $row['m06'];
        $m07 = $row['m07'];
        $m08 = $row['m08'];
        $m09 = $row['m09'];
        $m10 = $row['m10'];
        $m11 = $row['m11'];
        $m12 = $row['m12'];
        $m13 = $row['m13'];
        $m14 = $row['m14'];
        $m15 = $row['m15'];
        $m16 = $row['m16'];

        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
            $blisters = $row['blister'];
            $preblister = $row['preblister'];
        } elseif ($precios_por_local == 0) {
            $blisters = $row['blister'];
            $preblister = $row['preblister'];
        }

        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

            $sql_precio = "SELECT $blister_p,$preblister_p FROM precios_por_local where codpro = '$codpro'";
            $result_precio = mysqli_query($conexion, $sql_precio);
            if (mysqli_num_rows($result_precio)) {
                while ($row_precio = mysqli_fetch_array($result_precio)) {
                    $blisters = $row_precio[0];
                    $preblister = $row_precio[1];
                }
            }
        }

        $min = $m00 + $m01 + $m02 + $m03 + $m04 + $m05 + $m06 + $m07 + $m08 + $m09 + $m10 + $m11 + $m12 + $m13 + $m14 + $m15 + $m16;   ////COMO STOCK GENERAL - MINIMOS
        if ($factor == 0) {
            $factor = 1;
            $convert = $stopro / $factor;
        } else {
            $convert = $stopro / $factor;
        }
        $convertmin = $min / $factor;
        $div = floor($convert);   ////PARTE ENTERA DEL STOCK GENERAL
        $div1 = floor($convertmin);  ////PARTE ENTERA DEL STOCK MINIMOS
        $mult = $factor * $div;
        $mult1 = $factor * $div1;
        $tot = $stopro - $mult;   /////OBTENGO EL RESIDUO DEL STOCK GENERAL
        $tot1 = $min - $mult1;   /////OBTENGO EL RESIDUO DEL STOCK MINIMO
        //$r			= $stopro - $min;
        $r = $min - $stopro;
        if ($r < 0) {
            $c = 0;
            $r = $r * (-1);
            $desc = "SOBRAN";
        } else {
            $c = 1;
            $desc = "FALTAN";
        }
        $div2 = $r / $factor;
        $div2 = floor($div2);
        $mult2 = $factor * $div2;
        $tot2 = $r - $mult2;
    }
}
// echo 'nombre_local = ' . $nombre_local . "<br>";
$sql1 = "SELECT codloc FROM xcompa WHERE nomloc='$nombre_local'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc2 = $row1["codloc"];
    }
}
$sqlP = "SELECT codloc,nomloc,nombre FROM xcompa where habil = '1' and codloc = '$codloc2' ";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $codloc = $row1['codloc'];
        $nomloc = $row1['nomloc'];
        $nom2 = $row1['nombre'];
    }
}
if ($nom2 <> "") {
    $nombre_local = $nom2;
} else {
    $nombre_local = $nomloc;
}
if ($nomloc == 'LOCAL0') {
    $stock_min = $m00;
} else if ($nomloc == 'LOCAL1') {
    $stock_min = $m01;
} else if ($nomloc == 'LOCAL2') {
    $stock_min = $m02;
} else if ($nomloc == 'LOCAL3') {
    $stock_min = $m03;
} else if ($nomloc == 'LOCAL4') {
    $stock_min = $m04;
} else if ($nomloc == 'LOCAL5') {
    $stock_min = $m05;
} else if ($nomloc == 'LOCAL6') {
    $stock_min = $m06;
} else if ($nomloc == 'LOCAL7') {
    $stock_min = $m07;
} else if ($nomloc == 'LOCAL8') {
    $stock_min = $m08;
} else if ($nomloc == 'LOCAL9') {
    $stock_min = $m09;
} else if ($nomloc == 'LOCAL10') {
    $stock_min = $m10;
} else if ($nomloc == 'LOCAL11') {
    $stock_min = $m11;
} else if ($nomloc == 'LOCAL12') {
    $stock_min = $m12;
} else if ($nomloc == 'LOCAL13') {
    $stock_min = $m13;
} else if ($nomloc == 'LOCAL14') {
    $stock_min = $m14;
} else if ($nomloc == 'LOCAL15') {
    $stock_min = $m15;
} else if ($nomloc == 'LOCAL16') {
    $stock_min = $m16;
}
$sum0 = 0;
$sum1 = 0;
$sum2 = 0;
$sum3 = 0;
$sum4 = 0;
$sum5 = 0;

// Valor del IGV
$sql = "SELECT porcent FROM datagen";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $porcent = $row['porcent'];
    }
}
$porcentaje = (1 + ($porcent / 100));

if ($ckigv == 1) {
    // $PrecioPrint = $costre;
    $PrecioPrint = $utlcos;
} else {
    // $PrecioPrint = $costod;
    $PrecioPrint = $utlcos / $porcentaje;
}
$PrecioPrint = number_format($PrecioPrint, 2, '.', ' ');
