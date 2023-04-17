<?php
require_once('arreglaInvtot.php');

require_once('../../../conexion.php');
require_once('../../../titulo_sist.php'); //CONEXION A BASE DE DATOS
require_once('../../session_user.php');

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

$UsuarioPrincipal = $_SESSION['codigo_user'];
$CodClaveVendedor = isset($_REQUEST['CodClaveVendedor']) ? $_REQUEST['CodClaveVendedor'] : "";
if ($CodClaveVendedor <> "") {
    $sql1 = "SELECT usecod FROM usuario where claveventa = '$CodClaveVendedor'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $CodUsuarioVendedor = $row1['usecod'];
        }
    }
    $_SESSION['codigo_user'] = $CodUsuarioVendedor;
    $usuario = $CodUsuarioVendedor;
}
$venta = $_SESSION['venta'];
$cotizacion = isset($_SESSION['cotizacion']) ? $_SESSION['cotizacion'] : "";
require_once('session_ventas.php');
require_once('calcula_monto.php'); //////CALCULO DE LOS MONTOS POR LA VENTA
require_once('../../local.php');
$mont1 = $mont_bruto;   ///PRECIO BRUTO
$mont2 = $total_des;   ///CON DESCUENTO
$mont3 = $valor_vent1;  ///PRECIO VENTA
$mont4 = $sum_igv;   ///IGV
$mont5 = $monto_total;  ///TOTAL
$mont6 = $icbper_total;  ///TOTAL

$date = date("Y-m-d");
$FechaSeg = date("Y-m-d");
$total_costo = 0;

function tablaslocal($nomloc)
{
    // Tomar los ultimos digitos de "nomloc" para construir el nombre de columna saldo de local
    $numero = substr($nomloc, 5, 2);
    $tabla = "s" . str_pad($numero, 3, "0", STR_PAD_LEFT);
    return $tabla;
}

//try {
//        error_log("Inicio de transaccion conexion:".mysqli_get_host_info($conexion));
//        mysqli_begin_transaction($conexion, MYSQLI_TRANS_START_READ_WRITE);
//        if (mysqli_errno($conexion))
//                error_log("Begin Transaction Error(".mysqli_error($conexion).")");

$tablalocals = tablaslocal($tablanom_local);
$sql1 = "SELECT nrovent,forpag,sucursal FROM venta where invnum = '$venta'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $numdoc = $row1['nrovent'];
        $forpag = $row1['forpag'];
        $codigo_local = $row1['sucursal'];
    }
}
$sql1 = "UPDATE venta set usecod = '$usuario', " . ($forpag <> 'T' ? "codtab = '0'" : "") . " where invnum = '$venta'";
$sql1  = arreglarSql($sql1 );
$result1 = mysqli_query($conexion, $sql1);
//        if (mysqli_errno($conexion))
//                error_log("Actualiza venta (".$sql1.")\nError(".mysqli_error($conexion).")");

$sql1 = "SELECT codloc FROM xcompa where nomloc = 'LOCAL0'";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $localp = $row1['codloc'];
    }
}
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
            $sqlXX = "SELECT invnum FROM incentivadodet where estado = '1' and codpro = '$codpro' group by invnum";
            $resultXX = mysqli_query($conexion, $sqlXX);
            if (mysqli_num_rows($resultXX)) {
                while ($rowXX = mysqli_fetch_array($resultXX)) {
                    $incentivo = $rowXX[0];
                }
            }
            $sqlXY = "SELECT stopro,$tablalocals,blister,preblister,codpro FROM producto where codpro = '$codpro'";
            $resultXY = mysqli_query($conexion, $sqlXY);
            if (mysqli_num_rows($resultXY)) {
                while ($rowXY = mysqli_fetch_array($resultXY)) {
                    $codpro = $rowXY[4];
                    $sactual = $rowXY[0];
                    $slocals = $rowXY[1];
                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                        $blister = $rowXY[2];
                        $preblister = $rowXY[3];
                    } elseif ($precios_por_local == 0) {
                        $blister = $rowXY[2];
                        $preblister = $rowXY[3];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $blister_p,$preblister_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $blister = $row_precio[0];
                                $preblister = $row_precio[1];
                            }
                        }
                    }
                }
            }

            if (($fraccion == 'T') && ($factor <> 1)) {

                if (($blister <> 0) && ($preblister <> 0)) {
                    if ($canpro >= $blister) {
                        $prisal = $preblister;
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
            $total_costo = $total_costo + $cospro;
            /* if ($bonif == 1)
          { */
            $sql2 = "SELECT codkey,cajas,codpro,codprobonif FROM temp_vent_bonif where invnum = '$venta' and codpro = '$codpro'";
            $result2 = mysqli_query($conexion, $sql2);
            if (mysqli_num_rows($result2)) {
                while ($row2 = mysqli_fetch_array($result2)) {
                    $codkey = $row2['codkey'];
                    $cajas = $row2['cajas'];
                    $codproo = $row2['codpro'];
                    $codproboniff = $row2['codprobonif'];
                    $sqlx = "SELECT cajas FROM ventas_bonif_unid where codkey = '$codkey'";
                    $resultx = mysqli_query($conexion, $sqlx);
                    if (mysqli_num_rows($resultx)) {
                        while ($rowx = mysqli_fetch_array($resultx)) {
                            $cajasx = $rowx['cajas'];
                        }
                    }
                    $cajas = $cajasx - $cajas;

                    $sql1 = "UPDATE ventas_bonif_unid set cajas = '$cajas' where codkey = '$codkey'";
                    mysqli_query($conexion, $sql1);
                    //                                        if (mysqli_errno($conexion))
                    //                                                error_log("Act.Vta.Bon (".$sql1.")\nError(".mysqli_error($conexion).")");

                    $sql1 = "INSERT INTO det_vent_bonif(invnum,codpro,codprobonif,codkey,cajas) values ('$venta','$codproo','$codproboniff','$codkey','$cajas')";
                    mysqli_query($conexion, $sql1);
                    //                                        if (mysqli_errno($conexion))
                    //                                                error_log("Det.Vta.Bon (".$sql1.")\nError(".mysqli_error($conexion).")");
                }
            }
            /* } */
            if ($factor == 1) { //SON CAJAS
                $fraccion = "F";
                $cantidad_kardex = $canpro;
                $canprocajas = $canpro * $factor;
                $stockcentralactual = $sactual - $canprocajas;
                $stocklocalactual = $slocals - $canprocajas;
            } else {
                if ($fraccion == "T") { ////son unidades
                    $fraccion = "T";
                    $cantidad_kardex = "f" . $canpro;
                    $stockcentralactual = $sactual - $canpro;
                    $stocklocalactual = $slocals - $canpro;
                } else { //SON CAJAS
                    $fraccion = "F";
                    $cantidad_kardex = $canpro;
                    $canprocajas = $canpro * $factor;
                    $stockcentralactual = $sactual - $canprocajas;
                    $stocklocalactual = $slocals - $canprocajas;
                }
            }
            $sql1 = "UPDATE producto set stopro = '$stockcentralactual',$tablalocals = '$stocklocalactual' where codpro = '$codpro'";

            $result2 = mysqli_query($conexion, $sql1);
            //                        if (mysqli_errno($conexion))
            //                                error_log("Actualiza producto (".$sql1."\nError(".mysqli_error($conexion).")");

          //  $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$pripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo')";
            $npripro=$canpro * $prisal;
            $sql1 = "INSERT INTO detalle_venta(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif,incentivo) values ('$venta','$date','$cuscod','$usuario','$codpro','$canpro','$fraccion','$factor','$prisal','$npripro','$codmar','$cospro','$costpr','$bonif','$yesincentivo')";
$sql1  = arreglarSql($sql1 );
            $result2 = mysqli_query($conexion, $sql1);
            //                        if (mysqli_errno($conexion))
            //                                error_log("Agrega detalle SQL(".$sql1."\nError(".mysqli_error($conexion).")");


            $campo = ($fraccion == "T") ? "fraccion" : "qtypro";
            $tipdoc = ($bonif == 1) ? "11" : "9";
            $sql1 = "INSERT INTO kardex(nrodoc,codpro,fecha,tipmov,tipdoc," . $campo . ",factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$date','9',$tipdoc,'$cantidad_kardex','$factor','$venta','$usuario','$slocals','$codigo_local')";
$sql1  = arreglarSql($sql1 );
            $result2 = mysqli_query($conexion, $sql1);
            //                        if (mysqli_errno($conexion))
            //                                error_log("Agrega kardex (".$sql1."\nError(".mysqli_error($conexion).")");
            //                                error_log("Registrando venta");
        }
    }
}
if ($count > 0) {

    $hora = date('H:i:s a');

    if ($cotizacion <> '') {
        mysqli_query($conexion, "UPDATE cotizacion set baja = '1' where invnum = '$cotizacion'");
    }
    unset($_SESSION['arr_detalle_venta']);
    mysqli_query($conexion, $sql1);
    //        if (mysqli_errno($conexion))
    //                error_log("Del TmpVta (".$sql1."\nError(".mysqli_error($conexion).")");

    $sql1 = "UPDATE venta set bruto = '$mont5',valven = '$mont3',igv = '$mont4',invtot = '$mont5',saldo = '$mont5',estado = '0',cosvta = '$total_costo',hora = '$hora',invfec = '$date',redondeo = '$redondeo',icbper_total='$mont6',icbpertotal='$mont6' where invnum = '$venta'";
$sql1  = arreglarSql($sql1 );
    mysqli_query($conexion, $sql1);
    //        if (mysqli_errno($conexion))
    //                error_log("UpdVta (".$sql1."\nError(".mysqli_error($conexion).")");
}
$_SESSION['codigo_user'] = $UsuarioPrincipal;
mysqli_close($conexion);
header("Location: ventas_registro.php");
//}
//catch(Exception $ex)
//{
//error_log("Transaccion cancelada\nError MySQL:".mysqli_error());
//error_log($ex->$php_errormsg);
//mysqli_rollback($conexion);
//}
exit;
