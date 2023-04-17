<?php
require_once('arreglaInvtot.php');

require_once('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
require_once('../../local.php');

$mont1 = $mont_bruto;   ///PRECIO BRUTO
$mont2 = $total_des;   ///CON DESCUENTO
$mont3 = $valor_vent1;  ///PRECIO VENTA
$mont4 = $sum_igv;   ///IGV
$mont5 = $monto_total;  ///TOTAL
$mont6 = $icbper_total;  ///TOTAL
$hour = date("G");
$date = date("Y-m-d");
//$date	= CalculaFechaHora($hour);
$FechaSeg = date("Y-m-d");
$total_costo = 0;
$incentivo = "";

$sql_drogueria = "SELECT drogueria FROM datagen_det ";
$result_drogueria = mysqli_query($conexion, $sql_drogueria);
if (mysqli_num_rows($result_drogueria)) {
    while ($row_drogueria = mysqli_fetch_array($result_drogueria)) {
        $drogueria = $row_drogueria['drogueria'];
    }
}
$sql = "SELECT puntosdiv,precioIcbperAnual,diasCuotasVentas FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $puntosdiv1 = $row['puntosdiv'];
        $precioIcbperAnual = $row['precioIcbperAnual'];
        $diasCuotasVentas = $row['diasCuotasVentas'];
    }
}
if ($puntosdiv1 == '0.00') {

    $puntosdiv = '1.00';
} else {
    $puntosdiv = $puntosdiv1;
}
$numero_xcompa = substr($tablanom_local, 5, 2);
$tablalocals = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);



//**FIN_CONFIGPRECIOS_PRODUCTO**//

$count = 0;
$count1 = 0;
$count2 = 0;

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

foreach ($arr_detalle_venta as $row) {
    //    error_log("Codigo Venta: " . $row['invnum']);
    $invnumTemp = $row['invnum'];
    $canproTemp = $row['canpro'];
    //if ($invnumTemp ==$invnum) {
    $count++;
    if ($canproTemp == '0') {
        $count1++;
    } else {
        $count2++;
    }
    //}
}


if ($count > 0) {
    if ($drogueria == 1) {

        function callLotes($Conexion, $CodPro, $Tipo, $codloc)
        {
            
            $sqlLote = "SELECT idlote,stock FROM movlote where codpro = '$CodPro'  and codloc= '$codloc'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
            $resultLote = mysqli_query($Conexion, $sqlLote);
            if (mysqli_num_rows($resultLote)) {
                while ($rowLote = mysqli_fetch_array($resultLote)) {
                    $CLote = $rowLote['idlote'];
                    $Stock = $rowLote['stock'];
                }
                if ($Tipo == 1) {
                    return $CLote;
                }
                if ($Tipo == 2) {
                    return $Stock;
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
            //     error_log("Actualiza producto SQL(" . $sql1 . ")\nError(" . mysqli_error($Conexion) . ")");
            // }
        }
    }

    $cuscod = 0;
    $sqlV = "SELECT invnum,nrovent,invfec,invfec,cuscod,usecod,codven,forpag,fecven,sucursal,correlativo,tipdoc,tipteclaimpresa,n_cotizacion FROM venta where invnum = '$venta'";
    $resultV = mysqli_query($conexion, $sqlV);
    if (mysqli_num_rows($resultV)) {
        while ($row1 = mysqli_fetch_array($resultV)) {
            $invnum = $row1['invnum'];  //codgio
            $nrovent = $row1['nrovent'];
            $invfec = $row1['invfec'];
            $cuscod = $row1['cuscod'];
            $usecod = $row1['usecod'];
            $codven = $row1['codven'];
            $forpag = $row1['forpag'];
            $fecven = $row1['fecven'];
            $tipdoc = $row1['tipdoc'];          //4=TICKET, 2=BOLETA, 1=FACTURA
            $tipteclaimpresa = $row1['tipteclaimpresa']; //0=nada,1=F8, 2=F9
            $sucursal = $row1['sucursal'];
            $correlativo = $row1['correlativo'];
            $n_cotizacion = $row1['n_cotizacion'];
            switch ($forpag) {
                case 'E':
                    $forma_pago = 'EFECTIVO';
                    break;
                case 'T':
                    $forma_pago = 'TARJETA';
                    break;
                case 'C':
                    $forma_pago = 'correlativo';
                    break;
            }
            //SOLO CUANDO ES F9
            if ($tipteclaimpresa == 2) {
                $NuevoCorrelativo = 0;
                //RECALCULO EL CORRELATIVO POR EL TIPO DE DOCUMENTO Y LA SUCURSAL
                $sqlXCOM = "SELECT seriebol,seriefac,serietic,numbol,numfac,numtic,correlativo_venta FROM xcompa where codloc = '$sucursal'";
                $resultXCOM = mysqli_query($conexion, $sqlXCOM);
                if (mysqli_num_rows($resultXCOM)) {
                    while ($row = mysqli_fetch_array($resultXCOM)) {
                        $seriebol = $row['seriebol'];
                        $seriefac = $row['seriefac'];
                        $serietic = $row['serietic'];
                        $numbol = $row['numbol'];
                        $numfac = $row['numfac'];
                        $numtic = $row['numtic'];
                        $correlativo_venta = $row['correlativo_venta'];
                        // BOLETA
                        if ($tipdoc == 1) {
                            $serie = "F" . $seriefac;
                            $NuevoCorrelativo = $numbol + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numbol = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                        // FACTURA
                        if ($tipdoc == 2) {
                            $serie = "B" . $seriebol;
                            $NuevoCorrelativo = $numfac + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numfac = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                        //TICKET
                        if ($tipdoc == 4) {
                            $serie = "T" . $serietic;
                            $NuevoCorrelativo = $numtic + 1;
                            $correlativo_venta_suma = $correlativo_venta + 1;
                            mysqli_query($conexion, "UPDATE xcompa set numtic = '$NuevoCorrelativo',correlativo_venta='$correlativo_venta_suma' where codloc = '$sucursal'");
                        }
                    }
                    $PrintSerie = $serie . '-' . $NuevoCorrelativo;
                    mysqli_query($conexion, "UPDATE venta set nrovent = '$NuevoCorrelativo', correlativo = '$NuevoCorrelativo',nrofactura = '$PrintSerie',correlativo_venta='$correlativo_venta_suma' where invnum = '$venta'");
                }
            }
        }
    }
    if ($forpag <> 'T') {
        mysqli_query($conexion, "UPDATE venta set codtab = '0' where invnum = '$venta'");
    }

    $sqlxc = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
    $resultxc = mysqli_query($conexion, $sqlxc);
    if (mysqli_num_rows($resultxc)) {
        while ($row1 = mysqli_fetch_array($resultxc)) {
            $localp = $row1['codloc'];
        }
    }




    if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
    } else {
        $arr_detalle_venta = array();
    }
    if (!empty($arr_detalle_venta)) {
        foreach ($arr_detalle_venta as $row1) {
            $canprocajas = 0;
            $stockcentralactual = 0;
            $stocklocalactual = 0;
            $codpro = $row1['codpro'];
            $date = $row1['invfec'];
            $cuscod = $row1['cuscod'];
            $usuario = $row1['usecod'];
            $codmar = $row1['codmar'];
            $canpro = $row1['canpro'];
            $cospro = $row1['cospro'];
            $costpr = $row1['costpr'];
            $fraccion = $row1['fraccion'];
            $factor = $row1['factor'];
            $prisal = $row1['prisal'];  ////PRECIO UNITARIO
            $pripro = $row1['pripro'];  ////MONTO VENTA
            if (isset($row['bonif']) && $row['bonif'] != '') {
                $bonif = $row['bonif'];
            } else {
                $bonif = 0;
            }

            if ($factor == 0) {
                $factor = 1;
            }



            $sqlXX = "SELECT invnum FROM incentivadodet where estado = '1' and codpro = '$codpro' group by invnum";
            $resultXX = mysqli_query($conexion, $sqlXX);
            if (mysqli_num_rows($resultXX)) {
                while ($rowXX = mysqli_fetch_array($resultXX)) {
                    $incentivo = $rowXX[0];
                }
            }

            $sql = "SELECT stopro,costre,utlcos,$tablalocals,codpro,icbper FROM producto where codpro = '$codpro'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $sactual = $row[0];
                    $slocals = $row[3];
                    $codpro = $row[4];
                    $costre = $row[1];
                    $utlcos = $row[2];
                    $icbper = $row[5];

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $utlcos_p,$costre_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $utlcos = $row_precio[0];
                                $costre = $row_precio[1];
                            }
                        }
                    }
                }
            }

            if (($incentivo <> "") and ($incentivo <> 0)) {
                $sql2 = "SELECT incentivado.invnum FROM incentivadodet inner join incentivado on incentivadodet.invnum = incentivado.invnum where codpro = '$codpro'  
                    and dateini <= '$FechaSeg' and datefin >= '$FechaSeg' and incentivado.estado = '1' and incentivadodet.estado = '1'";
                $result2 = mysqli_query($conexion, $sql2);
                if (mysqli_num_rows($result2)) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        $yesincentivo = $row2[0];
                    }
                } else {
                    $yesincentivo = 0;
                }
            } else {
                $yesincentivo = 0;
            }

            $total_costo += $cospro;

            if ($fraccion == "T") {
                $fraccion = "T";
                $cantidad_kardex = "f" . $canpro;
                $stockcentralactual = $sactual - $canpro; // stock de la suma de todos los locales
                $stocklocalactual = $slocals - $canpro;
                $CantidadLotes = $canpro;
            } else {
                $fraccion = "F";
                $cantidad_kardex = $canpro;
                $canprocajas = $canpro * $factor;
                $stockcentralactual = $sactual - $canprocajas;  // stock de la suma de todos los locales
                $stocklocalactual = $slocals - $canprocajas;
                $CantidadLotes = $canprocajas;
            }

            $sql1 = "UPDATE producto set stopro = '$stockcentralactual',$tablalocals = '$stocklocalactual' where codpro = '$codpro'";
            $result2 = mysqli_query($conexion, $sql1);

            $campo = ($fraccion == "T") ? "fraccion" : "qtypro";
            $tipdoc = ($bonif == 1) ? "11" : "9";



            //INSERTO KARDEX
            $sqlKR = "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc," . $campo . ",factor ,invnum,usecod,sactual,sucursal) values ('$nrovent','$codpro','$date','9',$tipdoc,'$cantidad_kardex','$factor','$venta','$usuario','$slocals','$sucursal')";
$sqlKR  = arreglarSql($sqlKR );
            $resultKR = mysqli_query($conexion, $sqlKR);
            //        $last_idKardex = mysqli_insert_id($conexion);


            if ($drogueria == 1) {

                //VERIFICO SI HAY LOTES
                $Clote = 0;
                $sqlLote = "SELECT idlote from movlote where codpro = '$codpro'  and codloc= '$sucursal' AND stock <> 0";
                $resultLote = mysqli_query($conexion, $sqlLote);
                if (mysqli_num_rows($resultLote)) {
                    //ACTUALIZO LOS LOTE
                    //********************************************
                    $CantDetalle = 0;
                    $StockDescontar = $CantidadLotes;
                    while ($StockDescontar <> 0) {

                        $Clote     = callLotes($conexion, $codpro, 1, $sucursal);
                        $stocklote = callLotes($conexion, $codpro, 2, $sucursal);
                        if ($stocklote == 0) {
                            $CantDetalle = $StockDescontar;
                            $StockDescontar = 0;
                        } else {
                            if ($StockDescontar <= $stocklote) {
                                $StockActualLote = $stocklote - $StockDescontar;
                                $CantDetalle     = $StockDescontar;
                                $CantDetalleColm = $CantDetalle;
                                //ACTUALIZO EL STOCK DE LOTES
                                callUpdateLote($conexion, $Clote, $StockActualLote);
                                $StockDescontar = 0;
                            } else {
                                //ACTUALIZO EL STOCK DEL ANTERIOR Y SIGO BUSCANDO DE OTRO LOTE CON EL STOCK POR DESCONTAR
                                $StockDescontar = $StockDescontar - $stocklote;
                                $CantDetalle    = $stocklote;
                                //ACTUALIZO EL STOCK DE LOTES
                                callUpdateLote($conexion, $Clote, 0);
                            }
                        }
                        //INSERTO DETALLEVENTA
                        $CantDetalleAux = $CantDetalle;
                        $saldoVenta = 0;
                        if ($fraccion == "F") {
                            $cajasADescontar = floor($CantDetalleAux / $factor);

                            if ($icbper == 1) {
                                $icbper_factor = $factor;
                                $icbper_subtotal = $cajasADescontar * $precioIcbperAnual;
                            } else {
                                $icbper_factor = 0;
                                $icbper_subtotal = 0;
                            }

                            if ($cajasADescontar > 0) {
                                 $npripro=$cajasADescontar * $prisal;
                                $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos,icbperfactor,icbpersubtotal) values ('$venta','$date','$cuscod','$usuario','$codpro','$cajasADescontar','$fraccion','$factor','$prisal','$npripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ",'$icbper_factor','$icbper_subtotal')";
$sql1  = arreglarSql($sql1 );
                                $result2 = mysqli_query($conexion, $sql1);
                                $CantDetalleAux = $CantDetalleAux - $cajasADescontar * $factor;
                            }
                            if ($CantDetalleAux > 0) {
                                $saldoVenta = 1;
                            }
                        }
                        if ($CantDetalleAux > 0) {
                            if ($saldoVenta == 1) {
                                $precioAux = $prisal / $factor;
                            } else {
                                $precioAux = $prisal;
                            }
                            if ($icbper == 1) {
                                $icbper_factor = $factor;
                                $icbper_subtotal = $precioIcbperAnual  * $CantDetalleAux;
                            } else {
                                $icbper_factor = 0;
                                $icbper_subtotal = 0;
                            }
                            $npripro=$CantDetalleAux * $precioAux;
                            $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos,icbperfactor,icbpersubtotal) values ('$venta','$date','$cuscod','$usuario','$codpro','$CantDetalleAux','T','$factor','$precioAux','$npripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ",'$icbper_factor','$icbper_subtotal')";
$sql1  = arreglarSql($sql1 );
                            $result2 = mysqli_query($conexion, $sql1);
                        }

                        //INSERTO EN KARDEX DETALLE
                        // $sql1 = "INSERT INTO kardexLote(codkard,IdLote,Cantidad) values ('$last_idKardex','$Clote','$CantDetalle')";
                        // $result2 = mysqli_query($conexion, $sql1);
                    }
                } else {
                    if ($icbper == 1) {
                        $icbper_factor = $factor;
                        $icbper_subtotal = $precioIcbperAnual * $canpro;
                    } else {
                        $icbper_factor = 0;
                        $icbper_subtotal = 0;
                    }
                    //INSERTO DETALLEVENTA
                    $npripro=$canpro * $prisal;
                    $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos,icbperfactor,icbpersubtotal) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$npripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ",'$icbper_factor','$icbper_subtotal')";
$sql1  = arreglarSql($sql1 );
                    $result2 = mysqli_query($conexion, $sql1);
                }
            } else {
                if ($icbper == 1) {
                    $icbper_factor = $factor;
                    $icbper_subtotal = $precioIcbperAnual * $canpro;
                } else {
                    $icbper_factor = 0;
                    $icbper_subtotal = 0;
                }
                //INSERTO DETALLEVENTA
                $npripro=$canpro * $prisal;
                $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo,idlote,ultcos,icbperfactor,icbpersubtotal) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$npripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo','$Clote'," . ($utlcos == "" ? "NULL" : $utlcos) . ",'$icbper_factor','$icbper_subtotal')";
$sql1  = arreglarSql($sql1 );
                $result2 = mysqli_query($conexion, $sql1);
            }
        }
    }




    //$hour   = CalculaHora($hour);
    $hora = date('H:i:s a');

    unset($_SESSION['arr_detalle_venta']);

    $sqlV2 = "UPDATE venta set bruto = '$mont5',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',hora = '$hora',redondeo = '$redondeo',icbper_total='$mont6',icbpertotal='$mont6' where invnum = '$venta'";
$sqlV2  = arreglarSql($sqlV2 );
    $result2 = mysqli_query($conexion, $sqlV2);


    $sqlCuota = "SELECT invfec,forpag,numeroCuota,ventaDiasCuotas,invtot,tipoOpcionPrecio FROM venta where invnum = '$venta'";
    $resultCuota = mysqli_query($conexion, $sqlCuota);
    if (mysqli_num_rows($resultCuota)) {
        while ($rowCuota = mysqli_fetch_array($resultCuota)) {
            $invfec             = $rowCuota['invfec'];
            $forpag             = $rowCuota['forpag'];
            $numeroCuota        = $rowCuota['numeroCuota'];
            $ventaDiasCuotas    = $rowCuota['ventaDiasCuotas'];
            $invtot             = $rowCuota['invtot'];
            $tipoOpcionPrecio   = $rowCuota['tipoOpcionPrecio'];


            if ($forpag == 'C') {
                $montoCuotas = $invtot / $numeroCuota;

                // $montoCuotas=round($montoCuotas ,2);

                for ($i = 1; $i <= $numeroCuota; $i++) {
                    $nuevosDias = $ventaDiasCuotas * $i;

                    $textoCuota=$i.'/'.$numeroCuota;

                    $date1 = date('Y-m-d');
                    $registro = date('Y-m-d H:m:s');
                    // $fechaPago = date("Y-m-d", strtotime($date1 . "+ $i month"));
                    $fechaPago = date("Y-m-d", strtotime($date1 . "+ $nuevosDias days"));

                    $sqlCuota = "INSERT INTO venta_cuotas(venta_id,monto,fecha_pago,registro,montoCobro,textoCuota) values ('$venta','$montoCuotas','$fechaPago','$registro','$montoCuotas','$textoCuota')";
                    $result2 = mysqli_query($conexion, $sqlCuota);
                }
            }
        }
    }



    if ($n_cotizacion <> '0') {
        $sql1x = "UPDATE cotizacion set estado_venta = '1' where invnum = '$n_cotizacion'";
        mysqli_query($conexion, $sql1x);

        // $sqlV22 = "UPDATE venta set vendedor_cotizacion = '$usuario' where invnum = '$venta'";
        // $result22 = mysqli_query($conexion, $sqlV22);
    }


    $sqlNuevaSuma = "SELECT SUM(pripro) FROM detalle_venta as D INNER JOIN producto as P on P.codpro=D.codpro WHERE P.activoPuntos='1'  and invnum = '$venta' ";
    $resultNuevaSuma = mysqli_query($conexion, $sqlNuevaSuma);
    if (mysqli_num_rows($resultNuevaSuma)) {
        while ($rowNuevaSuma = mysqli_fetch_array($resultNuevaSuma)) {
            $mont5  = $rowNuevaSuma[0];
        }
    }



    //PUNTOS DE CLIENTES
    if ($cuscod <> 0) {
        $Puntos = 0;
        $sqlPuntos = "SELECT codcli,puntos FROM cliente where codcli = '$cuscod' AND ((descli <> 'PUBLICO EN GENERAL') )";
        $resultPuntos = mysqli_query($conexion, $sqlPuntos);
        if (mysqli_num_rows($resultPuntos)) {
            while ($row = mysqli_fetch_array($resultPuntos)) {
                $codcli = $row['codcli'];
                $Puntos2 = $row['puntos'];
            }
            $Puntos = (intval($mont5) / $puntosdiv) + $Puntos2;
            $sqlVP = "UPDATE cliente set puntos = '$Puntos',numeroPrecio='$tipoOpcionPrecio' where codcli = '$codcli'";
            $result2 = mysqli_query($conexion, $sqlVP);
        }
    }
}
