<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="../css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .Estilo1 {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
</head>
<?php
require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
//$date   = date('d/m/Y');
$hour = date('G');
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = $_REQUEST['val'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$tipo = $_REQUEST['tipo'];
$reporte = $_REQUEST['reporte'];
$dat1 = $date1;
$dat2 = $date2;
$date1 = fecha1($date1);
$date2 = fecha1($date2);
if ($reporte == 1) {
    $dsc_repor = "RESUMIDO POR CLIENTE";
}
if ($reporte == 2) {
    $dsc_repor = "RESUMIDO POR FECHA";
}
if ($reporte == 3) {
    $dsc_repor = "DETALLADO";
}

function formato($c)
{
    printf("%06d", $c);
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="316" valign="top"><strong><?php echo $desemp ?> </strong></td>
                        <td width="269">
                            <div align="center"><strong>CUENTAS POR PAGAR</strong></div>
                        </td>
                        <td width="315" valign="top">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA </strong></td>
                        <td width="633">
                            <div align="center"><b><?php echo $dsc_repor; ?> - FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php echo $dat2; ?></b></div>
                        </td>
                        <td width="133">
                            <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../../images/line2.png" width="910" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php if ($tipo == 4) {
        if ($reporte == 1) {
    ?>
            <!-- RESUMIDO -->
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        $sql1 = "SELECT V.cuscod, SUM(VC.`monto`) FROM `venta_cuotas` AS VC INNER JOIN venta AS V ON V.invnum=VC.venta_id    WHERE   VC.fecha_pago BETWEEN  '$date1' and '$date2'  AND  V.estado='0' and V.val_habil='0' and VC.montoCobro>0 GROUP BY V.cuscod";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                        ?>
                            <table width="100%" border="0" align="center">

                                <tr>
                                    <th width="10%"><strong>N</strong></th>
                                    <th width="30%"><strong>CLIENTE</strong></th>
                                    <th width="128"><strong>MONTO TOTAL</strong></th>

                                </tr>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $i++;
                                    $codCliente = $row1['cuscod'];  /////codigo interno de la planilla
                                    $monto_deuda = $row1[1];  /////codigo interno de ordmae
                                    
                                    $sql2 = "SELECT codcli,descli FROM `cliente` WHERE codcli='$codCliente'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $cliente = $row2['descli'];
                                        }
                                    }

                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $cliente ?></td>
                                        <td>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monto_deuda, 2, '.', ' '); ?></div>
                                        </td>
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

        <?php } else { ?>


            <!-- DETALLADO -->

            <!-- RESUMIDO -->
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        $sql1 = "SELECT  VC.monto,V.cuscod,V.usecod,V.nrofactura,V.invfec,VC.fecha_pago,V.sucursal,V.numeroCuota FROM `venta_cuotas` AS VC INNER JOIN venta as V on V.invnum=VC.venta_id WHERE V.estado='0' and V.val_habil='0' and VC.montoCobro>0 and VC.fecha_pago BETWEEN  '$date1' and '$date2' ";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                        ?>
                            <table width="100%" border="1" align="center">
                                <tr>
                                    <th width="1%"><strong>N</strong></th>
                                    <th width="15%"><strong>CLIENTE</strong></th>
                                    <th width="15%"><strong>USUARIO</strong></th>
                                    <th width="15%"><strong>N° DOC</strong></th>
                                    <th width="10%"><strong>FECHA REGISTRO</strong></th>
                                    <th width="10%"><strong>PLAZO</strong></th>
                                    <th width="10%"><strong>FECHA VENCIMIENTO</strong></th>
                                    <th width="10%"><strong>SUCURSAL</strong></th>
                                    <th width="10%"><strong>MONTO TOTAL</strong></th>
                                </tr>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $i++;
                                    $usecod = $row1['usecod'];
                                    $codCliente = $row1['cuscod'];
                                    
                                    $nrofactura = $row1['nrofactura'];
                                    $invfec = $row1['invfec'];
                                    $numeroCuota = $row1['numeroCuota'];
                                    $fecha_pago = $row1['fecha_pago'];
                                    $sucursal = $row1['sucursal'];
                                    $monto = $row1['monto'];
                                    
                                    $sql2 = "SELECT codcli,descli FROM `cliente` WHERE codcli='$codCliente'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $cliente = $row2['descli'];
                                        }
                                    }
                                    $sql = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                                    $result = mysqli_query($conexion, $sql);
                                    if (mysqli_num_rows($result)) {
                                        while ($row = mysqli_fetch_array($result)) {
                                            $user2 = $row['nomusu'];
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $cliente ?></td>
                                        <td><?php echo $user2 ?></td>
                                        <td><?php echo $nrofactura ?></td>
                                        <td><?php echo $invfec; ?></td>
                                        <td><?php echo $numeroCuota; ?></td>
                                        <td><?php echo $fecha_pago; ?></td>
                                        <td><?php echo $sucursal; ?></td>
                                        <td>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monto, 2, '.', ' '); ?></div>
                                        </td>
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
        <?php } ?>

    <?php } else { ?>

        <?php
        if ($reporte == 3) {
        ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        $sql1 = "SELECT invnum,numdoc,fecpla,codprov,monpag,codusu,saldo_deuda FROM planilla where fecpla between '$date1' and '$date2' order by fecpla, invnum";
                        $labAnt = '';
                        $i = 0;
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                        ?>
                            <table width="100%" border="1" align="center">
                                <tr>
                                    <th width="85"><strong>N°</strong></th>
                                    <!-- <th width="88"><strong>NUM DOC</strong></th> -->
                                    <th width="98"><strong>FECHA PAGO</strong></th>
                                    <th width="233"><strong>PROVEEDOR</strong></th>
                                    <th width="90">
                                        <div align="right"><strong>USUARIO</strong></div>
                                    </th>
                                    <th width="128"><strong>MONTO TOTAL</strong></th>
                                    <th width="86">
                                        <div align="right"><strong>MONTO PAGADO</strong></div>
                                    </th>
                                    <th width="84">
                                        <div align="right"><strong>SALDO</strong></div>
                                    </th>
                                </tr>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $i2++;
                                    $invnum = $row1['invnum'];  /////codigo interno de la planilla
                                    $numdoc = $row1['numdoc'];  /////codigo interno de ordmae
                                    $fecpla = $row1['fecpla'];
                                    $codprov = $row1['codprov'];
                                    $monpag = $row1['monpag'];
                                    $codusu = $row1['codusu'];
                                    $saldo_deuda = $row1['saldo_deuda'];
                                    $saldo = 0;
                                    $sql2 = "SELECT despro FROM proveedor where codpro = '$codprov'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $proveedor = $row2['despro'];
                                        }
                                    }
                                    $sql2 = "SELECT plazo FROM letras where planilla = '$invnum'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $plazo = $row2['plazo'];
                                        }
                                    }
                                    if ($codprov <> $pro[$zz]) {
                                        $zz++;
                                        $pro[$zz] = $codprov;
                                    }
                                    // $vvvv = $pro[$zz];
                                    $saldo = $saldo_deuda - $monpag;


                                ?>
                                    <?php if ($i != 0 && $labAnt != $codprov) { ?>
                                        <!-- <tr bgcolor="#CCCCCC">
                                            <td colspan="7">
                                                <div align="center"><strong>TOTAL 2 = <?php echo $zz; ?></strong></div>
                                            </td>
                                        </tr> -->
                                    <?php
                                        $labAnt = $codprov;
                                    } else if ($i == 0) {
                                        $labAnt = $codprov;
                                    }
                                    $i++;
                                    ?>

                                    <tr title=" <?php echo $vvvv; ?>">
                                        <td><?php echo $i2; ?></td>
                                        <td><?php echo $fecpla ?></td>
                                        <td><?php echo $proveedor ?></td>
                                        <td><?php echo $proveedor ?></td>
                                        <td><?php echo $saldo_deuda; ?></td>
                                        <td>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monpag, 2, '.', ' '); ?></div>
                                        </td>
                                        <td>
                                            <div align="right"><?php echo $numero_formato_frances = number_format($saldo, 2, '.', ' '); ?></div>
                                        </td>
                                    </tr>


                                <?php }
                                ?>
                                <!-- <tr bgcolor="#CCCCCC">
                                    <td colspan="7">
                                        <div align="center"><strong>TOTAL 2 342342322= <?php echo $zz; ?></strong></div>
                                    </td>
                                </tr> -->
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
        <?php }
        ?>
        <?php
        if ($reporte == 1) {
        ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        $zz = 0;
                        $sql1 = "SELECT codprov,SUM(monpag),SUM(saldo_deuda) FROM planilla where fecpla between '$date1' and '$date2' GROUP BY  codprov ";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                        ?>
                            <table width="100%" border="0" align="center">
                                <tr>
                                    <th width="635"><strong>PROVEEDOR</strong></th>
                                    <th width="172">
                                        <div align="right"><strong>MONTO TOTAL</strong></div>
                                    </th>
                                    <th width="105">
                                        <div align="right"><strong>SALDO</strong></div>
                                    </th>
                                </tr>
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $codprov = $row1['codprov'];
                                    $monpag = $row1[1];
                                    $saldo_deuda = $row1[2];
                                    $saldo = 0;
                                    $sql2 = "SELECT despro FROM proveedor where codpro = '$codprov'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $proveedor = $row2['despro'];
                                        }
                                    }

                                    if ($codprov <> $pro[$zz]) {
                                        $zz++;
                                        $pro[$zz] = $codprov;
                                    }
                                    $vvvv = $pro[$zz];
                                    $saldo = $saldo_deuda - $monpag;
                                ?>
                                    <tr title=" <?php echo $vvvv; ?>">
                                        <td width="635"><?php echo $proveedor ?></td>
                                        <td width="172">
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monpag, 2, '.', ' '); ?></div>
                                        </td>
                                        <td width="105">
                                            <div align="right"><?php echo $numero_formato_frances = number_format($saldo, 2, '.', ' '); ?></div>
                                        </td>
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
        <?php }
        ?>
        <?php
        if ($reporte == 2) {
        ?>
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td width="635"><strong>FECHA</strong></td>
                                <td width="172">
                                    <div align="right"><strong>MONTO TOTAL</strong></div>
                                </td>
                                <td width="105">
                                    <div align="right"><strong>SALDO</strong></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td><?php
                        $sql1 = "SELECT invnum,numdoc,fecpla,monpag,saldo_deuda FROM planilla where fecpla between '$date1' and '$date2' order by fecpla, invnum";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                        ?>
                            <table width="100%" border="0" align="center">
                                <?php
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $invnum = $row1['invnum'];  /////codigo interno de la planilla
                                    $numdoc = $row1['numdoc'];  /////codigo interno de ordmae
                                    $fecpla = $row1['fecpla'];
                                    $monpag = $row1['monpag'];
                                    $saldo_deuda = $row1['saldo_deuda'];
                                    $saldo = 0;
                                    // $sql2 = "SELECT invtot FROM ordmae where invnum = '$numdoc'";
                                    // $result2 = mysqli_query($conexion, $sql2);
                                    // if (mysqli_num_rows($result2)) {
                                    //     while ($row2 = mysqli_fetch_array($result2)) {
                                    //         $invtot = $row2['invtot'];
                                    //     }
                                    // }
                                    // $sql2 = "SELECT sum(monpag) FROM planilla where numdoc = '$invnum' and borrada = '0' and (fecpla <= '$date1') or (fecpla <= '$date2')";
                                    // $result2 = mysqli_query($conexion, $sql2);
                                    // if (mysqli_num_rows($result2)) {
                                    //     while ($row2 = mysqli_fetch_array($result2)) {
                                    //         $monpagsum = $row2[0];
                                    //     }
                                    // }
                                    $saldo = $saldo_deuda - $monpag;
                                ?>
                                    <tr height="25" <?php if ($datDSDe2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>
                                        <td width="635"><?php echo fecha($fecpla) ?></td>
                                        <td width="172">
                                            <div align="right"><?php echo $numero_formato_frances = number_format($monpag, 2, '.', ' '); ?></div>
                                        </td>
                                        <td width="105">
                                            <div align="right"><?php echo $numero_formato_frances = number_format($saldo, 2, '.', ' '); ?></div>
                                        </td>
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
        <?php }
        ?>
    <?php } ?>
</body>

</html>