<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    .Estilo1 {
        color: #FF0000;
        font-weight: bold;
    }
</style>
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

    #customers td a {
        color: #4d9ff7;
        font-weight: bold;
        font-size: 15px;
        text-decoration: none;

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
<?php
$hour = date("G");
$min = date("i");
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
if ($local <> 'all') {
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$local'";
    $result = mysqli_query($conexion, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $nloc = $row["nomloc"];
        $nombre = $row["nombre"];
        if ($nombre == '') {
            $locals = $nloc;
        } else {
            $locals = $nombre;
        }
    }
}
$dat1 = $date1;
$dat2 = $date2;
$date1 = fecha1($dat1);
$date2 = fecha1($dat2);

$vendedor = isset($_REQUEST['vendedor']) ? ($_REQUEST['vendedor']) : "";

$sqladdusuario = " AND ";

if($vendedor != "" and $vendedor != "all")
{
    $sqladdusuario .= " venta.usecod = '" . $vendedor . "' AND ";
}

//echo '<script>alert("' . $vendedor . '")</script>';

if ($sunat == 1) {
    $tipoDoc2 = '4';
} else {
    $tipoDoc2 = '';
}
?>
<table width="100%" border="0" align="center">
    <tr>
        <td>
            <table width="100%" border="0">
                <tr>
                    <td width="260"><strong><?php echo $desemp ?> </strong></td>
                    <td width="380">
                        <div align="center">
                            <strong>REPORTE DE VENTAS POR DIA -
                                <?php
                                if ($local == 'all') {
                                    echo 'TODAS LAS SUCURSALES';
                                } else {
                                    echo $locals;
                                }
                                ?>
                            </strong>
                        </div>
                    </td>
                    <td width="260">
                        <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                    </td>
                </tr>

            </table>
            <table width="100%" border="0">
                <tr>
                    <td width="134"><strong>PAGINA <?php echo $pagina; ?> de <?php echo $tot_pag ?></strong></td>
                    <td width="633">
                        <div align="center"><b><?php if ($val == 1) { ?>NRO DE VENTA ENTRE EL <?php echo $desc; ?> Y EL <?php
                                                                                                                        echo $desc1;
                                                                                                                    }
                                                                                                                    if ($vals == 2) {
                                                                                                                        ?> FECHAS ENTRE EL <?php echo $dat1; ?> Y EL <?php
                                                                                                                                                                        echo $dat2;
                                                                                                                                                                    }
                                                                                                                                                                    if ($valTipoDoc == 1) {
                                                                                                                                                                        ?> No DE DOCUMENTO ENTRE EL <?php echo $from; ?> Y EL <?php
                                                                                                                                                                                                                                echo $until;
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                ?></b></div>
                    </td>
                    <td width="133">
                        <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                    </td>
                </tr>
            </table>
            <div align="center"><img src="../../images/line2.png" width="910" height="4" /></div>
        </td>
    </tr>
</table>
<?php
if ($ckprod == 1) {
?>


    <table width="98%" style="border-collapse: collapse;" border="1" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <?php
                $zz = 0;
                if ($val == 1) { ///	PRIMER BOTON
                    if ($local == 'all') { ////TODOS LOS LOCALES
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.idlote,detalle_venta.pripro,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where correlativo_venta between '$desc' and '$desc1' and estado = '0' " . $sqladdusuario . " invtot <> '0' order by sucursal,invfec, nrovent,codpro";
                    } else { ///UN SOLO LOCAL
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.idlote,detalle_venta.pripro,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where correlativo_venta between '$desc' and '$desc1' and estado = '0' " . $sqladdusuario . " invtot <> '0' and sucursal = '$local'  order by sucursal,invfec, nrovent,codpro";
                    }
                } elseif ($vals == 2) { ///	SEGUNDO BOTON 
                    if ($local == 'all') { ////TODOS LOS LOCALES
                        //echo $date1; echo "<br>";
                        //echo $date2;
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.nrovent,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.idlote,detalle_venta.pripro,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' " . $sqladdusuario . " invtot <> '0' and estado = '0' order by sucursal,invnum, nrovent,codpro";
                    } else { ///UN SOLO LOCAL
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.nrovent,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.idlote,detalle_venta.pripro,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where detalle_venta.invfec between '$date1' and '$date2' " . $sqladdusuario . " sucursal = '$local'  and invtot <> '0' and estado = '0' order by sucursal,invnum, nrovent,codpro";
                    }
                } else { //TERCER BOTON
                    if ($local == 'all') { ////TODOS LOS LOCALES
                        //echo $date1; echo "<br>";
                        //echo $date2;
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.nrovent,venta.gravado,venta.invtot,detalle_venta.usecod,detalle_venta.pripro,costpr,detalle_venta.idlote,sucursal,nrofactura,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta  on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' " . $sqladdusuario . " tipdoc='$tipoDoc'  and invtot <> '0' and estado = '0' order by sucursal,invfec, nrovent,codpro";
                    } else { ///UN SOLO LOCAL
                        $sql = "SELECT venta.val_habil, venta.invnum,venta.igv,venta.nrovent,venta.gravado,venta.invtot,detalle_venta.usecod,costpr,sucursal,nrofactura,detalle_venta.idlote,detalle_venta.pripro,detalle_venta.invfec,detalle_venta.cuscod,codpro,codmar,prisal,factor,canpro,fraccion,costpr,nrofactura FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where venta.correlativo between '$from' and '$until' " . $sqladdusuario . " tipdoc='$tipoDoc' and sucursal = '$local'  and invtot <> '0' and estado = '0' and nrofactura <> '' order by sucursal,invfec, nrovent,codpro";
                    }
                }

                //echo $sql;

                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                ?>
                    <table width="98%" border="0" align="center" id="customers">
                        <tr>
                            <th width="57">
                                <div align="center"><strong>TIENDA </strong></div>
                            </th>
                            <th width="74">
                                <div align="center"><strong>RESPONSABLE </strong></div>
                            </th>
                            <th width="24">
                                <div align="center"><strong>NUMERO</strong></div>
                            </th>
                            <th width="24">
                                <div align="center"><strong>NUM FISICO</strong></div>
                            </th>
                            <th width="50">
                                <div align="center"><strong>FECHA</strong></div>
                            </th>
                            <th width="54">
                                <div align="center"><strong>CLIENTE</strong></div>
                            </th>
                            <th width="308">
                                <div align="center"><strong>PRODUCTO</strong></div>
                            </th>
                            <th width="61">
                                <div align="center"><strong>MARCA</strong></div>
                            </th>
                            <th width="61">
                                <div align="center"><strong>CANTIDAD</strong></div>
                            </th>
                            <th width="61">
                                <div align="center"><strong>IGV</strong></div>
                            </th>
                            <th width="61">
                                <div align="center"><strong>GRAVADO</strong></div>
                            </th>
                            <th width="60">
                                <div align="center"><strong>PRECIO UNI.</strong></div>
                            </th>
                            <th width="60">
                                <div align="center"><strong>SUB. TOTAL</strong></div>
                            </th>
                            <th width="60">
                                <div align="center"><strong>ANULADO</strong></div>
                            </th>
                            <th width="60">
                                <div align="center"><strong>TOTAL</strong></div>
                            </th>

                        </tr>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            $usecod = $row['usecod'];
                            $invnum = $row['invnum'];
                            $igv = $row['igv'];
                            $gravado = $row['gravado'];
                            $invtot = $row['invtot'];
                            $sucursal = $row['sucursal'];
                            $nrovent = $row['nrovent'];
                            $nrofactura = $row['nrofactura'];
                            $invfec = fecha($row['invfec']);
                            $cuscod = $row['cuscod'];
                            $codpro = $row['codpro'];
                            $codmar = $row['codmar'];
                            $prisal = $row['prisal'];
                            $factor = $row['factor']; ////
                            $canpro = $row['canpro']; ////
                            $cospro = $row['costpr']; ////
                            $fraccion = $row['fraccion']; /////
                            $costpr = $row['costpr']; //costo del producto x unidad
                            $pripro = $row['pripro'];
                            //agregado ADRIAN
                            $v_habil = $row['val_habil'];


                            $factorP = 1;

                            if ($fraccion == "T") {
                                $cospro = $costpr;
                            } else {
                                $cospro = $costpr;
                            }

                            $plista = 0;
                            $dif = 0;
                            //USUARIO
                            $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $nomusu = $row1['nomusu'];
                                }
                            }
                            //CLIENTE
                            $sql1 = "SELECT descli FROM cliente where codcli = '$cuscod'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $descli = $row1['descli'];
                                }
                            }
                            $sql1 = "SELECT desprod,destab,pdistribuidor,abrev FROM producto inner join titultabladet on codmar = codtab where codpro = '$codpro' and producto.eliminado='0'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $desprod = $row1['desprod'];
                                    $destab = $row1['destab'];
                                    $abrev = $row1['abrev'];
                                    if ($abrev <> '') {
                                        $destab = $abrev;
                                    }
                                    $pdistribuidor = $row1['pdistribuidor'];
                                }
                            }
                            $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                            $result3 = mysqli_query($conexion, $sql3);
                            if (mysqli_num_rows($result3)) {
                                while ($row3 = mysqli_fetch_array($result3)) {
                                    $nloc = $row3["nomloc"];
                                    $nombre = $row3["nombre"];
                                }
                            }
                            $plista = $prisal - $costpr;
                            $dif = $prisal - $costpr;
                            if ($nombre == "") {
                                $nombre = $nloc;
                            }
                            if ($prisal < $costpr) {
                                $color = "#000000";
                            } else {
                                if ($prisal < $costpr) {
                                    $color = "#000000";
                                } else {
                                    $color = "";
                                }
                            }


                            if ($fraccion == "F") {
                                $cantemp = "C" . $canpro;
                            } else {
                                if ($factorP == 1) {
                                    $cantemp = $canpro;
                                } else {
                                    $cantemp = "F" . $canpro;
                                }
                            }
                            $Cantidad = $canpro;
                        ?>
                            <!--<tr <?php //if ($prisal < $costpr){                        
                                    ?>bgcolor="#FF0000"<?php //} else { if ($prisal < $costpr){                         
                                                        ?> bgcolor="#006600"<?php // }}                        
                                                                            ?> height="25"  <?php //if($dateDASDAS2){                        
                                                                                            ?> bgcolor="#ff0000"<?php // } else {                        
                                                                                                                ?>onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';"<?php //}                        
                                                                                                                                                                                                                                                    ?>>-->
                            <tr <?php if($v_habil==1){ echo 'style="background-color:#ff6666"'; }else {echo ''; } ?> >
                                <td width="57">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $nombre; ?></font>
                                    </div>
                                </td>
                                <td width="74">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $nomusu; ?></font>
                                    </div>
                                </td>
                                <td width="24">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $nrovent ?></font>
                                    </div>
                                </td>
                                <td width="24">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $nrofactura ?></font>
                                    </div>
                                </td>
                                <td width="50">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $invfec; ?></font>
                                    </div>
                                </td>
                                <td width="54">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $descli; ?></font>
                                    </div>
                                </td>
                                <td width="308">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $desprod ?></font>
                                    </div>
                                </td>
                                <td width="61">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $destab ?></font>
                                    </div>
                                </td>
                                <td width="61">
                                    <div align="CENTER">
                                        <font color="<?php echo $color ?>"><?php echo $cantemp ?></font>
                                    </div>
                                </td>
                                <td width="61">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $igv ?></font>
                                    </div>
                                </td>
                                <td width="61">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $gravado ?></font>
                                    </div>
                                </td>
                                <td width="60">
                                    <div align="CENTER">
                                        <font color="<?php echo $color ?>"><?php echo $numero_formato_frances = number_format($prisal, 2, '.', ' '); ?></font>
                                    </div>
                                </td>
                                <td width="60">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"><?php echo $numero_formato_frances = number_format($prisal * $Cantidad, 2, '.', ' '); ?></font>
                                    </div>
                                </td>
                                <td width="60">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"> <?php if($v_habil==1){ echo $numero_formato_frances = number_format($prisal * $Cantidad, 2, '.', ' '); }else {echo '0.00'; } ?></font>
                                    </div>
                                </td>
                                <td width="60">
                                    <div align="center">
                                        <font color="<?php echo $color ?>"> <?php if($v_habil==0){ echo $numero_formato_frances = number_format($invtot, 2, '.', ' '); }else {echo '0.00'; } ?> </font>
                                    </div>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                <?php
                }
                ?>
            </td>
        </tr>
    </table>

    <?php
} else {
    error_log("Check :" . $ck2);
    error_log("valTipoDoc :" . $valTipoDoc);
    if (($ck == '') && ($ck1 == '') && ($ck2 == '')) {
        if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)) {
    ?>

            <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        $zz = 0;
                        if ($val == 1) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where correlativo_venta between '$desc' and '$desc1' and delivery='$delivery' and estado = '0' " . $sqladdusuario . " invtot <> '0'   group by usecod,sucursal ORDER BY  sucursal,usecod ";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where correlativo_venta between '$desc' and '$desc1'  and delivery='$delivery' and estado = '0' " . $sqladdusuario . " invtot <> '0'   group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {
                                    $sql = "SELECT usecod FROM venta where correlativo_venta between '$desc' and '$desc1' and delivery='$delivery' and sucursal = '$local' " . $sqladdusuario . " invtot <> '0'  and estado = '0' group by usecod ORDER BY  sucursal,usecod";
                                }
                            } else {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where correlativo_venta between '$desc' and '$desc1' and estado = '0' " . $sqladdusuario . " invtot <> '0'   group by usecod,sucursal ORDER BY  sucursal,usecod";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where correlativo_venta between '$desc' and '$desc1' and estado = '0' " . $sqladdusuario . " invtot <> '0'   group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {
                                    $sql = "SELECT usecod FROM venta where correlativo_venta between '$desc' and '$desc1' and sucursal = '$local' " . $sqladdusuario . " invtot <> '0'  and estado = '0' group by usecod ORDER BY  sucursal,usecod";
                                }
                            }
                        }
                        if ($vals == 2) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where invfec between '$date1' and '$date2' and delivery='$delivery' " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod,sucursal ORDER BY  sucursal,usecod";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2' and delivery='$delivery'  and estado = '0' " . $sqladdusuario . " invtot <> '0'  group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {

                                    $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2' and delivery='$delivery' and sucursal = '$local' " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod ORDER BY  sucursal,usecod";
                                }
                            } else {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where invfec between '$date1' and '$date2'  " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod,sucursal ORDER BY  sucursal,usecod";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2'   and estado = '0' " . $sqladdusuario . " invtot <> '0'  group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {

                                    $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2'  and sucursal = '$local' " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod ORDER BY  sucursal,usecod";
                                }
                            }
                        }
                        if ($valTipoDoc == 1) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery'  " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod,sucursal ORDER BY  sucursal,usecod";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery'  and estado = '0'  " . $sqladdusuario . " invtot <> '0' group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {

                                    $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' and delivery='$delivery' " . $sqladdusuario . " invtot <> '0'  and estado = '0' group by usecod ORDER BY  sucursal,usecod";
                                }
                            } else {
                                if ($local == 'all') {
                                    if ($ckloc == 1) {
                                        $sql = "SELECT usecod,sucursal FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' " . $sqladdusuario . " invtot <> '0' and estado = '0'  group by usecod,sucursal ORDER BY  sucursal,usecod";
                                    } else {
                                        $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  " . $sqladdusuario . " invtot <> '0' group by usecod ORDER BY  sucursal,usecod";
                                    }
                                } else {

                                    $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' " . $sqladdusuario . " invtot <> '0'  and estado = '0' group by usecod ORDER BY  sucursal,usecod";
                                }
                            }
                        }

                        //echo $sql;

                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="98%" border="0" align="center" id="customers">
                                <thead>
                                    <tr>
                                        <?php if ($ckloc == 1) { ?>
                                            <th width="102"><strong>LOCAL</strong></th>
                                        <?php } ?>
                                        <th width="<?php if ($ckloc == 1) { ?>240<?php } else { ?>342<?php } ?>"><strong>VENDEDOR</strong></th>
                                        <th width="10">FECHA INICIO</th>
                                        <th width="10">FECHA FIN</th>
                                        <th width="57">
                                            <div align="center"><strong># VENTAS<?php echo $delivery; ?> </strong></div>
                                        </th>
                                        <th width="64">
                                            <div align="center"><strong>EFECTIVO</strong></div>
                                        </th>
                                        <th width="68">
                                            <div align="center"><strong>CREDITO</strong></div>
                                        </th>
                                        <th width="80">
                                            <div align="center"><strong>TARJETAS</strong></div>
                                        </th>
                                        <th width="80">
                                            <div align="center"><strong>YAPE/PLIN</strong></div>
                                        </th>
                                        <!--<th width="54"><div align="center"><strong>OTROS</strong></div></th>-->
                                        <th width="68">
                                            <div align="center" class="Estilo1">ANULADAS</div>
                                        </th>
                                        <th width="61">
                                            <div align="center"><strong>TOTAL DE VENTA</strong></div>
                                        </th>
                                    </tr>
                                </thead>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $usecod = $row['usecod'];
                                    if ($ckloc == 1) {
                                        $sucurs = $row['sucursal'];
                                    }
                                    $user = 'Usuario Eliminado';
                                    ///////USUARIO QUE REALIZA LA VENTA
                                    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $user = $row1['nomusu'];
                                        }
                                    }
                                    $e = 0;
                                    $t = 0;
                                    $c = 0;
                                    $e_tot = 0;
                                    $t_tot = 0;
                                    $c_tot = 0;
                                    $deshabil = 0;
                                    $deshabil_tot = 0;
                                    $habil_tot = 0;
                                    $count = 0;
                                    $sumpripro = 0;
                                    $sumpcosto = 0;
                                    $porcentaje = 0;
                                    $Rentabilidad = 0;
                                    $total = 0;

                                    $m_tot = 0;

                                    if ($valTipoDoc == 1) {
                                        if ($delivery == 1) {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' " . $sqladdusuario . " invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' " . $sqladdusuario . " invtot <> '0' and correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and estado = '0'  order by sucursal";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and sucursal = '$local'  and estado = '0' order by sucursal";
                                            }
                                        } else {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  order by sucursal";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local'  and estado = '0' order by sucursal";
                                            }
                                        }
                                    }
                                    if ($vals == 2) {

                                        if ($delivery == 1) {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs'  order by sucursal,invnum";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and estado = '0'  order by sucursal,invnum";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and sucursal = '$local'  and estado = '0' order by sucursal,invnum";
                                            }
                                        } else {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs'  order by sucursal,invnum";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and estado = '0'  order by sucursal,invnum";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and sucursal = '$local'  and estado = '0' order by sucursal,invnum";
                                            }
                                        }
                                    }
                                    if ($val == 1) {

                                        if ($delivery == 1) {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'   and delivery='$delivery' and sucursal = '$sucurs' order by sucursal";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'   and delivery='$delivery' order by sucursal";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'   and delivery='$delivery' and estado = '0'";
                                            }
                                        } else {
                                            if ($local == 'all') {
                                                if ($ckloc == 1) {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                } else {
                                                    $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'  order by sucursal";
                                                }
                                            } else {
                                                $sql1 = "SELECT invnum,invfec,forpag,val_habil,invtot,sucursal,hora,mulEfectivo, mulVISA, mulMasterCard,mulCanje  FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'  and estado = '0'";
                                            }
                                        }
                                    }

                                    //echo $sql1;

                                    //                                    error_log("SQL 1 : " . $sql1);
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $contador++;
                                            $invnum = $row1["invnum"];
                                            $invfec = $row1["invfec"];
                                            $forpag = $row1["forpag"];
                                            $val_habil = $row1["val_habil"];
                                            $total = $row1["invtot"];
                                            $sucursal = $row1["sucursal"];
                                            $hora = $row1["hora"];
                                            $mulEfectivo = $row1["mulEfectivo"];
                                            $mulVISA = $row1["mulVISA"];
                                            $mulMasterCard = $row1["mulMasterCard"];
                                            $mulCanje = $row1["mulCanje"];




                                            if ($valTipoDoc == 1) {
                                                if ($delivery == 1) {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and estado = '0'  order by sucursal";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and delivery='$delivery' and sucursal = '$local'  and estado = '0' order by sucursal";
                                                    }
                                                } else {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and estado = '0'  order by sucursal";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local'  and estado = '0' order by sucursal";
                                                    }
                                                }
                                            }
                                            if ($vals == 2) {

                                                if ($delivery == 1) {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs'  order by sucursal,invnum";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and estado = '0'  order by sucursal,invnum";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " delivery='$delivery' and invfec between '$date1' and '$date2' and sucursal = '$local'  and estado = '0' order by sucursal,invnum";
                                                    }
                                                } else {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and estado = '0' and sucursal = '$sucurs'  order by sucursal,invnum";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and estado = '0'  order by sucursal,invnum";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0'  " . $sqladdusuario . " invfec between '$date1' and '$date2' and sucursal = '$local'  and estado = '0' order by sucursal,invnum";
                                                    }
                                                }
                                            }
                                            if ($val == 1) {

                                                if ($delivery == 1) {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'   and delivery='$delivery' and sucursal = '$sucurs' order by sucursal";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'   and delivery='$delivery' order by sucursal";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'   and delivery='$delivery' and estado = '0'";
                                                    }
                                                } else {
                                                    if ($local == 'all') {
                                                        if ($ckloc == 1) {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'  and sucursal = '$sucurs' order by sucursal";
                                                        } else {
                                                            $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and estado = '0'  order by sucursal";
                                                        }
                                                    } else {
                                                        $sqlFechas = "SELECT  MIN(invfec) as fechainicio , MAX(invfec) as fechaFin FROM venta where usecod = '$usecod' and invtot <> '0' " . $sqladdusuario . " correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'  and estado = '0'";
                                                    }
                                                }
                                            }

                                            //echo $sqlFechas;

                                            $resultadoFechas = mysqli_query($conexion, $sqlFechas);
                                            if (mysqli_num_rows($resultadoFechas)) {
                                                while ($row1 = mysqli_fetch_array($resultadoFechas)) {

                                                    $fechainicio = $row1["fechainicio"];
                                                    $fechaFin = $row1["fechaFin"];
                                                }
                                            }

                                           

                                            if ($forpag == "") {
                                                $forpag = "E";
                                            }




                                            // echo  ' invfec = '.$invfec."<BR>";
                                            // if ($contador == 1) {
                                            //$fec_inicio = $fechainicio;
                                            // }

                                            // if ($forpag == "") {
                                            //   $forpag = "E";
                                            // }
                                            // if ($ckloc == 1) {
                                            //     if ($sucursal <> $suc[$zz]) {
                                            //         $zz++;
                                            //         $suc[$zz] = $sucursal;
                                            //     }
                                            // } else {
                                            //     if ($usecod <> $suc[$zz]) {
                                            //         $zz++;
                                            //         $suc[$zz] = $usecod;
                                            //     }
                                            // }
                                            $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                            $result3 = mysqli_query($conexion, $sql3);
                                            while ($row3 = mysqli_fetch_array($result3)) {
                                                $nloc = $row3["nomloc"];
                                                $nombre = $row3["nombre"];
                                                if ($nombre == '') {
                                                    $sucur = $nloc;
                                                } else {
                                                    $sucur = $nombre;
                                                }
                                            }
                                            if ($val_habil == 0) {
                                                if ($forpag == "E") {
                                                    $e = $e + 1;
                                                    $e_tot = $e_tot + $mulEfectivo;
                                                   
                                                    $e_tot1[$zz] = $e_tot1[$zz] + $mulEfectivo;
                                                   
                                                }
                                                if ($forpag == "T") {
                                                    $t = $t + 1;
                                                    $t_tot = $t_tot + $mulVISA;
                                                    $t_tot1[$zz] = $t_tot1[$zz] + $mulVISA;
                                                }
                                                if ($forpag == "C") {
                                                    $c = $c + 1;
                                                    $c_tot = $c_tot + $total;
                                                    $c_tot1[$zz] = $c_tot1[$zz] + $total;
                                                }
                                                if ($forpag == "M") {
                                                    $m = $m + 1;
                                                    $e_tot = $e_tot + $mulEfectivo;
                                                    $t_tot = $t_tot + $mulVISA;
                                                    $m_tot = $m_tot + $mulCanje;
                                                    
                                                    $e_tot1[$zz] = $e_tot1[$zz] + $mulEfectivo;
                                                    $t_tot1[$zz] = $t_tot1[$zz] + $mulVISA;
                                                    $m_tot1[$zz] = $m_tot1[$zz] + $mulCanje;
                                                }

                                                $sql2 = "SELECT cospro,pripro,canpro,fraccion,factor,prisal,costpr FROM detalle_venta where invnum = '$invnum'";
                                                $result2 = mysqli_query($conexion, $sql2);
                                                if (mysqli_num_rows($result2)) {
                                                    while ($row2 = mysqli_fetch_array($result2)) {
                                                        $pcostouni = $row2["cospro"]; //costo del producto x caja
                                                        $pripro = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
                                                        $canpro = $row2['canpro'];
                                                        $fraccion = $row2['fraccion'];
                                                        $factor = $row2['factor'];
                                                        $prisal = $row2['prisal']; //precio de venta x unidad
                                                        $costpr = $row2['costpr']; //costo del producto x unidad

                                                        if ($fraccion == "T") {
                                                            $RentPorcent = (($prisal - $costpr) * $canpro);
                                                            $Rentabilidad = $Rentabilidad + $RentPorcent;

                                                            //$precio_costo = $pcostouni;
                                                        } else {
                                                            $RentPorcent = (($prisal - $costpr) * $canpro);
                                                            $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                        }
                                                    }
                                                }
                                            }
                                            if ($val_habil == 1) {
                                                $deshabil++;
                                                $deshabil_tot = $deshabil_tot + $total;
                                                $deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
                                            } else {
                                                $habil_tot = $habil_tot + $total;
                                                $habil_tot1[$zz] = $habil_tot1[$zz] + $total;
                                            }

                                            $suma_anuladas += $deshabil_tot;
                                            $suma_total += $habil_tot;
                                            $count++;
                                        }
                                    }

                                    $rentabilidad = $Rentabilidad;
                                    $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
                                    // echo 'valor 1 = ' . $suc[$zz - 1] . '  $zz= ' . $zz . "<br>";
                                    if (($suc[$zz - 1] <> "") and ($suc[$zz - 1] <> $suc[$zz])) {
                                ?>

                                        <tr bgcolor="#CCCCCC">


                                            <td <?php if ($ckloc == 1) { ?> COLSPAN="3" <?php } else { ?> COLSPAN="2" <?php } ?> width="407">
                                                <div align="center"><strong>TOTAL 1</strong></div>
                                            </td>


                                            <td width="64">
                                                <div align="center">
                                                    <?php echo $numero_formato_frances = number_format($e_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>
                                            <!--<td width="54"><div align="center"></div></td>-->
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>
                                            <td bgcolor="#92c1e5" width="61">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                    <tbody>
                                        <tr height="25">
                                            <?php if ($ckloc == 1) { ?><td width="102" align="center"><?php echo $usecod . '-' . $sucur ?></td><?php } ?>
                                            <td width="<?php if ($ckloc == 1) { ?>240<?php } else { ?>342<?php } ?>">
                                                <?php echo $user ?></td>
                                            <td><?php echo fecha($fechainicio); ?></td>
                                            <td><?php echo fecha($fechaFin); ?></td>
                                            <td width="57">
                                                <div align="center"><?php echo $count; ?></div>
                                            </td>
                                            <td width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($e_tot, 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($t_tot, 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($m_tot, 2, '.', ' '); ?></div>
                                            </td>
                                            <!--<td width="54">&nbsp;</td>-->
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="61">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' '); ?></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                                <?php if ($zz == 1) { ?>
                                    <tfoot>
                                        <!-- <table width="100%" border="0" align="center">-->
                                        <tr bgcolor="#CCCCCC">
                                            <td <?php if ($ckloc == 1) { ?> COLSPAN="3" <?php } else { ?> COLSPAN="2" <?php } ?> width="407">
                                                <div align="center"><strong>TOTAL 2</strong></div>
                                            </td>
                                            <td width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                            <td width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                            <!--<td width="54">&nbsp;</td>-->
                                            <td width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                            <td bgcolor="#92c1e5" width="61">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <!--</table>-->
                                <?php } else {
                                ?>
                                    <!--  <table width="100%" border="0" align="center">-->
                                    <tfoot>
                                        <tr bgcolor="#CCCCCC">
                                            <th <?php if ($ckloc == 1) { ?> COLSPAN="5" <?php } else { ?> COLSPAN="2" <?php } ?> width="407">
                                                <div align="center"><strong>TOTAL </strong></div>
                                            </th>
                                            <th width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <th width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <th width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <th width="80">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <!--<th width="54">&nbsp;</th>-->
                                            <th width="68">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <th bgcolor="#92c1e5" width="61">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>

                                        </tr>
                                    </tfoot>
                                    <!--</table>-->
                                <?php } ?>
                            </table>

                        <?php } else { ?>
                            <div class="siniformacion">
                                <center>No se logro encontrar informacion con los datos ingresados</center>
                            </div>
                        <?php } ?>
                    </td>
                </tr>
            </table>
    <?php
        }
    }
    ?>
    <?php
    if (($ck == 1) || ($ck1 == 1) || ($ck2 == 1)) {
        if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)) {
    ?>

            <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                        if ($val == 1) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta  FROM venta where correlativo_venta between '$desc' and '$desc1' and estado = '0'  and nrofactura<>''   and delivery='$delivery'  " . $sqladdusuario . " invtot <> '0' order by invfec,hora";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'    and delivery='$delivery' and nrofactura<>''  and estado = '0' " . $sqladdusuario . " invtot <> '0' order by invfec,hora";
                                }
                            } else {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo_venta between '$desc' and '$desc1' and estado = '0' and nrofactura<>'' and tipdoc<>'$tipoDoc2' " . $sqladdusuario . " invtot <> '0' order by invfec,hora";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo_venta between '$desc' and '$desc1' and sucursal = '$local'  and estado = '0' and nrofactura<>'' and tipdoc<>'$tipoDoc2' " . $sqladdusuario . " invtot <> '0' order by invfec,hora";
                                }
                            }
                        }
                        if ($vals == 2) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where invfec between '$date1' and '$date2' and estado = '0' and nrofactura<>''    and delivery='$delivery' " . $sqladdusuario . " invtot <> '0' order by invnum,hora  ";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local' and nrofactura<>''    and delivery='$delivery' " . $sqladdusuario . " invtot <> '0' and estado = '0'  order by invnum,hora";
                                }
                            } else {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where invfec between '$date1' and '$date2' and estado = '0' and nrofactura<>''  " . $sqladdusuario . " invtot <> '0' and tipdoc<>'$tipoDoc2' order by invnum,hora  ";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where invfec between '$date1' and '$date2' and sucursal = '$local'  and nrofactura<>'' " . $sqladdusuario . " invtot <> '0' and tipdoc<>'$tipoDoc2' and estado = '0'  order by invnum,hora";
                                }
                            }
                        }
                        if ($valTipoDoc == 1) {
                            if ($delivery == 1) {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo between '$from' and '$until'  and tipdoc='$tipoDoc'  and estado = '0' and nrofactura<>''   and delivery='$delivery' " . $sqladdusuario . " invtot <> '0' order by invnum  ";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc'  and sucursal = '$local' and nrofactura<>''   and delivery='$delivery' " . $sqladdusuario . " invtot <> '0' and estado = '0'  order by invnum";
                                }
                            } else {
                                if ($local == 'all') {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo between '$from' and '$until'  and tipdoc='$tipoDoc'  and estado = '0' and nrofactura<>'' and tipdoc<>'$tipoDoc2'  " . $sqladdusuario . " invtot <> '0' order by invnum  ";
                                } else {
                                    $sql = "SELECT val_habil,invnum,usecod,nrofactura,forpag,val_habil,invtot,sucursal,hora,nrofactura, nrovent,invfec,sunat_fenvio,sunat_respuesta_descripcion,mulEfectivo, mulVISA, mulMasterCard,mulCanje,correlativo_venta FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc'  and sucursal = '$local' and nrofactura<>'' and tipdoc<>'$tipoDoc2' " . $sqladdusuario . " invtot <> '0' and estado = '0'  order by invnum";
                                }
                            }
                        }
                        $zz = 0;
                        $i = 0;

                        //echo $sql;
                        
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="98%" border="0" align="center" id="customers">
                                <thead>
                                    <tr>
                                        <?php if ($ckloc == 1) { ?><th width="82"><strong>LOCAL</strong></th><?php } ?>
                                        <th width="<?php if ($ckloc == 1) { ?>180<?php } else { ?>250<?php } ?>"><strong>VENDEDOR</strong></th>
                                        <th width="60">
                                            <div align="center"><strong>HORA </strong></div>
                                        </th>
                                        <th width="20">
                                            <div align="center"><strong>FECHA </strong></div>
                                        </th>
                                        <th width="30">
                                            <div align="center"><strong>N&ordm; INTERNO </strong></div>
                                        </th>
                                        <!--	<th width="30"><div align="center"><strong>N&ordm; DE. VENTE </strong></div></th>-->
                                        <th width="29">
                                            <div align="center"><strong>N&ordm; FISICO </strong></div>
                                        </th>
                                        <th width="29">
                                            <div align="center"><strong>N&ordm; Correlativo de Venta </strong></div>
                                        </th>
                                        <th width="60">
                                            <div align="center"><strong><?php if ($sunat == 1) { ?>TOTAL<?php } else { ?>EFECTIVO<?php } ?></strong></div>
                                        </th>
                                        <?php if ($sunat == 1) { ?>
                                            <th width="60">
                                                <div align="center"><strong>FECHA ENVIO SUNAT</strong></div>
                                            </th>
                                            <th width="60">
                                                <div align="center"><strong>RESPUESTA SUNAT</strong></div>
                                            </th>
                                            <th width="60">
                                                <div align="center"><strong>OBSERVACION</strong></div>
                                            </th>
                                        <?php } else { ?>
                                            <th width="60">
                                                <div align="center"><strong>CREDITO</strong></div>
                                            </th>
                                            <th width="80">
                                                <div align="center"><strong>TARJETAS</strong></div>
                                            </th>
                                            <th width="80">
                                                <div align="center"><strong>YAPE/PLIN</strong></div>
                                            </th>
                                            <th width="44">
                                                <div align="center"><strong>OTROS</strong></div>
                                            </th>
                                            <th width="50">
                                                <div align="center" class="Estilo1">ANULADAS</div>
                                            </th>
                                            <th width="55">
                                                <div align="center"><strong>TOTAL VENTAS</strong></div>
                                            </th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $invnum = $row['invnum'];
                                    $usecod = $row['usecod'];
                                    $nrovent = $row['nrovent'];
                                    $forpag = $row["forpag"];
                                    $val_habil = $row["val_habil"];
                                    $total = $row["invtot"];
                                    $sucursal = $row["sucursal"];
                                    $nrofactura = $row["nrofactura"];
                                    $hora = $row["hora"];
                                    $invfec = $row["invfec"];
                                    $sunat_fenvio = $row["sunat_fenvio"];
                                    $sunat_respuesta_descripcion = $row["sunat_respuesta_descripcion"];
                                    $correlativo_venta = $row["correlativo_venta"];
                                    $v_hab2 = $row["val_habil"];

                                    $mulEfectivo = $row["mulEfectivo"];
                                    $mulVISA = $row["mulVISA"];
                                    $mulMasterCard = $row["mulMasterCard"];
                                    $mulCanje = $row["mulCanje"];

                                    if ($mulEfectivo > 0) {
                                        $titleMlEfectivo = ' Efectivo = ' . $mulEfectivo;
                                    } else {
                                        $titleMlEfectivo = '';
                                    }
                                    if ($mulVISA > 0) {
                                        $titleMulVISA = ' VISA = ' . $mulVISA;
                                    } else {
                                        $titleMulVISA = '';
                                    }
                                    if ($mulMasterCard > 0) {
                                        $titleMulMasterCard = ' MASTERCARD = ' . $mulMasterCard;
                                    } else {
                                        $titleMulMasterCard = '';
                                    }
                                    if ($mulCanje > 0) {
                                        $titleMulCanje = ' YAPE/PLIN = ' . $mulCanje;
                                    } else {
                                        $titleMulCanje = '';
                                    }

                                    $titleMultiple = 'Se realizo pagos con : ' . $titleMlEfectivo . ' ' . $titleMulVISA . ' ' . $titleMulMasterCard . ' ' . $titleMulCanje;

                                    $val_habilsuma = $val_habilsuma + $val_habil;
                                    $i++;
                                    $ssss[$i] = $sucursal;
                                    // if ($sucursal <> $suc[$zz]) {
                                    //     $zz++;
                                    //     $suc[$zz] = $sucursal;
                                    // }
                                    $sql3 = "SELECT nomloc,nombre FROM xcompa where codloc = '$sucursal'";
                                    $result3 = mysqli_query($conexion, $sql3);
                                    while ($row3 = mysqli_fetch_array($result3)) {
                                        $nloc = $row3["nomloc"];
                                        $nombre = $row3["nombre"];
                                        if ($nombre == '') {
                                            $sucur = $nloc;
                                        } else {
                                            $sucur = $nombre;
                                        }
                                    }
                                    $e_tot = 0;
                                    $t_tot = 0;
                                    $c_tot = 0;
                                    $m_tot = 0;
                                    $deshabil_tot = 0;
                                    $habil_tot = 0;
                                    $count = 0;
                                    $tot = 0;
                                    $Rentabilidad = 0;
                                    $sumpripro = 0;
                                    $sumpcosto = 0;
                                    $porcentaje = 0;
                                    $user = 'usuario eliminado';
                                    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                                    $result1 = mysqli_query($conexion, $sql1);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $user = $row1['nomusu'];
                                        }
                                    }
                                    if ($val_habil == 0) {
                                        if ($forpag == "E") {
                                            $e_tot = $total;
                                           
                                            $e_tot1[$zz] = $e_tot1[$zz] + $mulEfectivo;
                                            
                                        }
                                        if ($forpag == "T") {
                                            $t_tot = $total;
                                            $t_tot1[$zz] = $t_tot1[$zz] + $mulVISA;
                                        }
                                        if ($forpag == "C") {
                                            $c_tot = $total;
                                            $c_tot1[$zz] = $c_tot1[$zz] + $total;
                                           
                                        }
                                        if ($forpag == "M") {
                                            $m_tot = $total;
                                            $t_tot1[$zz] = $t_tot1[$zz] + $mulVISA;
                                            $e_tot1[$zz] = $e_tot1[$zz] + $mulEfectivo;
                                            $m_tot1[$zz] = $m_tot1[$zz] + $mulCanje;
                                        }
                                        $sql2 = "SELECT costpr,pripro,canpro,fraccion,factor,invfec,prisal,costpr, cospro FROM detalle_venta where invnum = '$invnum' order by invfec";
                                        $result2 = mysqli_query($conexion, $sql2);
                                        if (mysqli_num_rows($result2)) {
                                            while ($row2 = mysqli_fetch_array($result2)) {
                                                $pcostouni = $row2["cospro"]; //costo del producto x caja
                                                $pripro = $row2['pripro']; //subtotal de venta precio unitario x cantidad vendida
                                                $canpro = $row2['canpro'];
                                                $fraccion = $row2['fraccion'];
                                                $factor = $row2['factor'];
                                                $prisal = $row2['prisal']; //precio de venta x unidad
                                                $costpr = $row2['costpr']; //costo del producto x unidad
                                                $invfeSc = $row2['invfec'];

                                                //FRACCIONADO
                                                if ($fraccion == "T") {
                                                    $RentPorcent = (($prisal - $costpr) * $canpro);
                                                    $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                    //$precio_costo = $pcostouni;
                                                } else {
                                                    //NO FRACCIONADO
                                                    $RentPorcent = (($prisal - $pcostouni) * $canpro);
                                                    $Rentabilidad = $Rentabilidad + $RentPorcent;
                                                }
                                            }
                                        }
                                    }

                                    if ($val_habil == 1) {
                                        $deshabil_tot = $total;
                                        $deshabil_tot1[$zz] = $deshabil_tot1[$zz] + $total;
                                    } else {
                                        $habil_tot = $total;
                                        $habil_tot1[$zz] = $habil_tot1[$zz] + $total;
                                    }


                                    $sumatotal[$zz]= $deshabil_tot1[$zz] + $habil_tot1[$zz];

                                    $rentabilidad = $Rentabilidad;
                                    $rentabilidad1[$zz] = $rentabilidad1[$zz] + $Rentabilidad;
                                    /* if ($sumpcosto > 0){
                                      $rentabilidad   = $sumpripro - $sumpcosto;
                                      $rentabilidad1[$zz] = $rentabilidad1[$zz] + $rentabilidad;} */
                                    if (($suc[$zz - 1] <> "") and ($suc[$zz - 1] <> $suc[$zz])) {
                                        if ($sucursal <> $ssss[$i - 1]) {
                                ?>
                                            <tr bgcolor="#CCCCCC">
                                                <?php if ($ckloc == 1) { ?><td width="102"><?php ?></td><?php } ?>
                                                <td width="<?php if ($ckloc == 1) { ?>180<?php } else { ?>282<?php } ?>" bgcolor="#CCCCCC"></td>

                                                <td <?php if ($ckloc == 1) { ?>colspan="4" <?php } else { ?>colspan="4" <?php } ?>width="67">
                                                    <div align="center"><strong>TOTAL</strong></div>
                                                </td>
                                                <td width="64">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                </td>
                                                <?php if ($sunat <> 1) { ?>
                                                    <td width="68">
                                                        <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                    </td>
                                                    <td width="80">
                                                        <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' '); ?></div>
                                                    </td>
                                                    <td width="80">
                                                        <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz], 2, '.', ' '); ?></div>
                                                    </td>
                                                    <td width="54">&nbsp;</td>
                                                    <td width="68">
                                                        <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                    </td>
                                                    <td bgcolor="#92c1e5" width="61">
                                                        <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                    </td>
                                                <?php } else { ?>
                                                    <th>FECHA ENVIO SUNAT</th>
                                                    <th>RESPUESTA SUNAT</th>
                                                    <th><?php echo $val_habilsuma . " "; ?>ANULADOS</th>
                                                <?php } ?>

                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                    <tbody>
                                        <tr height="25" <?php if($v_hab2==1){ echo 'style="background-color:#ff6666"'; } else {echo ''; } ?>  >
                                            <?php if ($ckloc == 1) { ?><td width="82" align="center"><?php echo $sucur ?></td><?php } ?>
                                            <td width="<?php if ($ckloc == 1) { ?>180<?php } else { ?>282<?php } ?>">
                                                <a href="javascript:popUpWindow('ver_venta_usu.php?invnum=<?php echo $invnum ?>', 30, 140, 975, 280)"><?php echo $user ?></a>
                                            </td>
                                            <td width="40">
                                                <div align="center"><?php echo $hora ?></div>
                                            </td>
                                            <td width="40">
                                                <div align="center"><?php echo fecha($invfec) ?></div>
                                            </td>

                                            <!--                   <td width="25"><div align="center"><?php echo $nrovent ?></div></td>-->
                                            <td width="25">
                                                <div align="center"><?php echo $invnum ?></div>
                                            </td>

                                            <td width="25" <?php if($v_hab2==0){ echo 'bgcolor="#959fa4"'; } else {echo ''; } ?> >
                                                <div align="center"><?php echo $nrofactura ?></div>
                                            </td>

                                            <td width="25" <?php if($v_hab2==0){ echo 'bgcolor="#959fa4"'; } else {echo ''; } ?>>
                                                <div align="center"><?php echo $correlativo_venta ?></div>
                                            </td>

                                            <?php if ($sunat == 0) { ?>
                                            <td width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($mulEfectivo, 2, '.', ' '); ?></div>
                                            </td>
                                            <?php } else if ($sunat == 1 && $forpag <>''  ) { ?>

                                                <td width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($total, 2, '.', ' '); ?></div>
                                            </td>
                                            
                                            <?php } ?>




                                            <?php if ($sunat == 1) { ?>
                                                <td width="25">
                                                    <div align="center"><?php echo $sunat_fenvio ?></div>
                                                </td>
                                                <td width="25">
                                                    <div align="center"><?php echo $sunat_respuesta_descripcion ?></div>
                                                </td>
                                                <td width="25">
                                                    <div align="center"><?php
                                                                        if ($val_habil == 1) {
                                                                            $reso = "ANULADO";
                                                                            echo "<p class='Estilo1'>$reso</p>";
                                                                        } else {
                                                                            $reso = " ";
                                                                            echo "<strong>$reso</strong>";
                                                                        }
                                                                        ?></div>
                                                </td>
                                            <?php } else { ?>
                                                <td width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($c_tot, 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="80">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($mulVISA, 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="80" title="<?php echo $titleMultiple; ?>">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($mulCanje, 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="54">&nbsp;</td>
                                                <td width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot, 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="61" <?php if($v_hab2==0){ echo 'bgcolor="#50ADEA"'; } else {echo ''; } ?> >
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot, 2, '.', ' '); ?></div>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                                <!-- </table>-->
                                <?php if ($zz == 1) {
                                ?>
                                    <tfoot width="100%" border="0" align="center">
                                        <tr height="25" bgcolor="#CCCCCC">
                                            <th <?php if ($ckloc == 1) { ?>colspan="6" <?php } else { ?>colspan="5" <?php } ?> width="497">
                                                <div align="center"><strong>TOTAL</strong></div>
                                            </th>
                                            <th width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <?php if ($sunat <> 1) { ?>
                                                <th width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                </th>
                                                <th width="80">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th width="80">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th width="68">
                                                    <div align="left"></div>
                                                </th>
                                                <th width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th bgcolor="#92c1e5" width="61">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                            <?php } else { ?>
                                                <th>FECHA ENVIO SUNAT</th>
                                                <th>RESPUESTA SUNAT</th>
                                                <th><?php echo $val_habilsuma . " "; ?>ANULADOS</th>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>
                                <?php } else { ?>
                                    <tfoot width="100%" border="0" align="center">
                                        <tr height="25" bgcolor="#CCCCCC">
                                            <th <?php if ($ckloc == 1) { ?>colspan="7" <?php } else { ?>colspan="5" <?php } ?> width="497">
                                                <div align="center"><strong>TOTAL</strong></div>
                                            </th>
                                           

                                            <?php if ($sunat == 0) { ?>
                                                <th width="64">
                                                <div align="center"><?php echo $numero_formato_frances = number_format($e_tot1[$zz], 2, '.', ' '); ?></div>
                                            </th>
                                            <?php } else if ($sunat == 1   ) { ?>

                                                <th bgcolor="#92c1e5" width="61">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($sumatotal[$zz], 2, '.', ' '); ?></div>
                                                </th>

                                            <?php } ?>




                                            <?php if ($sunat <> 1) { ?>
                                                <th width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($c_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th width="80">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($t_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th width="80">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($m_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>

                                                <th></th>
                                                <th width="68">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($deshabil_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                                <th bgcolor="#92c1e5" width="61">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($habil_tot1[$zz], 2, '.', ' '); ?></div>
                                                </th>
                                            <?php } else { ?>
                                                <th>FECHA ENVIO SUNAT</th>
                                                <th>RESPUESTA SUNAT</th>
                                                <th><?php echo $val_habilsuma . " "; ?>ANULADOS</th>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>
                            </table>

                        <?php
                                }
                            } else {
                        ?>
                        <div class="siniformacion">
                            <center>
                                No se logro encontrar informacion con los datos ingresados
                            </center>
                        </div>
                    <?php } ?>
                    </td>
                </tr>
            </table>
<?php
        }
    }
}
?>