<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');


$sql1 = "SELECT priceditable,drogueria FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $priceditable   = $row1['priceditable'];
        $drogueria      = $row1['drogueria'];
    }
}
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

$venta = $_SESSION['venta'];
$date = date("Y-m-d");
$text1 = $_REQUEST['text1']; //CANTIDAD
$text2 = $_REQUEST['text2'];  ////PRECIO
$text3 = $_REQUEST['text3'];
$factor = $_REQUEST['factor'];
$numero = $_REQUEST['numero'];
$cant_prod = $_REQUEST['cant_prod'];
$codpro = $_REQUEST['codpro'];
$pcostouni = $_REQUEST['pcostouni'];
// $faltastock = $_REQUEST['faltastock'];
$faltastock = isset($_REQUEST['faltastock']) ? ($_REQUEST['faltastock']) : "0";
if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

//SI NUMERO = 0 ES NUMERO SI NO ES LETRA O CAJA
//require_once('funciones/datos_generales.php');
$cantventaparabonificar = "";
$codprobonif = "";
$cantbonificable = "";


$sql1usuario = "SELECT codloc FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
$result1usuario = mysqli_query($conexion, $sql1usuario);
if (mysqli_num_rows($result1usuario)) {
    while ($row1usuario = mysqli_fetch_array($result1usuario)) {
        $codloc = $row1usuario['codloc'];
    }
}
$sqlxcompa = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$resultxcompa = mysqli_query($conexion, $sqlxcompa);
if (mysqli_num_rows($resultxcompa)) {
    while ($rowxcompa = mysqli_fetch_array($resultxcompa)) {
        $nomloc = $rowxcompa['nomloc'];
    }
}
$numero_filtro = substr($nomloc, 5, 2);
$tabla = "s" . str_pad($numero_filtro, 3, "0", STR_PAD_LEFT);

$sqlPRODT = "SELECT $tabla,codpro FROM producto where codpro = '$codpro'";
$resultPRODT = mysqli_query($conexion, $sqlPRODT);
if (mysqli_num_rows($resultPRODT)) {
    while ($row = mysqli_fetch_array($resultPRODT)) {
        $cant_prod1 = $row[0];
        $codpro = $row[1];

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
    }
}

$repetido = 0;  ////// NO ESTA EN LA BASE DE DATOS

$popupMostrado = 0;
$sqlCLI = "SELECT cuscod,invfec,sucursal FROM venta where invnum = '$venta'";
$resultCLI = mysqli_query($conexion, $sqlCLI);
if (mysqli_num_rows($resultCLI)) {
    while ($row1 = mysqli_fetch_array($resultCLI)) {
        $cuscod = $row1['cuscod'];
        $invfec = $row1['invfec'];
        $sucursal = $row1['sucursal'];
    }
}

function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}
//////EVITAR REPITICIONES
if ($repetido == 0) {
    if ($numero == 1) { ///// NO ES NUMERO ES UNA LETRA C 14 - precio de CAJA
        $text2 = $_REQUEST['textprevta'];
        //echo '$text2-1'.$text2."<br>";
        //TODAS LAS CONSULTAS SERAN EN BASE A CAJAS						
        $text1 = convertir_a_numero($text1); ////EJEMPLO: C4 = 4 CAJAS
        $caja_bonifi = $text1;
        $cantreal = $text1; //CANTIDAD
        $text1 = $text1 * $factor;
        $cantidades = $text1;
        $tt = 1;
    } else { /////ES NUMERO Y SON UNIDADES
        //$text2   	= $_REQUEST['text2'];
        if ($priceditable == '1') {
            $text2 = $_REQUEST['text222'];
            //echo '$text2-2='.$text2."<br>";
            if ($text2 == "") {
                $text2 = $_REQUEST['text2'];
                //echo '$text2-3='.$text2."<br>";
            }
        } else {
            //$text2	= $_REQUEST['text2'];
            $text2_1 = $_REQUEST['text222'];
            $text2_2 = $_REQUEST['text2'];

            if ($text2_2 <> $text2_1) {

                $text2 = $_REQUEST['text222'];
            } else {
                $text2 = $_REQUEST['text2'];
            }
            //echo '$text2-4='.$text2."<br>";
        }
        $cantidades = $text1;
    }
    if ($cantidades <> 0) {

        if ($cantidades > $cant_prod) { ////NO HAY STOCK PARA ESTE PRODUCTO
            $agotado = $cantidades - $cant_prod;
            $agot = 1;
        } else { /////HAY STOCK PARA ESTE PRODUCTO
            $agot = 0;
        }

        if ($faltastock == 1) {


            if ($cantidades <> 0) {



                if (($cant_prod <= 0) || ($faltastock == 1)) {

                    // cuando es caja el numero es 1
                    // cuando es unidad el numero es 0
                    if ($numero == 0) {


                        mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values 
                                                                      ('$cuscod','$codpro','$agotado','T','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                    } else {


                        mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','F','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                    }
                }
            }
        } else {

            $sql = "SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$codpro'";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
                while ($row = mysqli_fetch_array($result)) {
                    $codpro = $row['codpro'];
                    $stopro = $row['stopro'];
                    $codmar = $row['codmar'];
                    $codfam = $row['codfam'];
                    $coduso = $row['coduso'];
                    $factor = $row['factor'];
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

                        $costpr                 = $row['costpr'];
                        $cantventaparabonificar = $row['cantventaparabonificar'];
                        $codprobonif            = $row['codprobonif'];
                        $cantbonificable        = $row['cantbonificable'];
                    } elseif ($precios_por_local == 0) {

                        $costpr                 = $row['costpr'];
                        $cantventaparabonificar = $row['cantventaparabonificar'];
                        $codprobonif            = $row['codprobonif'];
                        $cantbonificable        = $row['cantbonificable'];
                    }

                    if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                        $sql_precio = "SELECT $costpr_p,$cantventaparabonificar_p,$codprobonif_p,$cantbonificable_p FROM precios_por_local where codpro = '$codpro'";
                        $result_precio = mysqli_query($conexion, $sql_precio);
                        if (mysqli_num_rows($result_precio)) {
                            while ($row_precio = mysqli_fetch_array($result_precio)) {
                                $costpr                 = $row_precio[0];
                                $cantventaparabonificar = $row_precio[1];
                                $codprobonif            = $row_precio[2];
                                $cantbonificable        = $row_precio[3];
                            }
                        }
                    }

                    $numeroBonif = 0;
                    if (($codprobonif <> 0) || ($codprobonif <> "")) {
                        // CATIDAD POR VENTA SI ES MAYOR O IGUAL AL CANTIDAD A VENDER
                        if (!is_numeric($cantventaparabonificar)) {

                            $numeroBonif = 1;
                            // CAJA
                            // $tipo_cantidad_venta = 'F';
                            //  $cantidad_de_CV_bonificar = convertir_a_numero($cantventaparabonificar);
                            //  $cantidad_de_CV_bonificar_stock_unidad = $cantidad_de_CV_bonificar * $factor;

                            if ($numeroBonif == $numero) {
                                if ($cantidades >= $cantidad_de_CV_bonificar) {
                                    // CAJA
                                    $tipo_cantidad_venta = 'F';
                                    $cantidad_de_CV_bonificar = convertir_a_numero($cantventaparabonificar);
                                    $cantidad_de_CV_bonificar_stock_unidad = $cantidad_de_CV_bonificar * $factor;
                                }
                            } else {
                                $cantbonificable = 0;
                                $cantidad_a_bonificar = 0;
                            }
                        } else {

                            // UNIDAD
                            $tipo_cantidad_venta = 'T';
                            $cantidad_de_CV_bonificar = $cantventaparabonificar;
                            $cantidad_de_CV_bonificar_stock_unidad = $cantidad_de_CV_bonificar;
                        }
                        // CANTIDAD A BONIFICAR DEL PRODUCTO SELECCIONADO
                        // SI ES EL MISMO PRODUCTO A BONIFICAR SE SUMA LA CANTIDAD INGRESADA A VENDER,
                        // MAS LA CANTIDA A BONIFICAR PARA VER SI TIENE EL STOCK SUFICIENTE A DESCARGAR




                        if ($cantbonificable <> '') {
                            if (!is_numeric($cantbonificable)) {


                                $sql = "SELECT factor FROM producto where codpro = '$codprobonif'";
                                $result = mysqli_query($conexion, $sql);
                                if (mysqli_num_rows($result)) {
                                    while ($row = mysqli_fetch_array($result)) {
                                        $factor_BONIFICADO = $row['factor'];
                                    }
                                }

                                $tipo_a_bonificar = 'F'; //CAJA
                                $cantidad_a_bonificar = convertir_a_numero($cantbonificable);
                                $cantidad_a_bonificar_stock_unidad = $cantidad_a_bonificar * $factor_BONIFICADO;
                            } else {

                                $tipo_a_bonificar = 'T'; //UNIDAD
                                $cantidad_a_bonificar = $cantbonificable;
                                $cantidad_a_bonificar_stock_unidad = $cantidad_a_bonificar;
                            }
                        } else {
                            $cantbonificable = 0;
                            $cantidad_a_bonificar = 0;
                        }
                    }
                }
            }

            if ($numero == 1) { ///// NO ES NUMERO ES UNA LETRA = CAJA
            } else {
                //FRACCION
                if ($factor > 1) {
                    $costpr = $costpr / $factor;
                }
            }

            if ($agot == 0) { /////HAY STOCK PARA ESTE PRODUCTO
                if ($factor == 1) {
                    $permitido = $cantidades;
                    $strFactor = "F"; //cajas
                } else {

                    if ($numero == 1) { ///// NO ES NUMERO ES UNA LETRA 
                        $permitido = $cantreal;
                        $strFactor = "F";
                    } else {
                        if ($cantidades <> 0) {
                            $permitido = $cantidades;
                            $strFactor = "T";
                            $pcostouni = $pcostouni / ($factor * $cantidades);
                        }
                    }
                }
                $total_local = $cant_loc - $cantidades;
                $total_general = $stopro - $cantidades;
            } else {
                //NO HAY STOCK
                $permitido = $cant_loc;
                $strFactor = "T";
                //$pcostouni     = $pcostouni/($factor * $permitido);
                if ($priceditable == 1) {
                    $text2 = $_REQUEST['text222'];
                    //echo '$text2-5='.$text2."<br>";
                    if ($text2 == "") {
                        $text2 = $_REQUEST['text2'];
                        //echo '$text2-6='.$text2."<br>";
                    }
                } else {
                    $text2_1 = $_REQUEST['text222'];
                    $text2_2 = $_REQUEST['text2'];

                    if ($text2_2 <> $text2_1) {

                        $text2 = $_REQUEST['text222'];
                    } else {
                        $text2 = $_REQUEST['text2'];
                    }
                    //echo '$text2-7='.$text2."<br>";
                }
                $cantidades = $text1;

                //$pc            = ($text3*$cant_loc)/$factor;
                if ($cant_loc <> 0) {
                    $pcunit = $pc / $cant_loc;
                } else {
                    $pcunit = 0;
                }
                $total_local = $cant_loc - $cant_loc;
                $total_general = $stopro - $cant_loc;
                $ppc = $agotado * $pcunit;
            }
            $text3 = $text2 * $permitido;
            // error_log("cantventaparabonificar 1: ". $cantventaparabonificar );
            // error_log("cantidades 1: ". $cantidades );
            if (($cantidades <> "") || ($cantidades <> 0)) {
                if (($text3 <> "") || ($text3 <> 0)) {
                    //ES NUMERO
                    if ($numero == 0) {
                        //ES NUMERO -> T
                        if ($cant_prod <> 0) {
                            if ($agot == 1) {
                                //AGOTADOS
                                // error_log("Log 1: ". $text2 );
                                $detalle_venta['invnum'] = $venta;
                                $detalle_venta['invfec'] = $date;
                                $detalle_venta['cuscod'] = $cuscod;
                                $detalle_venta['usecod'] = $usuario;
                                $detalle_venta['codpro'] = $codpro;
                                $detalle_venta['canpro'] = $permitido;
                                $detalle_venta['fraccion'] = $strFactor;
                                $detalle_venta['factor'] = $factor;
                                $detalle_venta['prisal'] = $text2;
                                $detalle_venta['pripro'] = $text3;
                                $detalle_venta['codmar'] = $codmar;
                                $detalle_venta['cospro'] = $pcostouni;
                                $detalle_venta['costpr'] = $costpr;
                                $detalle_venta['bonif2'] = 0;
                                $detalle_venta['bonif']  = 0;

                                $arr_detalle_venta[] = $detalle_venta;

                                end($arr_detalle_venta);
                                $key = key($arr_detalle_venta);
                                $lastDetVentaId = $key;
                                //error_log("Log 1: ". $lastDetVentaId );
                            } else {
                                //HAY STOCK
                                //AQUI GRABA 
                                //error_log("Log 2: ". $text2 );

                                $detalle_venta['invnum'] = $venta;
                                $detalle_venta['invfec'] = $date;
                                $detalle_venta['cuscod'] = $cuscod;
                                $detalle_venta['usecod'] = $usuario;
                                $detalle_venta['codpro'] = $codpro;
                                $detalle_venta['canpro'] = $permitido;
                                $detalle_venta['fraccion'] = $strFactor;
                                $detalle_venta['factor'] = $factor;
                                $detalle_venta['prisal'] = $text2;
                                $detalle_venta['pripro'] = $text3;
                                $detalle_venta['codmar'] = $codmar;
                                $detalle_venta['cospro'] = $pcostouni;
                                $detalle_venta['costpr'] = $costpr;
                                $detalle_venta['bonif2']    = 0;
                                $detalle_venta['bonif']  = 0;
                                $arr_detalle_venta[] = $detalle_venta;

                                end($arr_detalle_venta);
                                $key = key($arr_detalle_venta);
                                $lastDetVentaId = $key;
                                //error_log("Log 2: ". $lastDetVentaId );
                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                            }
                            //BONIFICADO****************************************
                            //PERMITIDO ES LA CANTIDAD
                            if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {

                                if ($permitido >= $cantidad_de_CV_bonificar) {

                                    $suma_cantidad_bonificable = 0;

                                    if ($codpro == $codprobonif) {


                                        if (!is_numeric($permitido)) {

                                            $permitdo = convertir_a_numero($permitido) * $factor;
                                        }


                                        $suma_cantidad_bonificable = $permitdo;

                                        $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                        $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                        $suma_de_cantidades     = $cantidades + $stock_cantbonificable;
                                        $stock_de_localV1         = $cant_prod;

                                        $factor_pasa = $factor;
                                    } else {

                                        $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                        $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                        $suma_de_cantidades     =  $stock_cantbonificable;

                                        $sqlB = "SELECT  $tabla,desprod,factor FROM producto where codpro = '$codprobonif'";
                                        $resultB = mysqli_query($conexion, $sqlB);
                                        if (mysqli_num_rows($resultB)) {
                                            while ($rowB = mysqli_fetch_array($resultB)) {
                                                $cant_locBoni = $rowB[0];
                                                $desprod_1 = $rowB[1];
                                                $factor_1 = $rowB[2];
                                            }
                                        }
                                        $factor_pasa = $factor_1;
                                        $stock_de_localV1         = $cant_locBoni;
                                    }

                                    /*echo "ENTRA 1 <br>";
                                    echo 'permitido = ' . $permitido . "<br>";
                                    echo 'cantidad_de_CV_bonificar = ' . $cantidad_de_CV_bonificar . "<br>";
                                    return;*/ 
                                    $stock_de_local = $stock_de_localV1 - $suma_cantidad_bonificable;

                                    if ($suma_de_cantidades <= $stock_de_local) {
                                        //BONIFICADO****************************************
                                        //PERMITIDO ES LA CANTIDAD
                                        if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {
                                            if ($numero == $numeroBonif) {
                                                if ($permitido >= $cantidad_de_CV_bonificar) {
                                                    //INSERTA UN DETALLE PARA BONIFICADO
                                                    $sqlB = "SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                                                    $resultB = mysqli_query($conexion, $sqlB);
                                                    if (mysqli_num_rows($resultB)) {
                                                        while ($rowB = mysqli_fetch_array($resultB)) {
                                                            $codproB = $rowB['codpro'];
                                                            $stoproB = $rowB['stopro'];
                                                            $cant_locB1 = $rowB[2];
                                                            $factorB = $rowB['factor'];
                                                            $codmarB = $rowB['codmar'];


                                                            if ($drogueria == 1) {

                                                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                                                if (mysqli_num_rows($result1_movlote)) {
                                                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                                                        $stock_movlote = $row1_movlote[0];
                                                                    }
                                                                }

                                                                $cant_locB = $stock_movlote;
                                                            } else {

                                                                $cant_locB = $cant_locB1;
                                                            }

                                                            $factorBonif = floor($permitido / $cantidad_de_CV_bonificar);
                                                            $cantbonificable =  $cantidad_a_bonificar * $factorBonif;

                                                            //SI HAY STOCK PARA LA BONIFICACION
                                                            if ($suma_de_cantidades <= $cant_locB) {

                                                                $cantDescontar = $cant_locB - $cantbonificable;

                                                                $detalle_venta['invnum']    = $venta;
                                                                $detalle_venta['invfec']    = $date;
                                                                $detalle_venta['cuscod']    = $cuscod;
                                                                $detalle_venta['usecod']    = $usuario;
                                                                $detalle_venta['codpro']    = $codprobonif;
                                                                $detalle_venta['canpro']    = $cantbonificable;
                                                                $detalle_venta['fraccion']  = $tipo_a_bonificar;
                                                                $detalle_venta['factor']    = $factorB;
                                                                $detalle_venta['prisal']    = '0';
                                                                $detalle_venta['pripro']    = '0';
                                                                $detalle_venta['codmar']    = $codmarB;
                                                                $detalle_venta['cospro']    = '0';
                                                                $detalle_venta['costpr']    = '0';
                                                                $detalle_venta['bonif2']    = '1';
                                                                $detalle_venta['bonif']  = 0;

                                                                $arr_detalle_venta[] = $detalle_venta;
                                                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                                                header("Location: venta_index4_reg.php");
                                                            } else {
                                                                echo ("<script LANGUAGE='JavaScript'>
                                                                if (confirm('No existe stock suficiente para agregar bonificacion.  Desea continuar?') == true) {
                                                                    document.location='venta_index_bonificacion_reg.php?venta=$venta&date=$date&cuscod=$cuscod&usuario=$usuario&codprobonif=$codprobonif&tipo_a_bonificar=$tipo_a_bonificar&factorB=$factorB&factor_pasa=$factor_pasa&text1=$text1&stock_de_local=$stock_de_local&suma_de_cantidades=$suma_de_cantidades&codpro=$codpro';
                                                                } else {
                                                                    document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                                                }                                
                                                             </script>");
                                                                $popupMostrado = 1;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo ("<script LANGUAGE='JavaScript'>
                                        if (confirm('No existe stock suficiente para agregar bonificacion.  Desea continuar?') == true) {
                                            document.location='venta_index_bonificacion_reg.php?venta=$venta&date=$date&cuscod=$cuscod&usuario=$usuario&codprobonif=$codprobonif&tipo_a_bonificar=$tipo_a_bonificar&factorB=$factorB&factor_pasa=$factor_pasa&text1=$text1&stock_de_local=$stock_de_local&suma_de_cantidades=$suma_de_cantidades&codpro=$codpro';
                                        } else {
                                            document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                        }                                
                                        </script>");
                                        $popupMostrado = 1;
                                    }
                                }
                            }
                        }
                    } else {
                        //NO ES NUMERO ES EN CAJAS
                        //EMPIEZA CON C - F
                        if ($cant_prod <> 0) {
                            if ($agot == 1) {
                                // error_log("Log 3: ". $pcunit );
                                //AGOTADOS

                                $detalle_venta['invnum'] = $venta;
                                $detalle_venta['invfec'] = $date;
                                $detalle_venta['cuscod'] = $cuscod;
                                $detalle_venta['usecod'] = $usuario;
                                $detalle_venta['codpro'] = $codpro;
                                $detalle_venta['canpro'] = $permitido;
                                $detalle_venta['fraccion'] = $strFactor;
                                $detalle_venta['factor'] = $factor;
                                $detalle_venta['prisal'] = $pcunit;
                                $detalle_venta['pripro'] = $pc;
                                $detalle_venta['codmar'] = $codmar;
                                $detalle_venta['cospro'] = $pcostouni;
                                $detalle_venta['costpr'] = $costpr;
                                $detalle_venta['bonif2']    = 0;
                                $detalle_venta['bonif']  = 0;
                                $arr_detalle_venta[] = $detalle_venta;

                                end($arr_detalle_venta);
                                $key = key($arr_detalle_venta);
                                $lastDetVentaId = $key;
                                // error_log("Log 3: ". $lastDetVentaId );
                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                            } else {
                                //  error_log("Log 4: ". $text2 );
                                //HAY STOCK
                                $detalle_venta['invnum'] = $venta;
                                $detalle_venta['invfec'] = $date;
                                $detalle_venta['cuscod'] = $cuscod;
                                $detalle_venta['usecod'] = $usuario;
                                $detalle_venta['codpro'] = $codpro;
                                $detalle_venta['canpro'] = $permitido;
                                $detalle_venta['fraccion'] = $strFactor;
                                $detalle_venta['factor'] = $factor;
                                $detalle_venta['prisal'] = $text2;
                                $detalle_venta['pripro'] = $text3;
                                $detalle_venta['codmar'] = $codmar;
                                $detalle_venta['cospro'] = $pcostouni;
                                $detalle_venta['costpr'] = $costpr;
                                $detalle_venta['bonif2']    = 0;
                                $detalle_venta['bonif']  = 0;
                                $arr_detalle_venta[] = $detalle_venta;

                                end($arr_detalle_venta);
                                $key = key($arr_detalle_venta);
                                $lastDetVentaId = $key;
                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                            }

                            if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {

                                if ($permitido >= $cantidad_de_CV_bonificar) {

                                    $suma_cantidad_bonificable = 0;

                                    if ($codpro == $codprobonif) {


                                        if (!is_numeric($permitido)) {

                                            $permitdo = convertir_a_numero($permitido) * $factor;
                                        }


                                        $suma_cantidad_bonificable = $permitdo;

                                        $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                        $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                        $suma_de_cantidades     = $cantidades + $stock_cantbonificable;
                                        $stock_de_localV1         = $cant_prod;

                                        $factor_pasa = $factor;
                                    } else {

                                        $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                        $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                        $suma_de_cantidades     =  $stock_cantbonificable;

                                        $sqlB = "SELECT  $tabla,desprod,factor FROM producto where codpro = '$codprobonif'";
                                        $resultB = mysqli_query($conexion, $sqlB);
                                        if (mysqli_num_rows($resultB)) {
                                            while ($rowB = mysqli_fetch_array($resultB)) {
                                                $cant_locBoni = $rowB[0];
                                                $desprod_1 = $rowB[1];
                                                $factor_1 = $rowB[2];
                                            }
                                        }
                                        $factor_pasa = $factor_1;
                                        $stock_de_localV1         = $cant_locBoni;
                                    }
                                    /*echo "ENTRA 2 <br>";
                                    echo 'NUMERO = ' . $numero . "<br>";
                                    echo 'numeroBonif = ' . $numeroBonif . "<br>";

                                    echo 'permitido = ' . $permitido . "<br>";
                                    echo 'cantidad_de_CV_bonificar = ' . $cantidad_de_CV_bonificar . "<br>";
                                    //return;*/
                                    $stock_de_local = $stock_de_localV1 - $suma_cantidad_bonificable;

                                    if ($suma_de_cantidades <= $stock_de_local) {
                                        //BONIFICADO****************************************
                                        //PERMITIDO ES LA CANTIDAD
                                        if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {
                                            if ($numero == $numeroBonif) {
                                                if ($permitido >= $cantidad_de_CV_bonificar) {
                                                    //INSERTA UN DETALLE PARA BONIFICADO
                                                    $sqlB = "SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                                                    $resultB = mysqli_query($conexion, $sqlB);
                                                    if (mysqli_num_rows($resultB)) {
                                                        while ($rowB = mysqli_fetch_array($resultB)) {
                                                            $codproB = $rowB['codpro'];
                                                            $stoproB = $rowB['stopro'];
                                                            $cant_locB1 = $rowB[2];
                                                            $factorB = $rowB['factor'];
                                                            $codmarB = $rowB['codmar'];


                                                            if ($drogueria == 1) {

                                                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                                                if (mysqli_num_rows($result1_movlote)) {
                                                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                                                        $stock_movlote = $row1_movlote[0];
                                                                    }
                                                                }

                                                                $cant_locB = $stock_movlote;
                                                            } else {

                                                                $cant_locB = $cant_locB1;
                                                            }


                                                            $factorBonif = floor($permitido / $cantidad_de_CV_bonificar);
                                                            $cantbonificable =  $cantidad_a_bonificar * $factorBonif;

                                                            //SI HAY STOCK PARA LA BONIFICACION
                                                            if ($suma_de_cantidades <= $cant_locB) {

                                                                $cantDescontar = $cant_locB - $cantbonificable;

                                                                $detalle_venta['invnum']    = $venta;
                                                                $detalle_venta['invfec']    = $date;
                                                                $detalle_venta['cuscod']    = $cuscod;
                                                                $detalle_venta['usecod']    = $usuario;
                                                                $detalle_venta['codpro']    = $codprobonif;
                                                                $detalle_venta['canpro']    = $cantbonificable;
                                                                $detalle_venta['fraccion']  = $tipo_a_bonificar;
                                                                $detalle_venta['factor']    = $factorB;
                                                                $detalle_venta['prisal']    = '0';
                                                                $detalle_venta['pripro']    = '0';
                                                                $detalle_venta['codmar']    = $codmarB;
                                                                $detalle_venta['cospro']    = '0';
                                                                $detalle_venta['costpr']    = '0';
                                                                $detalle_venta['bonif2']    = '1';
                                                                $detalle_venta['bonif']  = 0;
                                                                $arr_detalle_venta[] = $detalle_venta;
                                                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                                                                header("Location: venta_index4_reg.php");
                                                            } else {
                                                                echo ("<script LANGUAGE='JavaScript'>
                                                                if (confirm('No existe stock suficiente para agregar bonificacion.  Desea continuar?') == true) {
                                                                    document.location='venta_index_bonificacion_reg.php?venta=$venta&date=$date&cuscod=$cuscod&usuario=$usuario&codprobonif=$codprobonif&tipo_a_bonificar=$tipo_a_bonificar&factorB=$factorB&factor_pasa=$factor_pasa&text1=$text1&stock_de_local=$stock_de_local&suma_de_cantidades=$suma_de_cantidades&codpro=$codpro';
                                                                } else {
                                                                    document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                                                }                                
                                                             </script>");
                                                                $popupMostrado = 1;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        echo ("<script LANGUAGE='JavaScript'>
                                        if (confirm('No existe stock suficiente para agregar bonificacion.  Desea continuar?') == true) {
                                            document.location='venta_index_bonificacion_reg.php?venta=$venta&date=$date&cuscod=$cuscod&usuario=$usuario&codprobonif=$codprobonif&tipo_a_bonificar=$tipo_a_bonificar&factorB=$factorB&factor_pasa=$factor_pasa&text1=$text1&stock_de_local=$stock_de_local&suma_de_cantidades=$suma_de_cantidades&codpro=$codpro';
                                        } else {
                                            document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                        }                                
                                        </script>");
                                        $popupMostrado = 1;
                                    }
                                }
                            }
                        }
                    }

                    // if ($numero == 0) {
                    //     if ($agot == 1) {
                    //         mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','T','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                    //     }
                    // } else {
                    //     if ($agot == 1) {
                    //         mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','F','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                    //     }
                    // }
                }
            }
        }
    }
}


mysqli_close($conexion);
if ($popupMostrado != 1) {
    header("Location: venta_index2.php");
}
