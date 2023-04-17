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
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

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
    $date1 = fecha1($_REQUEST['date1']);
    $date2 = fecha1($_REQUEST['date2']);
    $cliente = $_REQUEST['cliente'];
    $vendedor = $_REQUEST['vendedor'];
    $t1 = $_REQUEST['t1'];
    $t2 = $_REQUEST['t2'];
    $opcion = $_REQUEST['opcion'];
    $inicio = $_REQUEST['inicio'];
    $pagina = $_REQUEST['pagina'];
    $tot_pag = $_REQUEST['tot_pag'];
    $registros = $_REQUEST['registros'];
    $registros = 40;
    $pagina = $_REQUEST["pagina"];
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $registros;
    }
//echo $cliente;
    if ($cliente == "all_cli") {
        $sql = "SELECT codcli,descli FROM cliente where descli = 'PUBLICO EN GENERAL'";
    } else {
        $sql = "SELECT codcli,descli FROM cliente where codcli = '$cliente'";
    }
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $cliente = $row['codcli'];
            $descli = $row['descli'];
        }
    }
    if ($descli == "PUBLICO EN GENERAL") {
        $publico = 1;  /////publico en general
    } else {
        $publico = 0;
    }
    if (($t1 <> "") and ( $t2 <> "")) {
        $rango = 1;
    } else {
        $rango = 0;
    }
    ?>
    <body>
        <table width="930" border="0" align="center">
            <tr>
                <td>
                    <table width="914" border="0">
                        <tr>
                            <td width="377"><strong><?php echo $desemp ?> </strong></td>
                            <td width="205"><strong>REPORTE DE VENTAS POR CLIENTES </strong></td>
                            <td width="30">&nbsp;</td>
                            <td width="284"><div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div></td>
                        </tr>
                    </table>
                    <table width="914" border="0">
                        <tr>
                            <td width="134"><strong>PAGINA # </strong></td>
                            <td width="633"><div align="center"><?php
                                    if ($descli == 'PUBLICO EN GENERAL') {
                                        echo 'TODOS LOS CLIENTES';
                                    } else {
                                        echo $descli;
                                    }
                                    ?></div></td>
                            <td width="133"><div align="right">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div></td>
                        </tr>
                    </table>
                    <div align="center"></div>
                </td>
            </tr>
        </table>
        <?php
        if ($val == 1) { //////SI SE HA PRESIONADO EL BOTON BUSCAR
            ?>
            <table width="926" border="0" align="center">
                <tr>
                    <td><div align="center"><strong>VENTAS</strong></div></td>
                </tr>
            </table>
            <?php
            if ($opcion == 1) { ////VENTAS POR CLIENTE RESUMIDO
                ?>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="926" border="0" align="center">
                                <tr>
                                    <td width="34"><strong>N&ordm;</strong></td>
                                    <td width="413"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="154"><div align="right"><strong>NRO VENTAS </strong></div></td>
                                    <td width="145"><div align="right"><strong>MONTO TOTAL DE VENTAS </strong></div></td>
                                    <td width="77"><div align="right"><strong>UTILIDAD</strong></div></td>
                                  <!--  <td width="77"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <?php
                $i = 0;
                $sumtot = 0;
                ?>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT invnum,invtot FROM venta where invfec between '$date1' and '$date2' and cuscod = '$cliente' and val_habil = '0' and invtot <> '0'";
                        } else {
                            $sql1 = "SELECT invnum,invtot FROM venta where invfec between '$date1' and '$date2' and cuscod = '$cliente' and usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                        }
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) { //(*)
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $codventa = $row1['invnum'];
                                $invtot = $row1['invtot'];
                                $sumtot = $sumtot + $invtot;
                                $sum_mont = 0;
                                $sum_price = 0;
                                $sum_pvta = 0;
                                $nrovent++;
                                $sql2 = "SELECT prisal,canpro,fraccion,factor,cospro FROM detalle_venta where invnum = '$codventa'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $prisal = $row2['prisal'];
                                        $canpro = $row2['canpro'];
                                        $fraccion = $row2['fraccion'];
                                        $factor = $row2['factor'];
                                        $pcostouni = $row2['cospro'];
                                        //$prevta    = $pcostouni/$factor;
                                        $prevta = $pcostouni * $canpro;
                                        $monto = 0;
                                        if ($fraccion == "T") {
                                            //$prevta = $pcostouni * $canpro;
                                            $precio = $prisal * $canpro;
                                        } else {
                                            $div = $prisal / $factor;
                                            //$div1	= $pcostouni/$factor;
                                            $div = number_format($div, 2, ',', '.');
                                            //$div1   = number_format($div1,2,',','.');
                                            $precio = $div * $canpro;
                                            //$prevta = $div1 * $canpro;
                                        }
                                        $sum_price = $sum_price + $precio;
                                        $sum_pvta = $sum_pvta + $prevta;
                                        $monto = $precio - $prevta;
                                        $sum_mont = $sum_mont + $monto;
                                    }
                                }
                                if ($sum_pvta <> 0) {
                                    $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                                }
                            }
                            ?>
                            <tr>
                                <td width="38"><?php echo $i + 1; ?></td>
                                <td width="414"><?php echo $descli ?></td>
                                <td width="155"><div align="right"><?php echo $nrovent ?></div></td>
                                <td width="149"><div align="right"><?php echo $numero_formato_frances = number_format($sumtot, 2, '.', ' '); ?></div></td>
                                <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                              <!--  <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL IF DE LA CONSULTA (*)
                        else {
                            ?> <div class="siniformacion">
                                <center>
                                    No se logro encontrar informacion con los datos ingresados
                                </center>
                            </div>
                            <?php
                        }
                    } /////CIERRO SI EL PUBLICO ES = 0
                    else { //////PUBLICO EN GENERAL
                        if ($vendedor == "all") {
                            $sql1 = "SELECT cuscod FROM venta where invfec between '$date1' and '$date2' and val_habil = '0' group by cuscod";
                        } else {
                            $sql1 = "SELECT cuscod FROM venta where invfec between '$date1' and '$date2' and val_habil = '0' and usecod = '$vendedor' group by cuscod";
                        }
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $cuscod = $row1[0];
                                $nrovent = 0;
                                $sumtot = 0;
                                $sum_mont = 0;
                                $sum_price = 0;
                                $sum_pvta = 0;
                                //echo $cuscod;
                                if ($vendedor == "all") {
                                    $sql2 = "SELECT invnum,descli,invtot FROM venta inner join cliente on cliente.codcli = venta.cuscod where codcli = '$cuscod' and invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0'";
                                } else {
                                    $sql2 = "SELECT invnum,descli,invtot FROM venta inner join cliente on cliente.codcli = venta.cuscod where codcli = '$cuscod' and invfec between '$date1' and '$date2' and val_habil = '0' and usecod = '$vendedor' and invtot <> '0'";
                                }
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $codventa = $row2['invnum'];
                                        $client = $row2['descli'];
                                        $invtot = $row2['invtot'];
                                        $sumtot = $sumtot + $invtot;
                                        $sum_mont = 0;
                                        $sum_price = 0;
                                        $sum_pvta = 0;
                                        $nrovent++;
                                        $sql3 = "SELECT prisal,canpro,fraccion,factor,cospro FROM detalle_venta where invnum = '$codventa'";
                                        $result3 = mysqli_query($conexion, $sql3);
                                        if (mysqli_num_rows($result3)) {
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                $prisal = $row3['prisal'];
                                                $canpro = $row3['canpro'];
                                                $fraccion = $row3['fraccion'];
                                                $factor = $row3['factor'];
                                                $pcostouni = $row3['cospro'];
                                                //$prevta    = $pcostouni/$factor;	
                                                $prevta = $pcostouni * $canpro;
                                                $monto = 0;
                                                if ($fraccion == "T") {
                                                    //$prevta = $pcostouni * $canpro;
                                                    $precio = $prisal * $canpro;
                                                } else {
                                                    $div = $prisal / $factor;
                                                    //$div1	= $pcostouni/$factor;
                                                    $div = number_format($div, 2, ',', '.');
                                                    //$div1   = number_format($div1,2,',','.');
                                                    $precio = $div * $canpro;
                                                    //$prevta = $div1 * $canpro;
                                                }
                                                $sum_price = $sum_price + $precio;
                                                $sum_pvta = $sum_pvta + $prevta;
                                                $monto = $precio - $prevta;
                                                $sum_mont = $sum_mont + $monto;
                                            }
                                        }
                                        if ($sum_pvta <> 0) {
                                            $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                                        }
                                    }
                                }
                                $i++;
                                ?>
                                <tr>
                                    <td width="38"><?php echo $i ?></td>
                                    <td width="414"><?php echo $client ?></td>
                                    <td width="155"><div align="right"><?php echo $nrovent ?></div></td>
                                    <td width="149"><div align="right"><?php echo $numero_formato_frances = number_format($sumtot, 2, '.', ' '); ?></div></td>
                                    <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                                   <!-- <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                                </tr>
                                <?php
                            }//// CIERRO EL WHILE
                        }/////CIERRO EL IF DE LA CONSULTA
                    }/////CIERRO EL ELSE
                    ?>
                </table>
                <?php
            } /// CIERRO OPCION = 1 VENTAS POR CLIENTE RESUMIDO
            if ($opcion == 2) {  ////VENTAS POR CLIENTE DETALLADO POR DOCUMENTO
                ?>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="926" border="0" align="center">
                                <tr>
                                    <td width="28"><strong>N&ordm;</strong></td>
                                    <td width="247"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="47"><div align="left"><strong>FECHA</strong></div></td>
                                    <td width="127"><div align="right"><strong>INTERNO DOCUMENTO </strong></div></td>
                                    <td width="213"><div align="left"><strong>VENDEDOR</strong></div></td>
                                    <td width="95"><div align="right"><strong>MONTO VENTA </strong></div></td>
                                    <td width="59"><div align="right"><strong>UTILIDAD </strong></div></td>
                                  <!--  <td width="76"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT invnum,invtot,cuscod,usecod,invfec,nrovent FROM venta where invfec between '$date1' and '$date2' and cuscod = '$cliente' and val_habil = '0' and invtot <> '0'";
                        } else {
                            $sql1 = "SELECT invnum,invtot,cuscod,usecod,invfec,nrovent FROM venta where invfec between '$date1' and '$date2' and cuscod = '$cliente' and usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT invnum,invtot,cuscod,usecod,invfec,nrovent FROM venta where invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0'";
                        } else {
                            $sql1 = "SELECT invnum,invtot,cuscod,usecod,invfec,nrovent FROM venta where invfec between '$date1' and '$date2' and usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $codventa = $row1['invnum'];
                            $invtot = $row1['invtot'];
                            $invtot2 += $row1['invtot'];
                            $cuscod = $row1['cuscod'];
                            $usecod = $row1['usecod'];
                            $invfec = $row1['invfec'];
                            $nrovent = $row1['nrovent'];
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            $sql2 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $user = $row2['nomusu'];
                                }
                            }
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            $sql3 = "SELECT prisal,canpro,fraccion,factor,cospro FROM detalle_venta where invnum = '$codventa'";
                            $result3 = mysqli_query($conexion, $sql3);
                            if (mysqli_num_rows($result3)) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    $prisal = $row3['prisal'];
                                    $canpro = $row3['canpro'];
                                    $fraccion = $row3['fraccion'];
                                    $factor = $row3['factor'];
                                    $pcostouni = $row3['cospro'];
                                    //$prevta    = $pcostouni/$factor;	
                                    $prevta = $pcostouni * $canpro;
                                    $monto = 0;
                                    if ($fraccion == "T") {
                                        //$prevta = $pcostouni * $canpro;
                                        $precio = $prisal * $canpro;
                                    } else {
                                        $div = $prisal / $factor;
                                        //$div1	= $pcostouni/$factor;
                                        $div = number_format($div, 2, ',', '.');
                                        //$div1   = number_format($div1,2,',','.');
                                        $precio = $div * $canpro;
                                        //$prevta = $div1 * $canpro;
                                    }
                                    $sum_price = $sum_price + $precio;
                                    $sum_pvta = $sum_pvta + $prevta;
                                    $monto = $precio - $prevta;
                                    $sum_mont = $sum_mont + $monto;
                                }
                            }
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $sum_mont2 = $sum_mont2 + $sum_mont;
                            $porcentaje2 = $porcentaje2 + $porcentaje;

                            $i++;
                            ?>
                            <tr>
                                <td width="32"><?php echo $i; ?></td>
                                <td width="248"><?php echo $client ?></td>
                                <td width="49"><div align="left"><?php echo fecha($invfec) ?></div></td>
                                <td width="130"><div align="center"><?php echo $nrovent ?></div></td>
                                <td width="215"><div align="left"><?php echo $user ?></div></td>
                                <td width="97"><div align="right"><?php echo $invtot ?></div></td>
                                <td width="61"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                            <!--    <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                        <?php } ?>/////CIERRO EL WHILE
                        <tr bgcolor="#CCCCCC">
                            <td colspan="5" width="450"><div align="center"><strong>TOTAL</strong></div></td>
                            <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($invtot2, 2, '.', ' '); ?></div></td>
                            <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont2, 2, '.', ' '); ?></div></td>
                          <!--  <td width="90"><div align="right"><?php echo $numero_formato_frances = number_format(333, 2, '.', ' '); ?> %<</div></td>-->
                        </tr>

                        <?php
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 2 VENTAS POR CLIENTE DETALLADO POR DOCUMENTO
            if ($opcion == 3) {  ////VENTAS POR CLIENTE DETALLADO POR PRODUCTO
                ?>
                <table width="1067" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1067">
                            <table width="1067" border="0" align="center">
                                <tr>
                                    <td width="24"><strong>N&ordm;</strong></td>
                                    <td width="201"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="45"><div align="left"><strong>FECHA</strong></div></td>
                                    <td width="75"><div align="center"><strong>INTERNO </strong></div></td>
                                    <td width="143"><div align="left"><strong>VENDEDOR</strong></div></td>
                                    <td width="172"><div align="left"><strong>PRODUCTO VENDIDO</strong></div></td>
                                    <td width="146"><div align="left"><strong>MARCA </strong></div></td>
                                    <td width="79"><div align="right"><strong>MONTO VENTA </strong></div></td>
                                    <td width="63"><div align="right"><strong>UTILIDAD </strong></div></td>
                                   <!-- <td width="77"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>

                            </table>
                        </td>
                    </tr>
                </table>
                <table width="1071" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.invnum,prisal,pripro,canpro,fraccion,venta.cuscod,venta.usecod,venta.invfec,nrovent,codpro,factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and val_habil = '0' and invtot <> '0'";
                        } else {
                            $sql1 = "SELECT venta.invnum,prisal,pripro,canpro,fraccion,venta.cuscod,venta.usecod,venta.invfec,nrovent,codpro,factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.invnum,prisal,pripro,canpro,fraccion,venta.cuscod,venta.usecod,venta.invfec,nrovent,codpro,factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec between '$date1' and '$date2' and val_habil = '0'  and invtot <> '0'";
                        } else {
                            $sql1 = "SELECT venta.invnum,prisal,pripro,canpro,fraccion,venta.cuscod,venta.usecod,venta.invfec,nrovent,codpro,factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0'  and invtot <> '0'";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $invnum = $row1['invnum'];
                            $prisal = $row1['prisal'];
                            $pripro = $row1['pripro'];
                            $canpro = $row1['canpro'];
                            $fraccion = $row1['fraccion'];
                            $cuscod = $row1['cuscod'];
                            $usecod = $row1['usecod'];
                            $invfec = $row1['invfec'];
                            $nrovent = $row1['nrovent'];
                            $codpro = $row1['codpro'];
                            $factor = $row1['factor'];
                            $pcostouni = $row1['cospro'];
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            $sql2 = "SELECT desprod,codmar FROM producto where codpro = '$codpro' and eliminado='0'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $product = $row2['desprod'];
                                    $codmar = $row2['codmar'];
                                }
                            }
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $marca = $row2['destab'];
                                    $abrev = $row2['abrev'];
                                    if ($abrev <> '') {
                                        $marca = $abrev;
                                    }
                                }
                            }
                            $sql2 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $user = $row2['nomusu'];
                                }
                            }
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result2)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            //$prevta    = $pcostouni/$factor;
                            $prevta = $pcostouni * $canpro;
                            $monto = 0;
                            if ($fraccion == "T") {
                                //$prevta = $pcostouni * $canpro;
                                $precio = $prisal * $canpro;
                            } else {
                                $div = $prisal / $factor;
                                //$div1	= $pcostouni/$factor;
                                $div = number_format($div, 2, ',', '.');
                                //$div1   = number_format($div1,2,',','.');
                                $precio = $div * $canpro;
                                //$prevta = $div1 * $canpro;
                            }
                            $sum_price = $sum_price + $precio;
                            $sum_pvta = $sum_pvta + $prevta;
                            $monto = $precio - $prevta;
                            $sum_mont = $sum_mont + $monto;
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $i++;
                            ?>
                            <tr>
                                <td width="31"><?php echo $i; ?></td>
                                <td width="200"><?php echo $client ?></td>
                                <td width="49"><div align="left"><?php echo fecha($invfec) ?></div></td>
                                <td width="73"><div align="center"><?php echo $nrovent ?></div></td>
                                <td width="145"><div align="left"><?php echo $user ?></div></td>
                                <td width="174"><div align="left"><?php echo $product ?></div></td>
                                <td width="151"><div align="left"><?php echo $marca ?></div></td>
                                <td width="78"><div align="right"><?php echo $pripro ?></div></td>
                                <td width="68"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                             <!--   <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 3 VENTAS POR CLIENTE DETALLADO POR PRODUCTO
            if ($opcion == 4) { ///VENTAS POR CLIENTE RESUMIDO POR MARCA
                ?>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1067">
                            <table width="926" border="0" align="center">
                                <tr>
                                    <td width="26"><strong>N&ordm;</strong></td>
                                    <td width="221"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="278"><div align="left"><strong>MARCA</strong></div></td>
                                    <td width="121"><div align="right"><strong>NRO OPERACIONES </strong></div></td>
                                    <td width="96"><div align="right"><strong>MONTO VENTA</strong></div></td>
                                    <td width="77"><div align="right"><strong>UTILIDAD</strong></div></td>
                                 <!--   <td width="77"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="930" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codmar";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codmar";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codmar";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codmar FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codmar";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $cuscod = $row1['cuscod'];
                            $codmar = $row1['codmar'];
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
                            $nrooperacion = 0;
                            $sumpripro = 0;
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            if ($vendedor == "all") {
                                $sql3 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.cuscod = '$cuscod' and venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0'";
                            } else {
                                $sql3 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.cuscod = '$cuscod' and venta.usecod = '$vendedor' and venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0'";
                            }
                            $result3 = mysqli_query($conexion, $sql3);
                            if (mysqli_num_rows($result3)) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    $prisal = $row3['prisal'];
                                    $pripro = $row3['pripro'];
                                    $canpro = $row3['canpro'];
                                    $fraccion = $row3['fraccion'];
                                    $factor = $row3['factor'];
                                    $pcostouni = $row3['cospro'];
                                    $sumpripro = $sumpripro + $pripro;
                                    $nrooperacion++;
                                    //$prevta    = $pcostouni/$factor;
                                    $prevta = $pcostouni * $canpro;
                                    $monto = 0;
                                    if ($fraccion == "T") {
                                        $precio = $prisal * $canpro;
                                        //$prevta = $pcostouni * $canpro;
                                    } else {
                                        $div = $prisal / $factor;
                                        //$div1	= $pcostouni/$factor;
                                        $div = number_format($div, 2, ',', '.');
                                        //$div1   = number_format($div1,2,',','.');
                                        $precio = $div * $canpro;
                                        //$prevta = $div1 * $canpro;
                                    }
                                    $sum_price = $sum_price + $precio;
                                    $sum_pvta = $sum_pvta + $prevta;
                                    $monto = $precio - $prevta;
                                    $sum_mont = $sum_mont + $monto;
                                }
                            }
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            $i++;
                            ?>
                            <tr>
                                <td width="34"><?php echo $i; ?></td>
                                <td width="221"><?php echo $client ?></td>
                                <td width="277"><div align="left"><?php echo $destab ?></div></td>
                                <td width="122"><div align="right"><?php echo $nrooperacion ?></div></td>
                                <td width="100"><div align="right"><?php echo $sumpripro ?></div></td>
                                <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                               <!-- <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 4 VENTAS POR CLIENTE RESUMIDO POR MARCA
            if ($opcion == 5) { ///VENTAS POR CLIENTE RESUMIDO POR PRODUCTO
                ?>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1067">
                            <table width="1014" border="0" align="center">
                                <tr>
                                    <td width="23"><strong>N&ordm;</strong></td>
                                    <td width="180"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="159"><div align="left"><strong>MARCA</strong></div></td>
                                    <td width="209"><div align="left"><strong>PRODUCTO VENDIDO </strong></div></td>
                                    <td width="61"><div align="right"><strong>CANTIDAD</strong></div></td>
                                    <td width="125"><div align="right"><strong>NRO DE OPERACIONES</strong></div></td>
                                    <td width="79"><div align="right"><strong>MONTO  VENTA </strong></div></td>
                                    <td width="63"><div align="right"><strong>UTILIDAD </strong></div></td>
                                   <!-- <td width="77"><div align="right"><strong>% UTILIDAD</strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and val_habil = '0'  and invtot <> '0' group by venta.cuscod, codmar,codpro";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and venta.usecod = '$vendedor' and val_habil = '0'  and invtot <> '0' group by venta.cuscod, codmar,codpro";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and val_habil = '0'  and invtot <> '0' group by venta.cuscod, codmar, codpro";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codmar, codpro FROM detalle_venta inner join venta on detalle_venta.invnum = venta.invnum where venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0'  and invtot <> '0' group by venta.cuscod, codmar, codpro";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $cuscod = $row1['cuscod'];
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
                            $sql2 = "SELECT desprod FROM producto where codpro = '$codpro' and eliminado='0'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $product = $row2['desprod'];
                                }
                            }
                            $nrooperacion = 0;
                            $canpro1 = 0;
                            $sumpripro = 0;
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            if ($vendedor == "all") {
                                $sql3 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.cuscod = '$cuscod' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and val_habil = '0'  and invtot <> '0'";
                            } else {
                                $sql3 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where producto.codmar = '$codmar' and venta.cuscod = '$cuscod' and producto.codpro = '$codpro' and venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0'  and invtot <> '0'";
                            }
                            $result3 = mysqli_query($conexion, $sql3);
                            if (mysqli_num_rows($result3)) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    $prisal = $row3['prisal'];
                                    $pripro = $row3['pripro'];
                                    $canpro = $row3['canpro'];
                                    $fraccion = $row3['fraccion'];
                                    $factor = $row3['factor'];
                                    $pcostouni = $row3['cospro'];
                                    $sumpripro = $sumpripro + $pripro;
                                    $nrooperacion++;
                                    //$prevta    = $pcostouni/$factor;
                                    $prevta = $pcostouni * $canpro;
                                    $monto = 0;
                                    if ($fraccion == "T") {
                                        //$prevta = $pcostouni * $canpro;
                                        $precio = $prisal * $canpro;
                                        $canpro1 = $canpro1 + $canpro;
                                    } else {
                                        $div = $prisal / $factor;
                                        //$div1	= $pcostouni/factor;
                                        $div = number_format($div, 2, ',', '.');
                                        //$div1   = number_format($div1,2,',','.');
                                        $precio = $div * $canpro;
                                        //$prevta = $div1 * $canpro;
                                        $canpro = $canpro * $factor;
                                        $canpro1 = $canpro1 + $canpro;
                                    }
                                    $sum_price = $sum_price + $precio;
                                    $sum_pvta = $sum_pvta + $prevta;
                                    $monto = $precio - $prevta;
                                    $sum_mont = $sum_mont + $monto;
                                }
                            }
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            $i++;
                            ?>
                            <tr>
                                <td width="29"><?php echo $i; ?></td>
                                <td width="180"><?php echo $client ?></td>
                                <td width="162"><div align="left"><?php echo $destab ?></div></td>
                                <td width="209"><div align="left"><?php echo $product ?></div></td>
                                <td width="67"><div align="right"><?php echo $canpro1 ?></div></td>
                                <td width="124"><div align="right"><?php echo $nrooperacion ?></div></td>
                                <td width="80"><div align="right"><?php echo $numero_formato_frances = number_format($sumpripro, 2, '.', ' '); ?></div></td>
                                <td width="67"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                              <!--  <td width="82"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 5 VENTAS POR CLIENTE RESUMIDO POR PRODUCTO
            if ($opcion == 6) { ///VENTAS POR CLIENTE RESUMIDO POR LINEA DE PRODUCTO
                ?>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1067">
                            <table width="1014" border="0" align="center">
                                <tr>
                                    <td width="28"><strong>N&ordm;</strong></td>
                                    <td width="242"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="305"><div align="left"><strong>LINEA DE PRODUCTO</strong></div></td>
                                    <td width="131"><div align="right"><strong>NRO OPERACIONES </strong></div></td>
                                    <td width="105"><div align="right"><strong>MONTO VENTA</strong></div></td>
                                    <td width="84"><div align="right"><strong>UTILIDAD</strong></div></td>
                                 <!--   <td width="89"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codfam FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codfam";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codfam FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codfam";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, codfam FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codfam";
                        } else {
                            $sql1 = "SELECT venta.cuscod, codfam FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod, codfam";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $cuscod = $row1['cuscod'];
                            $codfam = $row1['codfam'];
                            $nrooperacion = 0;
                            $sumpripro = 0;
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            if ($vendedor == "all") {
                                $sql2 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.cuscod = '$cuscod' and venta.invfec between '$date1' and '$date2' and codfam = '$codfam' and val_habil = '0' and invtot <> '0'";
                            } else {
                                $sql2 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.cuscod = '$cuscod' and venta.invfec between '$date1' and '$date2' and codfam = '$codfam' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                            }
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $prisal = $row2['prisal'];
                                    $pripro = $row2['pripro'];
                                    $canpro = $row2['canpro'];
                                    $fraccion = $row2['fraccion'];
                                    $factor = $row2['factor'];
                                    $pcostouni = $row2['cospro'];
                                    $sumpripro = $sumpripro + $pripro;
                                    $nrooperacion++;
                                    //$prevta    = $pcostouni/$factor;
                                    $prevta = $pcostouni * $canpro;
                                    $monto = 0;
                                    if ($fraccion == "T") {
                                        $precio = $prisal * $canpro;
                                        //$prevta = $pcostouni * $canpro;
                                    } else {
                                        $div = $prisal / $factor;
                                        //$div1	= $pcostouni/factor;
                                        $div = number_format($div, 2, ',', '.');
                                        //$div1   = number_format($div1,2,',','.');
                                        $precio = $div * $canpro;
                                        //$prevta = $div1 * $canpro;
                                    }
                                    $sum_price = $sum_price + $precio;
                                    $sum_pvta = $sum_pvta + $prevta;
                                    $monto = $precio - $prevta;
                                    $sum_mont = $sum_mont + $monto;
                                }
                            }
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codfam'";
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
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            $i++;
                            ?>
                            <tr>
                                <td width="37"><?php echo $i; ?></td>
                                <td width="242"><?php echo $client ?></td>
                                <td width="305"><div align="left"><?php echo $destab ?></div></td>
                                <td width="133"><div align="right"><?php echo $nrooperacion ?></div></td>
                                <td width="109"><div align="right"><?php echo $sumpripro ?></div></td>
                                <td width="87"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                              <!--  <td width="91"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 6 VENTAS POR CLIENTE RESUMIDO POR LINEA DE PRODUCTO
            if ($opcion == 7) { ///VENTAS POR CLIENTE RESUMIDO POR CLASE DE PRODUCTO
                ?>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="1067">
                            <table width="1014" border="0" align="center">
                                <tr>
                                    <td width="28"><strong>N&ordm;</strong></td>
                                    <td width="242"><div align="left"><strong>CLIENTE</strong></div></td>
                                    <td width="305"><div align="left"><strong>CLASE DE PRODUCTO</strong></div></td>
                                    <td width="131"><div align="right"><strong>NRO OPERACIONES </strong></div></td>
                                    <td width="105"><div align="right"><strong>MONTO VENTA</strong></div></td>
                                    <td width="84"><div align="right"><strong>UTILIDAD</strong></div></td>
                                 <!--   <td width="89"><div align="right"><strong>% UTILIDAD </strong></div></td>-->
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table width="1020" border="1" align="center" cellpadding="0" cellspacing="0">
                    <?php
                    if ($publico == 0) {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod,coduso FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and val_habil = '0' and invtot <> '0' group by venta.cuscod,coduso";
                        } else {
                            $sql1 = "SELECT venta.cuscod,coduso FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.cuscod = '$cliente' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod,coduso";
                        }
                    } else {
                        if ($vendedor == "all") {
                            $sql1 = "SELECT venta.cuscod, coduso FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and val_habil = '0' and invtot <> '0' group by venta.cuscod, coduso";
                        } else {
                            $sql1 = "SELECT venta.cuscod, coduso FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.invfec between '$date1' and '$date2' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0' group by venta.cuscod, coduso";
                        }
                    }
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $cuscod = $row1['cuscod'];
                            $coduso = $row1['coduso'];
                            $nrooperacion = 0;
                            $sumpripro = 0;
                            $sum_mont = 0;
                            $sum_price = 0;
                            $sum_pvta = 0;
                            if ($vendedor == "all") {
                                $sql2 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.cuscod = '$cuscod' and venta.invfec between '$date1' and '$date2' and coduso = '$coduso' and val_habil = '0' and invtot <> '0'";
                            } else {
                                $sql2 = "SELECT prisal,pripro,canpro,fraccion,detalle_venta.factor,cospro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum inner join producto on detalle_venta.codpro = producto.codpro where venta.cuscod = '$cuscod' and venta.invfec between '$date1' and '$date2' and coduso = '$coduso' and venta.usecod = '$vendedor' and val_habil = '0' and invtot <> '0'";
                            }
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $prisal = $row2['prisal'];
                                    $pripro = $row2['pripro'];
                                    $canpro = $row2['canpro'];
                                    $fraccion = $row2['fraccion'];
                                    $factor = $row2['factor'];
                                    $pcostouni = $row2['cospro'];
                                    $sumpripro = $sumpripro + $pripro;
                                    $nrooperacion++;
                                    //$prevta    = $pcostouni/$factor;
                                    $prevta = $pcostouni * $canpro;
                                    $monto = 0;
                                    if ($fraccion == "T") {
                                        $precio = $prisal * $canpro;
                                        //$prevta = $pcostouni * $canpro;
                                    } else {
                                        $div = $prisal / $factor;
                                        //$div1	= $pcostouni/factor;
                                        $div = number_format($div, 2, ',', '.');
                                        ///$div1   = number_format($div1,2,',','.');
                                        $precio = $div * $canpro;
                                        //$prevta = $div1 * $canpro;
                                    }
                                    $sum_price = $sum_price + $precio;
                                    $sum_pvta = $sum_pvta + $prevta;
                                    $monto = $precio - $prevta;
                                    $sum_mont = $sum_mont + $monto;
                                }
                            }
                            if ($sum_pvta <> 0) {
                                $porcentaje = (($sum_price - $sum_pvta) / $sum_pvta) * 100;
                            }
                            $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$coduso'";
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
                            $sql2 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result2 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row2 = mysqli_fetch_array($result2)) {
                                    $client = $row2['descli'];
                                }
                            }
                            $i++;
                            ?>
                            <tr>
                                <td width="37"><?php echo $i; ?></td>
                                <td width="242"><?php echo $client ?></td>
                                <td width="306"><div align="left"><?php echo $destab ?></div></td>
                                <td width="132"><div align="right"><?php echo $nrooperacion ?></div></td>
                                <td width="109"><div align="right"><?php echo $sumpripro ?></div></td>
                                <td width="87"><div align="right"><?php echo $numero_formato_frances = number_format($sum_mont, 2, '.', ' '); ?></div></td>
                               <!-- <td width="91"><div align="right"><?php echo $numero_formato_frances = number_format($porcentaje, 2, '.', ' '); ?> %</div></td>-->
                            </tr>
                            <?php
                        } /////CIERRO EL WHILE
                    } /////CIERRO EL IF DE LA CONSULTA
                    else {
                        ?> <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php }
                    ?>
                </table>
                <?php
            }   /// CIERRO OPCION = 7 VENTAS POR CLIENTE RESUMIDO POR CLASE DE PRODUCTO
        } /// CIERRO SI SE HA PRESIONADO EL BOTON BUSCAR
        ?>
    </body>
</html>
