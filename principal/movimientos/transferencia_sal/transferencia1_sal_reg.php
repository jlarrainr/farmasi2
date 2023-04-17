<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$hoy = date('Y-m-d H:i:s');

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


$sql = "SELECT drogueria FROM datagen_det";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $drogueria = $row['drogueria'];
    }
}


$cod = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : ""; //F8,F9
$referencia = isset($_REQUEST['referencia']) ? $_REQUEST['referencia'] : ""; //F8,F9
$local_dest = isset($_REQUEST['local']) ? $_REQUEST['local'] : ""; //F8,F9
$vendedor = isset($_REQUEST['vendedor']) ? $_REQUEST['vendedor'] : ""; //F8,F9
$mont2 = isset($_REQUEST['mont2']) ? $_REQUEST['mont2'] : ""; //F8,F9
//si no graba en venta comentar rd



if ($drogueria == 1) {
    $rd = isset($_REQUEST['rd']) ? $_REQUEST['rd'] : "";
} else {
    $rd = 3;
}


if ($drogueria == 1) {


    //$venta = $_SESSION['venta'];
    $date = date("Y-m-d");
    $hora = date('H:i:s a');

    if ($drogueria == 1) {

        function callLotes($Conexion, $CodPro, $Tipo, $sucursal)
        {
            $sqlLote = "SELECT idlote, numlote, stock FROM movlote where codpro = '$CodPro' and codloc='$sucursal' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW()
    ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')  limit 1";
            $resultLote = mysqli_query($Conexion, $sqlLote);
            if (mysqli_num_rows($resultLote)) {
                while ($rowLote = mysqli_fetch_array($resultLote)) {
                    $CLote = $rowLote['idlote'];
                    $Stock = $rowLote['stock'];
                    $numlote = $rowLote['numlote'];
                }
                if ($Tipo == 1) {
                    return $CLote;
                }
                if ($Tipo == 2) {
                    return $Stock;
                }
                if ($Tipo == 3) {
                    return $numlote;
                }
            } else {
                return 0;
            }
        }

        function callUpdateLote($Conexion, $Clote, $StockActualLote)
        {
            $sql1 = "UPDATE movlote set stock = '$StockActualLote' where idlote = '$Clote'";
            $result2 = mysqli_query($Conexion, $sql1);
            // if (mysqli_errno($Conexion)) {
            //     //   error_log("Actualiza producto SQL(" . $sql1 . ")\nError(" . mysqli_error($Conexion) . ")");
            // }
        }
    }

    function convertir_a_numero($str)
    {
        $legalChars = "%[^0-9\-\. ]%";
        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

    function numberOfWeek($dia, $mes, $ano)
    {
        $Hora = date("H");
        $Min = date("i");
        $Sec = date("s");
        $fecha = mktime($Hora, $Min, $Sec, $mes, 1, $ano);
        $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
        return $numberOfWeek;
    }

    $sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $codloc = $row['codloc'];
        }
    }


    $sql = "SELECT codcli FROM cliente where codloc = '$local_dest'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $codcli = $row['codcli'];
        }
    } else {
        $sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            if ($row = mysqli_fetch_array($result)) {
                $codcli = $row['codcli'];
            }
        }
    }



    $date = date("Y-m-d");

    $fecha = explode("-", $date);
    $daysem = $fecha[2];
    $messem = $fecha[1];
    $yearsem = $fecha[0];
    $correlativo = 1;
    $sql = "SELECT max(correlativo) correlativo FROM venta where sucursal = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $correlativo = $row['correlativo'] + 1;
        }
    }
    $semana = numberOfWeek($daysem, $messem, $yearsem);

    if ($rd <> 3) {
        mysqli_query($conexion, "INSERT INTO venta (nrovent,invfec,usecod,cuscod,forpag,estado,sucursal,tipdoc,correlativo,semana,nrofactura,transferenciaVenta) values ('$correlativo','$date','$usuario','$codcli','E','$rd','$codloc','2','$correlativo','$semana','', '$cod')");

        $venta = mysqli_insert_id($conexion);
        $_SESSION['venta'] = $venta;
    } else {
        $venta = 0;
    }
    ////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
    $sql = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numdoc = $row['numdoc'];
            $invfec = $row['invfec'];
            $tipmov = $row['tipmov'];
            $tipdoc = $row['tipdoc'];
            $usecod = $row['usecod'];
        }
    }





    $sql = "SELECT codcli FROM cliente where codloc = '$local_dest'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        if ($row = mysqli_fetch_array($result)) {
            $cuscod = $row['codcli'];
        }
    } else {
        $sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            if ($row = mysqli_fetch_array($result)) {
                $cuscod = $row['codcli'];
            }
        }
    }



    $sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codloc = $row['codloc'];
        }
    }
    $sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomlocalG = $row['nomloc'];
        }
    }

    $numero_xcompa = substr($nomlocalG, 5, 2);
    $tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

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
    $sql4 = "SELECT porcent FROM datagen";
    $result4 = mysqli_query($conexion, $sql4);
    if (mysqli_num_rows($result4)) {
        while ($row4 = mysqli_fetch_array($result4)) {
            $porcent = $row4['porcent'];
        }
    }

    $sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod' order by codtemp ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $i++;
            $codpro = $row['codpro'];
            $qtypro = $row['qtypro'];
            $qtyprf = $row['qtyprf'];
            $pripro = $row['pripro'];
            $costre = $row['costre'];
            $costpr = $row['costpr'];
            $numlote = $row['numlote'];


            $sql1 = "SELECT factor,stopro,$tabla,desprod,codpro FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $factor     = $row1['factor'];
                    $stopro     = $row1['stopro'];
                    $cant_loc  = $row1[2];
                    $desprod    = $row1['desprod'];
                    $codpro     = $row1['codpro'];


                    // if ($drogueria == 1) {

                    //     $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                    //     $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                    //     if (mysqli_num_rows($result1_movlote)) {
                    //         while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                    //             $stock_movlote = $row1_movlote[0];
                    //         }
                    //     }

                    //     $cant_loc = $stock_movlote;
                    // } else {

                    //     $cant_loc = $cant_loc1;
                    // }
                    $sactual = $cant_loc;
                }
            }

            if ($qtyprf <> "") {
                $text_char = convertir_a_numero($qtyprf);
                $cant_unid = $text_char;
            } else {
                $cant_unid = $qtypro * $factor;
            }
            if ($cant_loc < $cant_unid) {
                echo '<script type="text/javascript">
                                    alert("Eliminar de la lista los productos que no cuentan con stock disponible(fondo rojo)");
                                    window.location.href="transferencia_sal.php";
                    </script>';


                return;
            }

            $sql1 = "SELECT factor,stopro,$tabla,codmar,igv,prelis,factor,margene,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,costre,mardis,codpro  FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $factor = $row1['factor'];
                    $stopro = $row1['stopro'];
                    $cant_loc = $row1[2];
                    $codmar = $row1['codmar'];
                    $igv = $row1['igv'];
                    $codpro = $row1['codpro'];


                    // if ($drogueria == 1) {

                    //     $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                    //     $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                    //     if (mysqli_num_rows($result1_movlote)) {
                    //         while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                    //             $stock_movlote = $row1_movlote[0];
                    //         }
                    //     }

                    //     $cant_loc = $stock_movlote;
                    // } else {

                    //     $cant_loc = $cant_loc1;
                    // }

                    // para calculo
                    $sactual = $cant_loc;

                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                        $referencial = $row1['prelis'];
                        $margene = $row1['margene'];
                        $prevtaMain = $row1['PrevtaMain'];
                        $preuniMain = $row1['PreuniMain'];
                        $prevta = $row1[10];
                        $preuni = $row1[11];
                        $costrepro = $row1['costre'];
                        $mardis = $row1['mardis'];
                    } elseif ($precios_por_local == 0) {

                        $referencial = $row1['prelis'];
                        $margene = $row1['margene'];
                        $prevtaMain = $row1['PrevtaMain'];
                        $preuniMain = $row1['PreuniMain'];
                        $prevta = $row1[10];
                        $preuni = $row1[11];
                        $costrepro = $row1['costre'];
                        $mardis = $row1['mardis'];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $prelis_p,$margene_p,$prevta_p,$preuni_p,$prevta_p,$preuni_p,$costre_p,$mardis_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $referencial = $row_precio[0];
                                $margene = $row_precio[1];
                                $prevtaMain = $row_precio[2];
                                $preuniMain = $row_precio[3];
                                $prevta = $row_precio[4];
                                $preuni = $row_precio[5];
                                $costrepro = $row_precio[6];
                                $mardis = $row_precio[7];
                            }
                        }
                    }
                }
            }

            if ($mardis == 0) {
                $costre2 = $costrepro * (1 + 5 / 100);
            } else {
                $costre2 = $costrepro * (1 + $mardis / 100);
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

            $precio_ref = $costre2;


            // Calcular cantidad y precios sub-totales
            $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0



            if ($qtyprf <> "") {
                $text_char = convertir_a_numero($qtyprf);
                $canpro = convertir_a_numero($qtyprf);
                $fraccion = "T";
                $cant_unid = $text_char;
            } else {
                $cant_unid = $qtypro * $factor;
                $canpro = $qtypro;
                $fraccion = "F";
            }
            //echo "existe este producto";
            $cant_local = $cant_loc - $cant_unid;
            $stopro = $stopro - $cant_unid;
            $stocklote = 0;
            /////////////////////////////////////////////////////////////
            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote,transferenciaVenta) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc','$Clote','$venta')");
            $last_idKardex = mysqli_insert_id($conexion);

            /////////////////////////////////////////////////
            //VERIFICO SI HAY LOTES
            $Clote = 0;
            $sqlLote = "SELECT idlote, numlote from movlote where codpro = '$codpro' AND stock <> 0";
            $resultLote = mysqli_query($conexion, $sqlLote);
            if (mysqli_num_rows($resultLote)) {
                //ACTUALIZO LOS LOTE
                //********************************************
                $CantDetalle = 0;
                $cajasADescontar = 0;
                $CantDetalleAux = 0;
                $n_pripro = 0;
                $costre_calculado = 0;

                $StockDescontar = $cant_unid;
                while ($StockDescontar <> 0) {

                    $Clote = callLotes($conexion, $codpro, 1, $codloc);
                    if ($Clote == 0) {
                        $StockDescontar = 0;
                    } else {
                        $stocklote = callLotes($conexion, $codpro, 2, $codloc);
                        $numlote = callLotes($conexion, $codpro, 3, $codloc);

                        if ($StockDescontar <= $stocklote) {
                            $StockActualLote = $stocklote - $StockDescontar;
                            $CantDetalle = $StockDescontar;
                            $CantDetalleColm = $CantDetalle;
                            //ACTUALIZO EL STOCK DE LOTES
                            callUpdateLote($conexion, $Clote, $StockActualLote);
                            $StockDescontar = 0;
                        } else {
                            //ACTUALIZO EL STOCK DEL ANTERIOR Y SIGO BUSCANDO DE OTRO LOTE CON EL STOCK POR DESCONTAR
                            $StockDescontar = $StockDescontar - $stocklote;
                            $CantDetalle = $stocklote;
                            //ACTUALIZO EL STOCK DE LOTES
                            callUpdateLote($conexion, $Clote, 0);
                        }


                        //mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$numlote')");
                        //mysqli_query($conexion, "INSERT INTO detalle_venta(invnum ,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,costpr,idlote) values ('$venta','$date','$cuscod','$usuario','$codpro','$cajasADescontar','$fraccion','$factor','$pripro','$costre','$codmar','$costpr','$Clote)");
                        //INSERTO DETALLEVENTA
                        $CantDetalleAux = $CantDetalle;
                        $saldoVenta = 0;
                        if ($fraccion == "F") {
                            $cajasADescontar = floor($CantDetalleAux / $factor);
                            if ($cajasADescontar > 0) {
                                $costre_calculado = $cajasADescontar * $pripro;
                                mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,orden,codloc) values ('$cod','$invfec','$codpro','$cajasADescontar','$qtyprf','$pripro','$costre_calculado','$costpr','$Clote','$i','$codloc')");

                                if ($rd <> 3) {
                                    $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos) 
                            values ('$venta','$date','$cuscod','$usuario','$codpro','$cajasADescontar','$fraccion','$factor','$pripro','$costre','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ")";
                                    $result2 = mysqli_query($conexion, $sql1);
                                }
                                $CantDetalleAux = $CantDetalleAux - $cajasADescontar * $factor;
                            }
                            if ($CantDetalleAux > 0) {
                                $saldoVenta = 1;
                            }
                        }
                        if ($CantDetalleAux > 0) {
                            if ($saldoVenta == 1) {
                                $precioAux = $pripro / $factor;
                            } else {
                                $precioAux = $pripro;
                            }
                            $costre_calculado = $CantDetalleAux * $pripro;
                            $CantDetalleAuxMOVMOV = "F" . $CantDetalleAux;
                            mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,orden,codloc) values ('$cod','$invfec','$codpro','$qtypro','$CantDetalleAuxMOVMOV','$pripro','$costre_calculado','$costpr','$Clote','$i','$codloc')");

                            if ($rd <> 3) {
                                $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos) 
                        values ('$venta','$date','$cuscod','$usuario','$codpro','$CantDetalleAux','T','$factor','$precioAux','$costre','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ")";
                                $result2 = mysqli_query($conexion, $sql1);
                            }
                        }
                        //INSERTO EN KARDEX DETALLE
                        // $sql1 = "INSERT INTO kardexLote(codkard,IdLote,Cantidad) values ('$last_idKardex','$Clote','$CantDetalle')";
                        // $result2 = mysqli_query($conexion, $sql1);
                        // if (mysqli_errno($conexion)) {
                        //     //error_log("Agrega detalle SQL(" . $sql1 . "),\nerror(" . mysqli_error($conexion) . ")");
                        // }
                    }
                }


                //  error fatal actualizado
            } else {
                mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,orden,codloc) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','','$i','$codloc')");
                if ($rd <> 3) {
                    mysqli_query($conexion, "INSERT INTO detalle_venta(invnum ,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$pripro','$costre','$codmar','$costpr')");
                }
            }
            // Si el producto se vende fraccionado
            if ($fraccion == 'T') {
                $cantidad_comp = $canpro;
                $precio_ref = number_format($precio_ref / $factor, 2, '.', ' ');
                $sum_mont1 = $precio_ref * $cantidad_comp;
                $mont_bruto = $mont_bruto + $sum_mont1;
                $valor_vent = ($pripro / (($porcent_igv / 100) + 1)) * $cantidad_comp;
            } else {
                $cantidad_comp = $canpro * $factor;
                $sum_mont1 = $precio_ref * $canpro;
                $mont_bruto = $mont_bruto + $sum_mont1;
                $valor_vent = ($costre / (($porcent_igv / 100) + 1));
            }

            $valor_vent1 = $valor_vent1 + $valor_vent;
            $monto_total = $monto_total + $costre;
        }
    }
    $total_des = $mont_bruto - $valor_vent1;
    $sum_igv = ($monto_total - $valor_vent1);


    if ($rd <> 3) {

        $mont1 = number_format($mont_bruto, 2, '.', ' ');    ///PRECIO BRUTO
        $mont3 = number_format($valor_vent1, 2, '.', ' ');   ///PRECIO VENTA
        $mont4 = number_format($sum_igv, 2, '.', ' ');   ///IGV
        $mont5 = number_format($monto_total, 2, '.', ' ');  ///TOTAL

        $NuevoCorrelativo = 0;
        //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
        $sqlXCOM = "SELECT seriebol,seriefac,serietic,numbol,numfac,numtic FROM xcompa where codloc = '$codloc'";
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
                if ($rd == 1) {
                    $serie = "F" . $seriefac;
                    $NuevoCorrelativo = $numbol + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numbol = '$NuevoCorrelativo' where codloc = '$codloc'");
                }
                // FACTURA
                if ($rd == 2) {
                    $serie = "B" . $seriebol;
                    $NuevoCorrelativo = $numfac + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numfac = '$NuevoCorrelativo' where codloc = '$codloc'");
                }
                //TICKET
                if ($rd == 4) {
                    $serie = "T" . $serietic;
                    $NuevoCorrelativo = $numtic + 1;
                    mysqli_query($conexion, "UPDATE xcompa set numtic = '$NuevoCorrelativo' where codloc = '$codloc'");
                }
            }
            $PrintSerie = $serie . '-' . $NuevoCorrelativo;
            mysqli_query($conexion, "UPDATE venta set nrovent = '$NuevoCorrelativo', correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie',tipdoc='$rd' where invnum = '$venta'");
        }
    }

    $sql4_suma = "SELECT SUM(costre) FROM `movmov` WHERE invnum='$cod' ";
    $result4_suma = mysqli_query($conexion, $sql4_suma);
    if (mysqli_num_rows($result4_suma)) {
        while ($row4_suma = mysqli_fetch_array($result4_suma)) {
            $invtot_suma = $row4_suma[0];
        }
    }

    $sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $correlativo = $row[0];        //codigo
        }
        $correlativo    = $correlativo + 1;
    }

    mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE movmae set invtot  = '$invtot_suma', monto = '$invtot_suma',refere = '$referencia', codusu = '$vendedor', estado = '0', proceso = '0',correlativo='$correlativo',hora='$hoy',transferenciaVenta='$venta'  where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$cod'");

    if ($rd <> 3) {


        $sql4 = "SELECT porcent FROM datagen";
        $result4 = mysqli_query($conexion, $sql4);
        if (mysqli_num_rows($result4)) {
            while ($row4 = mysqli_fetch_array($result4)) {
                $porcent = $row4['porcent'];
            }
        }


        $SumInafectos = 0;
        $monto_total = 0;
        $valor_vent1 = 0;
        $mont_bruto = 0;


        $sqlDetTot = "SELECT * FROM detalle_venta where invnum = '$venta' and canpro <> '0'";
        $resultDetTot = mysqli_query($conexion, $sqlDetTot);
        if (mysqli_num_rows($resultDetTot)) {
            while ($row = mysqli_fetch_array($resultDetTot)) {
                $i++;
                $igvVTADet = 0;
                $codproDet = $row['codpro'];
                $canproDet = $row['canpro'];
                $factorDet = $row['factor'];
                $prisalDet = $row['prisal'];


                //$priproDet = $row['pripro'];
                $priproDet = $canproDet * $prisalDet;


                $fraccionDet = $row['fraccion'];
                $sqlProdDet = "SELECT igv FROM producto where codpro = '$codproDet'";
                $resultProdDet = mysqli_query($conexion, $sqlProdDet);
                if (mysqli_num_rows($resultProdDet)) {
                    while ($row1 = mysqli_fetch_array($resultProdDet)) {
                        $igvVTADet = $row1['igv'];
                    }
                }
                // Si aplica IGV, colocar porcentaje, sino 0
                $porcent_igv = ($igvVTADet == 1) ? $porcent : 0;

                // Si el producto se vende fraccionado
                if ($fraccion == 'T') {
                    $valor_vent = ($prisalDet / (($porcent_igv / 100) + 1)) * $canproDet;
                } else {
                    $valor_vent = ($priproDet / (($porcent_igv / 100) + 1));
                }


                if ($igvVTADet == 0) {
                    $MontoDetalle = $prisalDet * $canproDet;
                    $SumInafectos = $SumInafectos + $MontoDetalle;
                }

                $valor_vent1 += $valor_vent;
                $monto_total += $priproDet;


                // $sql1 = "UPDATE detalle_venta set pripro = '$priproDet' where invnum = '$invnumventa' and codpro='$codproDet'";
                // mysqli_query($conexion, $sql1);

            }
        }
        $sum_igv = ($monto_total - $valor_vent1);


        $SumGrabado = round(($valor_vent1 - ($sum_igv + $SumInafectos)), 2);



        $mont3 = $valor_vent1;  ///PRECIO VENTA
        $mont4 = $sum_igv;   ///IGV
        $mont5 = $monto_total;  ///TOTAL



        $mont3 = round($mont3, 2);
        $mont4 = round($mont4, 2);
        $mont5 = round($mont5, 2);
        $SumGrabado = round($SumGrabado, 2);
        $SumInafectos = round($SumInafectos, 2);

        $sql1 = "UPDATE venta set valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',gravado = '$SumGrabado',inafecto = '$SumInafectos',estado = '0',hora = '$hora',dedonde ='$cod'  where invnum = '$venta'";
        mysqli_query($conexion, $sql1);


        // mysqli_query($conexion, "UPDATE venta set bruto = '$mont1',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',hora = '$hora',dedonde ='$cod' where invnum = '$venta'");
    }
    echo "<script>if(confirm('Desea imprimir esta transferencia?')){document.location='transferencia1_sal_op_reg1.php?rd=$rd';}else{ alert(document.location='../ing_salid.php');}</script>";
    //header("Location: ../ing_salid.php");

    //////////////////////////////////////////////////////////FIN DE MODO DROGUERIA//////////////////////////////////////////////////////////
} else {
    //////////////////////////////////////////////////////////INICIO DE MODO BOTICA - FARMACIA///////////////////////////////////////////////
    function convertir_a_numero($str)
    {
        $legalChars = "%[^0-9\-\. ]%";
        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

    ////VERIFICO LOS DATOS DEL DOCUMENTO Y ESCOGO EL USUARIO Y SU LOCAL
    $sql = "SELECT numdoc,invfec,tipmov,tipdoc,usecod FROM movmae where invnum = '$cod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $numdoc = $row['numdoc'];
            $invfec = $row['invfec'];
            $tipmov = $row['tipmov'];
            $tipdoc = $row['tipdoc'];
            $usecod = $row['usecod'];
        }
    }
    $sql = "SELECT codloc FROM usuario where usecod = '$usecod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codloc = $row['codloc'];
        }
    }
    $sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }
    require_once('../tabla_local.php');
    $sql = "SELECT codpro,qtypro,qtyprf,pripro,costre,costpr,numlote FROM tempmovmov where invnum = '$cod' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        $i2 = 0;
        while ($row = mysqli_fetch_array($result)) {
            $i2++;
            $codpro = $row['codpro'];
            $qtypro = $row['qtypro'];
            $qtyprf = $row['qtyprf'];
            $pripro = $row['pripro'];
            $costre = $row['costre'];
            $costpr = $row['costpr'];
            $numlote = $row['numlote'];
            $sql1 = "SELECT factor,stopro,$tabla,desprod FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $factor = $row1['factor'];
                    $stopro = $row1['stopro'];
                    $cant_loc = $row1[2];
                    $desprod = $row1['desprod'];
                    //				$sactual   = $stopro;
                    $sactual = $cant_loc;
                }
            }
            if ($qtyprf <> "") {
                $text_char = convertir_a_numero($qtyprf);
                $cant_unid = $text_char;
            } else {
                $cant_unid = $qtypro * $factor;
            }
            if ($cant_loc < $cant_unid) {
                echo '<script type="text/javascript">
                                    alert("Eliminar de la lista los productos que no cuentan con stock disponible(fondo rojo)  ");
                                    window.location.href="transferencia_sal.php";
                                    </script>';
                return;
            }
            if ($cant_loc >= $cant_unid) {
                //echo "existe este producto";
                $cant_local = $cant_loc - $cant_unid;
                $stopro = $stopro - $cant_unid;
                $stocklote = 0;
                /////////////////////////////////////////////////////////////////////
                if ($numlote <> "") {
                    $sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $numerolote = $row1['numlote'];
                            $fvencimi = $row1['vencim'];
                            $stocklote = $row1['stock'];
                            $stocklote = $stocklote - $cant_local;
                        }
                        mysqli_query($conexion, "UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote'");
                    }
                }
                /////////////////////////////////////////////////////////////
                mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,transferenciaVenta) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$sactual','$codloc','$venta')");
                /////////////////////////////////////////////////
                mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,costpr,numlote,orden,codloc) values ('$cod','$invfec','$codpro','$qtypro','$qtyprf','$pripro','$costre','$costpr','$numlote','$i2','$codloc')");
            }
            //else {
            //  mysqli_query($conexion, "INSERT INTO rechazo_prepedido (codpro,invnum,qtypro,qtyprf) values ('$codpro','$cod','$qtypro','$qtyprf')");
            //}
        }
    }

    $sql4_suma = "SELECT SUM(costre) FROM `movmov` WHERE invnum='$cod' ";
    $result4_suma = mysqli_query($conexion, $sql4_suma);
    if (mysqli_num_rows($result4_suma)) {
        while ($row4_suma = mysqli_fetch_array($result4_suma)) {
            $invtot_suma = $row4_suma[0];
        }
    }

    $sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $correlativo = $row[0];        //codigo
        }
        $correlativo    = $correlativo + 1;
    }
    mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE movmae set invtot  = '$invtot_suma', monto = '$invtot_suma',refere = '$referencia', codusu = '$vendedor', estado = '0', proceso = '0',correlativo='$correlativo',hora='$hoy' where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$cod'");
    echo "<script>if(confirm('Desea imprimir esta transferencia?')){document.location='transferencia1_sal_op_reg1.php?rd=3';}else{ alert(document.location='../ing_salid.php');}</script>";

    //////////////////////////////////////////////////////////FIN DE MODO BOTICA - FARMACIA/////////////////////////////////////////////////
}
