<?php

include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');

require_once('../../../titulo_sist.php');

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
$cod = $_REQUEST['cod'];   ///invnum
$date1 = fecha1($_REQUEST['date1']); ///cantidad ingresada
$date2 = fecha1($_REQUEST['date2']); ///precio sin descuentos y sin igv
$n1 = $_REQUEST['n1'];    ///num documento1
$n2 = $_REQUEST['n2'];    ///num documento2
$plazo = $_REQUEST['plazo'];   ///plazo
//$moneda = $_REQUEST['moneda'];   ///moneda
$mont1 = $_REQUEST['mont_bruto'];  ///precio bruto
$mont2 = $_REQUEST['total_des'];  ///descuentos
$mont3 = $_REQUEST['valor_vent1']; ///precio venta
$mont4 = $_REQUEST['sum_igv'];  ///igv
$mont5 = $_REQUEST['monto_total']; ///total
$sum33 = $_REQUEST['sum33'];   ///total
$ncompra = $_REQUEST['ncompra'];  ///numero interno de compra
$ckigv = isset($_REQUEST['ckigv']) ? ($_REQUEST['ckigv']) : ""; ///APLICO EL IGV
$Proveedor = $_REQUEST['alfa1'];
//NUEVO
$dafecto = $_REQUEST['dafecto'];
$dinafecto = $_REQUEST['dinafecto'];
$digv = $_REQUEST['digv'];
$dtotal = $_REQUEST['dtotal'];
$hoy = date('Y-m-d H:i:s');
if ($ckigv == "") {
    $ckigv = 0;
}

$cant_registros = $_REQUEST['cant_registros']; ///CANTIDAD DE REGISTROS DE LA COMPRA
/////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT count(invnum) FROM templote where invnum = '$cod' and vencim <> ''";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $count = $row[0]; ////CANTIDAD DE REGISTROS EN EL GRID
    }
} else {
    $count = 0; ////CUANDO NO HAY NADA EN EL GRID
}
/////////////////////////////////////////////////////////////////////////////////
$date = date("Y-m-d");
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
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
        $nomloc = $row['nomloc'];
    }
}
require_once('../tabla_local.php');

///FUNCION PARA CONVERTIR EL FACTOR A NUMERO
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}


$sql = "SELECT invnum FROM movmae where invnum = '$cod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum_filtro = $row["invnum"];  //codigo

    }
}
if (($invnum_filtro == 0) || ($invnum_filtro == '')) {
    header("Location: compras1.php?ok=5&filtro=1");
} else {

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
    // Valor del IGV
    $sql = "SELECT porcent FROM datagen";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $porcent = $row['porcent'];
        }
    }

    // obtengo el lote por filtro
    $sql = "SELECT codpro FROM tempmovmov where invnum = '$cod' ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row['codpro'];
        }
    }

    $sql1 = "SELECT lotec,costpr  FROM producto where codpro = '$codpro'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $lotecfiltro = $row1['lotec']; ///para buscar el lote 
            $costoPromedioAnterior = $row1['costpr']; ///para buscar el lote 
        }
    }

    if ($lotecfiltro == 1) {
        $lotenombre = "lotec";
    } else {
        $lotenombre = "lote";
    }

    $porcentaje = (1 + ($porcent / 100));
    $costre = 0;
    $nohay = 0;
    $sql = "SELECT P.codpro, P.desprod FROM tempmovmov T, producto P where invnum = '$cod' and T.codpro=P.codpro and P.$lotenombre='1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row['codpro'];
            $desprod = $row['desprod'];
            $sqlLote = "SELECT COUNT(codpro) contador FROM templote where invnum = '$cod' and codpro='$codpro'";
            $resultLote = mysqli_query($conexion, $sqlLote);
            if (mysqli_num_rows($resultLote)) {
                if ($rowLote = mysqli_fetch_array($resultLote)) {
                    $contador = $rowLote['contador'];
                    if ($contador < 1) {
                        echo '<script type="text/javascript">
                    alert("No se ha asociado un lote para el producto: ' . $desprod . '");
                    window.location.href="compras.php?ok=4";
                    </script>';
                        return;
                    }
                }
            }
        }
    }
    // Recuperar filas registradas en compra
    $sql = "SELECT * FROM tempmovmov where invnum = '$cod' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $i++;
            $codtemp = $row['codtemp'];
            $codpro = $row['codpro'];
            $qtypro = $row['qtypro'];
            $qtyprf = $row['qtyprf'];
            $pripron = $row['pripro']; //precio incluyendo el descuento e igv
            $prisal = $row['prisal']; //precio sin igv ni descuento
            $costre = $row['costre']; //costo real del producto. el pripro * la cantidad
            $desc1 = $row['desc1'];
            $desc2 = $row['desc2'];
            $desc3 = $row['desc3'];
            $costpr = $row['costpr'];
            $canbon = $row['canbon']; //cantidad bonificada
            $tipbon = $row['tipbon']; //tipo de bonificacion
            $conigv = $row['conigv']; //veo si fue utilizado con igv o no
            $digemid = $row['digemid'];
            $registrosanitario = $row['registrosanitario'];
            $stopro = 0;
            $cant_loc = 0;


            $sql1 = "SELECT lotec FROM producto where codpro = '$codpro'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                while ($row1 = mysqli_fetch_array($result1)) {
                    $lotecfiltro = $row1['lotec']; ///para buscar el lote 
                }
            }

            if ($lotecfiltro == 1) {
                $lotenombre = "lotec";
            } else {
                $lotenombre = "lote";
            }


            ////veo los datos del producto
            $sqlx = "SELECT tcosto,tmargene,tprevta,tpreuni,tcostpr,factor,$lotenombre,codpro FROM producto where codpro = '$codpro'";
            $resultx = mysqli_query($conexion, $sqlx);
            if (mysqli_num_rows($resultx)) {
                while ($rowx = mysqli_fetch_array($resultx)) {
                    $factor = $rowx["factor"];
                    $lotec = $rowx[6];
                    $codpro = $rowx["codpro"];


                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                        $tcosto = $rowx["tcosto"];   //codigo
                        $tmargene = $rowx["tmargene"];  //codigo
                        $tprevta = $rowx["tprevta"];  //codigo
                        $tpreuni = $rowx["tpreuni"];  //codigo
                        $tcostpr = $rowx["tcostpr"];
                    } elseif ($precios_por_local == 0) {
                        $tcosto = $rowx["tcosto"];   //codigo
                        $tmargene = $rowx["tmargene"];  //codigo
                        $tprevta = $rowx["tprevta"];  //codigo
                        $tpreuni = $rowx["tpreuni"];  //codigo
                        $tcostpr = $rowx["tcostpr"];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $tcosto_p,$tmargene_p,$tprevta_p,$tpreuni_p,$tcostpr_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $tcosto = $row_precio[0];   //codigo
                                $tmargene = $row_precio[1];  //codigo
                                $tprevta = $row_precio[2];  //codigo
                                $tpreuni = $row_precio[3];  //codigo
                                $tcostpr = $row_precio[4];
                            }
                        }
                    }
                }
            }

            if ($qtyprf <> "") {
                $pripro = $pripron * $factor;
            } else {
                $pripro = $pripron;
            }
            if (($tmargene <> 0) && ($tprevta <> 0) && ($tpreuni <> 0)) {


                if ($precios_por_local == 1) {

                    if (($zzcodloc == 1)) {

                        mysqli_query($conexion, "UPDATE producto set margene = '$tmargene',tmargene = '0',prevta= '$tprevta',tprevta= '0',preuni = '$tpreuni',tpreuni = '0',tcosto = '0',costpr = '$tcostpr',tcostpr = '0' where codpro = '$codpro'");
                    } else {

                        mysqli_query($conexion, "UPDATE precios_por_local set $margene_p = '$tmargene',$tmargene_p = '0',$prevta_p= '$tprevta',$tprevta_p= '0',$preuni_p = '$tpreuni',$tpreuni_p = '0',$tcosto_p = '0',$costpr_p = '$tcostpr',$tcostpr_p = '0' where codpro = '$codpro'");
                    }
                } else {

                    mysqli_query($conexion, "UPDATE producto set margene = '$tmargene',tmargene = '0',prevta= '$tprevta',tprevta= '0',preuni = '$tpreuni',tpreuni = '0',tcosto = '0',costpr = '$tcostpr',tcostpr = '0' where codpro = '$codpro'");
                }
            }

            ////SI HAY CANTIDAD BONIFICABLE EN EL TEMPORAL
            //----------------------------------------------------
            if ($canbon <> 0) {
                ////COMPRUEBO QUE SE HAYA REGISTRADO EL PRODUCTO BONIFICABLE
                $sqlq = "SELECT codpro,canbon,tipbon,costo_real,numlote,vencim,codprobon,factor  FROM tempmovmov_bonif where codtemp = '$codtemp' and invnum = '$cod'";
                $resultq = mysqli_query($conexion, $sqlq);
                if (mysqli_num_rows($resultq)) {
                    while ($rowq = mysqli_fetch_array($resultq)) {

                        $codprobon = $rowq['codprobon'];   /////el codigo del producto que se esta bonificando
                        $canbon1 = $rowq['canbon'];
                        $tipbon1 = $rowq['tipbon'];
                        $pripro1 = $rowq['costo_real'];  /////nuevo precio de compra calculado
                        $numloteBoni = 'BONIF' . $rowq['numlote'];
                        $vencimBoni = $rowq['vencim'];
                        $codigoProducto = $rowq['codprobon'];
                        $factorBoni = $rowq['factor'];
                    }
                } else {
                    $nohay = 1; ////quiere decir que no se ha registrado nada de bonificaciones, por tanto sale del sist a compras1
                    $codprobon = 0;
                    $canbon1 = 0;
                    $tipbon1 = 0;
                    $pripro1 = 0;
                    $numloteBoni = '';
                    $vencimBoni = '';
                    $codigoProducto = 0;
                    $factorBoni = '0';
                }
            } else {
                $codprobon = 0;
                $canbon1 = 0;
                $tipbon1 = 0;
                $pripro1 = 0;
                $numloteBoni = '';
                $vencimBoni = '';
                $codigoProducto = 0;
                $factorBoni = '0';
            }

            //--------------------------------------------------
            if ($nohay <> 1) { /////PREGUNTO SI EL PRODUCTO ES BONIFICABLE O SI ESTE NO TIENE VINCULO CON BONIFICACION
                //----------------------------AQUI EMPIEZO $NOHAY = 1 ------------------------------////
                //-------------SELECCIONO EL PRODUCTO Y VEO SU FACTOR Y STOCK EN GENERAL------------////
                $sql1 = "SELECT factor,stopro,preuni,margene,igv,$tabla,pcostouni,$lotenombre,codpro FROM producto where codpro = '$codpro'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $factor = $row1['factor'];
                        $stopro = $row1['stopro'];
                        $igv = $row1['igv'];
                        $cant_loc = $row1[5];
                        $lotec = $row1[7];
                        $sactual = $cant_loc;
                        $codpro = $row1['codpro'];

                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                            $preuni = $row1['preuni'];
                            $margene = $row1['margene'];
                            $ultpcostouni = $row1['pcostouni'];
                        } elseif ($precios_por_local == 0) {
                            $preuni = $row1['preuni'];
                            $margene = $row1['margene'];
                            $ultpcostouni = $row1['pcostouni'];
                        }

                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                            $sql_precio = "SELECT $preuni_p,$margene_p,$pcostouni_p FROM precios_por_local where codpro = '$codpro'";
                            $result_precio = mysqli_query($conexion, $sql_precio);
                            if (mysqli_num_rows($result_precio)) {
                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                    $preuni = $row_precio[0];
                                    $margene = $row_precio[1];
                                    $ultpcostouni = $row_precio[2];
                                }
                            }
                        }
                    }
                }

                if ($qtyprf <> "") { ///// EN UNIDADES
                    $text_char = convertir_a_numero($qtyprf);
                    $cant_unid = $text_char;    ////cantidad ingresada en unidades
                    if ($pripro1 == 0) {      ////si el costo bonificable es igual a 0
                        $pcostouni = $costre / $cant_unid;  /////costo real/unidades ingresantes
                    } else {
                        $pcostouni = $pripro1 * $factor;  /////costo real del producto
                    }
                } else {   //// EN CAJAS
                    $cant_unid = $qtypro * $factor;   ////cantidad ingresada en unidades
                    if ($pripro1 == 0) {      ////si el costo bonificable es igual a 0
                        $pcostouni = $costre / $qtypro;   /////costo real/caja
                    } else {
                        $pcostouni = $pripro1 * $factor;  /////costo real del producto
                    }
                }
                ////ESTO HE AGREGADO
                //////CALCULO DEL PRECIO REFERENCIAL
                //if (($igv == 1) || ($ckigv == 1))
                if ($conigv == 1) {
                    $referencial = $prisal;
                    $pcostouni = $pcostouni;
                    $costpr = $costpr;
                    $pripro = $pripro;
                } else {
                    if (($ckigv == 1)) {
                        $referencial = $prisal * $porcentaje;
                        $pcostouni = $pcostouni * $porcentaje;
                        $costpr = $costpr * $porcentaje;
                        $pripro = $pripro * $porcentaje;
                    } else {
                        $referencial = $prisal;
                        $pcostouni = $pcostouni;
                        $costpr = $costpr;
                        $pripro = $pripro;
                    }
                }
                $numlote = "";
                ////////LOTES Y VENCIMIENTOS DE LA TABLA TEMPORAL///////////////////////////////////////
                $sql1 = "SELECT numerolote,vencim FROM templote where invnum = '$cod' and codpro = '$codpro' and codloc= '$codloc' and codtemp='$codtemp'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $numlote = $row1['numerolote'];
                        $vencimi = $row1['vencim'];
                    }
                }
                $stocklote = 0;
                ///////REVISO SI EL NUMERO DEL TEMPORAL EXISTE EN MI TABLA ORIGINAL

                if ($numlote <> "") {
                    $sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numlote' and codpro = '$codpro' and codloc= '$codloc'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $numerolote = $row1['numlote'];
                            $fvencimi = $row1['vencim'];
                            $stocklote = $row1['stock'];
                            $stocklote = $stocklote + $cant_unid;
                        }
                        mysqli_query($conexion, "UPDATE movlote set stock = '$stocklote' where codpro = '$codpro' and numlote = '$numerolote' and codloc = '$codloc'");
                    } else {
                        mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codpro','$numlote','$vencimi','$cant_unid', '$codloc')");
                    }


                    $sql1 = "SELECT idlote FROM movlote where numlote = '$numlote' and vencim ='$vencimi' and codpro = '$codpro' and codloc= '$codloc'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $idlotereg = $row1['idlote'];
                        }
                    }
                }



                if ($canbon <> 0) {
                    ////COMPRUEBO QUE SE HAYA REGISTRADO EL PRODUCTO BONIFICABLE



                    $stocklote = 0;
                    ///////REVISO SI EL NUMERO DEL TEMPORAL EXISTE EN MI TABLA ORIGINAL

                    if ($numloteBoni <> "") {

                        if ($tipbon1 != 'U') {
                            $stockParaBonificacion = $canbon1 * $factorBoni;
                        } else {
                            $stockParaBonificacion = $canbon1;
                        }

                        $sql1 = "SELECT numlote,vencim,stock FROM movlote where numlote = '$numloteBoni' and codpro = '$codpro' and codloc= '$codloc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $numerolote = $row1['numlote'];
                                $fvencimi = $row1['vencim'];
                                $stocklote = $row1['stock'];
                                $stocklote = $stocklote + $stockParaBonificacion;
                            }
                            mysqli_query($conexion, "UPDATE movlote set stock = '$stockParaBonificacion' where codpro = '$codprobon' and numlote = '$numerolote' and codloc = '$codloc'");
                            $idUltimoRegistroLote = mysqli_insert_id($conexion);
                        } else {


                            mysqli_query($conexion, "INSERT INTO movlote (codpro,numlote,vencim,stock, codloc) values ('$codprobon','$numloteBoni','$vencimBoni','$stockParaBonificacion', '$codloc')");
                            $idUltimoRegistroLote = mysqli_insert_id($conexion);
                        }
                    }
                }



                $sqlProducto = "SELECT $lotenombre FROM producto where codpro = '$codprobon' ";
                $resultProducto = mysqli_query($conexion, $sqlProducto);
                if (mysqli_num_rows($resultProducto)) {
                    while ($rowProducto = mysqli_fetch_array($resultProducto)) {
                        $loteProducto = $rowProducto[0];
                    }
                }



                /////////////////////////////////////////////////////////////
                //----si ay bonificacion y es por el mismo producto en cajas
                if (($codprobon == $codpro) && ($codprobon <> 0) && ($tipbon1 == "C")) {
                    $frac_canbon = $canbon1;       /////CANTIDAD BONIFICADA POR CAJA
                    $canbon1 = $canbon1 * $factorBoni;    /////CANTIDAD BONIFICADA EN UNIDADES
                    $cant_local = $cant_unid + $cant_loc + $canbon1; /////STOCK LOCAL INCL BONIFICACION
                    $cant_local2 =  $cant_loc + $canbon1; /////STOCK LOCAL INCL BONIFICACION

                    // $kardex = "muestra 1";
                    // echo "muestra 1" . "<br>";
                    $stopro = $cant_unid + $stopro + $canbon1; /////NUEVO STOCK INCL BONIFICACION
                    $prevta1 = $pripro1 * (($margene / 100) + 1); /////NUEVO PRECIO DE VENTA INCL BONIFICACION DEL PROD GENERAL
                    $preciounit = $prevta1 / $factorBoni;     /////NUEVO PRECIO UNITARIO INCL BONIFICACION DEL PROD GENERAL
                    //////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
                    mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,preciocompra,numlote) values ('$numdoc','$codprobon','$invfec','11','11','$frac_canbon','','$factorBoni','$cod','$usuario','$sactual','$codloc','$pcostouni','$idUltimoRegistroLote')");
                    mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr,tipmov,numlote,orden,costoPromedioAnterior) values ('$cod','$date','$codprobon','$frac_canbon','','0','0','0','0','0','0','0', '$tipmov','$idlotereg','$i','$costoPromedioAnterior')");
                } else {
                    //----si es bonificacion pero con otro producto en cajas
                    if (($codprobon <> $codpro) && ($codprobon <> 0) && ($tipbon1 == "C")) {
                        $sqlc = "SELECT factor,stopro,$tabla,$lotenombre FROM producto where codpro = '$codprobon'";
                        $resultc = mysqli_query($conexion, $sqlc);
                        if (mysqli_num_rows($resultc)) {
                            while ($rowc = mysqli_fetch_array($resultc)) {
                                $factores = $rowc['factor'];
                                $stoproes = $rowc['stopro'];
                                $cant_loces = $rowc[2];
                                $lotec = $rowc[3];
                                //$sactual     = $stoproes;
                                $sactual = $cant_loces;
                            }
                        }
                        $frac_canbon = $canbon1;     /////CANTIDAD BONIFICADA POR CAJA
                        $canbon1 = $canbon1 * $factores;  /////CANTIDAD BONIFICADA EN UNIDADES
                        $stoproes = $stoproes + $canbon1;  /////STOCK GENERAL DEL PRODUCTO BONIFICADO
                        $cant_loces = $cant_loces + $canbon1; /////STOCK LOCAL DEL PRODUCTO BONIFICADO
                        $cant_local = $cant_unid + $cant_loc; /////STOCK LOCAL DEL PRODUCTO PRINCIPAL
                        $cant_local2 =  $cant_loces;
                        // echo "muestra 2" . "<br>";
                        $kardex = "muestra 2";
                        $stopro = $cant_unid + $stopro;  /////STOCK GENERAL DEL PRODUCTO PRINCIPAL
                        $prevta1 = $pripro1 * (($margene / 100) + 1); ////NUEVO PRECIO DE VENTA DEL PRODUCTO GENERAL
                        $preciounit = $prevta1 / $factor;   /////NUEVO PRECIO UNITARIO DE VENTA DEL PRODUCTO GENERAL
                        mysqli_query($conexion, "UPDATE producto set stopro = '$stoproes', $tabla = '$cant_loces' where codpro = '$codprobon'");
                        //////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
                        mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,preciocompra,numlote) values ('$numdoc','$codprobon','$invfec','11','11','$frac_canbon','','$factorBoni','$cod','$usuario','$sactual','$codloc','$pcostouni','$idUltimoRegistroLote')");
                        mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr, tipmov,numlote,orden,costoPromedioAnterior) values ('$cod','$date','$codprobon','$frac_canbon','','0','0','0','0','0','0','0', '$tipmov','$idlotereg','$i','$costoPromedioAnterior')");
                    } else {
                        //-----si hay bonificacion con otro producto pero en unidades
                        if (($codprobon <> 0) && ($tipbon1 == "U")) {
                            $sqlc = "SELECT stopro,$tabla FROM producto where codpro = '$codprobon'";
                            $resultc = mysqli_query($conexion, $sqlc);
                            if (mysqli_num_rows($resultc)) {
                                while ($rowc = mysqli_fetch_array($resultc)) {
                                    $stoproes = $rowc['stopro'];
                                    $cant_loces = $rowc[1];
                                    //$sactual	 = $stoproes;
                                    $sactual = $cant_loces;
                                }
                            }
                            $frac_canbon = "f" . $canbon1;      /////CANTIDAD BONIFICADA CON EL CARACTER F - UNID
                            if ($codprobon == $codpro) {      /////SI ES BNIFICACION CON EL MISMO PROD
                                $cant_local = $cant_unid + $cant_loc + $canbon1; /////STOCK LOCAL INCL BONIFICACION DEL PROD GENERAL
                                $cant_local2 =  $cant_loc + $canbon1; /////STOCK LOCAL INCL BONIFICACION DEL PROD GENERAL
                                // echo "muestra 3" . "<br>";
                                $kardex = "muestra 3";
                                // echo "cant_unid: " . $cant_unid . '<br>';
                                // echo "cant_loc: " . $cant_loc . '<br>';
                                // echo "canbon1: " . $canbon1 . '<br>';
                                $stopro = $cant_unid + $stopro + $canbon1; /////NUEVO STOCK INCL BONIFICACION DEL PROD GENERAL
                                $prevta1 = $pripro1 * (($margene / 100) + 1); /////NUEVO PRECIO DE VENTA INCL BONIFICACION DEL PROD GEN
                                $preciounit = $prevta1 / $factorBoni;     /////NUEVO PRECIO UNITARIO INCL BONIFICACION
                            } else {           /////SI ES BNIFICACION CON OTRO PROD
                                $stoproes = $stoproes + $canbon1;    /////STOCK GENERAL DEL PROD BONIFICABLE
                                $cant_loces = $cant_loces + $canbon1;   /////STOCK LOCAL DEL PROD BONIFICABLE
                                $cant_local = $cant_unid + $cant_loc;   /////STOCK LOCAL DEL PROD GENERAL
                                $cant_local2 =  $cant_loc;   /////STOCK LOCAL DEL PROD GENERAL
                                // echo "muestra 4" . "<br>";
                                $kardex = "muestra 4";
                                $stopro = $cant_unid + $stopro;    /////STOCK GENERAL DEL PROD GENERAL
                                $prevta1 = $pripro1 * (($margene / 100) + 1); /////NUEVO PRECIO DE VENTA DEL PRODUCTO GENERAL
                                $preciounit = $prevta1 / $factor;
                                mysqli_query($conexion, "UPDATE producto set stopro = '$stoproes', $tabla = '$cant_loces' where codpro = '$codprobon'");
                            }
                            mysqli_query($conexion, "INSERT INTO ventas_bonif_unid (codpro,codprobonif,cajas,unid) values ('$codpro','$codprobon','$qtypro','$canbon1')");
                            //////TIPMOV Y TIPDOC = 11 CUANDO ES BONIFICACION
                            mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,preciocompra,numlote) values ('$numdoc','$codprobon','$invfec','11','11','','$frac_canbon','$factorBoni','$cod','$usuario','$sactual','$codloc','$pcostouni','$idUltimoRegistroLote')");
                            mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr, tipmov,numlote,orden,costoPromedioAnterior) values ('$cod','$date','$codprobon','','$frac_canbon','0','0','0','0','0','0','0', '$tipmov','$idlotereg','$i','$costoPromedioAnterior')");
                        }
                        //// no ay bonificaciones
                        else {

                            $cant_local = $cant_unid + $cant_loc;
                            $cant_local2 =  $cant_loc;
                            $kardex = "muestra 5";
                            // echo "muestra 5" . "<br>";
                            // echo "**********cant_unid: " . $cant_unid . '<br>';
                            // echo "*********cant_loc: " . $cant_loc . '<br>';
                            $stopro = $cant_unid + $stopro;
                            $prevta1 = $pripro * (($margene / 100) + 1);
                            $preciounit = $prevta1 / $factor;
                        }
                    }
                }
                //////MODIFICAR LA TABLA ORDMOV
                if ($costre <> 0) {
                    mysqli_query($conexion, "UPDATE ordmov set canate = '$cant_unid' where invnum = '$ncompra' and codpro = '$codpro' and mont_total <> '0'");
                    if ($tipbon1 == "C") {
                        $tx = $factor * $canbon1;
                        mysqli_query($conexion, "UPDATE ordmov set codpro = '$codprobon',canate = '$tx' where invnum = '$ncompra' and codprobon = '$codpro' and mont_total = '0'");
                    } else {
                        $cant_unidxxx = $canbon1;
                        mysqli_query($conexion, "UPDATE ordmov set codpro = '$codprobon',canate = '$cant_unidxxx' where invnum = '$ncompra' and codprobon = '$codpro'  and mont_total = '0'");
                    }
                } else {
                    if ($tipbon1 == "C") {
                        $tx = $factor * $canbon1;
                        mysqli_query($conexion, "UPDATE ordmov set codpro = '$codprobon',canate = '$tx' where invnum = '$ncompra' and codprobon = '$codpro' and mont_total = '0'");
                    } else {
                        $cant_unidxxx = $canbon1;
                        mysqli_query($conexion, "UPDATE ordmov set codpro = '$codprobon',canate = '$cant_unidxxx' where invnum = '$ncompra' and codprobon = '$codpro'  and mont_total = '0'");
                    }
                }
                /* echo "PRECIO REFERENCIAL: ";echo $referencial; echo '<br>';
              echo "PRIPRO: ";echo $pripro; echo '<br>';
              echo "Pcostouni: ";echo $pcostouni; echo '<br>';
              echo "Prisal: ";echo $prisal; echo '<br>';
              echo "PRIPRO1: ";echo $pripro1; echo '<br>';
             */
                $sql1 = "SELECT stopro,$tabla FROM producto where codpro = '$codpro'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        //$sactual       = $row1['stopro'];
                        $sactual = $row1[1];
                    }
                }
                // $sactual = $canbon1;
                $sql1 = "SELECT idlote,codpro,stock FROM movlote where codpro = '$codpro'";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $idlote = $row1['idlote'];
                        $codpro = $row1['codpro'];
                        $stocklote = $row1['stock'];
                    }
                }
                // echo "cant_local: " . $cant_local . '<br>';

                if ($precios_por_local == 1) {

                    if (($zzcodloc == 1)) {

                        mysqli_query($conexion, "UPDATE producto set stopro = '$stopro', prelis = '$referencial',costre = '$pripro',utlcos = '$pripro',$tabla = '$cant_local',pcostouni = '$pcostouni',fecord = '0000-00-00',ultpcostouni = '$ultpcostouni',modifpcosto = '0',digemid='$digemid',registrosanitario='$registrosanitario' where codpro = '$codpro'");
                    } else {
                        mysqli_query($conexion, "UPDATE producto set stopro = '$stopro',$tabla = '$cant_local',fecord = '0000-00-00',modifpcosto = '0',digemid='$digemid',registrosanitario='$registrosanitario' where codpro = '$codpro'");
                        mysqli_query($conexion, "UPDATE precios_por_local set $prelis_p = '$referencial',$costre_p = '$pripro',$utlcos_p = '$pripro',$pcostouni_p = '$pcostouni',$ultpcostouni_p = '$ultpcostouni' where codpro = '$codpro'");
                    }
                } else {

                    mysqli_query($conexion, "UPDATE producto set stopro = '$stopro', prelis = '$referencial',costre = '$pripro',utlcos = '$pripro',$tabla = '$cant_local',pcostouni = '$pcostouni',fecord = '0000-00-00',ultpcostouni = '$ultpcostouni',modifpcosto = '0',digemid='$digemid',registrosanitario='$registrosanitario' where codpro = '$codpro'");
                }


                if ($codprobon == $codpro)  {
                
                    $cant_local2 = $cant_loc + $canbon1; 
              } else  {
                  
                  $cant_local2 = $cant_loc;
                  
              }
              


     
              

                //mysqli_query($conexion, "UPDATE movlote set stock = '$cant_unid' where invnum = '$cod' and codpro = '$codpro'");

                /////////////////////////////////////////////////////////////
                mysqli_query($conexion, "INSERT INTO movmov (invnum,invfec,codpro,qtypro,qtyprf,pripro,prisal,costre,desc1,desc2,desc3,costpr,codprobon,canbon,tipbon,priprobon, codloc, tipmov,numlote,orden,costoPromedioAnterior) values ('$cod','$date','$codpro','$qtypro','$qtyprf','$pripro','$prisal','$costre','$desc1','$desc2','$desc3','$costpr','$codprobon','$canbon1','$tipbon1','$pripro1','$codloc', '$tipmov','$idlotereg','$i','$costoPromedioAnterior')");

                mysqli_query($conexion, "INSERT INTO kardex (nrodoc,codpro,fecha,tipmov,tipdoc,qtypro,fraccion,factor,invnum,usecod,sactual,sucursal,preciocompra,numlote) values ('$numdoc','$codpro','$invfec','$tipmov','$tipdoc','$qtypro','$qtyprf','$factor','$cod','$usuario','$cant_local2','$codloc','$pcostouni','$idlotereg')");
                //----------------------------AQUI TERMINO $NOHAY = 1 ------------------------------/////

                $sql1 = "select codkard from kardex where codpro = '$codpro' order by codkard desc limit 1;";
                $result1 = mysqli_query($conexion, $sql1);
                if (mysqli_num_rows($result1)) {
                    while ($row1 = mysqli_fetch_array($result1)) {
                        $codkard = $row1['codkard'];
                    }
                }

                if ($lotec == 1) {

                    //   mysqli_query($conexion, "INSERT INTO kardexlote (codkard,IdLote,Cantidad) values ('$codkard','$idlote','$stocklote')");
                }
            }
        }

        // mysqli_query($conexion, "CALL procedure_recalculakardex('" . $codpro . "' , '" . $codloc . "')");
    }

    if ($nohay <> 1) {
        $sql = "SELECT correlativo FROM movmae order by correlativo desc limit 1";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $correlativo = $row[0];        //codigo
            }
            $correlativo    = $correlativo + 1;
        }
        $invtot_deuda =  ($plazo > 0) ? $mont5 : '0.00';
        mysqli_query($conexion, "DELETE from tempmovmov where invnum = '$cod'");
        mysqli_query($conexion, "DELETE from tempmovmov_bonif where invnum = '$cod'");
        mysqli_query($conexion, "DELETE from templote where invnum = '$cod'");
        mysqli_query($conexion, "UPDATE movmae set incluidoIGV = $ckigv, usecod  = '$usuario',cuscod = '$Proveedor',fecdoc = '$date1',numero_documento = '$n1', numero_documento1 = '$n2',plazo = '$plazo',moneda = 'S',invtot = '$mont5',monto_deuda = '$invtot_deuda',destot = '$mont2', valven = '$mont3',fecven = '$date2',monto = '$sum33',costo = '$mont1',igv = '$mont4', estado = 1, proceso = 0,sucursal = '$codloc', dafecto ='$dafecto',dinafecto='$dinafecto',digv='$digv',dtotal='$dtotal',correlativo='$correlativo',hora='$hoy' where invnum = '$cod'");
        mysqli_query($conexion, "UPDATE kardex set nrodoc = $correlativo  where invnum = '$cod'");
        mysqli_query($conexion, "UPDATE ordmae set pendiente = '0', confirmado = '0' where invnum = '$ncompra'");
        //header("Location: ../ing_salid.php");
        //header("Location: generaImpresion.php?Compra=$cod");
        if (($nopaga == 1) || ($alertaPagoPorLocal == 1) || ($nopaga == 0)) {
            echo "<script>if(confirm('Deseas Imprimir esta Compra')){document.location='generaImpresion.php?Compra=$cod';}else{ alert(document.location='../ing_salid.php');}</script>";
        } elseif (($nopaga == 2) || ($alertaPagoPorLocal == 2)) {
            echo "<script>if(confirm('Deseas Imprimir esta Compra')){document.location='generaImpresion.php?Compra=$cod';}else{ alert(document.location='../../logout.php');}</script>";
        }
    } else {
        header("Location: compras.php?msg=2");
    }
}
