<?php
include('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
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
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
$date = date('d/m/Y');
$hour = date("G") - 5;
$hour = CalculaHora($hour);
$min = date("i");
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = $_REQUEST['val'];
$date1 = fecha1($_REQUEST['date1']);
$date2 = fecha1($_REQUEST['date2']);
$local = $_REQUEST['local'];
$det = $_REQUEST['det'];
$ltdgen = $_REQUEST['ltdgen'];
$marca = $_REQUEST['marca'];
if ($local <> 'all') {
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
            $nombre = $row['nombre'];
        }
    }
    if ($nombre <> "") {
        $nomloc = $nombre;
    }
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td><strong><?php echo $desemp ?></strong></td>
                        <td>
                            <div align="center"><strong>REPORTE DE RENTABILIDAD </strong></div>
                        </td>
                        <td>&nbsp;</td>
                        <td>
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
                    <tr>
                        <td width="361"><strong>PAGINA # </strong></td>
                        <td width="221">
                            <div align="center">
                                <?php
                                if ($local == 'all') {
                                    echo 'TODAS LAS SUCURSALES';
                                } else {
                                    echo $nomloc;
                                }
                                ?>
                            </div>
                        </td>
                        <td width="30">&nbsp;</td>
                        <td width="284">
                            <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span> </div>
                        </td>
                    </tr>

                </table>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
    ?>

        <?php
        if ($det == 1) {
        ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" id="customers">
                <tr>
                    <th><strong>N&ordm;</strong></th>


                    <th>
                        <div align="center"><strong>CODIGO</strong></div>
                    </th>
                    <th>
                        <div align="left"><strong>PRODUCTO</strong></div>
                    </th>
                    <?php if ($marca == 'all') { ?>
                        <th>
                            <div align="left"><strong>MARCA</strong></div>
                        </th>
                    <?php } ?>
                    <th>
                        <div align="CENTER"><strong>FACTOR</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>CAJAS Y UNIDADES</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>MONTO VENTA</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>COSTO PROMEDIO</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>RENTABILIDAD</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>% RENTABILIDAD</strong></div>
                    </th>

                </tr>
                <tr>
                    <?php
                    //$Sumgenpripro = 0;
                    //$Sumgenpcosto = 0.01;
                    if ($local == 'all') {
                        if ($marca == 'all') {
                            $sql1 = "SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' group by producto.codmar, producto.codpro ";
                        } else {
                            $sql1 = "SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and producto.codmar = '$marca' and val_habil = '0' group by producto.codmar, producto.codpro ";
                        }
                    } else {
                        if ($marca == 'all') {
                            $sql1 = "SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' group by producto.codmar, producto.codpro ";
                        } else {
                            $sql1 = "SELECT producto.codmar, producto.codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and producto.codmar = '$marca' and val_habil = '0' group by producto.codmar, producto.codpro";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {

                            $codmar = $row1['codmar'];
                            $codpro = $row1['codpro'];
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $destab = $row2['destab'];
                                    $abrev = $row2['abrev'];
                                    if ($abrev <> '') {
                                        $destab = $abrev;
                                    }
                                }
                            }
                            $sql2 = "SELECT desprod FROM producto where codpro = '$codpro' and eliminado='0' ";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $product = $row2['desprod'];
                                }
                            }
                            $precio_costo = 0;
                            $nrooperacion = 0;
                            $canprod1 = 0;
                            $canprod = 0;
                            $tot = 0;
                            $sumpripro = 0;
                            $sumpcosto = 0;
                            $rentabilidad = 0;
                            $SumPorcent = 0;
                            $pripro = 0;
                            $priproSUM = 0;
                            $costprsum = 0;
                            $sumcostpr = 0;
                            $canprodsinfac = 0;

                            if ($local == 'all') {
                                $sql2 = "SELECT detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.prisal,detalle_venta.costpr,detalle_venta.pripro  FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where producto.codmar = '$codmar' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and val_habil = '0'  ";
                            } else {
                                $sql2 = "SELECT detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.prisal,detalle_venta.costpr,detalle_venta.pripro  FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on detalle_venta.codpro=producto.codpro where producto.codmar = '$codmar' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0'";
                            }
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $canpro     = $row2['canpro'];
                                    $fraccion   = $row2['fraccion'];
                                    $factor     = $row2['factor'];
                                    $prisalPR   = $row2['prisal'];
                                    $prisal     = $row2['prisal'];
                                    $costpr     = $row2['costpr'];

                                    $tot = 0;
                                    if ($costpr <= 0) {
                                        $costpr = 0.01;
                                    }

                                    /*$costprsum = $costprsum + $costpr;
                                        $pripro2SU = $prisalPR;
                                        $priproSUM = $priproSUM + $pripro2SU;

                                        $pripro2 = $prisal * $canpro;
                                        $pripro = $pripro + $pripro2;
*/


                                    if ($factor <> 1) {
                                        if ($fraccion == "T") {
                                            $canprod = $canprod + $canpro;
                                            $tot = $tot + $canpro;
                                            $precio_costo = $costpr;
                                        } else {
                                            $canprod1 = $canprod1 + $canpro;

                                            $canpros = $canpro * $factor;
                                            $tot = $tot + $canpros;
                                            $precio_costo = $costpr / $factor;
                                        }
                                    } else {

                                        $canprod1 = $canprod1 + $canpro;
                                        $canprodsinfac = $canprodsinfac + $canpro;
                                        $sumcostpr = $sumcostpr + $costpr;
                                    }


                                    $saldoactual = $canprod + ($canprod1 * $factor);

                                    $sumpripro = $sumpripro + ($prisal * $canpro);
                                    $sumpcosto = $sumpcosto + ($costpr * $canpro);
                                }
                            }

                            $Sumgenpripro_2 +=  $sumpripro;
                            $sumgenpcosto_2 +=  $sumpcosto;

                            $rentabilidad = $sumpripro - $sumpcosto;
                            $porcentaje = ($rentabilidad / $sumpcosto) * 100;
                            $Sumgenpripro = $Sumgenpripro + $sumpripro;
                            $Sumgenpcosto = $Sumgenpcosto + $sumpcosto;
                            $trentabilidad = $Sumgenpripro - $Sumgenpcosto;
                            $tporcentaje = ($trentabilidad / $Sumgenpcosto) * 100;


                            $i++;
                    ?>
                <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>

                    <td><?php echo $i; ?></td>
                    <td align="center" title="<?php echo $rentabilidad . "---" . $costprsum; ?>"><?php echo $codpro; ?></td>



                    <td>
                        <div align="left"><a href="javascript:popUpWindow('ver_rentabilidad.php?codp=<?php echo $codpro ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>', 10, 10, 1100, 500)"><?php echo $product ?></a></div>
                    </td>
                    <?php if ($marca == 'all') { ?>
                        <td><?php echo $destab ?>
                        </td>
                    <?php } ?>

                    <td align="center"><?php echo $factor;  ?> </td>
                    <td>
                        <div align="right"><?php

                                            echo stockcaja($saldoactual, $factor);

                                            ?></div>
                    </td>

                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div>
                    </td>


                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($sumpcosto, 2, '.', ' '); ?></div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' '); ?> </div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div>
                    </td>
                </tr>
            <?php
                        } /////CIERRO EL WHILE
            ?>
            <tr bgcolor="#dedeca">
                <?php if ($marca == 'all') { ?>
                    <td colspan="6">
                        <center>TOTAL</center>
                    </td>
                <?php } else { ?>
                    <td colspan="5">
                        <center>TOTAL</center>
                    </td>
                <?php } ?>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($Sumgenpripro_2, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($sumgenpcosto_2, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($trentabilidad, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($tporcentaje, 2, '.', ' '); ?> %</div>
                </td>

            </tr>
        <?php
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
        ?> <td colspan="8">
                <div class="siniformacion">
                    <center>
                        No se logro encontrar informacion con los datos ingresados
                    </center>
                </div>
            </td>
        <?php }
        ?>
            </table>
            </td>
            </tr>
            </table>
        <?php
        } else {
        ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" id="customers">
                <tr>
                    <th><strong>N&ordm;</strong></th>
                    <th>
                        <div align="left"><strong>MARCA</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>MONTO VENTA</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>COSTO VENTA</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>RENTABILIDAD</strong></div>
                    </th>
                    <th>
                        <div align="right"><strong>% RENTABILIDAD</strong></div>
                    </th>
                </tr>
                <tr>
                    <?php
                    // $Sumgenpripro = 0;
                    // $Sumgenpcosto = 0;

                    if ($local == 'all') {
                        if ($marca == 'all') {
                            $sql1 = "SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on producto.codpro=detalle_venta.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' group by producto.codmar";
                        } else {
                            $sql1 = "SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on producto.codpro=detalle_venta.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' and producto.codmar = '$marca' group by producto.codmar";
                        }
                    } else {
                        if ($marca == 'all') {
                            $sql1 = "SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on producto.codpro=detalle_venta.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' group by producto.codmar";
                        } else {
                            $sql1 = "SELECT producto.codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum inner join producto on producto.codpro=detalle_venta.codpro where venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0' and producto.codmar = '$marca' group by producto.codmar";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $codmar = $row1['codmar'];
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $destab = $row2['destab'];
                                    $abrev = $row2['abrev'];
                                    if ($abrev <> '') {
                                        $destab = $abrev;
                                    }
                                }
                            }
                            $precio_costo = 0;
                            $sumpripro = 0;
                            $sumpcosto = 0;
                            if ($local == 'all') {
                                $sql2 = "SELECT detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.prisal,detalle_venta.costpr FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.invfec between '$date1' and '$date2' and val_habil = '0'";
                            } else {
                                $sql2 = "SELECT detalle_venta.canpro,detalle_venta.fraccion,detalle_venta.factor,detalle_venta.prisal,detalle_venta.costpr FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.invfec between '$date1' and '$date2' and sucursal = '$local' and val_habil = '0'";
                            }
                            //echo $sql2;
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $prisal = $row2['prisal'];
                                    $canpro = $row2['canpro'];
                                    $fraccion = $row2['fraccion'];
                                    $factor = $row2['factor'];
                                    $costpr = $row2['costpr'];
                                    $tot = 0;
                                    if ($costpr <= 0) {
                                        $costpr = 0.01;
                                    }
                                    if ($fraccion == "T") {
                                        $canprod = $canprod + $canpro;
                                        $tot = $tot + $canpro;
                                        $precio_costo = $costpr;
                                    } else {
                                        $canprod1 = $canprod1 + $canpro;
                                        $canpros = $canpro * $factor;
                                        $tot = $tot + $canpros;
                                        $precio_costo = $costpr / $factor;
                                    }
                                    $sumpripro = $sumpripro + ($prisal * $canpro);
                                    $sumpcosto = $sumpcosto + ($costpr * $canpro);
                                }
                            }
                            $rentabilidad = $sumpripro - $sumpcosto;
                            $porcentaje = ($rentabilidad / $sumpcosto) * 100;
                            $Sumgenpripro = $Sumgenpripro + $sumpripro;
                            $Sumgenpcosto = $Sumgenpcosto + $sumpcosto;
                            $trentabilidad = $Sumgenpripro - $Sumgenpcosto;
                            $tporcentaje = ($trentabilidad / $Sumgenpcosto) * 100;

                            $i++;
                    ?>
                <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>
                    <td><?php echo $i ?></td>
                    <td><?php echo $destab ?></td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($sumpcosto, 2, '.', ' '); ?></div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($rentabilidad, 2, '.', ' '); ?></div>
                    </td>
                    <td>
                        <div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %%%</div>
                    </td>

                </tr>
            <?php
                        } /////CIERRO EL WHILE
            ?>
            <tr bgcolor="#dedeca">
                <td colspan="2">
                    <center>TOTAL</center>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($Sumgenpripro, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($Sumgenpcosto, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($trentabilidad, 2, '.', ' '); ?></div>
                </td>
                <td>
                    <div align="right"><?php echo $numero_formato_frances = number_format($tporcentaje, 2, '.', ' '); ?> %</div>
                </td>
            </tr>
        <?php
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
        ?><td colspan="6">
                <div class="siniformacion">
                    <center>
                        No se logro encontrar informacion con los datos ingresados
                    </center>
                </div>
            </td>
        <?php }
        ?>
            </table>
            </td>
            </tr>
            </table>
    <?php
        }
    }
    ?>
</body>

</html>