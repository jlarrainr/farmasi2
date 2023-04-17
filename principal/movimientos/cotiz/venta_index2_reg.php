<?php

require_once('arreglaInvtot.php');
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');

$sql1 = "SELECT priceditable FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $priceditable = $row1['priceditable'];
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

$venta = $_SESSION['cotiz'];
$date = date("Y-m-d");
$text1 = $_REQUEST['text1']; //CANTIDAD
$text2 = $_REQUEST['text2'];  ////PRECIO
$text3 = $_REQUEST['text3'];
$factor = $_REQUEST['factor'];
$numero = $_REQUEST['numero'];
$cant_prod = $_REQUEST['cant_prod'];
$codpro = $_REQUEST['codpro'];
$pcostouni = $_REQUEST['pcostouni'];

$sql = "SELECT invnum,codpro FROM cotizacion_det where invnum = '$venta' and codpro = '$codpro'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    $repetido = 1;
} else {
    $repetido = 0;
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

$sqlPRODT = "SELECT $tabla FROM producto where codpro = '$codpro'";
$resultPRODT = mysqli_query($conexion, $sqlPRODT);
if (mysqli_num_rows($resultPRODT)) {
    while ($row = mysqli_fetch_array($resultPRODT)) {
        $cant_prod = $row[0];
    }
}



$popupMostrado = 0;
$sqlCLI = "SELECT cuscod,invfec,sucursal FROM cotizacion where invnum = '$venta'";
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
    //////////////////////////////////////////////////////////////////////////////
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
    /////////////////////////////////////////////////////////////////////////////
    if ($cantidades <> 0) {
        if ($cantidades > $cant_prod) { ////NO HAY STOCK PARA ESTE PRODUCTO
            $agotado = $cantidades - $cant_prod;
            $agot = 1;
        } else { /////HAY STOCK PARA ESTE PRODUCTO
            $agot = 0;
        }
        if ($cantidades <> 0) {
            if ($cant_prod <= 0) {
                // cuando es caja el numero es 1
                // cuando es unidad el numero es 0
                if ($numero == 0) {
                    mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','T','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                } else {
                    mysqli_query($conexion, "INSERT INTO agotados (cliente,codpro,canpro,fraccion,invfec,pripro,factor,sucursal,usecod,codmar,codfam,coduso,invtot) values ('$cuscod','$codpro','$agotado','F','$invfec','$pcunit','$factor','$sucursal','$usuario','$codmar','$codfam','$coduso','$ppc')");
                }
            }
        }

        $sql = "SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$codpro'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codpro                 = $row['codpro'];
                $stopro                 = $row['stopro'];
                $codmar                 = $row['codmar'];
                $codfam                 = $row['codfam'];
                $coduso                 = $row['coduso'];
                $factor                 = $row['factor'];
                $cant_loc               = $row[7];
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



                if (($codprobonif <> 0) || ($codprobonif <> "")) {
                    // CATIDAD POR VENTA SI ES MAYOR O IGUAL AL CANTIDAD A VENDER
                    if (!is_numeric($cantventaparabonificar)) {

                        // CAJA
                        $tipo_cantidad_venta = 'F';
                        $cantidad_de_CV_bonificar = convertir_a_numero($cantventaparabonificar);
                        $cantidad_de_CV_bonificar_stock_unidad = $cantidad_de_CV_bonificar * $factor;
                    } else {

                        // UNIDAD
                        $tipo_cantidad_venta = 'T';
                        $cantidad_de_CV_bonificar = $cantventaparabonificar;
                        $cantidad_de_CV_bonificar_stock_unidad = $cantidad_de_CV_bonificar;
                    }
                    // CANTIDAD A BONIFICAR DEL PRODUCTO SELECCIONADO
                    // SI ES EL MISMO PRODUCTO A BONIFICAR SE SUMA LA CANTIDAD INGRESADA A VENDER,
                    // MAS LA CANTIDA A BONIFICAR PARA VER SI TIENE EL STOCK SUFICIENTE A DESCARGAR


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



        if (($cantidades <> "") || ($cantidades <> 0)) {
            if (($text3 <> "") || ($text3 <> 0)) {
                //ES NUMERO

                if ($numero == 0) {
                    //ES NUMERO -> T

                    if ($cant_prod <> 0) {
                        if ($agot == 1) {
                            
                            // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");

                            $sql1 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')";
                            $sql1  = arreglarSql($sql1);
                            $result1 = mysqli_query($conexion, $sql1);

                        
                        
                        
                        } else {
                            // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        

                            $sql2 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')";
                            $sql2  = arreglarSql($sql2);
                            $result2 = mysqli_query($conexion, $sql2);
                        
                        
                        }


                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                        //PERMITIDO ES LA CANTIDAD
                        if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {

                            if ($permitido >= $cantidad_de_CV_bonificar) {

                                if ($codpro == $codprobonif) {

                                    $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                    $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                    $suma_de_cantidades     = $cantidades + $stock_cantbonificable;
                                    $stock_de_local         = $cant_prod;

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
                                    $stock_de_local         = $cant_locBoni;
                                }

                                if ($suma_de_cantidades <= $stock_de_local) {
                                    //BONIFICADO****************************************
                                    //PERMITIDO ES LA CANTIDAD
                                    if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {
                                        if ($permitido >= $cantidad_de_CV_bonificar) {
                                            //INSERTA UN DETALLE PARA BONIFICADO
                                            $sqlB = "SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                                            $resultB = mysqli_query($conexion, $sqlB);
                                            if (mysqli_num_rows($resultB)) {
                                                while ($rowB = mysqli_fetch_array($resultB)) {
                                                    $codproB = $rowB['codpro'];
                                                    $stoproB = $rowB['stopro'];
                                                    $cant_locB = $rowB[2];
                                                    $factorB = $rowB['factor'];
                                                    $codmarB = $rowB['codmar'];

                                                    $factorBonif = floor($permitido / $cantidad_de_CV_bonificar);
                                                    $cantbonificable =  $cantidad_a_bonificar * $factorBonif;

                                                    //SI HAY STOCK PARA LA BONIFICACION
                                                    if ($suma_de_cantidades <= $cant_locB) {

                                                        $cantDescontar = $cant_locB - $cantbonificable;

                                                        // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','$tipo_a_bonificar','$factorB','0','0','$codmarB','0','0','1')");

                                                        $sql3 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','$tipo_a_bonificar','$factorB','0','0','$codmarB','0','0','1')";
                                                        $sql3  = arreglarSql($sql3);
                                                        $result3 = mysqli_query($conexion, $sql3);
                                                   
                                                   
                                                   
                                                   
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
                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                    }
                } else {


                    if ($cant_prod <> 0) {
                        if ($agot == 1) { ///AGOTADOS PERO VENDO POR UNIDAD
                            // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$pcunit','$pc','$codmar','$pcostouni','$costpr')");


                            $sql4 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$pcunit','$pc','$codmar','$pcostouni','$costpr')";
                            $sql4  = arreglarSql($sql4);
                            $result4 = mysqli_query($conexion, $sql4);
                        
                        
                        
                        
                        } else {
                            // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        
                            $sql5 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$venta','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')";
                            $sql5  = arreglarSql($sql5);
                            $result5 = mysqli_query($conexion, $sql5);
                        
                        
                        }


                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                        //BONIFICADO****************************************

                        if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {

                            if ($permitido >= $cantidad_de_CV_bonificar) {

                                if ($codpro == $codprobonif) {

                                    $Nuevo_factorBonif      = floor($text1 / $cantidad_de_CV_bonificar_stock_unidad);
                                    $stock_cantbonificable  = $cantidad_a_bonificar_stock_unidad * $Nuevo_factorBonif;
                                    $suma_de_cantidades     = $cantidades + $stock_cantbonificable;
                                    $stock_de_local         = $cant_prod;

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
                                    $stock_de_local         = $cant_locBoni;
                                }

                                if ($suma_de_cantidades <= $stock_de_local) {
                                    //BONIFICADO****************************************
                                    //PERMITIDO ES LA CANTIDAD
                                    if (strlen($codprobonif) > 0 && $cantidad_a_bonificar > 0) {
                                        if ($permitido >= $cantidad_de_CV_bonificar) {
                                            //INSERTA UN DETALLE PARA BONIFICADO
                                            $sqlB = "SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
                                            $resultB = mysqli_query($conexion, $sqlB);
                                            if (mysqli_num_rows($resultB)) {
                                                while ($rowB = mysqli_fetch_array($resultB)) {
                                                    $codproB = $rowB['codpro'];
                                                    $stoproB = $rowB['stopro'];
                                                    $cant_locB = $rowB[2];
                                                    $factorB = $rowB['factor'];
                                                    $codmarB = $rowB['codmar'];

                                                    $factorBonif = floor($permitido / $cantidad_de_CV_bonificar);
                                                    $cantbonificable =  $cantidad_a_bonificar * $factorBonif;

                                                    //SI HAY STOCK PARA LA BONIFICACION
                                                    if ($suma_de_cantidades <= $cant_locB) {

                                                        $cantDescontar = $cant_locB - $cantbonificable;

                                                        
                                                        // mysqli_query($conexion, "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','$tipo_a_bonificar','$factorB','0','0','$codmarB','0','0','1')");
                                                   
                                                   
                                                        $sql6 = "INSERT INTO cotizacion_det (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$venta','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','$tipo_a_bonificar','$factorB','0','0','$codmarB','0','0','1')";
                                                        $sql6  = arreglarSql($sql6);
                                                        $result6 = mysqli_query($conexion, $sql6);
                                                    
                                                   
                                                   
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

                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                        //BONIFICADO****************************************
                    }
                }
            } ///CIERRO IF DE TEXT1 <> ""
        } ///CIERRO IF DE TEXT1 <> ""
    } ////CIERRO IF DE CANTIDADES <> 0
}

header("Location: venta_index1.php");
