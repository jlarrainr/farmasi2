<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            table.tabla2
            { 
                color: #404040;
                background-color: #FFFFFF;
                border: 1px #CDCDCD solid;
                border-collapse: collapse;
                border-spacing: 0px;}
            .Estilo4 {color: #006699; font-weight: bold; }
            .Estilo5 {color: #0066CC}
            -->
            .LETRA{
                font-family:Tahoma;
                font-size:11px;
                line-height:normal;
                color:'#5f5e5e';
                font-weight: bold;
            }
            input {
                box-sizing: border-box;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 12px;
                background-color: white;
                background-position: 3px 3px; 
                background-repeat: no-repeat;
                padding: 2px 1px 2px 5px;

            }
            .LETRA2{
                background:#d7d7d7
            }

        </style>
        <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS ?>
    </head>
    <?php
    $codpro = $_REQUEST['codpro'];
    for ($i = 0; $i <= 5; $i++) {
        $dates[$i] = date("d-m-Y", mktime(0, 0, 0, date("m") - $i, date("d"), date("Y"))) . '<br>';
        list($dcar, $mcar, $ycar) = split('[/.-]', $dates[$i]);
        $m[$i] = $mcar;
        $y[$i] = $ycar;
        if ($m[$i] == 1) {
            $mes[$i] = "ENE";
        }
        if ($m[$i] == 2) {
            $mes[$i] = "FEB";
        }
        if ($m[$i] == 3) {
            $mes[$i] = "MAR";
        }
        if ($m[$i] == 4) {
            $mes[$i] = "ABR";
        }
        if ($m[$i] == 5) {
            $mes[$i] = "MAY";
        }
        if ($m[$i] == 6) {
            $mes[$i] = "JUN";
        }
        if ($m[$i] == 7) {
            $mes[$i] = "JUL";
        }
        if ($m[$i] == 8) {
            $mes[$i] = "AGO";
        }
        if ($m[$i] == 9) {
            $mes[$i] = "SET";
        }
        if ($m[$i] == 10) {
            $mes[$i] = "OCT";
        }
        if ($m[$i] == 11) {
            $mes[$i] = "NOV";
        }
        if ($m[$i] == 12) {
            $mes[$i] = "DIC";
        }
    }
    $sql = "SELECT codpro,desprod,stopro,factor FROM producto where codpro = '$codpro'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codpro = $row['codpro'];
            $desprod = $row['desprod'];
            $stopro = $row['stopro'];
            $factor = $row['factor'];
        }
    }
    ?>
    <body>
        <table width="935" border="0" class="tabla2">
            <tr>
                <td width="1086"><span class="text_login">PRODUCTO : <?php echo $desprod ?></span>
                    <br />
                    <img src="../../../images/line2.png" width="920" height="4" /></td>
            </tr>
        </table>
        <br />
        <table width="938" border="0">
            <tr>
                <td><table width="935" border="0" class="tabla2">
                        <tr>
                            <td width="925"><table width="920" border="0">
                                    <tr>
                                        <td width="224" class="text_gris"><span class="Estilo4">DESCRIPCION</span></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[5] ?></div></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[4] ?></div></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[3] ?></div></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[2] ?></div></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[1] ?></div></td>
                                        <td width="111" class="text_gris"><div align="right" class="Estilo4"><?php echo $mes[0] ?></div></td>
                                    </tr>
                                </table>
                                <img src="../../../images/line2.png" width="920" height="4" />
                                <table width="920" border="0">
                                    <tr>
                                        <td width="224"><span class="Estilo4">VENTA</span></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[5]' and year(detalle_venta.invfec) = '$y[5]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven0 = $row[0];
                                                        $frac0 = $row[1];
                                                        $fact0 = $row[2];
                                                        if ($frac0 == "T") {
                                                            $sum0 = $sum0 + $ven0;
                                                        } else {
                                                            $ven0 = $ven0 * $fact0;
                                                            $sum0 = $sum0 + $ven0;
                                                        }
                                                    }
                                                }
                                                if ($ven0 == "") {
                                                    $sum0 = "0";
                                                }
                                                echo $sum0;
                                                ?>
                                            </div></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[4]' and year(detalle_venta.invfec) = '$y[4]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven1 = $row[0];
                                                        $frac1 = $row[1];
                                                        $fact1 = $row[2];
                                                        if ($frac1 == "T") {
                                                            $sum1 = $sum1 + $ven1;
                                                        } else {
                                                            $ven1 = $ven1 * $fact1;
                                                            $sum1 = $sum1 + $ven1;
                                                        }
                                                    }
                                                }
                                                if ($ven1 == "") {
                                                    $sum1 = "0";
                                                }
                                                echo $sum1;
                                                ?>
                                            </div></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[3]' and year(detalle_venta.invfec) = '$y[3]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven2 = $row[0];
                                                        $frac2 = $row[1];
                                                        $fact2 = $row[2];
                                                        if ($frac2 == "T") {
                                                            $sum2 = $sum2 + $ven2;
                                                        } else {
                                                            $ven2 = $ven2 * $fact2;
                                                            $sum2 = $sum2 + $ven2;
                                                        }
                                                    }
                                                }
                                                if ($ven2 == "") {
                                                    $sum2 = "0";
                                                }
                                                echo $sum2;
                                                ?>
                                            </div></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[2]' and year(detalle_venta.invfec) = '$y[2]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven3 = $row[0];
                                                        $frac3 = $row[1];
                                                        $fact3 = $row[2];
                                                        if ($frac3 == "T") {
                                                            $sum3 = $sum3 + $ven3;
                                                        } else {
                                                            $ven3 = $ven3 * $fact3;
                                                            $sum3 = $sum3 + $ven3;
                                                        }
                                                    }
                                                }
                                                if ($ven3 == "") {
                                                    $sum3 = "0";
                                                }
                                                echo $sum3;
                                                ?>
                                            </div></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[1]' and year(detalle_venta.invfec) = '$y[1]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven4 = $row[0];
                                                        $frac4 = $row[1];
                                                        $fact4 = $row[2];
                                                        if ($frac4 == "T") {
                                                            $sum4 = $sum4 + $ven4;
                                                        } else {
                                                            $ven4 = $ven4 * $fact4;
                                                            $sum4 = $sum4 + $ven4;
                                                        }
                                                    }
                                                }
                                                if ($ven4 == "") {
                                                    $sum4 = "0";
                                                }
                                                echo $sum4;
                                                ?>
                                            </div></td>
                                        <td width="111"><div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and month(detalle_venta.invfec) = '$m[0]' and year(detalle_venta.invfec) = '$y[0]' and val_habil = '0'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $ven5 = $row[0];
                                                        $frac5 = $row[1];
                                                        $fact5 = $row[2];
                                                        if ($frac5 == "T") {
                                                            $sum5 = $sum5 + $ven5;
                                                        } else {
                                                            $ven5 = $ven5 * $fact5;
                                                            $sum5 = $sum5 + $ven5;
                                                        }
                                                    }
                                                }
                                                if ($ven5 == "") {
                                                    $sum5 = "0";
                                                }
                                                echo $sum5;
                                                ?>
                                            </div></td>
                                    </tr>
                                    <tr>
                                        <td><span class="Estilo4">VENTAS NO REALIZADAS </span></td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[5]' and year(invfec) = '$y[5]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven0 = $row[0];
                                                        $nofrac0 = $row[1];
                                                        $nofact0 = $row[2];
                                                        if ($nofrac0 == "T") {
                                                            $nosum0 = $nosum0 + $noven0;
                                                        } else {
                                                            $noven0 = $noven0 * $nofact0;
                                                            $nosum0 = $nosum0 + $noven0;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[5]' and year(invfec) = '$y[5]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven00 = $row[0];
                                                        $nofrac00 = $row[1];
                                                        $nofact00 = $row[2];
                                                        if ($nofrac00 == "T") {
                                                            $nosum00 = $nosum00 + $noven00;
                                                        } else {
                                                            $noven00 = $noven00 * $nofact00;
                                                            $nosum00 = $nosum00 + $noven00;
                                                        }
                                                    }
                                                }
                                                if ($noven0 == "") {
                                                    $nosum0 = "0";
                                                }
                                                if ($noven00 == "") {
                                                    $nosum00 = "0";
                                                }
                                                $ns0 = $nosum0 + $nosum00;
                                                echo $ns0;
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[4]' and year(invfec) = '$y[4]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven1 = $row[0];
                                                        $nofrac1 = $row[1];
                                                        $nofact1 = $row[2];
                                                        if ($nofrac1 == "T") {
                                                            $nosum1 = $nosum1 + $noven1;
                                                        } else {
                                                            $noven1 = $noven1 * $nofact1;
                                                            $nosum1 = $nosum1 + $noven1;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[4]' and year(invfec) = '$y[4]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven11 = $row[0];
                                                        $nofrac11 = $row[1];
                                                        $nofact11 = $row[2];
                                                        if ($nofrac11 == "T") {
                                                            $nosum11 = $nosum11 + $noven11;
                                                        } else {
                                                            $noven11 = $noven11 * $nofact11;
                                                            $nosum11 = $nosum11 + $noven11;
                                                        }
                                                    }
                                                }
                                                if ($noven1 == "") {
                                                    $nosum1 = "0";
                                                }
                                                if ($noven11 == "") {
                                                    $nosum11 = "0";
                                                }
                                                $ns1 = $nosum1 + $nosum11;
                                                echo $ns1;
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[3]' and year(invfec) = '$y[3]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven2 = $row[0];
                                                        $nofrac2 = $row[1];
                                                        $nofact2 = $row[2];
                                                        if ($nofrac2 == "T") {
                                                            $nosum2 = $nosum2 + $noven2;
                                                        } else {
                                                            $noven2 = $noven2 * $nofact2;
                                                            $nosum2 = $nosum2 + $noven2;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[3]' and year(invfec) = '$y[3]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven22 = $row[0];
                                                        $nofrac22 = $row[1];
                                                        $nofact22 = $row[2];
                                                        if ($nofrac22 == "T") {
                                                            $nosum22 = $nosum22 + $noven22;
                                                        } else {
                                                            $noven22 = $noven22 * $nofact22;
                                                            $nosum22 = $nosum22 + $noven22;
                                                        }
                                                    }
                                                }
                                                if ($noven2 == "") {
                                                    $nosum2 = "0";
                                                }
                                                if ($noven22 == "") {
                                                    $nosum22 = "0";
                                                }
                                                $ns2 = $nosum2 + $nosum22;
                                                echo $ns2;
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[2]' and year(invfec) = '$y[2]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven3 = $row[0];
                                                        $nofrac3 = $row[1];
                                                        $nofact3 = $row[2];
                                                        if ($nofrac3 == "T") {
                                                            $nosum3 = $nosum3 + $noven3;
                                                        } else {
                                                            $noven3 = $noven3 * $nofact3;
                                                            $nosum3 = $nosum3 + $noven3;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[2]' and year(invfec) = '$y[2]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven33 = $row[0];
                                                        $nofrac33 = $row[1];
                                                        $nofact33 = $row[2];
                                                        if ($nofrac33 == "T") {
                                                            $nosum33 = $nosum33 + $noven33;
                                                        } else {
                                                            $noven33 = $noven33 * $nofact33;
                                                            $nosum33 = $nosum33 + $noven33;
                                                        }
                                                    }
                                                }
                                                if ($noven3 == "") {
                                                    $nosum3 = "0";
                                                }
                                                if ($noven33 == "") {
                                                    $nosum33 = "0";
                                                }
                                                $ns3 = $nosum3 + $nosum33;
                                                echo $ns3;
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[1]' and year(invfec) = '$y[1]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven4 = $row[0];
                                                        $nofrac4 = $row[1];
                                                        $nofact4 = $row[2];
                                                        if ($nofrac4 == "T") {
                                                            $nosum4 = $nosum4 + $noven4;
                                                        } else {
                                                            $noven4 = $noven4 * $nofact4;
                                                            $nosum4 = $nosum4 + $noven4;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[1]' and year(invfec) = '$y[1]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven44 = $row[0];
                                                        $nofrac44 = $row[1];
                                                        $nofact44 = $row[2];
                                                        if ($nofrac44 == "T") {
                                                            $nosum44 = $nosum44 + $noven44;
                                                        } else {
                                                            $noven44 = $noven44 * $nofact44;
                                                            $nosum44 = $nosum44 + $noven44;
                                                        }
                                                    }
                                                }
                                                if ($noven4 == "") {
                                                    $nosum4 = "0";
                                                }
                                                if ($noven44 == "") {
                                                    $nosum44 = "0";
                                                }
                                                $ns4 = $nosum4 + $nosum44;
                                                echo $ns4;
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div align="right">
                                                <?php
                                                $sql = "SELECT canpro,fraccion,factor FROM venta_nosave_detalle where codpro = '$codpro' and month(invfec) = '$m[0]' and year(invfec) = '$y[0]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven5 = $row[0];
                                                        $nofrac5 = $row[1];
                                                        $nofact5 = $row[2];
                                                        if ($nofrac5 == "T") {
                                                            $nosum5 = $nosum5 + $noven5;
                                                        } else {
                                                            $noven5 = $noven5 * $nofact5;
                                                            $nosum5 = $nosum5 + $noven5;
                                                        }
                                                    }
                                                }
                                                $sql = "SELECT canpro,fraccion,factor FROM agotados where codpro = '$codpro' and month(invfec) = '$m[0]' and year(invfec) = '$y[0]'";
                                                $result = mysqli_query($conexion, $sql);
                                                if (mysqli_num_rows($result)) {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        $noven55 = $row[0];
                                                        $nofrac55 = $row[1];
                                                        $nofact55 = $row[2];
                                                        if ($nofrac55 == "T") {
                                                            $nosum55 = $nosum55 + $noven55;
                                                        } else {
                                                            $noven55 = $noven55 * $nofact55;
                                                            $nosum55 = $nosum55 + $noven55;
                                                        }
                                                    }
                                                }
                                                if ($noven5 == "") {
                                                    $nosum5 = "0";
                                                }
                                                if ($noven55 == "") {
                                                    $nosum55 = "0";
                                                }
                                                $ns5 = $nosum5 + $nosum55;
                                                echo $ns5;
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <img src="../../../images/line2.png" width="920" height="4" />
                                <table width="920" border="0">
                                    <tr>
                                        <td width="224"><span class="Estilo4">PROYECCION DE COMPRAS </span></td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum0 - $ns0;
                                                ?>
                                            </div>
                                        </td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum1 - $ns1;
                                                ?>
                                            </div>
                                        </td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum2 - $ns2;
                                                ?>
                                            </div>
                                        </td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum3 - $ns3;
                                                ?>
                                            </div>
                                        </td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum4 - $ns4;
                                                ?>
                                            </div>
                                        </td>
                                        <td width="111">
                                            <div align="right">
                                                <?php echo $sum5 - $ns5;
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <br />
    </body>
</html>
