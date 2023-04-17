<?php
require_once('../session_user.php');
require_once('../../conexion.php');
require_once('../../titulo_sist.php');
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


$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}
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
$tipo = $_REQUEST['tipo'];
$tipo1 = $_REQUEST['tipo1'];
$ltdgen = $_REQUEST['ltdgen'];
$local = $_REQUEST['local'];
$inicio = $_REQUEST['inicio'];
$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
$registros = $_REQUEST['registros'];
$marca1 = $_REQUEST['marca1'];
$marca2 = $_REQUEST['marca2'];
if ($pagina == 1) {
    $i = 0;
} else {
    $t = $pagina - 1;
    $i = $t * $registros;
}
if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}
if ($tipo == 1) {
    $t = "LISTA DE PRECIOS";
}
if ($tipo == 2) {
    $t = "LISTA DE STOCKS";
}
if ($tipo == 3) {
    $t = "FORMATO DE INVENTARIOS";
}
if ($tipo1 == 1) {
    $t1 = "TODOS LOS PRODUCTOS";
}
if ($tipo1 == 2) {
    $t1 = "SOLO PRODUCTOS CON STOCK";
}
if ($tipo1 == 3) {
    $t1 = "PRODUCTOS CON STOCK MINIMO";
}
if ($tipo1 == 4) {
    $t1 = "PRODUCTOS SIN STOCK MINIMO";
}
if ($tipo1 == 5) {
    $t1 = "PRODUCTOS CON STOCK Y CON STOCK MINIMO";
}
if ($tipo1 == 6) {
    $t1 = "PRODUCTOS CON STOCK Y SIN STOCK MINIMO";
}
//$fecha = time (); 
//echo date ( "h:i:s" , $fecha ); 
?>

<body>
    <table width="930" border="0" align="center">
        <tr>
            <td>
                <table width="914" border="0">
                    <tr>
                        <td width="377"><strong><?php echo $desemp ?></strong></td>
                        <td width="205"><strong>REPORTE DE MARCAS</strong></td>
                        <td width="30">&nbsp;</td>
                        <td width="284">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="914" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="633">
                            <div align="center"><b><?php echo $t ?> - <?php echo $t1 ?> - <?php
                                                                                            if ($local == 'all') {
                                                                                                echo 'TODOS LOS LOCALES';
                                                                                            } else {
                                                                                                echo $nomloc;
                                                                                            }
                                                                                            ?></b></div>
                        </td>
                        <td width="133">
                            <div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
        if ($local <> 'all') {
    ?>
            <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="926" border="0" align="center">
                            <tr>
                                <td width="32"><strong>N&ordm;</strong></td>
                                <td width="395">
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </td>
                                <td width="351">
                                    <div align="left"><strong>MARCA</strong></div>
                                </td>
                                <td width="130">
                                    <div align="right"><strong><?php echo $t ?></strong></div>
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
                        if ($tipo1 == 1) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
                        }
                        if ($tipo1 == 2) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
                        }
                        if ($tipo1 == 3) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by desprod";
                        }
                        if ($tipo1 == 4) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by desprod";
                        }
                        if ($tipo1 == 5) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
                        }
                        if ($tipo1 == 6) {
                            $sql = "SELECT desprod,codcatp,stopro,prevta,$tabla,factor,codpro FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
                        }
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="926" border="0" align="center">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $producto = $row['desprod'];
                                    $marca = $row['codcatp'];
                                    $stopro = $row['stopro'];
                                    $factor = $row['factor'];
                                    $stopro = $row[4];
                                    $codpro = $row['codpro'];



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


                                    if ($tipo == 3) {
                                        $calc1 = $stopro / $factor;
                                        $calc2 = $stopro % $factor;
                                        $calc1 = explode(".", $calc1);
                                        $calc1 = $calc1[0];
                                    }
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
                                    $i++;
                                ?>
                                    <tr>
                                        <td width="32"><?php echo $i ?></td>
                                        <td width="394"><?php echo $producto ?></td>
                                        <td width="354">
                                            <div align="left"><?php echo $destab ?></div>
                                        </td>
                                        <td width="128">
                                            <div align="right"><?php
                                                                if ($tipo == 1) {
                                                                    echo $prevta;
                                                                }
                                                                ?><?php
                                                                    if ($tipo == 2) {
                                                                        echo $stopro;
                                                                    }
                                                                    ?><?php
                                                                        if ($tipo == 3) {
                                                                            echo $calc1 . " C ";
                                                                            echo $calc2 . " U ";
                                                                        }
                                                                        ?></div>
                                        </td>
                                    </tr>
                                <?php }
                                ?>
                            </table>
                        <?php
                        } else {
                        ?>
                            <div class="siniformacion">
                                <center>No se logro encontrar informacion con los datos ingresados</center>
                            </div>
                        <?php }
                        ?>
                    </td>
                </tr>
            </table>
    <?php
        }   //////cierro si el reporte es de un determinado local
    }   //////cierro el if (val)
    ?>
</body>

</html>