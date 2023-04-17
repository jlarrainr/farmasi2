<?php

require_once('../../session_user.php');
require_once('../../../conexion.php');

$sql1 = "SELECT priceditable FROM datagen_det";
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $priceditable = $row1['priceditable'];
    }
}
$tventa = $_SESSION['tventa'];
$date = date("Y-m-d");
$text1 = $_REQUEST['text1']; //CANTIDAD
$text3 = $_REQUEST['text3'];
$factor = $_REQUEST['factor'];
$numero = $_REQUEST['numero'];
$cant_prod = $_REQUEST['cant_prod'];
$codpro = $_REQUEST['codpro'];
$pcostouni = $_REQUEST['pcostouni'];

//SI NUMERO = 0 ES NUMERO SI NO ES LETRA O CAJA
require_once('funciones/datos_generales.php');

$cantventaparabonificar = "";
$codprobonif = "";
$cantbonificable = "";

$sqlPRODT = "SELECT $tabla FROM producto where codpro = '$codpro'";
$resultPRODT = mysqli_query($conexion, $sqlPRODT);
if (mysqli_num_rows($resultPRODT)) {
    while ($row = mysqli_fetch_array($resultPRODT)) {
        $cant_prod = $row[0];
    }
}
//$sql="SELECT invnum,codpro FROM temp_venta where invnum = '$tventa' and codpro = '$codpro'";
$sql = "SELECT invnum,codpro FROM detalle_venta2 where invnum = '$tventa' and codpro = '$codpro'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    //$repetido = 1;
    $repetido = 0;
} else {
    $repetido = 0;  ////// NO ESTA EN LA BASE DE DATOS
}

$sqlCLI = "SELECT cuscod,invfec,sucursal FROM venta2 where invnum = '$tventa'";
$resultCLI = mysqli_query($conexion, $sqlCLI);
if (mysqli_num_rows($resultCLI)) {
    while ($row1 = mysqli_fetch_array($resultCLI)) {
        $cuscod = $row1['cuscod'];
        $invfec = $row1['invfec'];
        $sucursal = $row1['sucursal'];
    }
}

function convertir_a_numero($str) {
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}

if ($repetido == 0) {
    if ($numero == 1) { ///// NO ES NUMERO ES UNA LETRA C 14 - precio de CAJA
        $text2 = $_REQUEST['textprevta'];
        //TODAS LAS CONSULTAS SERAN EN BASE A CAJAS						
        $text1 = convertir_a_numero($text1); ////EJEMPLO: C4 = 4 CAJAS
        $caja_bonifi = $text1;
        $cantreal = $text1; //CANTIDAD
        $text1 = $text1 * $factor;
        $cantidades = $text1;
        $tt = 1;
    } else { /////ES NUMERO Y SON UNIDADES
        //$text2   	= $_REQUEST['text2'];
        if ($priceditable == 1) {
            $text2 = $_REQUEST['text222'];
        } else {
            $text2 = $_REQUEST['text2'];
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

        $sql = "SELECT codpro,stopro,codmar,costpr,codmar,codfam,coduso,$tabla,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$codpro'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codpro = $row['codpro'];
                $stopro = $row['stopro'];
                $codmar = $row['codmar'];
                $costpr = $row['costpr'];
                $codfam = $row['codfam'];
                $coduso = $row['coduso'];
                $factor = $row['factor'];
                $cant_loc = $row[7];
                $cantventaparabonificar = $row['cantventaparabonificar'];
                $codprobonif = $row['codprobonif'];
                $cantbonificable = $row['cantbonificable'];
                if (($codprobonif <> 0) || ($codprobonif <> "")) {
                    if (!is_numeric($cantventaparabonificar)) {
                        $cantventaparabonificar = convertir_a_numero($cantventaparabonificar) * $factor;
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
            if ($numero == 1) { ///// NO ES NUMERO ES UNA LETRA 
                $permitido = $cantreal;
                $strFactor = "F";
            } else {
                $permitido = $cantidades;
                $strFactor = "T";
                $pcostouni = $pcostouni / ($factor * $cantidades);
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
            } else {
                $text2 = $_REQUEST['text2'];
            }
            $cantidades = $text1;
            $text3 = $text2 * $permitido;
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

//        error_log("cantventaparabonificar 1: ". $cantventaparabonificar );
//        error_log("cantidades 1: ". $cantidades );
        if (($cantidades <> "") || ($cantidades <> 0)) {
            //ES NUMERO
            if ($numero == 0) {
                //ES NUMERO -> T
                if ($cant_prod <> 0) {
//                    error_log("A insertar");
                    if ($agot == 1) {
                        //AGOTADOS
                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        $lastDetVentaId = mysqli_insert_id($conexion);
                    } else {
                        //HAY STOCK
                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        $lastDetVentaId = mysqli_insert_id($conexion);
                    }
                    //BONIFICADO****************************************
                    //PERMITIDO ES LA CANTIDAD
                    if (strlen($codprobonif) > 0) {
                        //TEXT1 CANTIDAD CAJA O INDIVIDUAL
                        if ($cantidades >= $cantventaparabonificar) {
                            //INSERTA UN DETALLE PARA BONIFICADO
                            $sqlB = "SELECT codpro,stopro,$tabla,factor,codmar FROM producto where codpro = '$codprobonif'";
//                            error_log($sqlB);
                            $resultB = mysqli_query($conexion, $sqlB);
                            if (mysqli_num_rows($resultB)) {
                                while ($rowB = mysqli_fetch_array($resultB)) {
                                    $codproB = $rowB['codpro'];
                                    $stoproB = $rowB['stopro'];
                                    $cant_locB = $rowB[2];
                                    $factorB = $rowB['factor'];
                                    $codmarB = $rowB['codmar'];
//                                    error_log("DATOS 1: ". $cantbonificable. " ".$cantventaparabonificar. " ". $text1 );
                                    if (!is_numeric($cantbonificable)) {
                                        $cantbonificable = convertir_a_numero($cantbonificable);
                                    }
                                    $factorBonif = floor($text1 / $cantventaparabonificar);
//                                    error_log("DATOS 1: ". $factorBonif );
                                    $cantbonificable = $factorBonif * $cantbonificable;

//                                    error_log("DATOS 1: ". $cantbonificable );
                                    //SI HAY STOCK PARA LA BONIFICACION
                                    if ($cantbonificable <= $cant_locB) {
                                        $cantDescontar = $cant_locB - $cantbonificable;
                                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$tventa','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$tventa','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                                        header("Location: venta_index4_reg.php");
                                    } else {
//                                        error_log("NO HAY STOCK PARA BONIF " );
                                        echo("<script LANGUAGE='JavaScript'>
                                            if (confirm('No existe stock suficiente para agregar bonificaciÃ³n. Â¿Desea continuar?') == true) {
                                                document.location='venta_index4_reg.php?numero=$numero&agot=$agot&cuscod=$cuscod&codpro=$codpro&agotado=$agotado&invfec=$invfec&pcunit=$pcunit&factor=$factor&sucursal=$sucursal&usuario=$usuario&codmar=$codmar&codfam=$codfam&coduso=$coduso&ppc=$ppc';
                                            } else {
                                                document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                            }                                
                                            </script>");
                                    }
                                }
                            }
                        }
                    }
                }
            } else {
                //NO ES NUMERO
                //EMPIEZA CON C - F
                if ($cant_prod <> 0) {
                    if ($agot == 1) {
                        //AGOTADOS
                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$pcunit','$pc','$codmar','$pcostouni','$costpr')");
                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$pcunit','$pc','$codmar','$pcostouni','$costpr')");
                        $lastDetVentaId = mysqli_insert_id($conexion);
                    } else {
                        //HAY STOCK
                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr) values ('$tventa','$date','$cuscod','$usuario','$codpro','$permitido','$strFactor','$factor','$text2','$text3','$codmar','$pcostouni','$costpr')");
                        $lastDetVentaId = mysqli_insert_id($conexion);
                    }
                    //BONIFICADO****************************************
                    //PERMITIDO ES LA CANTIDAD
                    if (strlen($codprobonif) > 0) {
                        if ($permitido >= $cantventaparabonificar) {
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
//                                    error_log("DATOS 2: ". $cantbonificable. " ".$cantventaparabonificar. " ". $text1 );
                                    if (!is_numeric($cantbonificable)) {
                                        $cantbonificable = convertir_a_numero($cantbonificable);
                                    }
                                    $factorBonif = floor($text1 / $cantventaparabonificar);
//                                        error_log("DATOS 2: ". $factorBonif );
                                    $cantbonificable = $factorBonif * $cantbonificable;

//                                        error_log("DATOS 2: ". $cantbonificable );
                                    //SI HAY STOCK PARA LA BONIFICACION
                                    if ($cantbonificable <= $cant_locB) {
                                        $cantDescontar = $cant_locB - $cantbonificable;
                                        //mysqli_query($conexion,"INSERT INTO temp_venta (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$tventa','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                                        mysqli_query($conexion, "INSERT INTO detalle_venta2 (invnum,invfec,cuscod,usecod,codpro,canpro,fraccion,factor,prisal,pripro,codmar,cospro,costpr,bonif2) values ('$tventa','$date','$cuscod','$usuario','$codprobonif','$cantbonificable','T','$factorB','0','0','$codmarB','0','0','1')");
                                        header("Location: venta_index4_reg.php");
                                    } else {
//                                        error_log("NO HAY STOCK PARA BONIF " );
                                        echo("<script LANGUAGE='JavaScript'>
                                            if (confirm('No existe stock suficiente para agregar bonificaciÃ³n. Â¿Desea continuar?') == true) {
                                                document.location='venta_index4_reg.php?numero=$numero&agot=$agot&cuscod=$cuscod&codpro=$codpro&agotado=$agotado&invfec=$invfec&pcunit=$pcunit&factor=$factor&sucursal=$sucursal&usuario=$usuario&codmar=$codmar&codfam=$codfam&coduso=$coduso&ppc=$ppc';
                                            } else {
                                                document.location='venta_index5_reg.php?id=$lastDetVentaId';
                                            }                                
                                            </script>");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
header("Location: venta_index_t2.php");
?>