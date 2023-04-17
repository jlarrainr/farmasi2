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
    <meta charset="euc-jp">

    <title><?php echo $desemp ?></title>

    <style type="text/css">
        .Estilo1 {
            color: #FF0000;
            font-weight: bold;
        }
    </style>
</head>
<?php
require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUME
$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
        $codloc = $row['codloc'];
    }
}

$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$codloc'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

$date = date('Y/m/d');
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
$val = $_REQUEST['val'];
$mes = $_REQUEST['mes'];
$year = $_REQUEST['year'];
$ckvencidos = $_REQUEST['ckvencidos'];
$local = $_REQUEST['local'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$resumen = $_REQUEST['resumen'];
$registros = $_REQUEST['registros'];

$cuento = strlen($mes);
if ($cuento == '2') {
    $mes = $mes;
} else {
    $mes = '0' . $mes;
}

$mes1 = date("m");
$a���o1 = date("Y");

$feca1 = $mes1 . '/' . $a���o1;
$feca2 = $mes . '/' . $year;

$D1 = $a���o1 . '/' . $mes1 . '/' . '00';
$D2 = $year . '/' . $mes . '/' . '00';

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
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="260"><strong><?php echo $desemp ?> </strong></td>
                        <td width="380">
                            <div align="center"><strong>REPORTE DE PRODUCTOS POR VENCER -
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
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="633">
                            <div align="center"><b>
                                    <?php if ($val == 1) { ?>
                                        <?php if ($ckvencidos == 1) { ?>
                                            FECHAS ANTERIORES DEL <?php echo $feca1; ?>
                                        <?php } else { ?>

                                            FECHAS ENTRE EL <?php echo $feca1; ?> Y EL <?php echo $feca2;
                                                                                    }
                                                                                }
                                                                                        ?>

                                </b></div>
                        </td>
                        <td width="133">
                            <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
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

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td><?php

                    if ($ckvencidos == 1) {

                        if ($local == 'all') {
                            $sql = "SELECT ml.idlote,ml.codpro,ml.vencim,ml.numlote,ml.codloc,ml.stock,STR_TO_DATE(ml.vencim, '%m/%Y') as FE, p.desprod from movlote ml inner join producto p on ml.codpro = p.codpro where STR_TO_DATE(ml.vencim, '%m/%Y') = '$D2'   AND  ml.stock > 0  ORDER BY  p.desprod asc, FE";
                           // $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock,STR_TO_DATE(vencim, '%m/%Y') as FE from movlote where STR_TO_DATE(vencim, '%m/%Y') = '$D2'   AND  stock > 0  ORDER BY FE";
                        } else {
                            $sql = "SELECT ml.idlote,ml.codpro,ml.vencim,ml.numlote,ml.codloc,ml.stock,STR_TO_DATE(ml.vencim, '%m/%Y') as FE, p.desprod from movlote ml inner join producto p on ml.codpro = p.codpro where STR_TO_DATE(ml.vencim, '%m/%Y') = '$D2' and ml.codloc = '$local'  AND  ml.stock > 0  ORDER BY  p.desprod asc, FE";
                           // $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock,STR_TO_DATE(vencim, '%m/%Y') as FE from movlote where STR_TO_DATE(vencim, '%m/%Y') = '$D2'   and codloc = '$local' AND  stock > 0  ORDER BY FE";
                        }
                    } else {

                        if ($local == 'all') {
                            $sql = "SELECT ml.idlote,ml.codpro,ml.vencim,ml.numlote,ml.codloc,ml.stock,STR_TO_DATE(ml.vencim, '%m/%Y') as FE, p.desprod from movlote ml inner join producto p on ml.codpro = p.codpro where STR_TO_DATE(ml.vencim, '%m/%Y') <= '$D2'  and STR_TO_DATE(ml.vencim, '%m/%Y') >= '$D1'   AND  ml.stock > 0  ORDER BY  p.desprod asc, FE";
                           // $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock,STR_TO_DATE(vencim, '%m/%Y') as FE from movlote where STR_TO_DATE(vencim, '%m/%Y') <= '$D2'  and STR_TO_DATE(vencim, '%m/%Y') >= '$D1' AND  stock > 0  ORDER BY FE";
                        } else {
                            $sql = "SELECT ml.idlote,ml.codpro,ml.vencim,ml.numlote,ml.codloc,ml.stock,STR_TO_DATE(ml.vencim, '%m/%Y') as FE, p.desprod from movlote ml inner join producto p on ml.codpro = p.codpro where STR_TO_DATE(ml.vencim, '%m/%Y') <= '$D2'  and STR_TO_DATE(ml.vencim, '%m/%Y') >= '$D1' and ml.codloc = '$local'  AND  ml.stock > 0  ORDER BY  p.desprod asc, FE";
                           // $sql = "SELECT idlote,codpro,vencim,numlote,codloc,stock,STR_TO_DATE(vencim, '%m/%Y') as FE from movlote where STR_TO_DATE(vencim, '%m/%Y') <= '$D2'  and STR_TO_DATE(vencim, '%m/%Y') >= '$D1' and codloc = '$local' AND  stock > 0  ORDER BY FE";
                        }
                    }
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) { 
                    ?>
                        <table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th width="20" align="right"><strong>SUCURSAL</strong></th>
                                <th width="20" align="center"><strong>CODIGO</strong></th>
                                <th width="120">
                                    <div align="left"><strong>PRODUCTO </strong></div>
                                </th>
                                <th width="73">
                                    <div align="LEFT"><strong>MARCA</strong></div>
                                </th>
                                <th width="73">
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th width="73">
                                    <div align="center"><strong>LOTE</strong></div>
                                </th>
                                <th width="73">
                                    <div align="center" class="Estilo1"><strong>VENCIMIENTO</strong></div>
                                </th>
                                <th width="30">
                                    <div align="right"><strong>STOCK</strong></div>
                                </th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $codpro = $row['codpro'];
                                $vencim = $row['vencim'];
                                $codloc = $row['codloc'];
                                $stock = $row['stock'];
                                $numlote = $row['numlote'];



                                $sql1 = "SELECT desprod,codmar,factor,$tabla FROM producto WHERE codpro='$codpro' and eliminado='0'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {

                                        $desprod = $row1['desprod'];
                                        $codmar = $row1['codmar'];
                                        $factor = $row1['factor'];
                                        $stock = $row1[3];
                                    }
                                }
                                $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $destab = $row1['destab'];
                                    }
                                }
                                $sql1 = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
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
                                <tr height="25" onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                                    <td width="20" align="center"><?php echo $sucursal ?></td>
                                    <td width="20" align="center"><?php echo $codpro ?></td>
                                    <td width="130">
                                        <div align="left"><?php echo $desprod ?></div>
                                    </td>
                                    <td width="60">
                                        <div align="left"><?php echo $destab ?></div>
                                    </td>
                                    <td width="60">
                                        <div align="center"><?php echo $factor ?></div>
                                    </td>
                                    <td width="60">
                                        <div align="center"><?php echo $numlote ?></div>
                                    </td>
                                    <td width="40">
                                        <div align="center" class="Estilo1"><?php echo $vencim ?></div>
                                    </td>
                                    <td width="45">
                                        <div align="right"><?php echo stockcaja($stock, $factor); ?></div>
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
    <?php } ///CIERRE DE VAL = 1
    ?>
</body>

</html>