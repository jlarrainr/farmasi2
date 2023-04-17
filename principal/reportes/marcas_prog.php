<?php
require_once('../session_user.php');
require_once('../../conexion.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
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
$sql = "SELECT nomusu FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
    }
}

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

$sql = "SELECT nlicencia, precios_por_local FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
        $precios_por_local = $row['precios_por_local'];
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
$orden = $_REQUEST['orden'];
$alllocal = $_REQUEST['alllocal'];

if ($pagina == 1) {
    $i = 0;
} else {
    $t = $pagina - 1;
    $i = $t * $registros;
}
if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}

if ($orden == 1) {
    $dato =  "desprod";
} else {
    $dato = "destab,desprod";
}


if ($tipo == 1) {
    $t = "PRECIO X CAJA";
    $t2 = "PRECIO UNITARIO";
    $t3 = "PRECIO BLISTER";
    $t4 = "CANTIDAD BLISTER";
    $t5 = "PRECIO COMPRA";
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
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="377"><strong><?php echo $desemp ?></strong></td>
                        <td width="205"><strong>REPORTE DE MARCAS</strong></td>                        
                        <td width="30">&nbsp;</td>
                        <td width="284">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                        <td width="633">
                            <div align="center"><b><?php echo $t ?> - <?php echo $t1 ?> - <?php
                                                                                            if (($local == 'all') || (($alllocal == '1') && ($precios_por_local == '1'))) {
                                                                                                echo 'TODOS LOS LOCALES';
                                                                                            } else {
                                                                                                echo $nomloc;
                                                                                            }
                                                                                           
                                                                                            ?></b></div>
                        </td>
                        <td width="133">
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
        if ($local <> 'all') {
    ?>

            <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        if ($tipo1 == 1) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 2) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 3) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                            $sql = "SELECT P.codpro,P.desprod,P.codmar,P.stopro,P.prevta,P.$tabla stoprotab,P.factor,P.preuni,P.pcostouni,P.margene,P.costpr,P.costre,P.codcatp,P.preblister,P.blister,P.codfam FROM producto AS P inner join titultabladet AS T on P.codmar = T.codtab where P.$tabla1 > 0 and T.destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 4) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' order by desprod LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 5) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 6) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,stopro,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by $dato";
                        }
                        if ($tipo1 == 7) {
                            //$sql="SELECT desprod,codmar,stopro,prevta,$tabla,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' order by codpro LIMIT $inicio, $registros";
                            $sql = "SELECT codpro,desprod,codmar,prevta,$tabla stoprotab,factor,preuni,pcostouni,margene,costpr,costre,codcatp,preblister,blister,codfam FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla=0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by destab,desprod,codpro";
                        }
                        //echo $tipo1.$sql;
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="100%" border="1" align="center" id="customers">
                                <thead>
                                    <?php if ($tipo == 4) { ?>

                                        <tr>
                                            <th><strong>CODIGO</strong></th>
                                            <th>
                                                <div align="left"><strong>PRODUCTO</strong></div>
                                            </th>
                                            <th colspan="2">
                                                <div align="left"><strong>MARCA / LABORATORIO</strong></div>
                                            </th>
                                            <th><div align="center"><strong>CATEGORIA</strong></div></th>
                                            <th>
                                                <div align="center"><strong>FACTOR</strong></div>
                                            </th>
                                            <th>
                                                <div align="right"><strong>PRECIO DE COSTO</strong></div>
                                            </th>

                                            <th>
                                                <div align="right"><strong>PRECIO VTA</strong></div>
                                            </th>
                                            <th>
                                                <div align="right"><strong>COSTO PRO UNI.</strong></div>
                                            </th>
                                            <th>
                                                <div align="right"><strong>COSTO REPOSICION UNI.</strong></div>
                                            </th>
                                            <th>
                                                <div align="right"><strong>PRECIO VTA X UNI.</strong></div>
                                            </th>
                                        </tr>



                                    <?php } else { ?>
                                        <tr>
                                            <th width="10" align="left" rowspan="2"><strong>N&ordm;</strong></th>
                                            <th width="55" rowspan="2"><strong>COD. PRO</strong></th>
                                            <th width="350" rowspan="2">
                                                <div align="center"><strong>PRODUCTO</strong></div>
                                            </th>
                                            <th width="100" rowspan="2"><div align="center"><strong>PRINCIPIO ACTIVO</strong></div></th>
                                            <th width="300" colspan="2">
                                                <div align="center"><strong>MARCA / LABORATORIO</strong></div>
                                            </th>
                                            <th width="100" rowspan="2"><div align="center"><strong>CATEGORIA</strong></div></th>
                                            <th width="100" rowspan="2">
                                                <div align="center"><strong>FACTOR</strong></div>
                                            </th>
                                            <?php
                                            if ($tipo == 1) {
                                            ?>
                                               <th width="130" rowspan="2">
                                                    <div align="center"><strong>STOCK</strong></div>
                                                </th>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t5 ?></strong></div>
                                                </th>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t ?></strong></div>
                                                </th>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t2 ?></strong></div>
                                                </th>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t4 ?></strong></div>
                                                </th>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t3 ?></strong></div>
                                                </th>


                                                <?php
                                                if (($alllocal == '1') && ($precios_por_local == '1')) {
                                                    for ($i = 2; $i <= $nlicencia; $i++) {


                                                        ///////MARCA
                                                        $sql1 = "SELECT nombre FROM xcompa where codloc = '$i' ";
                                                        $result1 = mysqli_query($conexion, $sql1);
                                                        if (mysqli_num_rows($result1)) {
                                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                                $nombre = $row1['nombre'];
                                                            }
                                                        }
                                                ?>
                                                        <th width="130" rowspan="2">
                                                            <div align="center"><strong><?php echo $t . ' - ' . $nombre ?></strong></div>
                                                        </th>
                                                        <th width="130" rowspan="2">
                                                            <div align="center"><strong><?php echo $t2 . ' - ' . $nombre ?></strong></div>
                                                        </th>

                                                <?php
                                                    }
                                                }
                                                ?>
                                            <?php } else if ($tipo == 3) {
                                            ?>
                                                <th width="65" rowspan="2">
                                                    <div align="center"><strong>CAJAS</strong></div>
                                                </th>
                                                <th width="65" rowspan="2">
                                                    <div align="center"><strong>SUELTAS</strong></div>
                                                </th>
                                            <?php } else if ($tipo == 2) {
                                            ?>
                                                <th width="130" rowspan="2">
                                                    <div align="center"><strong><?php echo $t ?></strong></div>
                                                </th>
                                            <?php } ?>
                                        </tr>

                                        <tr>
                                            <th>Abreviatura</th>
                                            <th>Nombre Completo</th>
                                        </tr>




                                    <?php } ?>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codpro     = $row['codpro'];
                                        $producto   = $row['desprod'];
                                        $marca      = $row['codmar'];
                                        $stopro     = $row['stopro'];
                                        $factor     = $row['factor'];
                                        $stopro     = $row['stoprotab'];
                                        $codmar = $row['codmar'];
                                         $codcatp = $row['codcatp'];
                                         $codfam = $row['codfam'];
                                         






                                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                            $prevta     = $row['prevta'];
                                            $costpr     = $row['costpr'];
                                            $costre     = $row['costre'];
                                            $pcostouni  = $row['pcostouni'];
                                            $preuni     = $row['preuni'];
                                            $margene    = $row['margene'];
                                            $preblister = $row['preblister'];
                                            $blister = $row['blister'];
                                        } elseif ($precios_por_local == 0) {
                                            $prevta     = $row['prevta'];
                                            $costpr     = $row['costpr'];
                                            $costre     = $row['costre'];
                                            $pcostouni  = $row['pcostouni'];
                                            $preuni     = $row['preuni'];
                                            $margene    = $row['margene'];
                                            $preblister = $row['preblister'];
                                            $blister = $row['blister'];
                                        }

                                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                            $sql_precio = "SELECT $prevta_p,$costpr_p,$costre_p,$pcostouni_p,$preuni_p,$margene_p  FROM precios_por_local where codpro = '$codpro'";
                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                            if (mysqli_num_rows($result_precio)) {
                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                    $prevta     = $row_precio[0];
                                                    $costpr     = $row_precio[1];
                                                    $costre     = $row_precio[2];
                                                    $pcostouni  = $row_precio[3];
                                                    $preuni     = $row_precio[4];
                                                    $margene    = $row_precio[5];
                                                }
                                            }
                                        }




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
                                                $stopro = $div1 . ' C ' . $tot1;
                                            }
                                        }
                                        ///////MARCA
                                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$marca'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab = $row1['destab'];
                                                $abrev = $row1['abrev'];
                                            }
                                        }

                                        $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                        $result2 = mysqli_query($conexion, $sql2);
                                        if (mysqli_num_rows($result2)) {
                                            while ($row2 = mysqli_fetch_array($result2)) {
                                                $destab = $row2['destab'];
                                                $abrev = $row2['abrev'];
                                            }
                                        }
                                        
                                        
                                        $destab1='';
                                           $sql3 = "SELECT destab,abrev FROM titultabladet where codtab = '$codcatp'";
                                        $result3 = mysqli_query($conexion, $sql3);
                                        if (mysqli_num_rows($result3)) {
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                $destab1 = $row3['destab'];
                                                $abrev1 = $row3['abrev'];
                                               
                                            }
                                        }

                                        $principioActivo='';
                                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codfam'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $principioActivo = $row1['destab'];
                                            }
                                        }
                                        $i++;
                                    ?>
                                        <?php if ($tipo == 4) { ?>


                                            <tr>
                                                <td align="center"><?php echo $codpro ?></td>
                                                <td><?php echo $producto ?></td>
                                                <td><?php echo $abrev ?></td>
                                                <td><?php echo $destab ?></td>
                                                   <td ><?php echo $destab1 ?></td>
                                                <td align="center"><?php echo $factor ?></td>
                                                <td>
                                                    <div align="right"><?php
                                                                        if ($Preciovtacostopro == 1) {
                                                                            echo $costpr;
                                                                        } else {
                                                                            echo $costre;
                                                                        }
                                                                        ?></div>
                                                </td>
                                                <!-- <td width="80"><div align="right"><?php echo $margene; ?></div></td>-->
                                                <td>
                                                    <div align="right"><?php echo $prevta; ?></div>
                                                </td>
                                                <td>
                                                    <div align="right"><?php echo $numero_formato_frances = number_format($costpr / $factor, 2, '.', ' '); ?></div>
                                                </td>
                                                <td>
                                                    <div align="right"><?php echo $numero_formato_frances = number_format($costre / $factor, 2, '.', ' ');  ?></div>
                                                </td>
                                                <td>
                                                    <div align="right"><?php
                                                                        if ($factor == 1) {
                                                                            echo $prevta;
                                                                        } else {
                                                                            if ($preuni == 0) {
                                                                                echo $numero_formato_frances = number_format($prevta / $factor, 2, '.', ' ');
                                                                            } else {
                                                                                echo $preuni;
                                                                            }
                                                                        }
                                                                        ?></div>
                                                </td>
                                            </tr>





                                        <?php } else { ?>
                                            <tr height="35" <?php if ($date2) { ?> bgcolor="#ff0000" <?php } else { ?>onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';" <?php } ?>>
                                                <td width="32"><?php echo $i ?></td>
                                                <td width="90" align="center"><?php echo $codpro ?></td>
                                                <td width="394"><?php echo $producto ?></td>
                                                <td width="200" align="center"><?php echo $principioActivo ?></td>
                                                <td width="35">
                                                    <div align="center"><?php echo $abrev; ?></div>
                                                </td>
                                                <td width="200">
                                                    <div align="center"><?php echo $destab; ?></div>
                                                </td>
                                                <td width="200"><div align="center"><?php echo $destab1; ?></div></td>
                                                <td width="100">
                                                    <div align="center"><?php echo $factor ?></div>
                                                </td>

                                                <?php
                                                if ($tipo == 1) {
                                                ?>
                                                    <td width="128">
                                                        <div align="center">
                                                            <?php
                                                            if ($tipo == 1) {

                                                                echo stockcaja($stopro, $factor);
                                                            }
                                                            ?>
                                                    </td>
                                                <?php }
                                                ?>
                                                <?php
                                                if ($tipo == 3) {
                                                ?>


                                                    <td width="65">
                                                        <div align="center"><?php echo $calc1 . " ______"; ?></div>
                                                    </td>
                                                    <td width="65">
                                                        <div align="center"><?php echo $calc2 . " ______"; ?></div>
                                                    </td>



                                                <?php
                                                } else {
                                                ?>



                                                    <td width="128">
                                                        <div align="center">
                                                            <?php
                                                            if ($tipo == 1) {

                                                                echo $costpr;
                                                            }
                                                            ?>


                                                            <?php
                                                            if ($tipo == 2) {
                                                                //                    if($tipo1<>7){
                                                                echo $stopro;
                                                                //                    }
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <?php
                                                    if ($tipo == 1) {
                                                    ?>
                                                         <td width="128">
                                                            <div align="center">
                                                                <?php
                                                                if ($tipo == 1) {

                                                                    echo $prevta;
                                                                }
                                                                ?>
                                                        </td>

                                                        <td width="128">
                                                            <div align="center">
                                                                <?php
                                                                if ($tipo == 1) {

                                                                    echo $preuni;
                                                                }
                                                                ?>
                                                        </td>
                                                        <td width="128">
                                                            <div align="center">
                                                                <?php
                                                                if ($tipo == 1) {

                                                                    echo $blister;
                                                                }
                                                                ?>
                                                        </td>
                                                        <td width="128">
                                                            <div align="center">
                                                                <?php
                                                                if ($tipo == 1) {

                                                                    echo $preblister;
                                                                }
                                                                ?>
                                                        </td>
                                                    <?php }
                                                    ?>

                                                    <?php
                                                    if (($alllocal == '1') && ($precios_por_local == '1')) {
                                                        $suma = 0;
                                                        for ($i = 2; $i <= $nlicencia; $i++) {

                                                            $zzcodloc = $i;
                                                            if ($precios_por_local  == 1) {
                                                                require '../../precios_por_local.php';
                                                            }


                                                            $sql_precio = "SELECT $prevta_p,$preuni_p  FROM precios_por_local where codpro = '$codpro'";
                                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                                            if (mysqli_num_rows($result_precio)) {
                                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                                    $prevta1     = $row_precio[0];
                                                                    $preuni1     = $row_precio[1];
                                                                }
                                                            }
                                                    ?>
                                                            <td width="130">
                                                                <div align="center"><strong><?php echo $prevta1 ?></strong></div>
                                                            </td>
                                                            <td width="130">
                                                                <div align="center"><strong><?php echo $preuni1 ?></strong></div>
                                                            </td>

                                                    <?php
                                                        }
                                                    }
                                                    ?>

                                                <?php
                                                }
                                                ?>
                                            </tr>
                                        <?php } ?>
                                    <?php }
                                    ?>
                                <tbody>


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
    <?php
        }   //////cierro si el reporte es de un determinado local
    }   //////cierro el if (val)
    ?>
</body>

</html>