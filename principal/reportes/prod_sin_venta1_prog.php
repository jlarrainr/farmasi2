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
$dia = $_REQUEST['dia'];
$val = $_REQUEST['val'];
$local = $_REQUEST['local'];
if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}
$fecha_menos24hs = date('Y-m-d', time() - ($dia * 24 * 60 * 60));
echo $fecha_menos24hs;
////////////////////////////////////////////////////////


$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../precios_por_local.php';
}
?>

<body>
    <table width="930" border="0" align="center">
        <tr>
            <td>
                <table width="914" border="0">
                    <tr>
                        <td width="271"><strong><?php echo $desemp ?></strong></td>
                        <td width="358">
                            <div align="center"><strong>REPORTE DE PRODUCTOS SIN MOVIMIENTOS </strong></div>
                        </td>
                        <td width="271">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="914" border="0">
                    <tr>
                        <td width="271"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="358">
                            <div align="center">DIAS CONSULTADOS: <?php echo $dia ?> DIAS </div>
                        </td>
                        <td width="271">
                            <div align="right">USUARIO: <span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
    ?>
        <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="926" border="0" align="center">
                        <tr>
                            <td width="28"><strong>N&ordm;</strong></td>
                            <td width="370">
                                <div align="left"><strong>PRODUCTO</strong></div>
                            </td>
                            <td width="313">
                                <div align="left"><strong>MARCA</strong></div>
                            </td>
                            <td width="116">
                                <div align="right"><strong>ULTIMA FECHA VTA</strong></div>
                            </td>
                            <td width="77">
                                <div align="right"><strong>STOCK</strong></div>
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
                    $i = 0;
                    if ($local <> 'all') {
                        $sql = "SELECT codpro,desprod,codmar,stopro,prevta,datcre,$tabla FROM producto where $tabla > 0 and eliminado='0' order by codpro";
                    } else {
                        $sql = "SELECT codpro,desprod,codmar,stopro,prevta,datcre,stopro FROM producto where stopro > 0 and eliminado='0' order by codpro";
                    }
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                    ?>
                        <table width="926" border="0" align="center">
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $codpro = $row['codpro'];
                                $producto = $row['desprod'];
                                $marca = $row['codmar'];
                                $stopro = $row['stopro'];
                                $datcre = $row['datcre'];


                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                    $prevta = $row['prevta'];
                                } elseif ($precios_por_local == 0) {
                                    $prevta = $row['prevta'];
                                }

                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $prevta_p  FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $prevta = $row_precio[0];
                                        }
                                    }
                                }

                                $stopro = $row[6];
                                ///////MARCA
                                $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$marca'";
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $destab = $row1['destab'];
                                        $abrev = $row1['abrev'];
                                        if ($abrev <> '') {
                                            $destab = $abrev;
                                        }
                                    }
                                }
                                /////VENTAS
                                $no_vendido = 0;
                                if ($local <> 'all') {
                                    $sql1 = "SELECT detalle_venta.invfec FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where codpro = '$codpro' and sucursal = '$local' order by detalle_venta.invnum desc limit 1";
                                } else {
                                    $sql1 = "SELECT invfec FROM detalle_venta where codpro = '$codpro' order by invnum desc limit 1";
                                }
                                $result1 = mysqli_query($conexion, $sql1);
                                if (mysqli_num_rows($result1)) {
                                    while ($row1 = mysqli_fetch_array($result1)) {
                                        $invfec = $row1['invfec'];
                                        if ($fecha_menos24hs > $invfec) {
                                            $no_vendido = 1;
                                        } else {
                                            $no_vendido = 0;
                                        }
                                    }
                                } else {
                                    $no_vendido = 1;
                                    $invfec = "0000-00-00";
                                    $desc = "NO VENDIDO AUN";
                                }
                                //if (($fecha_busqueda == $invfec) || ($no_vendido == 1)) 
                                //echo $no_vendido;
                                //echo " - ";
                                //echo $codpro;
                                //echo "<br>";
                                //echo $invfec;
                                if (($no_vendido == 1)) {
                                    $i++;
                            ?>
                                    <tr>
                                        <td width="30"><?php echo $i ?></td>
                                        <td width="368"><?php echo $producto ?></td>
                                        <td width="313">
                                            <div align="left"><?php echo $destab ?></div>
                                        </td>
                                        <td width="116">
                                            <div align="right"><?php //if ($no_vendido == 1){echo $invfec; }else{ echo $invfec;}    
                                                                ?>
                                                <?php echo fecha($invfec) ?>
                                            </div>
                                        </td>
                                        <td width="77">
                                            <div align="right"><?php echo $stopro ?></div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
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
    <?php }   //////cierro el if (val)
    ?>
</body>

</html>