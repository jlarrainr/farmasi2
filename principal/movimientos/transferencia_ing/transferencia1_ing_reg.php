<?php

include('../../session_user.php');
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

$fechaActual = date('Y-m-d');
$transferencia_ing = $_SESSION['transferencia_ing'];

$sql = "SELECT invfec,tipmov,tipdoc,usecod,invnumrecib FROM movmae where invnum = '$transferencia_ing'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invfec = $row['invfec'];
        $tipmov = $row['tipmov'];
        $tipdoc = $row['tipdoc'];
        $usecod = $row['usecod'];
        $invnumrecib = $row['invnumrecib'];
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
$cod = $_POST['movmae'];  ///INVNUM
///CALCULO DEL LOCAL DESTINO Y EL USUARIO ORIGEN
$sql = "SELECT numdoc,invtot,sucursal, sucursal1 FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $numdoc = $row['numdoc'];
        $invtot = $row['invtot'];
        $sucursal = $row['sucursal'];
        $sucursal1 = $row['sucursal1'];
    }
}

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}



$sql_drogueria = "SELECT drogueria FROM datagen_det ";
$result_drogueria = mysqli_query($conexion, $sql_drogueria);
if (mysqli_num_rows($result_drogueria)) {
    while ($row_drogueria = mysqli_fetch_array($result_drogueria)) {
        $drogueria = $row_drogueria['drogueria'];
    }
}

if ($drogueria == 1) {


    function callLotes($Conexion, $CodPro, $Tipo, $codloc)
    {
        $sqlLote = "SELECT idlote,stock FROM movlote where codpro = '$CodPro'  and codloc= '$codloc'   and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW()
        ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
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

    function callUpdateLoteDestino($Conexion, $codpro, $numlote, $fecvenc, $cantidad, $sucursalDest, $numlote1)
    {
        $sql1 = "SELECT idlote FROM movlote where  	numlote = '$numlote' and codpro='$codpro' and codloc='$sucursalDest'";
        $resultLote = mysqli_query($Conexion, $sql1);

        if (mysqli_num_rows($resultLote)) {
            if ($rowLote = mysqli_fetch_array($resultLote)) {

                $idlote = $rowLote['idlote'];
                $sqlUpdate = "UPDATE movlote set stock = stock + $cantidad where idlote = '$idlote'";

                $result2 = mysqli_query($Conexion, $sqlUpdate);
                return $idlote;
            }
        } else {

            $sqlInsert = "INSERT INTO movlote (codpro, numlote, vencim, stock, codloc,idlote_sale) VALUES ('$codpro', '$numlote', '$fecvenc', '$cantidad', '$sucursalDest','$numlote1')";
            $result2 = mysqli_query($Conexion, $sqlInsert);
            $idlote = mysqli_insert_id($Conexion);
            return $idlote;
        }
        return 0;
    }


    // error_log("INICIO BUCLE==============");
    ///CALCULO DEL LOCAL ORIGEN
    ///BUCLE PARA ACTUALIZAR LA INFORMACION
    $sql = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing' and invnumrecib = '$invnumrecib' order by orden ";            /////CARGO LA DATA DE LA TRANSFERENCIA
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $i++;
            $codpro    = $row['codpro'];
            $qtypro    = $row['qtypro'];
            $qtyprf    = $row['qtyprf'];
            $pripro    = $row['pripro'];
            $costre    = $row['costre'];
            $costpr    = $row['costpr'];
            $numlote1   = $row['numlote'];
            $orden   = $row['orden'];
            $fraccion    = 1;
            $cant_local = 0;


            /////////////////////////////////////////////////////////////
            $sql1 = "SELECT factor,stopro,$tabla FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $factor    = $row1['factor'];
                    $stopro    = $row1['stopro'];
                    $cant_loc  = $row1[2];
                    //				$sactual   = $stopro;
                    $sactual   = $cant_loc;
                }
            }
            if ($qtyprf <> "") {
                $text_char =  convertir_a_numero($qtyprf);
                $cant_unid = $text_char;
            } else {
                $cant_unid = $qtypro * $factor;
            }
            $cant_local = $cant_loc + $cant_unid;
            $stopro = $stopro + $cant_unid;


            mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");


            mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,numlote) values ('$numdoc','$codpro','$fechaActual','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$transferencia_ing','$usuario','$sactual','$codloc','$idlote')");


            $Clote = 0;
            $sqlLote = "SELECT idlote, stock from movlote where  codpro = '$codpro' and codloc='$sucursal' AND  idlote='$numlote1'";

            $resultLote = mysqli_query($conexion, $sqlLote);
            if (mysqli_num_rows($resultLote)) {
                if ($rowRes = mysqli_fetch_array($resultLote)) {
                    $Clote = $rowRes['idlote'];

                    //ACTUALIZO EL STOCK DE LOTES
                    //callUpdateLote($conexion, $Clote, $StockActualLote);


                    //INSERTO EN KARDEX DETALLE

                    $sqlBusq = "SELECT numlote, vencim FROM movlote where  idlote='$Clote' and codloc='$sucursal'";
                    $resultBusq = mysqli_query($conexion, $sqlBusq);
                    if (mysqli_num_rows($resultBusq)) {
                        if ($rowBusq = mysqli_fetch_array($resultBusq)) {
                            $numlote = $rowBusq['numlote'];
                            $fecvenc = $rowBusq['vencim'];
                        }
                    }

                    $destIdLote = callUpdateLoteDestino($conexion, $codpro, $numlote, $fecvenc, $cant_unid, $sucursal1, $numlote1);
                }
            }

            //   echo 'fsdfsd = ' . $transferencia_ing . '========' . $codpro . '********' . $numlote1 . "<br>";
            $sql1 = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing' and codpro = '$codpro'  and numlote='$numlote1'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $temporal      = $row1['codtemp'];
                    $qtypro2       = $row1['qtypro'];
                    $qtyprf2       = $row1['qtyprf'];
                    $pripro2       = $row1['pripro'];
                    $costre2       = $row1['costre'];

                    $sqlBusq = "SELECT idlote FROM movlote where idlote_sale='$numlote1'  ";
                    $resultBusq = mysqli_query($conexion, $sqlBusq);
                    if (mysqli_num_rows($resultBusq)) {
                        if ($rowBusq = mysqli_fetch_array($resultBusq)) {
                            $idlotex = $rowBusq['idlote'];
                        }
                    }



                    mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,numlote,costpr,orden) values ('$transferencia_ing','$invfec','$codpro','$qtypro2','$qtyprf2','$pripro2','$costre2','$idlotex','$costpr','$orden')");


                    mysqli_query($conexion, "DELETE from tempmovmov where codtemp = '$temporal'");
                }
            }
        }
    }
    ///////////////////////////////////////////////////////

    $sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $correlativo = $row[0];        //codigo
        }
        $correlativo    = $correlativo + 1;
    }


    mysqli_query($conexion, "UPDATE movmae set estado = '1', proceso = '0' where invnum = '$cod'");

    // mysqli_query($conexion, "UPDATE movmae set estado = '1', proceso = '0',hora='$hoy' where invnum = '$transferencia_ing'");

    mysqli_query($conexion, "UPDATE movmae set estado = '1', proceso = '0',invtot='$invtot',monto='$invtot',sucursal1='$sucursal',correlativo='$correlativo',hora='$hoy'  where invnum = '$transferencia_ing'");

    header("Location: transferencia1_ing_op_reg1.php");
} else {

    ///CALCULO DEL LOCAL ORIGEN
    ///BUCLE PARA ACTUALIZAR LA INFORMACION
    $sql = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing' and invnumrecib = '$invnumrecib' order by orden ";   /////CARGO LA DATA DE LA TRANSFERENCIA
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row['codpro'];
            $qtypro = $row['qtypro'];
            $qtyprf = $row['qtyprf'];
            $pripro = $row['pripro'];
            $costre = $row['costre'];
            $costpr = $row['costpr'];
            $numlote = $row['numlote'];
            $orden = $row['orden'];
            $cant_local = 0;
            /////////////////////////////////////////////////////////////
            $promedio = 0;
            $sql1 = "SELECT factor,stopro,$tabla,SUM(s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015+s016+s017+s018+s019+s020) as sumatotal,codpro,costpr,costre,utlcos FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $factor = $row1['factor'];
                    // $stopro = $row1['stopro'];
                    $cant_loc = $row1[2];
                    $stopro = $row1['sumatotal'];
                    $sactual = $cant_loc;
                    $codpro1 = $row1['codpro'];
                    //$costpr = $row1['costpr'];
                    //  $costre = $row1['costre'];
                    //  $utlcos = $row1['utlcos'];


                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                        // $costpr_producto = $row1['costpr'];
                        // $costre_producto = $row1['costre'];
                        // $utlcos_producto = $row1['utlcos'];

                    } elseif ($precios_por_local == 0) {

                        // $costpr_producto = $row1['costpr'];
                        // $costre_producto = $row1['costre'];
                        // $utlcos_producto = $row1['utlcos'];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $costpr_p,$costre_p,$utlcos_p FROM precios_por_local where codpro = '$codpro1'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $costpr_producto = $row_precio[0];
                                $costre_producto = $row_precio[1];
                                $utlcos_producto = $row_precio[2];
                            }
                        }
                    }
                }
            }
            if ($qtyprf <> "") {
                $text_char = convertir_a_numero($qtyprf);
                $cant_unid = $text_char;
                $cant_unid_promedio = $text_char * $factor;

                $costpr2 = $costpr * $factor;
            } else {
                $cant_unid = $qtypro * $factor;
                $cant_unid_promedio = $qtypro;

                $costpr2 = $costpr;
            }
            $cant_local = $cant_loc + $cant_unid;
            $stopro = $stopro + $cant_unid;



            $promedio = ((($stopro / $factor) * $costpr_producto) + ($cant_unid * $costpr2)) / (($stopro / $factor) + $cant_unid);



            //echo '$promedio '.$promedio."<br>";


            if ($precios_por_local == 1) {
                if (($zzcodloc == 1)) {

                    mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
                } else {

                    if (($costpr_producto == '0') && ($costre_producto == '0') && ($utlcos_producto == '0')) {

                        mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");

                        mysqli_query($conexion, "UPDATE precios_por_local set $costpr_p = '$costpr2', $costre_p = '$costpr2', $utlcos_p = '$costpr2'  where codpro = '$codpro'");
                    } else {

                        mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");

                        mysqli_query($conexion, "UPDATE precios_por_local set $costpr_p = '$promedio' where codpro = '$codpro'");
                    }
                }
            } else {

                mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local' where codpro = '$codpro'");
            }



            mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal) values ('$numdoc','$codpro','$fechaActual','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$transferencia_ing','$usuario','$sactual','$codloc')");


            $sql1 = "SELECT * FROM tempmovmov where invnum = '$transferencia_ing' and codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $temporal = $row1['codtemp'];
                    $qtypro2 = $row1['qtypro'];
                    $qtyprf2 = $row1['qtyprf'];
                    $pripro2 = $row1['pripro'];
                    $costre2 = $row1['costre'];


                    mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,costre,numlote,costpr,orden) values ('$transferencia_ing','$fechaActual','$codpro','$qtypro2','$qtyprf2','$pripro2','$costre2','$numlote','$costpr','$orden')");



                    mysqli_query($conexion, "DELETE from tempmovmov where codtemp = '$temporal'");
                }
            }
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
    /////////////////////////////////////////////////////////

    mysqli_query($conexion, "UPDATE movmae set estado = '1', proceso = '0' where invnum = '$cod'");
    mysqli_query($conexion, "UPDATE movmae set estado = '1', proceso = '0',invtot='$invtot',monto='$invtot',sucursal1='$sucursal',correlativo='$correlativo',hora='$hoy'  where invnum = '$transferencia_ing'");
    mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$transferencia_ing'");

    header("Location: ../ing_salid.php");
}
