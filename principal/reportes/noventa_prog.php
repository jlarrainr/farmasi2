<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
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
        <style type="text/css">
            <!--
            .Estilo1 {
                color: #FF0000;
                font-weight: bold;
            }
            -->
        </style>
    </head>
    <?php
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    $sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $user = $row['nomusu'];
        }
    }
    $date = date('d/m/Y');
    $hour = date(G);
//$hour   = CalculaHora($hour);
    $min = date(i);
    if ($hour <= 12) {
        $hor = "am";
    } else {
        $hor = "pm";
    }
    $val = $_REQUEST['val'];
    $date1 = $_REQUEST['date1'];
    $date2 = $_REQUEST['date2'];
    $local = $_REQUEST['local'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $resumen = $_REQUEST['resumen'];
    $registros = $_REQUEST['registros'];
    $dat1 = $date1;
    $dat2 = $date2;
    $date1 = fecha1($date1);
    $date2 = fecha1($date2);
    if ($resumen == 1) {
        $desc_resumen = "RESUMEN POR SUCURSAL";
    }
    if ($resumen == 2) {
        $desc_resumen = "RESUMEN POR VENDEDOR";
    }
    if ($resumen == 3) {
        $desc_resumen = "RESUMEN POR MARCA";
    }
    if ($resumen == 4) {
        $desc_resumen = "RESUMEN POR PRODUCTO";
    }
    if ($resumen == 5) {
        $desc_resumen = "RESUMEN POR LINEA Y USO DEL PRODUCTO";
    }
    if ($local <> 'all') {
        $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomloc = $row['nomloc'];
                $nombre = $row['nombre'];
                if ($nombre <> "") {
                    $nomloc = $nombre;
                }
            }
        }
    }
    ?>
   <body>
        <table width="100%" border="0" align="center">
            <tr>
                <td><table width="100%" border="0">
                        <tr>
                            <td width="260"><strong><?php echo $desemp ?> </strong></td>
                            <td width="380"><div align="center"><strong>REPORTE DE VENTAS NO REALIZADAS - 
                                        <?php
                                        if ($local == 'all') {
                                            echo 'TODAS LAS SUCURSALES';
                                        } else {
                                            echo $nomloc;
                                        }
                                        ?>
                                    </strong></div></td>
                            <td width="260"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>

                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                            <td width="633"><div align="center"><b><?php if ($val == 1) { ?>FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php
                                            echo $dat2;
                                        }
                                        ?></b></div></td>
                            <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if (($val == 1) && ($resumen == 1)) {
            ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave.invfec between '$date1' and '$date2'  group by sucursal ";
                        } else {
                            $sql = "SELECT sucursal,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave.invfec between '$date1' and '$date2'  and sucursal = '$local' group by sucursal ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">

                                <tr>
                                    <th width="674"><strong>SUCURSAL</strong></th>
                                    <th width="165"><div align="right"><strong>CANTIDAD (U) </strong></div></th>
                                    <th width="73"><div align="right"><strong>TOTAL</strong></div></th>
                                </tr>

                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    //$invtot    = $row[1];
                                    $canpro = 0;
                                    $factor = 0;
                                    $sumcanpro = 0;
                                    $sumpripro = 0;
                                    $fraccion = "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro,codmed FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2' ";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro,codmed FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local'";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];
                                            $pripro = $row1['pripro'];
                                            $codmed = $row1['codmed'];
                                            if ($fraccion == 'T') {
                                                $sumcanpro = $sumcanpro + $canpro;
                                            } else {
                                                $canpro = $canpro * $factor;
                                                $sumcanpro = $sumcanpro + $canpro;
                                            }
                                            $sumpripro = $sumpripro + $pripro;
                                        }
                                    }

                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="674"><?php echo $sucursal ?></td>
                                        <td width="165"><div align="right"><?php echo $sumcanpro ?></div></td>
                                        <td width="73"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
        <?php
        if (($val == 1) && ($resumen == 2)) {
            ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,usecod,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  group by sucursal,usecod ";
                        } else {
                            $sql = "SELECT sucursal,usecod,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' group by sucursal,usecod ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">

                                <tr>
                                    <th width="151"><strong>SUCURSAL</strong></th>
                                    <th width="600"><strong>VENDEDOR</strong></th>
                                    <th width="550"><strong>MEDICO</strong></th>
                                    <th width="94"><div align="right"><strong>CANTIDAD (U) </strong></div></th>
                                    <th width="113"><div align="right"><strong>TOTAL</strong></div></th>
                                </tr>

                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $usecod = $row['usecod'];
                                    //$invtot    = $row[2];
                                    $canpro = 0;
                                    $factor = 0;
                                    $sumcanpro = 0;
                                    $sumpripro = 0;
                                    $fraccion = "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro,codmed FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and usecod = '$usecod'";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro,codmed FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' and usecod = '$usecod'";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];
                                            $pripro = $row1['pripro'];
                                            $codmed = $row1['codmed'];
                                            if ($fraccion == 'T') {
                                                $sumcanpro = $sumcanpro + $canpro;
                                            } else {
                                                $canpro = $canpro * $factor;
                                                $sumcanpro = $sumcanpro + $canpro;
                                            }
                                            $sumpripro = $sumpripro + $pripro;
                                        }
                                    }
                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    $sql1 = "SELECT nommedico,codcolegiatura FROM medico where codmed = '$codmed'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $nommedico = $row1['nommedico'];
                                            $codcolegiatura = $row1['codcolegiatura'];
                                        }
                                    }
                                    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $user = $row1['nomusu'];
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="151"><?php echo $sucursal ?></td>
                                        <td width="550"><?php echo $user ?></td>
                                        <td width="550"><?php echo $nommedico ?></td>
                                        <td width="94"><div align="right"><?php echo $sumcanpro ?></div></td>
                                        <td width="113"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
        <?php
        if (($val == 1) && ($resumen == 3)) {
            ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,codmar,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  group by sucursal,codmar ";
                        } else {
                            $sql = "SELECT sucursal,codmar,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' group by sucursal,codmar ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">

                                <tr>
                                    <th width="151"><strong>SUCURSAL</strong></th>
                                    <th width="550"><strong>MARCA</strong></th>
                                    <th width="94"><div align="right"><strong>CANTIDAD (U) </strong></div></th>
                                    <th width="113"><div align="right"><strong>TOTAL</strong></div></th>
                                </tr>



                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codmar = $row['codmar'];
                                    //$invtot    = $row[2];
                                    $canpro = 0;
                                    $factor = 0;
                                    $sumcanpro = 0;
                                    $sumpripro = 0;
                                    $fraccion = "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and codmar = '$codmar'";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' and codmar = '$codmar'";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];
                                            $pripro = $row1['pripro'];
                                            if ($fraccion == 'T') {
                                                $sumcanpro = $sumcanpro + $canpro;
                                            } else {
                                                $canpro = $canpro * $factor;
                                                $sumcanpro = $sumcanpro + $canpro;
                                            }
                                            $sumpripro = $sumpripro + $pripro;
                                        }
                                    }
                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $marca = $row1['destab'];
                                            $abrev = $row1['abrev'];
                                            if ($abrev <> '') {
                                                $marca = $abrev;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="151"><?php echo $sucursal ?></td>
                                        <td width="550"><?php echo $marca ?></td>
                                        <td width="94"><div align="right"><?php echo $sumcanpro ?></div></td>
                                        <td width="113"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
        <?php
        if (($val == 1) && ($resumen == 4)) {
            ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,codpro,codmar,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  group by sucursal,codpro,codmar ";
                        } else {
                            $sql = "SELECT sucursal,codpro,codmar,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' group by sucursal,codpro,codmar ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">

                                <tr>
                                    <th width="151"><strong>SUCURSAL</strong></th>
                                    <th width="163"><div align="left"><strong>MARCA</strong></div></th>
                                    <th width="402"><div align="left"><strong>PRODUCTO</strong></div></th>
                                    <th width="102"><div align="right"><strong>CANTIDAD (U) </strong></div></th>
                                    <th width="86"><div align="right"><strong>TOTAL</strong></div></th>
                                </tr>


                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codpro = $row['codpro'];
                                    $codmar = $row['codmar'];
                                    //$invtot    = $row[3];
                                    $canpro = 0;
                                    $factor = 0;
                                    $sumcanpro = 0;
                                    $sumpripro = 0;
                                    $fraccion = "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and codpro = '$codpro' and codmar = '$codmar'";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' and codpro = '$codpro' and codmar = '$codmar'";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];
                                            $pripro = $row1['pripro'];

                                            if ($fraccion == 'T') {
                                                $sumcanpro = $sumcanpro + $canpro;
                                            } else {
                                                $canpro = $canpro * $factor;
                                                $sumcanpro = $sumcanpro + $canpro;
                                            }
                                            $sumpripro = $sumpripro + $pripro;
                                        }
                                    }
                                    ///////USUARIO QUE REALIZA LA VENTA
                                    $sql1 = "SELECT desprod FROM producto where codpro = '$codpro' and eliminado='0'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $nomprod = $row1['desprod'];
                                        }
                                    }
                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $marca = $row1['destab'];
                                            $abrev = $row1['abrev'];
                                            if ($abrev <> '') {
                                                $marca = $abrev;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="151"><?php echo $sucursal ?></td>
                                        <td width="163"><div align="left"><?php echo $marca ?></div></td>
                                        <td width="402"><div align="left"><?php echo $nomprod; ?></div></td>
                                        <td width="102"><div align="right"><?php echo $sumcanpro; ?></div></td>
                                        <td width="86"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
        <?php
        if (($val == 1) && ($resumen == 5)) {
            ?>


            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,codfam,coduso,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  group by sucursal,codfam,coduso ";
                        } else {
                            $sql = "SELECT sucursal,codfam,coduso,sum(invtot) FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' group by sucursal,codfam,coduso ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="143"><strong>SUCURSAL</strong></th>
                                    <th width="214"><div align="left"><strong>LINEA</strong></div></th>
                                    <th width="360"><div align="left"><strong>USO DEL PRODUCTO</strong></div></th>
                                    <th width="101"><div align="right"><strong>CANTIDAD (U) </strong></div></th>
                                    <th width="86"><div align="right"><strong>TOTAL</strong></div></th>
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codfam = $row['codfam'];
                                    $coduso = $row['coduso'];
                                    //$invtot    = $row[3];
                                    $canpro = 0;
                                    $factor = 0;
                                    $sumcanpro = 0;
                                    $sumpripro = 0;
                                    $fraccion = "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and coduso = '$coduso' and codfam = '$codfam'";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave_detalle.invfec between '$date1' and '$date2'  and sucursal = '$local' and coduso = '$coduso' and codfam = '$codfam'";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];
                                            $pripro = $row1['pripro'];
                                            if ($fraccion == 'T') {
                                                $sumcanpro = $sumcanpro + $canpro;
                                            } else {
                                                $canpro = $canpro * $factor;
                                                $sumcanpro = $sumcanpro + $canpro;
                                            }
                                            $sumpripro = $sumpripro + $pripro;
                                        }
                                    }
                                    $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                            $nombre = $row1['nombre'];
                                            if ($nombre <> "") {
                                                $sucursal = $nombre;
                                            }
                                        }
                                    }
                                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codfam'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $familia = $row1['destab'];
                                            $abrev = $row1['abrev'];
                                            if ($abrev <> '') {
                                                $familia = $abrev;
                                            }
                                        }
                                    }
                                    $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$coduso'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $uso = $row1['destab'];
                                            $abrev1 = $row1['abrev'];
                                            if ($abrev1 <> '') {
                                                $uso = $abrev1;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="143"><?php echo $sucursal ?></td>
                                        <td width="214"><div align="left"><?php echo $familia ?></div></td>
                                        <td width="360"><div align="left"><?php echo $uso; ?></div></td>
                                        <td width="101"><div align="right"><?php echo $sumcanpro; ?></div></td>
                                        <td width="86"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                            <?php
                        } else {
                            ?>
                            <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
        <?php } ///CIERRE DE VAL = 1
        ?>
    </body>
</html>
