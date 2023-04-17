<?php require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
$invnummovmae = $_SESSION['nota_credito'];
require_once("../../local.php");
$usuario        = $_REQUEST['usuario'];
$codpro         = $_REQUEST['codpro'];
$cod            = $_REQUEST['cod'];
$nrofactura     = $_REQUEST['nrofactura'];
$t1             = $_REQUEST['t1'];
$factor         = $_REQUEST['factor'];
$invnum         = $_REQUEST['invnum'];
$fraccion       = $_REQUEST['fraccion'];
$number       = $_REQUEST['number'];
$date         = date("Y-m-d");

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

if ($number == 1) { ////NO ES NUMERO

    function convertir_a_numeros($str)
    {
        $legalChars = "%[^0-9\-\. ]%";

        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

    $t1        = convertir_a_numeros($t1);
} else { ////ES NUMERO

    $t1 = $t1;
}

$nomlocalG  = "";
$sqlLocal   = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG    = $rowLocal['nomloc'];
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

$sql4 = "SELECT porcent FROM datagen";
$result4 = mysqli_query($conexion, $sql4);
if (mysqli_num_rows($result4)) {
    while ($row4 = mysqli_fetch_array($result4)) {
        $porcent    = $row4['porcent'];
    }
}
$sql5 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result5 = mysqli_query($conexion, $sql5);
if (mysqli_num_rows($result5)) {
    while ($row5 = mysqli_fetch_array($result5)) {
        $user    = $row5['nomusu'];
    }
}


$sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    if ($row = mysqli_fetch_array($result)) {
        $codloc    = $row['codloc'];
    }
}
$monto_total = 0;
//error_log("Monto total : ". $monto_total);
$valor_vent1 = 0;
$mont_bruto  = 0;

$col_stock = "s" . sprintf('%03d', $codloc - 1);

//echo "1 usuario: ".$usuario."<BR>";
//echo "2 coprod ".$codpro."<BR>";
//echo "3 inv que jalo ".$cod."<BR>";
//echo "4 nrfac ".$nrofactura."<BR>";
// echo "5 texto ing " . $t1 . "<BR>";
//echo "6 factor ".$factor."<BR>";
//echo "7 actual ".$invnum."<BR>";
//echo "8 fracion ".$fraccion."<BR>";
//echo "9 fecha ".$date."<BR>";
//echo "10 s0000* ".$col_stock."<BR>";
// echo "11 number* " . $number . "<BR>";







$sql1 = "SELECT invnum, invfec, cuscod, usecod, codven, codpro,canpro, fraccion, factor, prisal, pripro, cospro, costpr, codmar, incentivo, bonif, ultcos, idlote FROM detalle_venta where invnum = '$invnum' and codpro = '$codpro'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row = mysqli_fetch_array($result1)) {
        $invnum        = $row['invnum'];
        $invfec        = $row['invfec'];
        $cuscod        = $row['cuscod'];
        $usecod        = $row['usecod'];
        $codven        = $row['codven'];
        $codpro        = $row['codpro'];
        $canproN        = $row['canpro'];
        $fraccion      = $row['fraccion'];
        $factor        = $row['factor'];
        $prisal        = $row['prisal'];
        $priproN        = $row['pripro'];
        $cospro        = $row['cospro'];
        $costpr        = $row['costpr'];
        $codmar        = $row['codmar'];
        $incentivo     = $row['incentivo'];
        $bonif         = $row['bonif'];
        $ultcos        = $row['ultcos'];
        $idlote        = $row['idlote'];
    }
}

$sql1 = "SELECT codpro,canpro,fraccion,prisal,pripro,factor FROM temp_detalle_venta where invnum = '$invnum' and codpro = '$codpro'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row = mysqli_fetch_array($result1)) {
        $codpro         = $row['codpro'];
        $canpro         = $row['canpro'];
        $fraccion       = $row['fraccion'];
        $prisal         = $row['prisal'];
        $pripro         = $row['pripro'];
        $factor         = $row['factor'];
    }
}




$resta = $canproN - $t1;
// $pripro = $prisal * $resta;
$pripro = $prisal * $t1;

//if ($t1 <> 0) {
if (($t1 <= $canproN)) {
    if ($t1 == 0) {
        mysqli_query($conexion, "UPDATE temp_detalle_venta set canpro = '$canproN',resta = '$t1',pripro='$priproN' where invnum = '$invnum' and codpro ='$codpro'");
    } else {
        mysqli_query($conexion, "UPDATE temp_detalle_venta set canpro = '$t1',resta = '$t1',pripro='$pripro' where invnum = '$invnum' and codpro ='$codpro'");
    }



    if ($t1 == 0) {
        $sql1 = "SELECT codpro,canpro,fraccion,prisal,pripro,factor,costpr,codmar,bonif FROM temp_detalle_venta where invnum = '$invnum' ";
    } else {
        $sql1 = "SELECT codpro,canpro,fraccion,prisal,pripro,factor,costpr,codmar,bonif FROM temp_detalle_venta where invnum = '$invnum' and resta <> 0";
    }

    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row7 = mysqli_fetch_array($result1)) {
            $codpro    = $row7['codpro'];
            $canpro    = $row7['canpro'];
            $fraccion  = $row7['fraccion'];
            $factor    = $row7['factor'];
            $prisal    = $row7['prisal'];
            $pripro    = $row7['pripro'];
            $costpr    = $row7['costpr'];
            $codmar    = $row7['codmar'];
            $bonif     = $row7['bonif'];

            if ($bonif <> 1) {
                $sql2 = "SELECT igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,preblister,blister,codpro FROM producto where codpro = '$codpro'";
                $result2 = mysqli_query($conexion, $sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $igv                = $row2['igv'];
                        $factor             = $row2['factor'];
                        $codpro             = $row2['codpro'];



                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                            $referencial        = $row2['prelis'];
                            $margene            = $row2['margene'];
                            $prevtaMain         = $row2['PrevtaMain'];
                            $preuniMain         = $row2['PreuniMain'];
                            $prevta             = $row2[6];
                            $preuni             = $row2[7];
                            $preblister         = $row2['preblister'];
                            $blister            = $row2['blister'];
                        } elseif ($precios_por_local == 0) {

                            $referencial        = $row2['prelis'];
                            $margene            = $row2['margene'];
                            $prevtaMain         = $row2['PrevtaMain'];
                            $preuniMain         = $row2['PreuniMain'];
                            $prevta             = $row2[6];
                            $preuni             = $row2[7];
                            $preblister         = $row2['preblister'];
                            $blister            = $row2['blister'];
                        }

                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                            $sql_precio = "SELECT $prelis_p,$margene_p,$prevta_p,$preuni_p,$preblister_p,$blister_p FROM precios_por_local where codpro = '$codpro'";
                            $result_precio = mysqli_query($conexion, $sql_precio);
                            if (mysqli_num_rows($result_precio)) {
                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                    $referencial        = $row_precio[0];
                                    $margene            = $row_precio[1];
                                    $prevtaMain         = $row_precio[2];
                                    $preuniMain         = $row_precio[3];
                                    $prevta             = $row_precio[2];
                                    $preuni             = $row_precio[3];
                                    $preblister         = $row_precio[4];
                                    $blister            = $row_precio[5];
                                }
                            }
                        }
                    }
                }

                //**CONFIGPRECIOS_PRODUCTO**//
                if (($prevta == "") || ($prevta == 0)) {
                    $prevta = $prevtaMain;
                }
                if (($preuni  == "") || ($preuni  == 0)) {
                    $preuni  = $preuniMain;
                }

                //**FIN_CONFIGPRECIOS_PRODUCTO**//

                if ($factor == 0) {
                    $factor = 1;
                }
                // Determina si debe calcular precio referencial
                if (($referencial <> 0) and ($referencial <> $prevta)) {
                    $margenes       = ($margene / 100) + 1;
                    $precio_ref     = $referencial * $margenes;
                    //$precio_ref	= $precio_ref * $margenes;
                } else {
                    $precio_ref    = $preuni;
                }
                // Calcular cantidad y precios sub-totales
                $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0

                if (($fraccion  == 'T') && ($factor <> 1)) {
                    if (($blister <> 0) && ($preblister <> 0)) {
                        if ($canpro >= $blister) {
                            $prisal = $preblister;
                        }
                    }
                }

                // Si el producto se vende fraccionado
                if ($fraccion == 'T') {
                    $cantidad_comp  = $canpro;
                    $sum_mont1      = ($precio_ref / $factor) * $cantidad_comp;
                    $mont_bruto     = $mont_bruto + $sum_mont1;
                    $valor_vent     = ($prisal / (($porcent_igv / 100) + 1)) * $cantidad_comp;
                } else {
                    $cantidad_comp  = $canpro * $factor;
                    $sum_mont1      = $precio_ref * $canpro;
                    $mont_bruto     = $mont_bruto + $sum_mont1;
                    $valor_vent        = ($pripro / (($porcent_igv / 100) + 1));
                    //$valor_vent	= ($prisal/(($porcent_igv/100)+1))*$cantidad_comp;
                }

                $valor_vent1 = $valor_vent1 + $valor_vent;   //valor de venta
                $monto_total = $monto_total + $pripro;
            }
        }
    }
}
//}
$r          = $monto_total;                  // motnto total invtot
$sum_igv    = ($monto_total - $valor_vent1); // igv

//echo "1 total: ".$r."<BR>";
//echo "2 igv ".$sum_igv."<BR>";
//echo "3 valor_vent1 ".$valor_vent1."<BR>";
//echo "4 nrfac ".$nrofactura."<BR>";

mysqli_query($conexion, "UPDATE temp_venta2 set invtot = '$r',valven = '$valor_vent1',gravado = '$valor_vent1',igv='$sum_igv' where invnum = '$invnum'");

header("Location: devolucion2.php?num=$nrofactura&tip=1&valform=1&invnum=$invnum");
