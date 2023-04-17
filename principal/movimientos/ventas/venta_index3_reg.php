<?php

require_once('../../session_user.php');
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

$venta = $_SESSION['venta'];
$date = date("Y-m-d");
$t1 = $_REQUEST['t1']; ////CANTIDAD


$t3 = $_REQUEST['t33']; ////SUBTOTAL
$number = $_REQUEST['number']; ////SI ES NUMERO O NO
$factor = $_REQUEST['factor'];
$codpro = $_REQUEST['codpro']; /////CODIGO DE LA RELACION ENTRE LOCAL Y PRODUCTO
$codtemp = $_REQUEST['codtemp'];
$blister = $_REQUEST['pblister'];
$preblister = $_REQUEST['preblister'];

if ($priceditable == '1') {
    $t2 = $_REQUEST['t2']; ////PRECIO EDITABLE

    if ($t2 == "") {

        $t2 = $_REQUEST['t22']; ////PRECIO
    }
} else {
    $t2_2 = $_REQUEST['t22']; ////PRECIO
    $t2_1 = $_REQUEST['t2']; ////PRECIO EDITABLE

    if ($t2_2 <> $t2_1) {

        $t2 = $_REQUEST['t2'];
    } else {
        $t2 = $_REQUEST['t22']; ////PRECIO
    }

    //echo '$text2-4='.$text2."<br>";
}
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL

$cantventaparabonificar = "";
$codprobonif = "";
$cantbonificable = "";

if (isset($_SESSION['arr_detalle_venta'])) {
    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
} else {
    $arr_detalle_venta = array();
}

/////FUNCION PARA CONVERTIR CADENA A NUMERO
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    return preg_replace($legalChars, "", $str);
}

///////////ACTUALIZO LA DATA HASTA ANTES DE HACER LA OPERACION
if (!empty($arr_detalle_venta)) {
    $aux = $arr_detalle_venta[$codtemp];
    $canpro = $aux['canpro'];  ////GENERAL
    $fraccion = $aux['fraccion'];
}


$sqlPRODT = "SELECT $tabla FROM producto where codpro = '$codpro'";
$resultPRODT = mysqli_query($conexion, $sqlPRODT);
if (mysqli_num_rows($resultPRODT)) {
    while ($row = mysqli_fetch_array($resultPRODT)) {
        $cant_prod = $row[0];
    }
}

////NO ES NUMERO - ESTOY INGRESANDO CAJAS --- LETRA C
if ($number == 1) {

    $t1 = convertir_a_numero($t1);
    $caja_bonifi = $t1;  /////CAJAS QUE DESEO VENDER
    $cantreal = $t1;
    $t1 = $t1 * $factor;
    $cantidades = $t1;
    $tt = 1;
} else {
    $cantidades = $t1;
}

if ($cantidades <> 0) {
    if ($cantidades > $cant_prod) { ////NO HAY STOCK PARA ESTE PRODUCTO
        $agotado = $cantidades - $cant_prod;
        if ($number <> 1) {
            //   $t2 = $_REQUEST['t23'];
        }
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
            $codfam = $row['codfam'];
            $coduso = $row['coduso'];
            $factor = $row['factor'];
            $cant_loc = $row[7];
            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                $costpr = $row['costpr'];
                $cantventaparabonificar = $row['cantventaparabonificar'];
                $codprobonif = $row['codprobonif'];
                $cantbonificable = $row['cantbonificable'];
            } elseif ($precios_por_local == 0) {
                $costpr = $row['costpr'];
                $cantventaparabonificar = $row['cantventaparabonificar'];
                $codprobonif = $row['codprobonif'];
                $cantbonificable = $row['cantbonificable'];
            }

            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                $sql_precio = "SELECT $costpr_p,$cantventaparabonificar_p,$codprobonif_p,$cantbonificable_p FROM precios_por_local where codpro = '$codpro'";
                $result_precio = mysqli_query($conexion, $sql_precio);
                if (mysqli_num_rows($result_precio)) {
                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                        $costpr = $row_precio[0];
                        $cantventaparabonificar = $row_precio[1];
                        $codprobonif = $row_precio[2];
                        $cantbonificable = $row_precio[3];
                    }
                }
            }

            if (($codprobonif <> 0) || ($codprobonif <> "")) {
                if (!is_numeric($cantventaparabonificar)) {
                    $cantventaparabonificar = convertir_a_numero($cantventaparabonificar) * $factor;
                }
            }
        }
    }
    //ES CAJAS
    if ($number == 1) {
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
            if ($number == 1) { ///// NO ES NUMERO ES UNA LETRA 
                $permitido = $cantreal;
                $strFactor = "F";
            } else {
                $permitido = $cantidades;
                $strFactor = "T";
                $pcostouni = $pcostouni / ($factor * $cantidades);
            }
        }
        $total_local = $cant_loc - $cantidades;
        $total_general = $stopro - $cantidades;
    } else {
        if ($factor == 1) {
            $permitido = $cant_loc;
            $strFactor = "F";
            $pc = ($t2 * $cant_loc) / $factor;
            if ($cant_loc <> 0) {
                $pcunit = $pc / $cant_loc;
            } else {
                $pcunit = 0;
            }
            $total_local = $cant_loc - $cant_loc;
            $total_general = $stopro - $cant_loc;
            $ppc = $agotado * $pcunit;
        } else {
            if ($number == 1) {
                //para caja
                $permitido = $cant_loc / $factor;
                $permitido = ((int) ($permitido));
                $strFactor = "F";
                $pc = ($t2 * $cant_loc) / $factor;
                if ($cant_loc <> 0) {
                    $pcunit = $pc / $cant_loc;
                } else {
                    $pcunit = 0;
                }
                $total_local = $cant_loc - $cant_loc;
                $total_general = $stopro - $cant_loc;
                $ppc = $agotado * $pcunit;
            } else {
                $permitido = $cant_loc;
                $strFactor = "T";
                $pc = ($t2 * $cant_loc) / $factor;
                if ($cant_loc <> 0) {
                    $pcunit = $pc / $cant_loc;
                } else {
                    $pcunit = 0;
                }
                if (($permitido > $blister) && ($blister <> 0) && ($blister <> "")) {
                    $t2 = $preblister;
                } else {
                    $t2 = $_REQUEST['t23'];
                }
                $total_local = $cant_loc - $cant_loc;
                $total_general = $stopro - $cant_loc;
                $ppc = $agotado * $pcunit;
            }
        }
    }

    if (($cantidades <> "") || ($cantidades <> 0)) {

        //ES NUMERO -> T
        if ($cant_prod <> 0) {
            $permitidon = $permitido * $t2;
            $aux = $arr_detalle_venta[$codtemp];
            $aux['canpro'] = $permitido;
            $aux['fraccion'] = $strFactor;
            $aux['prisal'] = $t2;
            $aux['pripro'] = $permitidon;
            $aux['costpr'] = $costpr;
            $arr_detalle_venta[$codtemp] = $aux;
            $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
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
                            if (!is_numeric($cantbonificable)) {
                                $cantbonificable = convertir_a_numero($cantbonificable) * $factorB;
                            }

                            //SI HAY STOCK PARA LA BONIFICACION
                            if ($cantbonificable <= $cant_locB) {
                                $cantDescontar = $cant_locB - $cantbonificable;
                                if (isset($_SESSION['arr_detalle_venta'])) {
                                    $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
                                } else {
                                    $arr_detalle_venta = array();
                                }
                                $auxtemp = array();
                                $auxtemp['invnum'] = $venta;
                                $auxtemp['invfec'] = $date;
                                $auxtemp['cuscod'] = $cuscod;
                                $auxtemp['usecod'] = $usuario;
                                $auxtemp['codpro'] = $codprobonif;
                                $auxtemp['canpro'] = $cantbonificable;
                                $auxtemp['fraccion'] = 'T';
                                $auxtemp['factor'] = $factorB;
                                $auxtemp['prisal'] = '0';
                                $auxtemp['pripro'] = '0';
                                $auxtemp['codmar'] = $codmarB;
                                $auxtemp['cospro'] = '0';
                                $auxtemp['costpr'] = '0';
                                $auxtemp['bonif2'] = '1';

                                $arr_detalle_venta[] = $auxtemp;

                                $_SESSION['arr_detalle_venta'] = $arr_detalle_venta;
                            }
                        }
                    }
                }
            }
        }
    }
}
//echo $t2."<BR>";

mysqli_close($conexion);
header("Location: venta_index2.php");
