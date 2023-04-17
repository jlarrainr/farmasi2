<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
?>
<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
    </head>
    <?php
    $val = $_REQUEST['val'];
    $mes = $_REQUEST['mes'];
    $year = $_REQUEST['year'];
    $mes1 = $_REQUEST['mes1'];
    $year1 = $_REQUEST['year1'];
    $report = $_REQUEST['report'];
    $tipo = $_REQUEST['tipo'];
    $hour = date(G);
//$date	= CalculaFechaHora($hour);
    $date = date("Y-m-d");
//$hour   = CalculaHora($hour);
    $min = date(i);
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }

    function getMonthDays($Month, $Year) {
        //Si la extensi?n que mencion? est? instalada, usamos esa. 
        if (is_callable("cal_days_in_month")) {
            return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
        } else {
            //Lo hacemos a mi manera. 
            return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
        }
    }

    $dd = getMonthDays($mes1, $year1);
    if ($mes == 1) {
        $mesx = "ENERO";
    }
    if ($mes == 2) {
        $mesx = "FEBRERO";
    }
    if ($mes == 3) {
        $mesx = "MARZO";
    }
    if ($mes == 4) {
        $mesx = "ABRIL";
    }
    if ($mes == 5) {
        $mesx = "MAYO";
    }
    if ($mes == 6) {
        $mesx = "JUNIO";
    }
    if ($mes == 7) {
        $mesx = "JULIO";
    }
    if ($mes == 8) {
        $mesx = "AGOSTO";
    }
    if ($mes == 9) {
        $mesx = "SETIEMBRE";
    }
    if ($mes == 10) {
        $mesx = "OCTUBRE";
    }
    if ($mes == 11) {
        $mesx = "NOVIEMBRE";
    }
    if ($mes == 12) {
        $mesx = "DICIEMBRE";
    }

    if ($mes1 == 1) {
        $mesx1 = "ENERO";
    }
    if ($mes1 == 2) {
        $mesx1 = "FEBRERO";
    }
    if ($mes1 == 3) {
        $mesx1 = "MARZO";
    }
    if ($mes1 == 4) {
        $mesx1 = "ABRIL";
    }
    if ($mes1 == 5) {
        $mesx1 = "MAYO";
    }
    if ($mes1 == 6) {
        $mesx1 = "JUNIO";
    }
    if ($mes1 == 7) {
        $mesx1 = "JULIO";
    }
    if ($mes1 == 8) {
        $mesx1 = "AGOSTO";
    }
    if ($mes1 == 9) {
        $mesx1 = "SETIEMBRE";
    }
    if ($mes1 == 10) {
        $mesx1 = "OCTUBRE";
    }
    if ($mes1 == 11) {
        $mesx1 = "NOVIEMBRE";
    }
    if ($mes1 == 12) {
        $mesx1 = "DICIEMBRE";
    }
    ?>
    <body>
        <table width="930" border="0" align="center">
            <tr>
                <td><table width="914" border="0">
                        <tr>
                            <td width="260"><strong><?php echo $desemp ?></strong></td>
                            <td width="380"><div align="center"><strong>REPORTES MENSUALES</strong></div></td>
                            <td width="260"><div align="right"><strong>FECHA: <?php echo date('d-m-Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>

                    </table>
                    <table width="914" border="0">
                        <tr>
                            <td width="134">&nbsp;</td>
                            <td width="633"><div align="center">
                                    <b><?php if ($val == 1) { ?>DE: <?php
                                            echo $mesx;
                                            echo " ";
                                            echo $year;
                                            echo " A ";
                                            echo $mesx1;
                                            echo " ";
                                            echo $year1;
                                        }
                                        ?></b>
                                </div>
                            </td>
                            <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if ($tipo == 2) {  ////POR SUCURSAL
            if ($val == 1) {
                $i = 0;
                $c = 0;
                $t = 0;
                $o = 0;
                $count_s = 0;  ////cuenta sucursales
                $count_m = 0;  ////cuenta marcas
                $cant_reg = 0;
                $x = 0;
                //echo $dd;
                /////CANTIDAD DE SUCURSALES
                $sql = "SELECT sucursal FROM venta where invfec >= '$year-$mes-1' and invfec <= '$year1-$mes1-$dd' and invtot <> '0' and val_habil = '0' and estado = '0' group by sucursal";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $sucursales[$x] = $row[0];
                        $codloc = $sucursales[$x];
                        $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
                        $result1 = mysqli_query($conexion, $sql1);
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $nloc = $row1["nomloc"];
                            $nombre = $row1["nombre"];
                            if ($nombre == '') {
                                $nomsucursal[$x] = $nloc;
                            } else {
                                $nomsucursal[$x] = $nombre;
                            }
                        }
                        /////CANTIDAD DE TRANSACCIONES
                        $sqlll = "SELECT count(invnum) FROM venta where invfec >= '$year-$mes-1' and invfec <= '$year1-$mes1-$dd' and invtot <> '0' and sucursal = '$codloc' and estado = '0' and val_habil = '0' group by invnum";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $invslll[$t] = $rowlll[0];
                                $t++;
                                $count_t++;
                            }
                        }
                        /////CANTIDAD DE OPERACIONES
                        $sqlll = "SELECT count(detalle_venta.invnum) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year1-$mes1-$dd' and invtot <> '0' and sucursal = '$codloc' and estado = '0' and val_habil = '0'";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $detslll[$o] = $rowlll[0];
                                $o++;
                                $count_o++;
                            }
                        }
                        $x++;
                        $count_s++;
                    }
                }
                $x = 0;
                /////CANTIDAD DE MESES
                $sql = "SELECT month(invfec),year(invfec) FROM venta where invfec >= '$year-$mes-1' and invfec <= '$year1-$mes1-$dd' and estado = '0'  and invtot <> '0' and val_habil = '0' group by month(invfec),year(invfec)";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $meses[$x] = $row[0];
                        $anios[$x] = $row[1];
                        $x++;
                        $count_m++;
                    }
                }
                $i = 0;
                $sql = "SELECT month(invfec),year(invfec),sum(invtot),sucursal FROM venta where invfec >= '$year-$mes-1' and invfec <= '$year1-$mes1-$dd' and invtot <> '0' and val_habil = '0' and estado = '0' group by month(invfec),year(invfec),sucursal  order by invfec,sucursal";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $mesi[$i] = $row[0];
                        $yeari[$i] = $row[1];
                        $invtot[$i] = $row[2];
                        $sucursal[$i] = $row[3];
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 500;
                $column = 80;
                $tot_ancho = $column * $count_m;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php $c = 0;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="<?php echo $tot_ancho ?>" border="0" align="center">
                                    <tr>
                                        <td width="132"><strong>LOCAL</strong></td>
                                        <td width="115"><div align="right"><strong>N TRANSACCIONES</strong></div></td>
                                        <td width="115"><div align="right"><strong>N OPERACIONES</strong></div></td>
                                        <?php
                                        while ($c < $count_m) {
                                            ?>
                                            <td width="80">
                                                <div align="right">
                                                    <b>
                                                        <?php
                                                        //echo $mesi[0];
                                                        //echo "hola";
                                                        if ($meses[$c] == "1") {
                                                            echo "ENE ";
                                                        }
                                                        if ($meses[$c] == "2") {
                                                            echo "FEB ";
                                                        }
                                                        if ($meses[$c] == "3") {
                                                            echo "MAR ";
                                                        }
                                                        if ($meses[$c] == "4") {
                                                            echo "ABR ";
                                                        }
                                                        if ($meses[$c] == "5") {
                                                            echo "MAY ";
                                                        }
                                                        if ($meses[$c] == "6") {
                                                            echo "JUN ";
                                                        }
                                                        if ($meses[$c] == "7") {
                                                            echo "JUL ";
                                                        }
                                                        if ($meses[$c] == "8") {
                                                            echo "AGO ";
                                                        }
                                                        if ($meses[$c] == "9") {
                                                            echo "SET ";
                                                        }
                                                        if ($meses[$c] == "10") {
                                                            echo "OCT ";
                                                        }
                                                        if ($meses[$c] == "11") {
                                                            echo "NOV ";
                                                        }
                                                        if ($meses[$c] == "12") {
                                                            echo "DIC ";
                                                        }
                                                        //echo $mesi[$c];
                                                        ?>
                                                        <?php echo $yeari[$c] ?>		</b>
                                                </div>		</td>
                                            <?php
                                            $c++;
                                        }
                                        ?>
                                        <td width="58"><div align="right"><strong>TOTAL</strong></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 0;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomsucursal[$z] ?></td>
                                <td width="115"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <td width="115"><div align="right"><?php echo $detslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($sucursales[$z] == $sucursal[$v]) {
                                                    if (($meses[$c] == $mesi[$v]) and ( $anios[$c] == $yeari[$v])) {
                                                        echo $invtot[$v];
                                                        $sum_invtot = $sum_invtot + $invtot[$v];
                                                    }
                                                }
                                                $v++;
                                            }
                                            ?>
                                        </div>		</td>
                                    <?php
                                    $c++;
                                }
                                ?>
                                <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sum_invtot, 2, '.', ' '); ?></div></td>
                            </tr>
                            <?php
                            $sumcolumn_tot = $sumcolumn_tot + $sum_invtot; ////suma toda la columna totales
                            $z++;
                        }
                        ?>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="362" colspan="3"><b>TOTAL</b></td>
                            <?php
                            while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$meses[$c]' and year(invfec) = '$anios[$c]' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(invfec),year(invfec)";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sumcol = $row[0];
                                                echo $sumcol;
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <?php
                                $c++;
                            }
                            ?>
                            <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sumcolumn_tot, 2, '.', ' '); ?></div></td>
                        </tr>
                    </table>
                    <?php
                } else {
                    ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <?php ////////////////////////////////////////////////////////////////////
        ?>
        <?php
        if ($tipo == 4) {  ////POR LABORATORIO
            if ($val == 1) {
                $i = 0;
                $c = 0;
                $o = 0;
                $cantl = 0;
                $count_s = 0;  /////cuenta marcas
                $count_m = 0;  /////cuenta meses
                $cant_reg = 0;
                $x = 0;
                /////CANTIDAD DE SUCURSALES
                $sql = "SELECT codmar FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by codmar";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $codmars[$x] = $row[0];
                        $marca = $codmars[$x];
                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$marca'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nommarca[$x] = $row1[0];
                            }
                        }
                        $sumcantl = 0;
                        /////CANTIDADES
                        $sqlll = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec < '$year1-$mes1-$dd' and codmar = '$marca' and estado = '0' and val_habil = '0'";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $canprol = $rowlll[0];
                                $fraccionl = $rowlll[1];
                                $factorl = $rowlll[2];
                                if ($fraccionl == 'F') {
                                    $cantl = $canprol * $factorl;
                                } else {
                                    $cantl = $canprol;
                                }
                                $sumcantl = $sumcantl + $cantl;
                            }
                        }
                        $invslll[$x] = $sumcantl;
                        $x++;
                        $count_s++;
                    }
                }
                $x = 0;
                /////CANTIDAD DE MESES
                $sql = "SELECT month(venta.invfec),year(venta.invfec) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec)";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $meses[$x] = $row[0];
                        $anios[$x] = $row[1];
                        $x++;
                        $count_m++;
                    }
                }

                //$sql="SELECT month(venta.invfec),year(venta.invfec),sum(invtot),codmar FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and invtot <> '0' and venta.invfec < '$year1-$mes1-$dd' group by month(venta.invfec), year(venta.invfec), codmar";
                $sql = "SELECT month(venta.invfec),year(venta.invfec),codmar FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and invtot <> '0' and venta.invfec < '$year1-$mes1-$dd' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec), codmar";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $mesi[$i] = $row[0];
                        $yeari[$i] = $row[1];
                        //$invtot[$i]  = $row[2];
                        $codmar[$i] = $row[2];
                        $canprod = 0;
                        $fracciond = 0;
                        $factord = 0;
                        $prisald = 0;
                        $totd = 0;
                        $sumtotd = 0;
                        $sqlrr = "SELECT canpro,fraccion,factor,prisal FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where month(detalle_venta.invfec) = '$mesi[$i]' and  year(detalle_venta.invfec) = '$yeari[$i]' and codmar = '$codmar[$i]' and estado = '0' and val_habil = '0'";
                        $resultrr = mysqli_query($conexion, $sqlrr);
                        if (mysqli_num_rows($resultrr)) {
                            while ($rowrr = mysqli_fetch_array($resultrr)) {
                                $canprod = $rowrr[0];
                                $fracciond = $rowrr[1];
                                $factord = $rowrr[2];
                                $prisald = $rowrr[3];
                                if ($fracciond == "T") {
                                    $totd = $canprod * $prisald;
                                } else {
                                    $totd = ($canprod * $factord) * $prisald;
                                }
                                $sumtotd = $sumtotd + $totd;
                            }
                        }
                        $invtot[$i] = $sumtotd;
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 350;
                $column = 80;
                $tot_ancho = $column * $count_m;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php $c = 0;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="<?php echo $tot_ancho ?>" border="0" align="center">
                                    <tr>
                                        <td width="132"><strong>LABORATORIO</strong></td>
                                        <td width="80"><div align="right"><strong>CANTIDADES</strong></div></td>
                                        <?php
                                        while ($c < $count_m) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        if ($mesi[$c] == "1") {
                                                            echo "ENE ";
                                                        }
                                                        if ($mesi[$c] == "2") {
                                                            echo "FEB ";
                                                        }
                                                        if ($mesi[$c] == "3") {
                                                            echo "MAR ";
                                                        }
                                                        if ($mesi[$c] == "4") {
                                                            echo "ABR ";
                                                        }
                                                        if ($mesi[$c] == "5") {
                                                            echo "MAY ";
                                                        }
                                                        if ($mesi[$c] == "6") {
                                                            echo "JUN ";
                                                        }
                                                        if ($mesi[$c] == "7") {
                                                            echo "JUL ";
                                                        }
                                                        if ($mesi[$c] == "8") {
                                                            echo "AGO ";
                                                        }
                                                        if ($mesi[$c] == "9") {
                                                            echo "SET ";
                                                        }
                                                        if ($mesi[$c] == "10") {
                                                            echo "OCT ";
                                                        }
                                                        if ($mesi[$c] == "11") {
                                                            echo "NOV ";
                                                        }
                                                        if ($mesi[$c] == "12") {
                                                            echo "DIC ";
                                                        }
                                                        //echo $mesi[$c];
                                                        ?>
                                                        <?php echo $yeari[$c] ?>		</b>
                                                </div>		</td>
                                            <?php
                                            $c++;
                                        }
                                        ?>
                                        <td width="58"><div align="right"><strong>TOTAL</strong></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 0;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nommarca[$z] ?></td>
                                <td width="80"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($codmars[$z] == $codmar[$v]) {
                                                    if (($meses[$c] == $mesi[$v]) and ( $anios[$c] == $yeari[$v])) {
                                                        echo $invtot[$v];
                                                        $sum_invtot = $sum_invtot + $invtot[$v];
                                                    }
                                                }
                                                $v++;
                                            }
                                            ?>
                                        </div>		</td>
                                    <?php
                                    $c++;
                                }
                                ?>
                                <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sum_invtot, 2, '.', ' '); ?></div></td>
                            </tr>
                            <?php
                            $sumcolumn_tot = $sumcolumn_tot + $sum_invtot; ////suma toda la columna totales
                            $z++;
                        }
                        ?>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="212" colspan="2"><b>TOTAL</b></td>
                            <?php
                            while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$meses[$c]' and year(invfec) = '$anios[$c]' and invtot <> '0' and val_habil = '0' and estado = '0' group by month(invfec),year(invfec)";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sumcol = $row[0];
                                                echo $sumcol;
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <?php
                                $c++;
                            }
                            ?>
                            <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sumcolumn_tot, 2, '.', ' '); ?></div>
                            </td>
                        </tr>
                    </table>
                    <?php
                } else {
                    ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <?php ////////////////////////////////////////////////////////////////////
        ?>
        <?php
        if ($tipo == 3) {  ////POR PRODUCTO
            if ($val == 1) {
                $i = 0;
                $c = 0;
                $o = 0;
                $cantl = 0;
                $count_s = 0;  /////cuenta productos
                $count_m = 0;  /////cuenta meses
                $cant_reg = 0;
                $x = 0;
                /////CANTIDAD DE PRODUCTOS
                $sql = "SELECT codpro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by codpro";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $codpros[$x] = $row[0];
                        $producto = $codpros[$x];
                        $sql1 = "SELECT desprod FROM producto where codpro = '$producto'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nomprod[$x] = $row1[0];
                            }
                        }
                        $sumcantl = 0;
                        /////CANTIDADES
                        $sqlll = "SELECT canpro,fraccion,factor FROM detalle_venta where invfec >= '$year-$mes-1' and invfec < '$year1-$mes1-$dd' and codpro = '$producto'";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $canprol = $rowlll[0];
                                $fraccionl = $rowlll[1];
                                $factorl = $rowlll[2];
                                if ($fraccionl == 'F') {
                                    $cantl = $canprol * $factorl;
                                } else {
                                    $cantl = $canprol;
                                }
                                $sumcantl = $sumcantl + $cantl;
                            }
                        }
                        $invslll[$x] = $sumcantl;
                        $x++;
                        $count_s++;
                    }
                }
                $x = 0;
                /////CANTIDAD DE MESES
                $sql = "SELECT month(venta.invfec),year(venta.invfec) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec)";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $meses[$x] = $row[0];
                        $anios[$x] = $row[1];
                        $x++;
                        $count_m++;
                    }
                }
                $sql = "SELECT month(venta.invfec),year(venta.invfec),codpro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec), codpro";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $mesi[$i] = $row[0];
                        $yeari[$i] = $row[1];
                        //$invtot[$i]  = $row[2];
                        $codpro[$i] = $row[2];
                        $canprod = 0;
                        $fracciond = 0;
                        $factord = 0;
                        $prisald = 0;
                        $totd = 0;
                        $sumtotd = 0;
                        $sqlrr = "SELECT canpro,fraccion,factor,prisal FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where month(detalle_venta.invfec) = '$mesi[$i]' and  year(detalle_venta.invfec) = '$yeari[$i]' and codpro = '$codpro[$i]' and estado = '0' and val_habil = '0'";
                        $resultrr = mysqli_query($conexion, $sqlrr);
                        if (mysqli_num_rows($resultrr)) {
                            while ($rowrr = mysqli_fetch_array($resultrr)) {
                                $canprod = $rowrr[0];
                                $fracciond = $rowrr[1];
                                $factord = $rowrr[2];
                                $prisald = $rowrr[3];
                                if ($fracciond == "T") {
                                    $totd = $canprod * $prisald;
                                } else {
                                    $totd = ($canprod * $factord) * $prisald;
                                }
                                $sumtotd = $sumtotd + $totd;
                            }
                        }
                        $invtot[$i] = $sumtotd;
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 350;
                $column = 80;
                $tot_ancho = $column * $count_m;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php $c = 0;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="<?php echo $tot_ancho ?>" border="0" align="center">
                                    <tr>
                                        <td width="132"><strong>PRODUCTO</strong></td>
                                        <td width="80"><div align="right"><strong>CANTIDADES</strong></div></td>
                                        <?php
                                        while ($c < $count_m) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        if ($mesi[$c] == "1") {
                                                            echo "ENE ";
                                                        }
                                                        if ($mesi[$c] == "2") {
                                                            echo "FEB ";
                                                        }
                                                        if ($mesi[$c] == "3") {
                                                            echo "MAR ";
                                                        }
                                                        if ($mesi[$c] == "4") {
                                                            echo "ABR ";
                                                        }
                                                        if ($mesi[$c] == "5") {
                                                            echo "MAY ";
                                                        }
                                                        if ($mesi[$c] == "6") {
                                                            echo "JUN ";
                                                        }
                                                        if ($mesi[$c] == "7") {
                                                            echo "JUL ";
                                                        }
                                                        if ($mesi[$c] == "8") {
                                                            echo "AGO ";
                                                        }
                                                        if ($mesi[$c] == "9") {
                                                            echo "SET ";
                                                        }
                                                        if ($mesi[$c] == "10") {
                                                            echo "OCT ";
                                                        }
                                                        if ($mesi[$c] == "11") {
                                                            echo "NOV ";
                                                        }
                                                        if ($mesi[$c] == "12") {
                                                            echo "DIC ";
                                                        }
                                                        //echo $mesi[$c];
                                                        ?>
                                                        <?php echo $yeari[$c] ?>
                                                    </b>
                                                </div>
                                            </td>
                                            <?php
                                            $c++;
                                        }
                                        ?>
                                        <td width="58"><div align="right"><strong>TOTAL</strong></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 0;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomprod[$z] ?></td>
                                <td width="80"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($codpros[$z] == $codpro[$v]) {
                                                    if (($meses[$c] == $mesi[$v]) and ( $anios[$c] == $yeari[$v])) {
                                                        echo $invtot[$v];
                                                        $sum_invtot = $sum_invtot + $invtot[$v];
                                                    }
                                                }
                                                $v++;
                                            }
                                            ?>
                                        </div>		</td>
                                    <?php
                                    $c++;
                                }
                                ?>
                                <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sum_invtot, 2, '.', ' '); ?></div></td>
                            </tr>
                            <?php
                            $sumcolumn_tot = $sumcolumn_tot + $sum_invtot; ////suma toda la columna totales
                            $z++;
                        }
                        ?>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="212" colspan="2"><b>TOTAL</b></td>
                            <?php
                            while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$meses[$c]' and year(invfec) = '$anios[$c]' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(invfec),year(invfec)";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sumcol = $row[0];
                                                echo $sumcol;
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <?php
                                $c++;
                            }
                            ?>
                            <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sumcolumn_tot, 2, '.', ' '); ?></div>
                            </td>
                        </tr>
                    </table>
                    <?php
                } else {
                    ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <?php ////////////////////////////////////////////////////////////////////
        ?>
        <?php
        if ($tipo == 5) {  ////POR USUARIO
            if ($val == 1) {
                $i = 0;
                $c = 0;
                $t = 0;
                $o = 0;
                $count_s = 0;  /////cuenta usuarios
                $count_m = 0;  /////cuenta meses
                $cant_reg = 0;
                $x = 0;
                /////CANTIDAD DE USUARIOS
                $sql = "SELECT usecod FROM venta where venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by usecod";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $usecods[$x] = $row[0];
                        $usuario = $usecods[$x];
                        $sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nomuser[$x] = $row1[0];
                            }
                        }
                        /////CANTIDAD DE TRANSACCIONES
                        $sqlll = "SELECT count(invnum) FROM venta where invfec >= '$year-$mes-1' and invfec < '$year1-$mes1-$dd' and invtot <> '0' and usecod = '$usuario' and estado = '0' and val_habil = '0' group by invnum";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $invslll[$t] = $rowlll[0];
                                $t++;
                                $count_t++;
                            }
                        }
                        /////CANTIDAD DE OPERACIONES
                        $sqlll = "SELECT count(detalle_venta.invnum) FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec < '$year1-$mes1-$dd' and detalle_venta.usecod = '$usuario' and estado = '0' and val_habil = '0'";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $detslll[$o] = $rowlll[0];
                                $o++;
                                $count_o++;
                            }
                        }
                        $x++;
                        $count_s++;
                    }
                }
                $x = 0;
                /////CANTIDAD DE MESES
                $sql = "SELECT month(venta.invfec),year(venta.invfec) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec)";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $meses[$x] = $row[0];
                        $anios[$x] = $row[1];
                        $x++;
                        $count_m++;
                    }
                }
                $sql = "SELECT month(invfec),year(invfec),sum(invtot),usecod FROM venta where  venta.invfec >= '$year-$mes-1' and venta.invfec < '$year1-$mes1-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(invfec),year(invfec),usecod";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $mesi[$i] = $row[0];
                        $yeari[$i] = $row[1];
                        $invtot[$i] = $row[2];
                        $usecod[$i] = $row[3];
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 500;
                $column = 80;
                $tot_ancho = $column * $count_m;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php $c = 0;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="<?php echo $tot_ancho ?>" border="0" align="center">
                                    <tr>
                                        <td width="132"><strong>USUARIO</strong></td>
                                        <td width="115"><div align="right"><strong>N TRANSACCIONES</strong></div></td>
                                        <td width="115"><div align="right"><strong>N OPERACIONES</strong></div></td>
                                        <?php
                                        while ($c < $count_m) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        if ($meses[$c] == "1") {
                                                            echo "ENE ";
                                                        }
                                                        if ($meses[$c] == "2") {
                                                            echo "FEB ";
                                                        }
                                                        if ($meses[$c] == "3") {
                                                            echo "MAR ";
                                                        }
                                                        if ($meses[$c] == "4") {
                                                            echo "ABR ";
                                                        }
                                                        if ($meses[$c] == "5") {
                                                            echo "MAY ";
                                                        }
                                                        if ($meses[$c] == "6") {
                                                            echo "JUN ";
                                                        }
                                                        if ($meses[$c] == "7") {
                                                            echo "JUL ";
                                                        }
                                                        if ($meses[$c] == "8") {
                                                            echo "AGO ";
                                                        }
                                                        if ($meses[$c] == "9") {
                                                            echo "SET ";
                                                        }
                                                        if ($meses[$c] == "10") {
                                                            echo "OCT ";
                                                        }
                                                        if ($meses[$c] == "11") {
                                                            echo "NOV ";
                                                        }
                                                        if ($meses[$c] == "12") {
                                                            echo "DIC ";
                                                        }
                                                        //echo $mesi[$c];
                                                        ?>
                                                        <?php echo $yeari[$c] ?>
                                                    </b>
                                                </div>
                                            </td>
                                            <?php
                                            $c++;
                                        }
                                        ?>
                                        <td width="58"><div align="right"><strong>TOTAL</strong></div></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 0;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomuser[$z] ?></td>
                                <td width="115"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <td width="115"><div align="right"><?php echo $detslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($usecods[$z] == $usecod[$v]) {
                                                    if (($meses[$c] == $mesi[$v]) and ( $anios[$c] == $yeari[$v])) {
                                                        echo $invtot[$v];
                                                        $sum_invtot = $sum_invtot + $invtot[$v];
                                                    }
                                                }
                                                $v++;
                                            }
                                            ?>
                                        </div>		</td>
                                    <?php
                                    $c++;
                                }
                                ?>
                                <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sum_invtot, 2, '.', ' '); ?></div></td>
                            </tr>
                            <?php
                            $sumcolumn_tot = $sumcolumn_tot + $sum_invtot; ////suma toda la columna totales
                            $z++;
                        }
                        ?>
                    </table>
                    <?php
                    $c = 0;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $count_m;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="362" colspan="3"><b>TOTAL</b></td>
                            <?php
                            while ($c < $count_m) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$meses[$c]' and year(invfec) = '$anios[$c]' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(invfec),year(invfec)";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $sumcol = $row[0];
                                                echo $sumcol;
                                            }
                                        }
                                        ?>
                                    </div>
                                </td>
                                <?php
                                $c++;
                            }
                            ?>
                            <td width="58"><div align="right"><?php echo $numero_formato_frances = number_format($sumcolumn_tot, 2, '.', ' '); ?></div>
                            </td>
                        </tr>
                    </table>
                    <?php
                } else {
                    ?>
                    <div class="siniformacion">
                        <center>
                            No se logro encontrar informacion con los datos ingresados
                        </center>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </body>
</html>
