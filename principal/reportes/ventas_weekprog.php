<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
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
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    $sql = "SELECT * FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
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
    $val = $_REQUEST['val'];
    $year = $_REQUEST['year'];
    $mes = $_REQUEST['mes'];
    $tipo = $_REQUEST['tipo'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $registros = $_REQUEST['registros'];
    $registros = 40;
    $pagina = $_REQUEST["pagina"];
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $registros;
    }

    function getMonthDays($Month, $Year) {
        //Si la extensi�n que mencion� est� instalada, usamos esa. 
        if (is_callable("cal_days_in_month")) {
            return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
        } else {
            //Lo hacemos a mi manera. 
            return date("d", mktime(0, 0, 0, $Month + 1, 0, $Year));
        }
    }

    function diaL($mes, $years) {
        if (trim($mes) != "") {
            $cant_dias = date('t', strtotime($years . $mes . '-' . '01-'));
            $lunes = 0;
            for ($i = 1; $i <= $cant_dias; $i++) {
                if (date('w', strtotime($years . '-' . $mes . '-' . $i)) == 6) {
                    $lunes++;
                }
            }

            return $lunes;
        } else {
            return 'Malll';
        }
    }

    $dd = getMonthDays($mes, $year);
    $weeks = diaL($mes, $year);
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
    ?>
    <body>
        <table width="930" border="0" align="center">
            <tr>
                <td><table width="914" border="0">
                        <tr>
                            <td width="260"><strong><?php echo $desemp ?></strong></td>
                            <td width="380"><div align="center"><strong>REPORTES MENSUALES</strong></div></td>
                            <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>

                    </table>
                    <table width="914" border="0">
                        <tr>
                            <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                            <td width="633"><div align="center">
                                    <b><?php if ($val == 1) { ?>DE: <?php
                                            echo $mesx;
                                            echo " ";
                                            echo $year;
                                        }
                                        ?></b>
                                </div>
                            </td>
                            <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <div align="center"></div></td>
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
                /////CANTIDAD DE SUCURSALES
                $sql = "SELECT sucursal FROM venta where invfec >= '$year-$mes-1' and invtot <> '0' and invfec <= '$year-$mes-$dd' and estado = '0' and val_habil = '0' group by sucursal";
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
                        $sqlll = "SELECT count(invnum) FROM venta where invfec >= '$year-$mes-1' and invtot <> '0' and invfec <= '$year-$mes-$dd' and sucursal = '$codloc' and val_habil = '0' and estado = '0' group by invnum";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $invslll[$t] = $rowlll[0];
                                $t++;
                                $count_t++;
                            }
                        }
                        /////CANTIDAD DE OPERACIONES
                        $sqlll = "SELECT count(detalle_venta.invnum) FROM detalle_venta inner join venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' and sucursal = '$codloc'";
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
                $sql = "SELECT month(invfec),year(invfec),sum(invtot),sucursal,semana FROM venta where invfec >= '$year-$mes-1' and invtot <> '0' and invfec <= '$year-$mes-$dd' and estado = '0' and val_habil = '0' group by month(invfec),year(invfec),sucursal,semana  order by sucursal";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        //$mm			 = $row[0];
                        //$yy			 = $row[1];
                        //$mesi[$i]    = $row[0];
                        //$yeari[$i]   = $row[1];
                        $invtot[$i] = $row[2];
                        $sucursal[$i] = $row[3];
                        $semana[$i] = $row[4];
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 500;
                $column = 80;
                $tot_ancho = $column * $weeks;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php
                    $c = 0;
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
                                        while ($c < $weeks) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        $print = $c + 1;
                                                        echo '<center>' . $print . '</center>';
                                                        $semanas[$c] = $c;
                                                        //echo $mesi[$c];
                                                        ?>
                                                    </b>
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
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 1;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomsucursal[$z] ?></td>
                                <td width="115"><div align="right"><center><?php echo $invslll[$z] ?></center></div></td>
                                <td width="115"><div align="right"><center><?php echo $detslll[$z] ?></center></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c <= $weeks) {  ////// imprimo columnas - cantidad de semanas
                                    $v = 0;
                                    //echo $c;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            //echo $c;
                                            /* if ($semanas[$z] == $c)
                                              {
                                              echo $invtot[$z];
                                              $sum_invtot = $sum_invtot + $invtot[$z];
                                              } */
                                            //echo $invtot[$z];
                                            while ($v < $cant_reg) {
                                                //echo $v; echo " ";
                                                //echo $invtot[$z]; echo " ";
                                                if ($sucursales[$z] == $sucursal[$v]) {
                                                    //if ($semanas[$c] == $v)
                                                    //echo $sucursal[$z]; echo " -";
                                                    if ($semanas[$c] == $semana[$v]) {
                                                        //echo $c; echo " h-";
                                                        echo $invtot[$v];
                                                        $sum_invtot = $sum_invtot + $invtot[$v];
                                                    }
                                                }
                                                $v++;
                                            }
                                            ?>
                                        </div>		
                                    </td>
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
                    $c = 1;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="3" width="362"><b>TOTAL</b></td>
                            <?php
                            while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$mes' and year(invfec) = '$year' and semana = '$c' and estado = '0' and val_habil = '0' group by semana";
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
                $sql = "SELECT codmar FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by codmar";
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
                        $sqlll = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec <= '$year-$mes-$dd' and codmar = '$marca' and estado = '0' and val_habil = '0'";
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
                //$sql="SELECT month(venta.invfec),year(venta.invfec),sum(invtot),codmar,sucursal FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec), codmar, sucursal";
                $sql = "SELECT codmar,semana FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec), codmar, semana";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        //$mesi[$i]    = $row[0];
                        //$yeari[$i]   = $row[1];
                        $codmar[$i] = $row[0];
                        $semana[$i] = $row[1];
                        $canprod = 0;
                        $fracciond = 0;
                        $factord = 0;
                        $prisald = 0;
                        $totd = 0;
                        $sumtotd = 0;
                        $sqlrr = "SELECT canpro,fraccion,factor,prisal FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where semana = '$semana[$i]' and codmar = '$codmar[$i]' and estado = '0' and val_habil = '0'";
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
                $tot_ancho = $column * $weeks;
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
                                        while ($c < $weeks) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        $semanas[$c] = $c;
                                                        $print = $c + 1;
                                                        echo '<center>' . $print . '</center>';
                                                        //echo $mesi[$c];
                                                        ?>
                                                    </b>
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
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 1;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nommarca[$z] ?></td>
                                <td width="80"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($codmars[$z] == $codmar[$v]) {
                                                    if ($semanas[$c] == $semana[$v]) {
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
                    $c = 1;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" width="212"><b>TOTAL</b></td>
                            <?php
                            while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$mes' and year(invfec) = '$year' and invtot <> '0' and estado = '0' and val_habil = '0' and semana = '$c' group by semana";
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
                $sql = "SELECT codpro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where  venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by codpro";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $codpros[$x] = $row[0];
                        $producto = $codpros[$x];
                        $sql1 = "SELECT desprod FROM producto where codpro = '$producto' and eliminado='0'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $nomprod[$x] = $row1[0];
                            }
                        }
                        $sumcantl = 0;
                        /////CANTIDADES
                        $sqlll = "SELECT canpro,fraccion,factor FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec <= '$year-$mes-$dd' and codpro = '$producto' and estado = '0' and val_habil = '0'";
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
                //$sql="SELECT month(venta.invfec),year(venta.invfec),sum(invtot),codpro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by month(venta.invfec), year(venta.invfec), codpro";
                $sql = "SELECT codpro,semana FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by semana, codpro";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        //$mesi[$i]    = $row[0];
                        //$yeari[$i]   = $row[1];
                        //$invtot[$i]  = $row[2];
                        $codpro[$i] = $row[0];
                        //$mm			 = $row[0];
                        //$yy			 = $row[1];
                        $semana[$i] = $row[1];
                        $canprod = 0;
                        $fracciond = 0;
                        $factord = 0;
                        $prisald = 0;
                        $totd = 0;
                        $sumtotd = 0;
                        $sqlrr = "SELECT canpro,fraccion,factor,prisal FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where semana = '$semana[$i]' and codpro = '$codpro[$i]' and estado = '0' and val_habil = '0'";
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
                $tot_ancho = $column * $weeks;
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
                                        while ($c < $weeks) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        $print = $c + 1;
                                                        echo '<center>' . $print . '</center>';
                                                        $semanas[$c] = $c;
                                                        //echo $mesi[$c];
                                                        ?>
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
                    $c = 1;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 1;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomprod[$z] ?></td>
                                <td width="80"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($codpros[$z] == $codpro[$v]) {
                                                    if ($semanas[$c] == $semana[$v]) {
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
                    $c = 1;
                    $z = 0;
                    $ancho = 350;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="2" width="212"><b>TOTAL</b></td>
                            <?php
                            while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$mes' and year(invfec) = '$year' and semana = '$c' and estado = '0' and val_habil = '0' group by semana";
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
                $sql = "SELECT usecod FROM venta where venta.invfec >= '$year-$mes-1' and venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and estado = '0' and val_habil = '0' group by usecod";
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
                        $sqlll = "SELECT count(detalle_venta.invnum) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec <= '$year-$mes-$dd' and invtot <> '0' and detalle_venta.usecod = '$usuario' and estado = '0' and val_habil = '0' group by venta.invnum";
                        $resultlll = mysqli_query($conexion, $sqlll);
                        if (mysqli_num_rows($resultlll)) {
                            while ($rowlll = mysqli_fetch_array($resultlll)) {
                                $invslll[$t] = $rowlll[0];
                                $t++;
                                $count_t++;
                            }
                        }
                        /////CANTIDAD DE OPERACIONES
                        $sqlll = "SELECT count(detalle_venta.invnum) FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec >= '$year-$mes-1' and detalle_venta.invfec <= '$year-$mes-$dd' and detalle_venta.usecod = '$usuario' and estado = '0' and val_habil = '0'";
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
                $sql = "SELECT month(venta.invfec),year(venta.invfec),sum(invtot),usecod,semana FROM venta where venta.invfec >= '$year-$mes-1' and invtot <> '0' and venta.invfec <= '$year-$mes-$dd' and estado = '0' and val_habil = '0' group by month(venta.invfec),year(venta.invfec),usecod,semana";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        //$mesi[$i]    = $row[0];
                        //$yeari[$i]   = $row[1];
                        $invtot[$i] = $row[2];
                        $usecod[$i] = $row[3];
                        //$mm			 = $row[0];
                        //$yy			 = $row[1];
                        $semana[$i] = $row[4];
                        $i++;
                        $cant_reg++;
                    }
                }
                //echo $mesi[0];
                $ancho = 500;
                $column = 80;
                $tot_ancho = $column * $weeks;
                $tot_ancho = $ancho + $tot_ancho;
                if ($i <> 0) {
                    ?>
                    <?php
                    $c = 0;
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
                                        while ($c < $weeks) {
                                            ?>
                                            <td width="80"><div align="right">
                                                    <b>
                                                        <?php
                                                        $print = $c + 1;
                                                        echo '<center>' . $print . '</center>';
                                                        $semanas[$c] = $c;
                                                        //echo $mesi[$c];
                                                        ?>
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
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <?php
                        while ($z < $count_s) { ///// imprimo filas - cantidad de sucursales 
                            $c = 1;
                            ?>
                            <tr>
                                <td width="132"><?php echo $nomuser[$z] ?></td>
                                <td width="115"><div align="right"><?php echo $invslll[$z] ?></div></td>
                                <td width="115"><div align="right"><?php echo $detslll[$z] ?></div></td>
                                <?php
                                $sum_invtot = 0;
                                while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                    $v = 0;
                                    ?>
                                    <td width="80">
                                        <div align="right">
                                            <?php
                                            while ($v < $cant_reg) {
                                                if ($usecods[$z] == $usecod[$v]) {
                                                    if ($semanas[$c] == $semana[$v]) {
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
                    $c = 1;
                    $z = 0;
                    $ancho = 500;
                    $column = 80;
                    $sumcol = 0;
                    $tot_ancho = $column * $weeks;
                    $tot_ancho = $ancho + $tot_ancho;
                    ?>
                    <table width="<?php echo $tot_ancho + 4; ?>" border="1" cellpadding="0" cellspacing="0">
                        <tr>
                            <td colspan="3" width="362"><b>TOTAL</b></td>
                            <?php
                            while ($c <= $weeks) {  ////// imprimo columnas - cantidad de meses
                                $v = 0;
                                ?>
                                <td width="80">
                                    <div align="right">
                                        <?php
                                        $sql = "SELECT sum(invtot) FROM venta where month(invfec) = '$mes' and year(invfec) = '$year' and semana = '$c' and estado = '0' and val_habil = '0' group by semana";
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
