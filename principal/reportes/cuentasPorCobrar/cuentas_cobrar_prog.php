<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
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
require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
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
    $dsc_repor = "RESUMIDO POR PROVEEDOR";
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
    <table width="930" border="0" align="center">
        <tr>
            <td>
                <table width="914" border="0">
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
                <table width="914" border="0">
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
    <?php
    if ($reporte == 3) {
    ?>
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="926" border="0" align="center">
                        <tr>
                            <td width="85"><strong>NUM INTERNO</strong></td>
                            <td width="88"><strong>NUM DOC</strong></td>
                            <td width="98"><strong>FECHA PAGO</strong></td>
                            <td width="233"><strong>PROVEEDOR</strong></td>
                            <td width="90">
                                <div align="right"><strong>PLAZO DE PAGO</strong></div>
                            </td>
                            <td width="128"><strong>CODIGO DIGITADOR</strong></td>
                            <td width="86">
                                <div align="right"><strong>MONTO TOTAL</strong></div>
                            </td>
                            <td width="84">
                                <div align="right"><strong>SALDO</strong></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php
                    $sql1 = "SELECT invnum,numdoc,fecpla,codprov,monpag,codusu FROM planilla where fecpla between '$date1' and '$date2' order by fecpla, invnum";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                    ?>
                        <table width="926" border="0" align="center">
                            <?php
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];  /////codigo interno de la planilla
                                $numdoc = $row1['numdoc'];  /////codigo interno de ordmae
                                $fecpla = $row1['fecpla'];
                                $codprov = $row1['codprov'];
                                $monpag = $row1['monpag'];
                                $codusu = $row1['codusu'];
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
                                $sql2 = "SELECT invtot FROM ordmae where invnum = '$numdoc'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $invtot = $row2['invtot'];
                                    }
                                }
                                $sql2 = "SELECT sum(monpag) FROM planilla where numdoc = '$invnum' and borrada = '0' and (fecpla <= '$date1') or (fecpla <= '$date2')";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $monpagsum = $row2[0];
                                    }
                                }
                                $saldo = $invtot - $monpagsum;
                            ?>
                                <tr>
                                    <td width="85"><?php echo formato($invnum) ?></td>
                                    <td width="88"><?php echo formato($numdoc) ?></td>
                                    <td width="98"><?php echo $fecpla ?></td>
                                    <td width="233"><?php echo $proveedor ?></td>
                                    <td width="90">
                                        <div align="right"><?php echo $plazo ?></div>
                                    </td>
                                    <td width="128"><?php echo formato($codusu) ?></td>
                                    <td width="86">
                                        <div align="right"><?php echo $numero_formato_frances = number_format($monpag, 2, '.', ' '); ?></div>
                                    </td>
                                    <td width="84">
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
    if ($reporte == 1) {
    ?>
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="926" border="0" align="center">
                        <tr>
                            <td width="635"><strong>PROVEEDOR</strong></td>
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
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td><?php
                    $sql1 = "SELECT invnum,numdoc,codprov,monpag FROM planilla where fecpla between '$date1' and '$date2' order by fecpla, invnum";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                    ?>
                        <table width="926" border="0" align="center">
                            <?php
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];  /////codigo interno de la planilla
                                $numdoc = $row1['numdoc'];  /////codigo interno de ordmae
                                $codprov = $row1['codprov'];
                                $monpag = $row1['monpag'];
                                $saldo = 0;
                                $sql2 = "SELECT despro FROM proveedor where codpro = '$codprov'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $proveedor = $row2['despro'];
                                    }
                                }
                                $sql2 = "SELECT invtot FROM ordmae where invnum = '$numdoc'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $invtot = $row2['invtot'];
                                    }
                                }
                                $sql2 = "SELECT sum(monpag) FROM planilla where numdoc = '$invnum' and borrada = '0' and (fecpla <= '$date1') or (fecpla <= '$date2')";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $monpagsum = $row2[0];
                                    }
                                }
                                $saldo = $invtot - $monpagsum;
                            ?>
                                <tr>
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
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="926" border="0" align="center">
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
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td><?php
                    $sql1 = "SELECT invnum,numdoc,fecpla,monpag FROM planilla where fecpla between '$date1' and '$date2' order by fecpla, invnum";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                    ?>
                        <table width="926" border="0" align="center">
                            <?php
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $invnum = $row1['invnum'];  /////codigo interno de la planilla
                                $numdoc = $row1['numdoc'];  /////codigo interno de ordmae
                                $fecpla = $row1['fecpla'];
                                $monpag = $row1['monpag'];
                                $saldo = 0;
                                $sql2 = "SELECT invtot FROM ordmae where invnum = '$numdoc'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $invtot = $row2['invtot'];
                                    }
                                }
                                $sql2 = "SELECT sum(monpag) FROM planilla where numdoc = '$invnum' and borrada = '0' and (fecpla <= '$date1') or (fecpla <= '$date2')";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $monpagsum = $row2[0];
                                    }
                                }
                                $saldo = $invtot - $monpagsum;
                            ?>
                                <tr>
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
</body>

</html>