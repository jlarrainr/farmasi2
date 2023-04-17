<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
$sql1 = "SELECT  drogueria FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {

        $drogueria      = $row1['drogueria'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}

$venta = $_SESSION['venta'];
$cotizacion = $_REQUEST['cotizacion'];
$eliminado = $_REQUEST['eliminado'];

if ($eliminado == 1) {

    mysqli_query($conexion, "UPDATE cotizacion SET estado_venta='1' WHERE invnum='$cotizacion' ");

    header("Location: venta_index1.php ");
} else {
    mysqli_query($conexion, "DELETE from temp_venta where invnum = '$venta'");
    mysqli_query($conexion, "DELETE from temp_vent_bonif where invnum = '$venta'");
    mysqli_query($conexion, "DELETE from detalle_venta where invnum = '$venta'");
    $date = date("Y-m-d");
    //$hour   = date(G);
    //$date	= CalculaFechaHora($hour);
    require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
    $sql_existe = "SELECT count(*) FROM cotizacion where sucursal = '$codloc' and invnum = '$cotizacion' and estado_venta ='0' ";
    $result_existe = mysqli_query($conexion, $sql_existe);
    if (mysqli_num_rows($result_existe)) {
        while ($row_existe = mysqli_fetch_array($result_existe)) {
            $existe = $row_existe[0];
        }
    }
    $sqlx1 = "SELECT baja,cuscod,usecod,codmed FROM cotizacion where sucursal = '$codloc' and invnum = '$cotizacion' and estado_venta ='0' ";
    $resultx1 = mysqli_query($conexion, $sqlx1);
    if (mysqli_num_rows($resultx1)) {
        while ($rowx1 = mysqli_fetch_array($resultx1)) {
            $baja = $rowx1['baja'];
            $cuscod = $rowx1['cuscod'];
            $usecod = $rowx1['usecod'];
            $codmed = $rowx1['codmed'];
        }
    }
    $sql_venta = "SELECT n_cotizacion FROM venta where invnum = '$venta'";
    $result_venta = mysqli_query($conexion, $sql_venta);
    if (mysqli_num_rows($result_venta)) {
        while ($row_venta1 = mysqli_fetch_array($result_venta)) {
            $n_cotizacion_filtro = $row_venta1['n_cotizacion'];
        }
    }

    if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
    } else {
        $arr_detalle_venta = array();
    }
    function convertir_a_numero($str)
    {
        $legalChars = "%[^0-9\-\. ]%";

        $str = preg_replace($legalChars, "", $str);
        return $str;
    }
    if (($n_cotizacion_filtro == $cotizacion) || ($existe == 0)) {
        header("Location:venta_index1.php?cotizacions=$cotizacion&msn=1");
    } else {
        if ($baja == 0) {

            mysqli_query($conexion, "UPDATE venta set n_cotizacion = '$cotizacion',cuscod='$cuscod',usecod='$usecod',codmed='$codmed' where invnum = '$venta'"); ///controla bonificaciones

            $sqlx = "SELECT codpro,canpro,fraccion,factor,pripro,prisal FROM cotizacion_det inner join cotizacion on cotizacion_det.invnum = cotizacion.invnum where cotizacion_det.invnum = '$cotizacion' and sucursal = '$codloc' and baja = '0' and estado_venta ='0'";
            $resultx = mysqli_query($conexion, $sqlx);
            if (mysqli_num_rows($resultx)) {
                $_SESSION['cotizacion'] = $cotizacion;
                while ($rowx = mysqli_fetch_array($resultx)) {
                    $codpro = $rowx['codpro'];
                    $factor = $rowx['factor'];
                    $text1 = $rowx['canpro'];
                    $prisal_referencial = $rowx['prisal'];
                    $text3 = $rowx['pripro'];
                    $fracc = $rowx['fraccion'];
                    if ($fracc == 'T') {
                        $numero = 0;
                    } else {
                        $numero = 1;
                    }
                    $sqly = "SELECT preuni,$tabla,pcostouni,codpro,prevta,blister,preblister  FROM producto where codpro = '$codpro'";
                    $resulty = mysqli_query($conexion, $sqly);
                    if (mysqli_num_rows($resulty)) {
                        while ($rowy = mysqli_fetch_array($resulty)) {

                            $cant_prod1 = $rowy[1];
                            $codpro = $rowy['codpro'];


                            if ($drogueria == 1) {

                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                if (mysqli_num_rows($result1_movlote)) {
                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                        $stock_movlote = $row1_movlote[0];
                                    }
                                }

                                $cant_prod = $stock_movlote;
                            } else {
                                $cant_prod = $cant_prod1;
                            }

                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $pcostouni = $rowy['pcostouni'];
                                $preuni = $rowy['preuni'];
                                $prevta  = $rowy['prevta'];
                                $blister  = $rowy['blister'];
                                $preblister  = $rowy['preblister'];
                            } elseif ($precios_por_local == 0) {
                                $pcostouni = $rowy['pcostouni'];
                                $preuni = $rowy['preuni'];
                                $prevta  = $rowy['prevta'];
                                 $blister  = $rowy['blister'];
                                $preblister  = $rowy['preblister'];
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $pcostouni_p,$preuni_p,$prevta_p,$blister_p,$preblister_p  FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $pcostouni = $row_precio[0];
                                        $preuni = $row_precio[1];
                                        $prevta = $row_precio[2];
                                        $blister  = $rowy[3];
                                        $preblister  = $rowy[4];
                                    }
                                }
                            }
                        }
                    }



                    if ($fracc == 'T') {
                        $numero = 0;
                        
                     if(($text1 >= $blister && $blister > 0 )){
                            $text2 = $preblister;
                        }else{
                            $text2 = $preuni;
                        }
                        
                    } else {
                        $numero = 1;
                        $text2 = $prevta;
                    }

                    $text3 =  $text1 * $text2;
                    if ($prisal_referencial <> $text2) {
                        $cambio_precio = 1;
                    } else {
                        $cambio_precio = 0;
                    }

                    // echo 'prisal_referencial = ' . $prisal_referencial . ' --- text2 = ' . $text2 . ' ---- ' . 'cambio_precio = ' . $cambio_precio . "<br>";
                    $sql = "SELECT invnum,codpro FROM temp_venta where invnum = '$venta' and codpro = '$codpro'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        $repetido = 1;
                    } else {
                        $repetido = 0;
                    }
                    //////EVITAR REPITICIONES
                    if ($repetido == 0) {
                        //////////////////////////////////////////////////////////////////////////////
                        if ($numero == 1) {     ////ESTOY INGRESANDO CAJAS CON LA LETRA C



                            /////FUNCION PARA CONVERTIR NUMERO
                            $text1 = convertir_a_numero($text1);
                            $caja_bonifi = $text1;  /////CAJAS QUE DESEO VENDER
                            $creal = $text1;
                            $text1 = $text1 * $factor;
                            $cantidades = $text1;
                            $tt = 1;
                            $sql1 = "SELECT codprobonif,codkey,cajas,unid FROM ventas_bonif_unid where codpro = '$codpro' and unid <> 0 order by codkey asc";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $codprodbonif = $row1['codprobonif'];  /////PRODUCTO A BONIFICAR
                                    $codkey = $row1['codkey'];
                                    $cajas = $row1['cajas'];   /////CAJAS E BONIFICACION QUE TENGO EN STOCK
                                    $unid = $row1['unid'];
                                    $sql2 = "SELECT stopro,$tabla,factor,codmar,pcostouni,costpr,preuni,codpro FROM producto where codpro = '$codprodbonif'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $stockbonif = $row2['stopro'];  ////STOCK GENERAL DEL PRODUCTO
                                            $tablabonif1 = $row2[1];    ////STOCK POR LOCAL
                                            $factorbonif = $row2['factor'];  ////FACTOR
                                            $codmarbonif = $row2['codmar'];  ////MARCA
                                            $codpro = $row2['codpro'];

                                            if ($drogueria == 1) {
                                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                                if (mysqli_num_rows($result1_movlote)) {
                                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                                        $stock_movlote = $row1_movlote[0];
                                                    }
                                                }
                                                $tablabonif = $stock_movlote;
                                            } else {
                                                $tablabonif = $tablabonif1;
                                            }




                                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                                $pcostounibonif = $row2['pcostouni']; ////PRECIO DE COSTO UNT
                                                $costprbonif = $row2['costpr'];  ////COSTO PROMEDIO
                                                $preunibonif = $row2['preuni'];  ////PRECIO UNITARIO
                                            } elseif ($precios_por_local == 0) {
                                                $pcostounibonif = $row2['pcostouni']; ////PRECIO DE COSTO UNT
                                                $costprbonif = $row2['costpr'];  ////COSTO PROMEDIO
                                                $preunibonif = $row2['preuni'];  ////PRECIO UNITARIO
                                            }

                                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                                $sql_precio = "SELECT $pcostouni_p,$preuni_p,$costpr_p FROM precios_por_local where codpro = '$codpro'";
                                                $result_precio = mysqli_query($conexion, $sql_precio);
                                                if (mysqli_num_rows($result_precio)) {
                                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                        $pcostounibonif = $row_precio[0];
                                                        $preunibonif = $row_precio[1];
                                                        $costprbonif = $row_precio[2];
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    $sql2 = "SELECT canpro FROM temp_venta where invnum = '$venta' and codpro = '$codprodbonif' and pripro = '0' and bonif = '1'";  ///si es venta por bonificacion
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $canprobonif = $row2['canpro'];
                                            $bik = 1;
                                        }
                                    } else {
                                        $bik = 0;
                                    }
                                    if (($caja_bonifi <= $cajas) && ($tt <> 0)) { //VENDO UNA CAJA Y MI STOCK BONIF ES DE 4 CAJAS
                                        $total_reducir = $cajas - $caja_bonifi;
                                        $tot_reducir_unid = $caja_bonifi * $unid;
                                        $stockbonif = $stockbonif - $tot_reducir_unid;
                                        $tablabonif = $tablabonif - $tot_reducir_unid;
                                        mysqli_query($conexion, "UPDATE ventas_bonif_unid set cajas = '$total_reducir' where codkey = '$codkey'"); ///controla bonificaciones
                                        //mysqli_query($conexion, "UPDATE producto set stopro = '$stockbonif',$tabla = '$tablabonif' where codpro = '$codprodbonif'");
                                        if ($bik == 1) {
                                            $canprobonif = $canprobonif + $tot_reducir_unid;
                                            mysqli_query($conexion, "UPDATE temp_venta set canpro = '$canprobonif' where codpro = '$codprodbonif'");
                                        } else {
                                            //mysqli_query($conexion, "INSERT INTO temp_venta 
                                            //(invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif) values 
                                            //('$venta','$date','$cuscod','$usuario','$codprodbonif','$tot_reducir_unid','T','$factorbonif','$preunibonif','0','$codmarbonif','$pcostounibonif','$costprbonif','1')");

                                            $detalle_venta['invnum'] = $venta;
                                            $detalle_venta['invfec'] = $date;
                                            $detalle_venta['cuscod'] = $cuscod;
                                            $detalle_venta['usecod'] = $usuario;
                                            $detalle_venta['codpro'] = $codprodbonif;
                                            $detalle_venta['canpro'] = $tot_reducir_unid;
                                            $detalle_venta['fraccion'] = 'T';
                                            $detalle_venta['factor'] = $factorbonif;
                                            $detalle_venta['prisal'] = $preunibonif;
                                            $detalle_venta['pripro'] = '0';
                                            $detalle_venta['codmar'] = $codmarbonif;
                                            $detalle_venta['cospro'] = $pcostounibonif;
                                            $detalle_venta['costpr'] = $costprbonif;
                                            $detalle_venta['bonif'] = '1';

                                            $arr_detalle_venta[] = $detalle_venta;

                                            end($arr_detalle_venta);
                                            $key = key($arr_detalle_venta);
                                            $lastDetVentaId = $key;
                                            $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                        }
                                        mysqli_query($conexion, "INSERT INTO temp_vent_bonif (invnum,codpro,codprobonif,codkey,cajas) values ('$venta','$codprodbonif','$codpro','$codkey','$caja_bonifi')");
                                        $tt = 0;
                                    } else { //VENDO 4 CAJAS Y MI STOCK BONIF ES DE 1 CAJA, BUSCO Y VEO SI TENGO MAS STOCKS
                                        if (($caja_bonifi > $cajas) && ($tt <> 0)) {
                                            $total_reducir = $cajas - $cajas;
                                            $tot_reducir_unid = $cajas * $unid;
                                            $stockbonif = $stockbonif - $tot_reducir_unid;
                                            $tablabonif = $tablabonif - $tot_reducir_unid;
                                            $caja_bonifi = $caja_bonifi - $cajas;
                                            mysqli_query($conexion, "UPDATE ventas_bonif_unid set cajas = '$total_reducir' where codkey = '$codkey'");
                                            //mysqli_query($conexion, "UPDATE producto set stopro = '$stockbonif',$tabla = '$tablabonif' where codpro = '$codprodbonif'");
                                            if ($bik == 1) {
                                                $canprobonif = $canprobonif + $tot_reducir_unid;
                                                mysqli_query($conexion, "UPDATE temp_venta set canpro = '$canprobonif' where codpro = '$codprodbonif'");
                                            } else {
                                                //mysqli_query($conexion, "INSERT INTO temp_venta 
                                                //(invnum   ,invfec ,cuscod     ,usecod     ,codpro         ,canpro             ,fraccion   ,factor         ,prisal         ,pripro,        codmar,         cospro,         costpr,         bonif) values 
                                                //('$venta','$date','$cuscod'   ,'$usuario' ,'$codprodbonif','$tot_reducir_unid','T'    ,   '$factorbonif', '$preunibonif', '0',            '$codmarbonif','$pcostounibonif','$costprbonif','1')");
                                                $detalle_venta['invnum'] = $venta;
                                                $detalle_venta['invfec'] = $date;
                                                $detalle_venta['cuscod'] = $cuscod;
                                                $detalle_venta['usecod'] = $usuario;
                                                $detalle_venta['codpro'] = $codprodbonif;
                                                $detalle_venta['canpro'] = $tot_reducir_unid;
                                                $detalle_venta['fraccion'] = 'T';
                                                $detalle_venta['factor'] = $factorbonif;
                                                $detalle_venta['prisal'] = $preunibonif;
                                                $detalle_venta['pripro'] = '0';
                                                $detalle_venta['codmar'] = $codmarbonif;
                                                $detalle_venta['cospro'] = $pcostounibonif;
                                                $detalle_venta['costpr'] = $costprbonif;
                                                $detalle_venta['bonif'] = '1';

                                                $arr_detalle_venta[] = $detalle_venta;

                                                end($arr_detalle_venta);
                                                $key = key($arr_detalle_venta);
                                                $lastDetVentaId = $key;
                                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                            }
                                            mysqli_query($conexion, "INSERT INTO temp_vent_bonif (invnum,codpro,codprobonif,codkey,cajas) values ('$venta','$codprodbonif','$codpro','$codkey','$caja_bonifi')");
                                            $tt = 1;
                                        }
                                    }
                                }
                            }
                        } else {
                            $cantidades = $text1;
                        }
                        /////////////////////////////////////////////////////////////////////////////
                        if ($cantidades <> 0) {
                            if ($cantidades > $cant_prod) {
                                $agotado = $cantidades - $cant_prod;
                                $agot = 1;
                                $sql1 = "SELECT cuscod,invfec,sucursal FROM venta where invnum = '$venta'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $cuscod = $row1['cuscod'];
                                        $invfec = $row1['invfec'];
                                        $sucursal = $row1['sucursal'];
                                    }
                                }
                            } else {
                                $agot = 0;
                            }
                            $sql = "SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla FROM producto where codpro = '$codpro'";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                                while ($row = mysqli_fetch_array($result)) {
                                    $codpro = $row['codpro'];  ////CODIGO DEL PRODUCTO
                                    $stopro = $row['stopro'];  ////GENERAL
                                    $codmar = $row['codmar'];
                                    $codfam = $row['codfam'];
                                    $coduso = $row['coduso'];

                                    $cant_loc1 = $row[7];


                                    if ($drogueria == 1) {

                                        $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                        $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                        if (mysqli_num_rows($result1_movlote)) {
                                            while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                                $stock_movlote = $row1_movlote[0];
                                            }
                                        }

                                        $cant_loc = $stock_movlote;
                                    } else {

                                        $cant_loc = $cant_loc1;
                                    }

                                    if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                        $costpr = $row['costpr'];
                                    } elseif ($precios_por_local == 0) {
                                        $costpr = $row['costpr'];
                                    }

                                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                        $sql_precio = "SELECT $costpr_p FROM precios_por_local where codpro = '$codpro'";
                                        $result_precio = mysqli_query($conexion, $sql_precio);
                                        if (mysqli_num_rows($result_precio)) {
                                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                $costpr = $row_precio[0];
                                            }
                                        }
                                    }


                                    $costpr = $costpr / $factor;
                                }
                            }
                            $total_local = $cant_loc - $text1;
                            $total_general = $stopro - $text1;
                            if ($cant_prod <> 0) {
                                //mysqli_query($conexion, "UPDATE producto set stopro = '$total_general', $tabla = '$total_local' where codpro = '$codpro'");
                                //           echo 'UPDATE producto' . "<br>";
                            }
                            if (($text1 <> "") || ($text1 <> 0)) {
                                if ($numero == 0) {
                                    if ($cant_prod <> 0) {
                                        //mysqli_query($conexion, "INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date' ,'$cuscod'  ,'$usuario' ,'$codpro'  ,'$text1'   ,'T'        ,'$factor'  ,'$text2'   ,'$text3'   ,'$codmar'  ,'$pcostouni','$costpr')");

                                        $detalle_venta['invnum'] = $venta;
                                        $detalle_venta['invfec'] = $date;
                                        $detalle_venta['cuscod'] = $cuscod;
                                        $detalle_venta['usecod'] = $usuario;
                                        $detalle_venta['codpro'] = $codpro;
                                        $detalle_venta['canpro'] = $text1;
                                        $detalle_venta['fraccion'] = 'T';
                                        $detalle_venta['factor'] = $factor;
                                        $detalle_venta['prisal'] = $text2;
                                        $detalle_venta['pripro'] = $text3;
                                        $detalle_venta['codmar'] = $codmar;
                                        $detalle_venta['cospro'] = $pcostouni;
                                        $detalle_venta['costpr'] = $costpr;
                                        $detalle_venta['cambio_precio'] = $cambio_precio;

                                        $arr_detalle_venta[] = $detalle_venta;

                                        end($arr_detalle_venta);
                                        $key = key($arr_detalle_venta);
                                        $lastDetVentaId = $key;
                                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                    }
                                } else {
                                    if ($cant_prod <> 0) {
                                        //mysqli_query($conexion, "INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar, cospro,costpr) values ('$venta' ,   '$date' ,   '$cuscod',  '$usuario', '$codpro',  '$creal',   'F',        '$factor',  '$text2',   '$text3',   '$codmar',  '$pcostouni','$costpr')");

                                        $detalle_venta['invnum'] = $venta;
                                        $detalle_venta['invfec'] = $date;
                                        $detalle_venta['cuscod'] = $cuscod;
                                        $detalle_venta['usecod'] = $usuario;
                                        $detalle_venta['codpro'] = $codpro;
                                        $detalle_venta['canpro'] = $creal;
                                        $detalle_venta['fraccion'] = 'F';
                                        $detalle_venta['factor'] = $factor;
                                        $detalle_venta['prisal'] = $text2;
                                        $detalle_venta['pripro'] = $text3;
                                        $detalle_venta['codmar'] = $codmar;
                                        $detalle_venta['cospro'] = $pcostouni;
                                        $detalle_venta['costpr'] = $costpr;
                                        $detalle_venta['cambio_precio'] = $cambio_precio;
                                        $arr_detalle_venta[] = $detalle_venta;

                                        end($arr_detalle_venta);
                                        $key = key($arr_detalle_venta);
                                        $lastDetVentaId = $key;
                                        $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                    }
                                }
                                /* if ($numero == 0) {
                          if ($agot == 1) {
                          mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','T','$invfec','$text2','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$text3')");
                          }
                          } else {
                          if ($agot == 1) {
                          mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','F','$invfec','$text2','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$text3')");
                          }
                          } */
                            } ///CIERRO IF DE TEXT1 <> ""
                        } ////CIERRO IF DE CANTIDADES <> 0
                    }
                }
            }

            header("Location: venta_index1.php?cotizacion=$cotizacion");
        } else {
            header("Location:venta_index1.php?cotizacions=$cotizacion&msn=1");
        }
    }
}
