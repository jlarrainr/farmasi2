<?php
$total_paginas = "";
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .Estilo1 {
            color: #FF0000;
            font-weight: bold;
        }

        .Estilo2 {
            color: #02BF97;
            font-weight: bold;
        }

        .Estilo3 {
            color: #065D95;
            font-weight: bold;
        }
    </style>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;
            font-size: 12px;

        }

        .Estilo11 {
            color: #a766ff;
            font-weight: bold;
        }

        .Estilo11rent {
            color: red;
            font-weight: bold;
        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }
    </style>
</head>
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME


$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}


$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$date = date('d/m/Y');
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$inicio = isset($_REQUEST['inicio']) ? ($_REQUEST['inicio']) : "";
$pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
$ord = isset($_REQUEST['ord']) ? ($_REQUEST['ord']) : "";
$tip = isset($_REQUEST['tip']) ? ($_REQUEST['tip']) : "";
$tot_pag = isset($_REQUEST['tot_pag']) ? ($_REQUEST['tot_pag']) : "";
$TipBusk = isset($_REQUEST['TipBusk']) ? ($_REQUEST['TipBusk']) : "";
$ordenar = isset($_REQUEST['ordenar']) ? ($_REQUEST['ordenar']) : "";
$registros = isset($_REQUEST['registros']) ? ($_REQUEST['registros']) : "";
$dat1 = $date1;
$dat2 = $date2;

if (strlen($date1) > 0) {
    $date1 = fecha1($date1);
} else {
    $date1 = $date;
}


if (strlen($date2) > 0) {
    $date2 = fecha1($date2);
} else {
    $date2 = $date;
}

if ($pagina == 1) {
    $i = 0;
} else {
    $t = $pagina - 1;
    $i = $t * $registros;
}

function tablaslocal($nomloc)
{
    if ($nomloc == "LOCAL0") {
        $tabla = 's000';
    }
    if ($nomloc == "LOCAL1") {
        $tabla = 's001';
    }
    if ($nomloc == "LOCAL2") {
        $tabla = 's002';
    }
    if ($nomloc == "LOCAL3") {
        $tabla = 's003';
    }
    if ($nomloc == "LOCAL4") {
        $tabla = 's004';
    }
    if ($nomloc == "LOCAL5") {
        $tabla = 's005';
    }
    if ($nomloc == "LOCAL6") {
        $tabla = 's006';
    }
    if ($nomloc == "LOCAL7") {
        $tabla = 's007';
    }
    if ($nomloc == "LOCAL8") {
        $tabla = 's008';
    }
    if ($nomloc == "LOCAL9") {
        $tabla = 's009';
    }
    if ($nomloc == "LOCAL10") {
        $tabla = 's010';
    }
    if ($nomloc == "LOCAL11") {
        $tabla = 's011';
    }
    if ($nomloc == "LOCAL12") {
        $tabla = 's012';
    }
    if ($nomloc == "LOCAL13") {
        $tabla = 's013';
    }
    if ($nomloc == "LOCAL14") {
        $tabla = 's014';
    }
    if ($nomloc == "LOCAL15") {
        $tabla = 's015';
    }
    if ($nomloc == "LOCAL16") {
        $tabla = 's016';
    }
    if ($nomloc == "LOCAL17") {
        $tabla = 's017';
    }
    if ($nomloc == "LOCAL18") {
        $tabla = 's018';
    }
    if ($nomloc == "LOCAL19") {
        $tabla = 's019';
    }
    if ($nomloc == "LOCAL20") {
        $tabla = 's020';
    }
    return $tabla;
}

if ($local <> 'all') {
    $sql = "SELECT nomloc FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }
    $Tabla = tablaslocal($nomloc);
} else {
    $Tabla = "0";
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="260"><strong><?php echo $desemp ?> </strong></td>
                        <td width="380">
                            <div align="center"><strong>REPORTE SUGERENCIA DE COMPRA (Sin Transferencias)-
                                    <?php
                                    if ($local == 'all') {
                                        echo 'TODAS LAS SUCURSALES';
                                    } else {
                                        echo $nomloc;
                                    }
                                    ?>
                                </strong></div>
                        </td>
                        <td width="260">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="633">
                            <div align="center">
                                <b>
                                    <?php if ($val == 1) { ?>
                                        FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php
                                                                                    echo $dat2;
                                                                                }
                                                                                    ?>
                                </b>
                            </div>
                        </td>
                        <td width="133">
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>

    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="100%" border="0" align="center" id="customers">
                    <tr>
                        <th width="38"><strong>CODIGO <?php echo $ordenar; ?> </strong></th>
                        <th width="220">
                            <div align="left"><strong>PRODUCTO </strong></div>
                        </th>
                        <th width="50">
                            <div align="left"><strong>FRACCIONES</strong></div>
                        </th>
                        <th width="169">
                            <div align="left"><strong>LABORATORIO</strong></div>
                        </th>
                        <th width="70">
                            <div align="CENTER"><strong>ULTIMO COSTO DE CAJA</strong></div>
                        </th>
                        <th width="120">
                            <div align="CENTER"><strong>ULTIMO PROVEEDOR</strong></div>
                        </th>
                        <th width="68">
                            <div align="center"><strong>
                                    <!--<a href="curva2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>&ord=1&tip=1"><img src="down_enabled.gif" width="7" height="9" border="0" /></a>-->
                                    MONTO VENDIDO S/.
                                    <!--<a href="curva2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>&ord=0&tip=1"><img src="up_enabled.gif" width="7" height="9" border="0"/></a>-->
                                </strong>
                            </div>
                        </th>
                        <th width="70">
                            <div align="CENTER"><strong>RENTABILIDAD GENERADA</strong></div>
                        </th>
                        <th width="87" <?php if ($TipBusk == 1) { ?>class='Estilo1'><?php } ?>
                        <div align="center"><strong>
                                <?php /* ?><a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=1&tip=2"><img src="down_enabled.gif" width="7" height="9" border="0" /></a> <?php */ ?>
                                <?php if ($TipBusk == 1) { ?>
                                    CANTIDAD VENDIDA
                                <?php } else { ?>
                                    CANTIDAD VENDIDA
                                <?php } ?>
                                <?php /* ?>
                                          <a href="curva2.php?val=<?php echo $val?>&date1=<?php echo $date1?>&date2=<?php echo $date2?>&local=<?php echo $local?>&inicio=<?php echo $inicio?>&registros=<?php echo $registros?>&pagina=<?php echo $pagina?>&tot_pag=<?php echo $total_paginas?>&ord=0&tip=2"><img src="up_enabled.gif" width="7" height="9" border="0"/></a><?php */ ?>
                            </strong>
                        </div>
                        </th>
                        <th width="70">
                            <div align="CENTER"><strong>STOCK ACTUAL</strong></div>
                        </th>

                        <th width="70">
                            <div align="CENTER"><strong>STOCK ALM</strong></div>
                        </th>


                        <?php if ($TipBusk <> 1) { ?>
                            <th width="50">
                                <div align="CENTER" class='Estilo1'><strong>COMPRA SUGERIDA</strong></div>
                            </th>

                            <th width="70">
                                <div align="CENTER"><strong>TOTAL REPOSICION S/.</strong></div>
                            </th>
                        <?php } ?>

                        <th width="77">
                            <div align="center"><strong>% PARTICIPACION DE LA VENTA TOTAL</strong></div>
                        </th>
                        <th width="78">
                            <div align="center"><strong>TOTAL DEL % </strong></div>
                        </th>
                    </tr>
                    <?php
                    if ($tip == "") {
                        $tip = 1;
                    }
                    if ($tip == 1) {
                        if ($local == 'all') {

                            $sql = "SELECT sum(invtot) FROM venta where invfec between '$date1' and '$date2' and val_habil = '0' and estado = '0' and dedonde='0'";
                        } else {

                            $sql = "SELECT sum(invtot) FROM venta where invfec between '$date1' and '$date2' and val_habil = '0' and sucursal = '$local'  and estado = '0' and dedonde='0'";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            while ($row = mysqli_fetch_array($result)) {
                                $tot = $row[0];
                            }
                        }
                        $sumporc = 0;

                        if ($ord == 1) {
                            $codpro = "";
                            if ($local == 'all') {

                                $sql = "SELECT sum(DV.pripro),DV.codpro FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum where DV.invfec between '$date1' and '$date2' and V.val_habil = '0' and V.estado = '0'  and V.dedonde='0' group by DV.codpro order by sum(DV.pripro) asc";
                            } else {

                                $sql = "SELECT sum(DV.pripro),DV.codpro FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum where DV.invfec between '$date1' and '$date2' and V.val_habil = '0' and V.sucursal = '$local' and V.estado = '0' and V.dedonde='0' group by DV.codpro order by sum(DV.pripro) asc";
                            }
                        } else {
                            ///todos los productos vendidos 
                            if ($local == 'all') {

                                $sql = "SELECT sum(DV.pripro),DV.codpro FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum where DV.invfec between '$date1' and '$date2' and V.val_habil = '0' and V.estado = '0'and V.dedonde='0'  group by DV.codpro order by sum(DV.pripro) desc";
                            } else {

                                $sql = "SELECT sum(DV.pripro),DV.codpro FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum where DV.invfec between '$date1' and '$date2' and V.val_habil = '0' and V.sucursal = '$local' and V.dedonde='0' and V.estado = '0' group by DV.codpro order by sum(DV.pripro) desc";
                            }
                        }
                        $datosPrepedido = array();

                        $codpro = "";
                        $totalReposicion=0;
                        $totalMontoVendido=0;
                        $totalRentabilidadGeneral=0;
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            while ($row = mysqli_fetch_array($result)) {

                                $cantidad = 0;
                                $sumcantidad = 0;
                                $sum = $row[0];
                                $codpro = $row['codpro'];

 
                             
                                ////////////////////proveedor ultimo
                                $desproveedor = "OTROS INGRESOS";
                                $sql1 = "SELECT P.despro FROM movmae as ME INNER JOIN movmov as MV on MV.invnum=ME.invnum INNER JOIN  proveedor AS P ON P.codpro=ME.cuscod WHERE MV.codpro='$codpro' and ME.tipmov='1' and ME.tipdoc='1' and ME.numero_documento <> '' and ME.numero_documento1 <> '' ORDER BY MV.invnum DESC LIMIT 1";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $desproveedor = $row1[0];
                                    }
                                }


                                $sumpripro = 0;
                                $sumpcosto = 0;

                                if ($local == 'all') {


                                    $sql1 = "SELECT V.invnum,DV.canpro,DV.fraccion,DV.factor,DV.prisal,DV.costpr FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum inner join producto P on P.codpro = DV.codpro where DV.invfec between '$date1' and '$date2' and DV.codpro = '$codpro' and V.val_habil = '0' and V.estado = '0' and V.dedonde='0'";
                                } else {

                                    $sql1 = "SELECT V.invnum,DV.canpro,DV.fraccion,DV.factor,DV.prisal,DV.costpr FROM detalle_venta DV inner join venta V on DV.invnum = V.invnum inner join producto P on P.codpro = DV.codpro where DV.invfec between '$date1' and '$date2' and DV.codpro = '$codpro' and V.sucursal = '$local' and V.val_habil = '0' and V.estado = '0' and V.dedonde='0'";
                                }

                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $invnum = $row1['invnum'];
                                        $canpro = $row1['canpro'];
                                        $fraccion = $row1['fraccion'];
                                        $factor = $row1['factor'];
                                        $prisal = $row1['prisal'];
                                        $costpr = $row1['costpr'];

                                        if ($fraccion == 'T') {
                                            $cantidad = $canpro;
                                        } else {
                                            $cantidad = $canpro * $factor;
                                        }
                                        $sumcantidad = $sumcantidad + $cantidad;
                                        $sumcantidadAux = $sumcantidad;

                                        $sumpripro = $sumpripro + ($prisal * $canpro);
                                        $sumpcosto = $sumpcosto + ($costpr * $canpro);
                                    }
                                }
                                
                                $rentabilidad = $sumpripro - $sumpcosto;
                               
                                if ($factor > 1) {
                                    $convert1 = $sumcantidad / $factor;
                                    $div1 = floor($convert1);
                                    $mult1 = $factor * $div1;
                                    $tot1 = $sumcantidad - $mult1;
                                    $sumcantidad1 = ' C ' . $div1 . ' + ' . ' F ' . $tot1;
                                } else {
                                    $convert1 = $sumcantidad;
                                    $div1 = floor($convert1);
                                    $mult1 = $factor * $div1;
                                    $tot1 = $sumcantidad - $mult1;
                                    $sumcantidad1 = ' C ' . $div1;
                                }

                                $codproUNICO == '';
                                
                                if ($Tabla <> "0") {
                                    $sql1 = "SELECT desprod,codmar,$Tabla,factor,s000,costre,utlcos,blister,codpro  FROM producto where codpro = '$codpro' and eliminado='0'";
                                } else {
                                    $sql1 = "SELECT desprod,codmar,stopro,factor,s000,costre,utlcos,blister,codpro  FROM producto where codpro = '$codpro' and eliminado='0'";
                                }

                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {

                                        $desprod = $row1['desprod'];
                                        $codmar = $row1['codmar'];
                                        $StockActual = $row1[2];
                                        $factorX = $row1['factor'];
                                        $StockP = $StockActual;
                                        $StockActualAux = $StockActual;
                                        $stockCentral = $row1['s000'];

                                        $codpro = $row1['codpro'];

                                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                            $costpr = $row1['costre'];
                                            $utlcos = $row1['utlcos'];
                                            $blister = $row1['blister'];
                                        } elseif ($precios_por_local == 0) {
                                            $costpr = $row1['costre'];
                                            $utlcos = $row1['utlcos'];
                                            $blister = $row1['blister'];
                                        }

                                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                            $sql_precio = "SELECT $costre_p,$utlcos_p,$blister_p  FROM precios_por_local where codpro = '$codpro'";
                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                            if (mysqli_num_rows($result_precio)) {
                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                    $costpr = $row_precio[0];
                                                    $utlcos = $row_precio[1];
                                                    $blister = $row_precio[2];
                                                }
                                            }
                                        }
                                    }
                                }

                                if ($factorX > 1) {
                                    $convert1X = $StockActual / $factorX;
                                    $div1X = floor($convert1X);
                                    $mult1X = $factorX * $div1X;
                                    $tot1X = $StockActual - $mult1X;
                                    $StockActual22 = ' C ' . $div1X . ' + ' . 'F' . $tot1X;
                                } else {
                                    $convert1X = $StockActual;
                                    $div1X = floor($convert1X);
                                    $mult1X = $factorX * $div1X;
                                    $tot1X = $StockActual - $mult1X;
                                    $StockActual22 = ' C ' . $div1X;
                                }


                                $suma = 0;
                                if ($TipBusk == 4) {
                                    if ($factorX > 1) {
                                        if ($StockActual > ($sumcantidad * 2)) {
                                            $RR = $StockActual - ($sumcantidad * 2);
                                        } else {
                                            $RR = ($sumcantidad * 2) - $StockActual;
                                        }

                                        $con = $RR / $factorX;
                                        //$repo = $con * $costpr;
                                        $repo = $con * $costpr;
                                        $d = floor($con);
                                        $m = $factorX * $d;
                                        $to = $RR - $m;
                                        $StockK = ' C ' . $d . ' + ' . ' F' . $to;
                                    } else {
                                        if ($StockActual > ($sumcantidad * 2)) {
                                            $RR = $StockActual - ($sumcantidad * 2);
                                        } else {
                                            $RR = ($sumcantidad * 2) - $StockActual;
                                        }

                                        $con = $RR;
                                        $repo = $con * $costpr;
                                        $d = floor($con);
                                        $m = $factorX * $d;
                                        $to = $RR - $m;
                                        $StockK = ' C ' . $d;
                                    }
                                } else {
                                    if ($factorX > 1) {
                                        if ($StockActual > ($sumcantidad * 2)) {
                                            $RR = $StockActual - $sumcantidad;
                                        } else {
                                            $RR = $sumcantidad - $StockActual;
                                        }

                                        $con = $RR / $factorX;
                                        $repo = $con * $costpr;
                                        $d = floor($con);
                                        $m = $factorX * $d;
                                        $to = $RR - $m;
                                        $StockK = ' C ' . $d . ' + ' . ' F' . $to;
                                    } else {
                                        if ($StockActual > ($sumcantidad * 2)) {
                                            $RR = $StockActual - $sumcantidad;
                                        } else {
                                            $RR = $sumcantidad - $StockActual;
                                        }

                                        $con = $RR;
                                        $repo = $con * $costpr;
                                        $d = floor($con);
                                        $m = $factorX * $d;
                                        $to = $RR - $m;
                                        $StockK = ' C ' . $d;
                                    }
                                }

                             
                                
                                
                                $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $destab = $row1['destab'];

                                        $abrev = $row1['abrev'];
                                        $destab2 = $row1['destab'];
                                        if ($abrev <> '') {
                                            $destab = $destab2;
                                        }
                                    }
                                }

                                $porcentaje = ($sum / $tot) * 100;
                                $sumporc = $sumporc + $porcentaje;

                                if ($TipBusk == 1) {
                                    $Mostrar = 1;
                                }
                                if ($TipBusk == 2) {
                                    if ($StockP == 0) {
                                        $Mostrar = 1;
                                    } else {
                                        $Mostrar = 0;
                                    }
                                }
                                if ($TipBusk == 3) {
                                    if ($StockP < $sumcantidad) {
                                        $Mostrar = 1;
                                    } else {
                                        $Mostrar = 0;
                                    }
                                }
                                if ($TipBusk == 4) {

                                    $doble = $sumcantidad * 2;
                                    if ($StockP < $doble) {
                                        $Mostrar = 1;
                                    } else {
                                        $Mostrar = 0;
                                    }
                                }

                                if (($factor > 1) && ($blister > 0)) {
                                    $redondeo = round($RR / $blister) * $blister;
                                } else {
                                    $redondeo = $RR;
                                }
                                if ($factor > 1) {
                                    if ($redondeo > $factor) {
                                        $convert1 = $redondeo / $factor;
                                        $caja = ((int) ($convert1));
                                        $redondeo = $caja;
                                        $fraccionpre = '0';
                                    } else {
                                        $redondeo = $redondeo;
                                        $fraccionpre = '1';
                                    }
                                } else {
                                    $redondeo = $redondeo;
                                    $fraccionpre = '0';
                                }
                                if (($factor > 1) && ($blister > 0)) {
                                    $redondeo = round($redondeo / $blister) * $blister;
                                } else {
                                    $redondeo = $RR;
                                }
                                $SUMA = $repo + $repo;
                                
                                if ($Mostrar == 1) {
                                    
                                    
                                     $totalRentabilidadGeneral+=$rentabilidad;
                                     $totalMontoVendido+=$sum;
                                     $totalReposicion+=$repo;
                                    $i++;
                    ?>
                                    <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>

                                        <td width="38"><?php echo $codpro; ?></td>
                                        <td width="200" title="el factor es.<?php echo $factor; ?>"><?php echo $desprod; ?></td>
                                        <td align="center" title="el factor es.<?php echo $factor; ?>"><?php echo $factor; ?></td>
                                        <td width="169" title="<?php echo $factor ?>"><?php echo $destab2; ?></td>
                                        <td width="77">
                                            <div align="center"><?php echo number_format($utlcos, 2, '.', ' '); ?> </div>
                                        </td>
                                        <td width="77">
                                            <div align="left"><?php
                                                                if ($desproveedor == "OTROS INGRESOS") {
                                                                    echo "<b class='Estilo11'>$desproveedor</b>";
                                                                } else {
                                                                    echo $desproveedor;
                                                                }
                                                                ?> </div>
                                        </td>
                                        <td class="Estilo2" width="68">
                                            <div align="right"><?php echo "S/." . $sum ?></div>
                                        </td>
                                        <td width="77">
                                            <div align="right"><?php
                                                                if ($rentabilidad < 0) {
                                                                    echo "<b class='Estilo11rent'> S/.$rentabilidad</b>";
                                                                } else {
                                                                    echo 'S/.' . $rentabilidad;
                                                                }
                                                                ?> </div>
                                        </td>
                                        <td class='Estilo3' align="center" width="87" <?php if ($TipBusk == 1) { ?>><?php } ?><div align="left"><?php echo $sumcantidad1 ?></div>
                                        </td>
                                        <td width="58">
                                            <div align="left"><?php echo $StockActual22; ?></div>
                                        </td>

                                        <td width="58">
                                            <div align="left"><?php echo stockcaja($stockCentral, $factorX); ?></div>
                                        </td>



                                        <?php if ($TipBusk <> 1) { ?>
                                            <td width="58">
                                                <div align="left"><?php echo "<p class='Estilo1'>$StockK</p>"; ?></div>
                                            </td>
                                            <td width="77">
                                                <div align="right" title="<?php echo $SUMA ?>"><?php echo "S/." . number_format($repo, 2, '.', ' '); ?> </div>
                                            </td>
                                        <?php } ?>

                                        <td width="77">
                                            <div align="right"><?php echo number_format($porcentaje, 2, '.', ' '); ?> %</div>
                                        </td>
                                        <td width="78" <?php if($sumporc <= '80'){ ?> bgcolor="red" <?php }else if(($sumporc > '80')&& ($sumporc <= '95') ) { ?>  bgcolor="#a4fb53" <?php }else if($sumporc > '95') {   ?>  bgcolor="#fbc453"  <?php  } ?>>
                                            <div align="right"><?php echo number_format($sumporc, 2, '.', ' '); ?> %</div>
                                        </td>
                                    </tr>

                            <?php
                                    //	if ($factorX == 1) {
                                    $datosCurva = array();
                                    $datosCurva['codprod'] = $codpro;
                                    //$datosCurva['unidades'] = $sumcantidadAux;
                                    $datosCurva['unidades'] = $redondeo;
                                    $datosCurva['stock'] = $StockActualAux;
                                    $datosCurva['destab'] = $destab;
                                    $datosCurva['stockCentral'] = $stockCentral;
                                    $datosCurva['fraccion'] = $fraccionpre;
                                    $datosCurva['factor'] = $factorX;
                                    $datosCurva['blister'] = $blister;

                                    $datosPrepedido[] = $datosCurva;
                                    //	}
                                }
                            }?>
                            
                            <tr>
                                <td colspan="6"> 
                                    <div align="center">TOTAL</div>
                                </td>
                                <td>
                                    <div align="center"><?php echo "S/." .number_format($totalMontoVendido, 2, '.', ' ');?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo "S/." .number_format($totalRentabilidadGeneral, 2, '.', ' ');?></div>
                                </td>
                                 <?php if ($TipBusk <> 1) { ?>
                                <td colspan="4"> </td>
                                <td>
                                    <div align="center"><?php echo "S/." .number_format($totalReposicion, 2, '.', ' ');?></div>
                                </td>
                                <td></td>
                                <td></td>
                                <?php }?>
                            </tr>
                            <?php 
                        } else {
                            ?>
                </table>
                <div class="siniformacion">
                    <center>
                        No se logro encontrar informacion con los datos ingresados
                    </center>
                </div>
        <?php
                        }
                        $_SESSION['datosPrepedido'] = $datosPrepedido;
                    }
        ?>

            </td>
        </tr>
        <b style="color:green; font-size:14px;"><?php echo "Hay " . $i . " productos en esta lista."; ?></b>
    </table>
</body>

</html>