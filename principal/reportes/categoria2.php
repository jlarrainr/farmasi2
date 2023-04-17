<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .Estilo1 {
        color: #FF0000;
        font-weight: bold;
    }
</style>
<?php
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
//$val    = $_REQUEST['val'];
//$tipo   = $_REQUEST['tipo'];
//$tipo1  = $_REQUEST['tipo1'];
$ltdgen = $_REQUEST['ltdgen'];
//$local  = $_REQUEST['local'];
//$inicio = $_REQUEST['inicio'];
//$pagina = $_REQUEST['pagina'];
//$tot_pag = $_REQUEST['tot_pag'];
$tot_pag = $_REQUEST['total_paginas'];
//$registros  = $_REQUEST['registros'];
//$marca1     = $_REQUEST['marca1'];
//$marca2     = $_REQUEST['marca2'];
if ($pagina == 1) {
    $i = 0;
} else {
    $t = $pagina - 1;
    $i = $t * $registros;
}
//if ($local <> 'all')
//{
//require_once("datos_generales.php");	//COGE LA TABLA DE UN LOCAL
//}
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
if ($tipo1 == 7) {
    $t1 = "SOLO PRODUCTOS SIN STOCK";
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
                        <table width="900" border="0" align="center">
                            <tr>
                                <td width="55"><strong>COD. PRO;</strong></td>
                                <td width="350">
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </td>
                                <td width="300">
                                    <div align="left"><strong>CATEGORIA</strong></div>
                                </td>
                                <?php
                                if ($tipo == 3) {
                                ?>

                                    <td width="65">
                                        <div align="right"><strong>CAJAS</strong></div>
                                    </td>
                                    <td width="65">
                                        <div align="right"><strong>SUELTAS</strong></div>
                                    </td>
                                <?php } ?>


                                <?php
                                if ($tipo == 2) {
                                ?>
                                    <?php if ($tipo1 <> 7) { ?>
                                        <td width="130">
                                            <div align="right"><strong><?php echo $t ?></strong></div>
                                        </td>

                                    <?php
                                    }
                                    ?>
                                <?php } ?>


                                <?php
                                if ($tipo == 1) {
                                ?>
                                    <td width="130">
                                        <div align="right"><strong><?php echo $t ?></strong></div>
                                    </td>
                                <?php } ?>





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
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 2) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 3) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 4) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 5) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 6) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,stopro,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        if ($tipo1 == 7) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codcatp,prevta,$tabla,factor,codcatp FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by abrev,desprod,codpro";
                        }
                        //        echo $sql;
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="926" border="0" align="center">
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $codpro = $row['codpro'];
                                    $producto = $row['desprod'];
                                    $marca = $row['codcatp'];
                                    $stopro = $row['stopro'];
                                    $factor = $row['factor'];



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
                                    //		$codcatp     = $row['codcatp'];
                                    $stopro = $row[4];
                                    if ($tipo == 3) {
                                        $calc1 = $stopro / $factor;
                                        $calc2 = $stopro % $factor;
                                        $calc1 = explode(".", $calc1);
                                        $calc1 = $calc1[0];
                                    }
                                    if ($tipo == 2) {
                                        if ($factor > 1) {
                                            $convert1 = $stopro / $factor;
                                            $div1 = floor($convert1);
                                            $mult1 = $factor * $div1;
                                            $tot1 = $stopro - $mult1;
                                            $stopro = $div1 . ' F ' . $tot1;
                                        }
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
                                        <!--            <td width="32"><?php echo $i ?></td>-->
                                        <td width="90"><?php echo $codpro ?></td>
                                        <td width="394"><?php echo $producto ?></td>
                                        <td width="354">
                                            <div align="left"><?php echo $destab ?></div>
                                        </td>
                                        <?php
                                        if ($tipo == 3) {
                                        ?>


                                            <td width="65">
                                                <div align="right"><?php echo $calc1 . " ______"; ?></div>
                                            </td>
                                            <td width="65">
                                                <div align="right"><?php echo $calc2 . " ______"; ?></div>
                                            </td>



                                        <?php
                                        } else {
                                        ?>

                                            <td width="128">
                                                <div align="right">
                                                    <?php
                                                    if ($tipo == 1) {

                                                        echo $prevta;
                                                    }
                                                    ?>


                                                    <?php
                                                    if ($tipo == 2) {
                                                        if ($tipo1 <> 7) {
                                                            echo $stopro;
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </td>



                                        <?php
                                        }
                                        ?>
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
    <!--</body>
</html>-->