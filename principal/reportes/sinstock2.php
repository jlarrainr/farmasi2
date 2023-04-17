<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desemp ?></title>
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <link href="css/tablas.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            .Estilo1 {
                color: #FF0000;
                font-weight: bold;
            }
            -->
        </style>
        <style>

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;

            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                padding: 3px;

            }

            #customers tr:nth-child(even){background-color: #f0ecec;}

            #customers tr:hover {background-color: #ddd;}

            #customers th {

                text-align: center;
                background-color: #50ADEA;
                color: white;
                font-size:12px;
                font-weight: 900;
            }
        </style>
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
    $resumen = $_REQUEST['resumen'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $registros = $_REQUEST['registros'];
    $dat1 = $date1;
    $dat2 = $date2;
    $date1 = fecha1($date1);
    $date2 = fecha1($date2);
    if ($local <> 'all') {
        $sql = "SELECT nomloc FROM xcompa where codloc = '$local'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $nomloc = $row['nomloc'];
            }
        }
    }
    ?>
    <body>
        <table width="100%" border="0" align="center">
            <tr>
                <td><table width="100%" border="0">
                        <tr>
                            <td width="275" valign="top"><strong><?php echo $desemp ?> </strong></td>
                            <td width="405"><div align="center"><strong>PRODUCTOS NO VENDIDOS POR FALTA DE STOCK- 
                                        <?php
                                        if ($local == 'all') {
                                            echo 'TODAS LAS SUCURSALES';
                                        } else {
                                            echo $nomloc;
                                        }
                                        ?>
                                    </strong></div></td>
                            <td width="220" valign="top"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>

                    </table>
                    <table width="100%" border="0">
                        <tr>
                            <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                            <td width="633"><div align="center"><b><?php if ($val == 1) { ?>FECHAS ENTRE EL <?php echo fecha($date1); ?> Y EL <?php
                                            echo fecha($date2);
                                        }
                                        ?></b></div></td>
                            <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div></td>
            </tr>
        </table>
        <?php
        if (($val == 1) && ($resumen == 1)) {
            ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' group by sucursal LIMIT $inicio, $registros";
                        } else {
                            $sql = "SELECT sucursal,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' and sucursal = '$local' group by sucursal LIMIT $inicio, $registros";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="806"><strong>SUCURSAL</strong></th>
                                   <!-- <th width="110"><div align="right"><strong>TOTAL</strong></div></th>-->
                                </tr>

                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $invtot = $row[1];
                                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="806"><?php echo $sucursal ?></td>
                                        <!--<td width="110"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>-->
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
                            $sql = "SELECT sucursal,usecod,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' group by sucursal,usecod LIMIT $inicio, $registros";
                        } else {
                            $sql = "SELECT sucursal,usecod,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' and sucursal = '$local' group by sucursal,usecod LIMIT $inicio, $registros";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="232"><strong>SUCURSAL</strong></th>
                                    <th width="607"><strong>VENDEDOR</strong></th>
                                   <!-- <th width="73"><div align="right"><strong>TOTAL</strong></div></th>-->
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $usecod = $row['usecod'];
                                    $invtot = $row[2];
                                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
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
                                        <td width="232"><?php echo $sucursal ?></td>
                                        <td width="607"><?php echo $user ?></td>
                                        <!--<td width="73"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>-->
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
                            $sql = "SELECT sucursal,codmar,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' group by sucursal,codmar LIMIT $inicio, $registros";
                        } else {
                            $sql = "SELECT sucursal,codmar,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' and sucursal = '$local' group by sucursal,codmar LIMIT $inicio, $registros";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="232"><strong>SUCURSAL</strong></th>
                                    <th width="607"><strong>MARCA</strong></th>
                                    <!--<th width="73"><div align="right"><strong>TOTAL</strong></div></th>-->
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codmar = $row['codmar'];
                                    $invtot = $row[2];
                                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                        }
                                    }
                                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $marca = $row1['destab'];
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="232"><?php echo $sucursal ?></td>
                                        <td width="607"><?php echo $marca ?></td>
                                        <!--<td width="73"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>-->
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
                    <td><?php
                        if ($local == 'all') {
                            $sql = "SELECT sucursal,codpro,codmar,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' group by sucursal,codpro,codmar,fraccion ORDER BY id LIMIT $inicio, $registros  ";
                        } else {
                            $sql = "SELECT sucursal,codpro,codmar,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' and sucursal = '$local' group by sucursal,codpro,codmar,fraccion  ORDER BY id LIMIT $inicio, $registros ";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center"   id="customers">

                                <tr>
                                    <th width="75"><div align="left"><strong>Sucursal</strong></div></th>

                                    <th width="529"><div align="left"><strong>Producto</strong></div></th>
                                    <th width="138"><div align="left"><strong>Laboratorio / Marca</strong></div></th>

                                    <th width="104"><div align="right"><strong>Cantidad no vendida</strong></div></th>
                            <!--<th width="58"><div align="right"><strong>Total</strong></div></th>-->
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codpro = $row['codpro'];
                                    //	$codmar    = $row['codmar'];
                                    $invtot = $row[3];
                                    $sumcanpro = 0;
                                    ///////USUARIO QUE REALIZA LA VENTA
//  $marca== "";
                                    if ($local == 'all') {
                                        $sql1 = "SELECT canpro,fraccion,factor FROM agotados where codpro='$codpro' ORDER BY id";
                                    } else {
                                        $sql1 = "SELECT canpro,fraccion,factor FROM agotados where codpro='$codpro' and sucursal = '$local' ORDER BY id";
                                    }
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {

                                            $canpro = $row1['canpro'];
                                            $fraccion = $row1['fraccion'];
                                            $factor = $row1['factor'];

                                            if ($fraccion <> "T") {
                                                $canpro = $canpro * $factor;
                                            }
                                            $sumcanpro = $sumcanpro + $canpro;
                                        }
                                    }

                                    $marca = " ";
                                    $sql1 = "SELECT p.desprod,p.codmar,t.destab FROM producto as p inner join titultabladet as t on p.codmar = t.codtab where p.codpro = '$codpro' and p.eliminado='0'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $nomprod = $row1['desprod'];
                                            $codmar = $row1['codmar'];
                                            $marca = $row1['destab'];
                                        }
                                    }
                                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="60"><?php echo $sucursal ?></td>
                                        <td width="528"><div align="left"><?php echo $nomprod; ?></div></td>
                                        <td width="154"><div align="left"><?php echo $marca ?></div></td>

                                        <td width="108"><div align="right"><?php echo $sumcanpro; ?></div></td>
                          <!--  <td width="54"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>-->
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
                            $sql = "SELECT sucursal,codfam,coduso,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' group by sucursal,codfam,coduso LIMIT $inicio, $registros";
                        } else {
                            $sql = "SELECT sucursal,codfam,coduso,sum(invtot) FROM agotados where invfec between '$date1' and '$date2' and sucursal = '$local' group by sucursal,codpro LIMIT $inicio, $registros";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                            ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                    <th width="88"><strong>SUCURSAL</strong></th>
                                    <th width="240"><div align="left"><strong>LINEA</strong></div></th>
                                    <th width="507"><div align="left"><strong>USO DEL PRODUCTO</strong></div></th>
                                    <!--<th width="73"><div align="right"><strong>TOTAL</strong></div></th>-->
                                </tr>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $sucursal = $row['sucursal'];
                                    $codfam = $row['codfam'];
                                    $coduso = $row['coduso'];
                                    $invtot = $row[3];
                                    $sql1 = "SELECT nomloc FROM xcompa where codloc = '$sucursal'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $sucursal = $row1['nomloc'];
                                        }
                                    }
                                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codfam'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $familia = $row1['destab'];
                                        }
                                    }
                                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$coduso'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $uso = $row1['destab'];
                                        }
                                    }
                                    ?>
                                    <tr height="25"  <?php if ($datDSDe2) { ?> bgcolor="#ff0000"<?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';"<?php } ?>>
                                        <td width="88"><?php echo $sucursal ?></td>
                                        <td width="240"><div align="left"><?php echo $familia ?></div></td>
                                        <td width="507"><div align="left"><?php echo $uso; ?></div></td>
                                        <!--<td width="73"><div align="right"><?php echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); ?></div></td>-->
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
