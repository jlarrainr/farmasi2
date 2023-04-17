<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=SIST_EXPORT_DATA.xls");

$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$vendedor = isset($_REQUEST['vendedor']) ? ($_REQUEST['vendedor']) : "";

$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
    <title><?php echo $desemp ?></title>
</head>
<?php


$date1 = fecha1($date1);
$date2 = fecha1($date2);

?>

<body>
    <table width="100%" border="0">
        <tr>
            <td width="278"><strong><?php echo $desemp ?> </strong></td>
            <td width="563">
                <div align="center"><strong>REPORTE DE ARQUEO DE CAJA</strong></div>
            </td>
            <td width="278">
                <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?></strong></div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <div align="center"><b>
                        <?php
                        if ($val == 1) {
                            echo "FECHAS ENTRE : ";
                            echo fecha($date1);
                            echo " AL ";
                            echo fecha($date2);
                        }
                        ?>
                    </b>
                </div>
            </td>
            <td></td>
        </tr>
    </table>
    <table width="99%" border="0" align="center" id="customers">
        <?php
        if ($ck == 1) {

            $fecha_actual = date('Y/m/d');
            if ($vendedor != 'all') {
                $sql1 = "SELECT *  FROM arqueo_caja  WHERE codigo_usuario ='$vendedor'   and fecha_inicio<>'$fecha_actual'   and fecha_inicio <> fecha_cierre ";
            } else {
                $sql1 = "SELECT *  FROM arqueo_caja  WHERE      fecha_inicio<>'$fecha_actual'  and fecha_inicio <> fecha_cierre";
            }
        } else {

            if ($vendedor != 'all') {
                $sql1 = "SELECT *  FROM arqueo_caja  WHERE codigo_usuario ='$vendedor' and fecha_inicio BETWEEN '$date1' and '$date2' and fecha_cierre != '0000-00-00' ";
            } else {
                $sql1 = "SELECT *  FROM arqueo_caja  WHERE  fecha_inicio BETWEEN '$date1' and '$date2' and fecha_cierre != '0000-00-00'";
            }
        }
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
        ?>
            <thead>

                <tr>
                    <th>N </th>
                    <th>Usuario</th>
                    <th>Fecha / Hora Inicio</th>
                    <th>Monto Inicio</th>
                    <th>Fecha / Hora Cierre</th>
                    <th>Monto Cierre</th>
                    <th>Monto Egresado</th>
                    <th>Detalle Monto Cierre</th>

                    <th>Cuadre Personal </th>
                    <th>Cuadre Sistema</th>
                    <th>Comparativa</th>
                    <!-- <th>Venta Efectivo</th>
                <th>Venta Tarjeta</th>
                <th>Venta Credito</th>
                <th>Monto Total</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result1)) {
                    $i++;
                    $codigo_usuario         = $row['codigo_usuario'];
                    $fecha_inicio           = $row['fecha_inicio'];
                    $hora_inicio            = $row['hora_inicio'];
                    $monto_inicio           = $row['monto_inicio'];
                    $monto_cierre           = $row['monto_cierre'];
                    $comparativa            = $row['comparativa'];
                    $monto_agregado         = $row['monto_agregado'];
                    $detalle_monto_agregado = $row['detalle_monto_agregado'];
                    $fecha_cierre           = $row['fecha_cierre'];
                    $hora_cierre            = $row['hora_cierre'];
                    $venta_efectivo         = $row['venta_efectivo'];
                    $venta_tarjeta          = $row['venta_tarjeta'];
                    $venta_credito          = $row['venta_credito'];


                    $suma_del_cuadre = $monto_cierre +  $monto_agregado;
                    $suma_de_vemtas_monto_inicio = $venta_efectivo +  $monto_inicio;

                    if ($suma_del_cuadre == $suma_de_vemtas_monto_inicio) {
                        $color = '#61d374';
                        $texto_comparativa = 'ok';
                        $signo = '';
                    } elseif ($suma_del_cuadre < $suma_de_vemtas_monto_inicio) {
                        $color = '#f96a6a';
                        $texto_comparativa = '';
                        $texto_comparativa =  $suma_del_cuadre - $suma_de_vemtas_monto_inicio;
                        $signo = '-';
                    } else {
                        $color = '#f96a6a';
                        $texto_comparativa = '';
                        $texto_comparativa = $suma_del_cuadre - $suma_de_vemtas_monto_inicio;
                        $signo = '+';
                    }
                    
                     if ($fecha_cierre == '0000-00-00'){
                        $color2 = '#f96a6a';
                    }else{
                        $color2 = '';
                    }

                    $monto_total = $venta_efectivo + $venta_tarjeta + $venta_credito;
                    $hora_inicio = date("g:i a", strtotime($hora_inicio));
                    $hora_cierre = date("g:i a", strtotime($hora_cierre));

                    $sql = "SELECT nomusu FROM usuario where usecod = '$codigo_usuario'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $nomusu = $row['nomusu'];
                        }
                    } else {
                        $nomusu = 'Usuario Eliminado';
                    }
                ?>
                    <tr align="center">
                        <td><?php echo $i; ?></td>
                        <td align="left"><?php echo $nomusu; ?></td>
                        <td><?php echo fecha($fecha_inicio) . ' - ' . $hora_inicio; ?></td>
                        <td><?php echo $monto_inicio; ?></td>
                        <td bgcolor="<?php echo $color2; ?>" >
                        <?php if ($fecha_cierre == '0000-00-00'){?>
                            <blink><a style="color:#fff;font-size:14px;"><?php echo ' A&uacute;n no Cierra Caja'?></a></blink>
                            
                            <?php }else{ ?>
                            <?php echo  fecha($fecha_cierre) . ' - ' . $hora_cierre; ?>
                            <?php } ?>
                    </td>
                        <td><?php echo $monto_cierre; ?></td>
                        <td><?php echo $monto_agregado; ?></td>
                        <td align="left"><?php echo $detalle_monto_agregado; ?></td>
                        <!-- <td><?php echo $venta_efectivo; ?></td>
                    <td><?php echo $venta_tarjeta; ?></td>
                    <td><?php echo $venta_credito; ?></td>
                    <td><?php echo $monto_total; ?></td> -->

                        <td> <?php echo $suma_del_cuadre; ?></td>
                        <td> <?php echo $suma_de_vemtas_monto_inicio; ?></td>

                        <td bgcolor="<?php echo $color; ?>" style="color:#fff;font-size:14px;"> <?php echo $texto_comparativa; ?></td>

                    </tr>
                <?php } ?>
            </tbody>
        <?php } ?>
    </table>
</body>

</html>