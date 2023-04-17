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

    #customers tr:nth-child(even) {
        background-color: #f0ecec;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers thead th {

        text-align: center;
        background-color: #50ADEA;
        color: white;
        font-size: 12px;
        font-weight: 900;
    }
</style>

<?php
function formato($c) {
        printf("%06d", $c);
    }
$hour = date('G');
//$hour   = CalculaHora($hour);
$min = date('i');
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

if($fpago=='all'){
     $accionFormapago="";
}elseif($fpago =='F'){
   $accionFormapago=" and forpag='F' ";
}elseif($fpago =='B'){
     $accionFormapago=" and forpag='B' ";
}elseif($fpago =='G'){
     $accionFormapago=" and forpag='G' ";
}elseif($fpago =='O'){
     $accionFormapago=" and forpag='O' ";
}

//echo '$accionFormapago = '.$accionFormapago;
?>

<table width="100%" border="0" align="center">
    <tr>
        <td>
            <table width="100%" border="0">
                <tr>
                    <td width="260"><strong><?php echo $desemp ?> </strong></td>
                    <td width="380">
                        <div align="center">
                            <strong>REPORTE DE REGISTRO DE COMPRA -
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
if (($ck1 == '')) {
    if (($vals == 2)) {
        ?>



        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr height="40">
                <td width="95%">
            <center>
                <h2>RESUMEN DE REGISTRO DE COMPRA</h2>
            </center>
        </td>
        </tr>

        <tr>
            <td colspan="2">


                <?php
                if ($vals == 2) {
                    if ($local == 'all') {
                        $sql = "SELECT MA.invnum,MA.invfec,MA.fecdoc,MA.forpag,MA.numero_documento,MA.numero_documento1,MA.fecven,MA.usecod,MA.cuscod as proveedor, MA.igv,MA.sucursal,MA.invtot,MA.valven,SUM(MA.dafecto) AS dafecto,SUM(MA.dinafecto) AS dinafecto,SUM(MA.digv) AS digv,SUM(MA.dtotal) AS dtotal FROM movmae as MA WHERE MA.fecdoc between '$date1' and '$date2' and  MA.tipmov='1'and MA.tipdoc='1' and MA.estado='1' and MA.proceso='0' and MA.val_habil='0' " . $accionFormapago . "  group by MA.cuscod order by MA.fecdoc ASC";
                    } else {
                        $sql = "SELECT MA.invnum,MA.invfec,MA.fecdoc,MA.forpag,MA.numero_documento,MA.numero_documento1,MA.fecven,MA.usecod,MA.cuscod as proveedor, MA.igv,MA.sucursal,MA.invtot,MA.valven,SUM(MA.dafecto)  AS dafecto,SUM(MA.dinafecto) AS dinafecto ,SUM(MA.digv) AS digv,SUM(MA.dtotal)AS dtotal FROM movmae as MA WHERE MA.fecdoc between '$date1' and '$date2' and MA.sucursal = '$local' and  MA.tipmov='1'and MA.tipdoc='1' and MA.estado='1' and MA.proceso='0' and MA.val_habil='0'  " . $accionFormapago . "  group by MA.cuscod order by MA.fecdoc ASC";
                    }
                }

                //echo $sql;

                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    ?>
                    <table width="100%" border="0" align="center" id="customers">
                        <thead>
                            <tr align="center">
                                <?php if ($ckloc == 1) { ?>
                                    <th width="120"><strong>LOCAL</strong></th>
                                <?php } ?>
            <!--                                <th><strong>INVNUM</strong></th>
            <th><strong>FECHA DE EMISION</strong></th>
            <th><strong>TIPO DOC</strong></th>
            <th><strong>NUMERO DOCUMENTO</strong></th>
            <th><strong>FECHA DE PAGO</strong></th>-->
                                <th colspan="2" ><strong>PROVEEDOR</strong></th>
                                <!--<th><strong>USUARIO</strong></th>-->
                                <th><strong>AFECTO</strong></th>
                                <th><strong>IGV</strong></th>
                                <th><strong>INAFECTO</strong></th>
                                <th><strong>MONTO TOTA</strong></th>

                            </tr>
                        </thead>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                            $invnum = $row['invnum'];
                            $invfec = $row['invfec'];
                            $fecdoc = $row['fecdoc'];
                            $forpag = $row['forpag'];
                            $numero_documento = $row['numero_documento'];
                            $numero_documento1 = $row['numero_documento1'];
                            $fecven = $row['fecven'];
                            $usecod = $row['usecod'];
                            $proveedor = $row['proveedor'];
                            $igv = $row['igv'];
                            $sucursal = $row['sucursal'];
                            $invtot = $row['invtot'];
                            $valven = $row['valven'];
                            $dafecto = $row['dafecto'];
                            $dinafecto = $row['dinafecto'];
                            $digv = $row['digv'];
                            $dtotal = $row['dtotal'];
                            $dafectototal += $row['dafecto'];
                            $dinafectototal += $row['dinafecto'];
                            $digvtotal += $row['digv'];
                            $dtotaltotal += $row['dtotal'];

                            $i++;

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


                            $sql2 = "SELECT despro,rucpro FROM proveedor WHERE codpro='$proveedor' ";
                            $result1 = mysqli_query($conexion, $sql2);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $despro = $row1['despro'];
                                    $rucpro = $row1['rucpro'];

                                    if (($rucpro == '') || ($rucpro == 0)) {
                                        $rucpro = '-----------------';
                                    } else {
                                        $rucpro = $rucpro;
                                    }
                                }
                            }

                            $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
                            $result1 = mysqli_query($conexion, $sql1);
                            if (mysqli_num_rows($result1)) {
                                while ($row1 = mysqli_fetch_array($result1)) {
                                    $user = $row1['nomusu'];
                                }
                            }
                            ?>
                            <tr >
                                <?php if ($ckloc == 1) { ?><td width="30" align="center"><?php echo $sucur ?></td><?php } ?>
                <!--                                <td>
                                    <div align="center"><?php echo $invnum; ?></div>
                                </td>-->
                <!--                                <td>
                                    <div align="center"><?php echo fecha($invfec); ?></div>
                                </td>-->
                <!--                                <td>
                                    <div align="center"><?php echo $forpag; ?></div>
                                </td>-->
                <!--                                <td>
                                    <div align="center"><?php echo $numero_documento . " - " . $numero_documento1 ?></div>
                                </td>-->
                <!--                                <td>
                                    <div align="center"><?php echo fecha($fecven); ?></div>
                                </td>-->
                                <td >
                                    <div align="center"><?php echo $despro; ?></div>
                                </td>
                                <td  >
                                    <div align="center"> RUC: <?php echo $rucpro; ?></div>
                                </td>
                <!--                                <td>
                                    <div align="center"><?php echo $user; ?></div>
                                </td>-->
                <!--                                <td>
                                    <div align="center"><?php echo $invtot; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $igv; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $valven ?></div>
                                </td>-->
                                <td>
                                    <div align="center"><?php echo $dafecto; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $digv; ?></div>
                                </td>
                                <td>
                                    <div align="center"><?php echo $dinafecto; ?></div>
                                </td>

                                <td>
                                    <div align="center"><?php echo $dtotal; ?></div>
                                </td>


                            </tr>
                        <?php } ?>
                        <tr bgcolor="#ece8e7">
                            <th <?php if ($ckloc == 1) { ?>colspan="3"<?php } else { ?>colspan="2"<?php } ?> bgcolor="#ece8e7">  
                                <div align="center">TOTAL</div>
                            </th>
                            <th bgcolor="#ece8e7">
                                <div align="center"><?php echo $dafectototal; ?></div>
                            </th>
                            <th bgcolor="#ece8e7">
                                <div align="center"><?php echo $digvtotal; ?></div>
                            </th>
                            <th bgcolor="#ece8e7">
                                <div align="center"><?php echo $dinafectototal; ?></div>
                            </th>

                            <th bgcolor="#ece8e7">
                                <div align="center"><?php echo $dtotaltotal; ?></div>
                            </th>
                        </tr>
                    </table>

                    <?php
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
?>
<?php
if (($ck1 == 1)) {

    if (($vals == 2)) {
        ?>

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>


                    <?php
                    if ($vals == 2) {
                        if ($local == 'all') {
                            $sql = "SELECT * FROM movmae as MA WHERE MA.fecdoc between '$date1' and '$date2' and  MA.tipmov='1'and MA.tipdoc='1' and MA.estado='1' and MA.proceso='0' and MA.val_habil='0'  " . $accionFormapago . "   order by MA.fecdoc ASC";
                        } else {
                            $sql = "SELECT * FROM movmae as MA WHERE MA.fecdoc between '$date1' and '$date2' and MA.sucursal = '$local' and  MA.tipmov='1'and MA.tipdoc='1' and MA.estado='1' and MA.proceso='0' and MA.val_habil='0'  " . $accionFormapago . "  order by MA.fecdoc ASC";
                        }
                    }

                    //echo $sql;

                    $zz = 0;
                    $i = 0;
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        ?>
                        <table width="100%" border="1" align="center" id="customers">
                            <thead>
                                <tr>
                                    <?php if ($ckloc == 1) { ?><th width="30"><strong>LOCAL</strong></th><?php } ?>
                                    <th width="50">
                                        <div align=""><strong>INVNUM </strong></div>
                                    </th>
                                    <th width="50">
                                        <div align=""><strong>CODIGO DOCUMENTO </strong></div>
                                    </th>
                                    <th width="40">
                                        <div align=""><strong>FECHA DE DIGITACION</strong></div>
                                    </th>
                                     <th width="40">
                                        <div align=""><strong>FECHA DE EMISION</strong></div>
                                    </th>
                                    <th width="40">
                                        <div align=""><strong>TIPO DOC</strong></div>
                                    </th>
                                    <th width="40">
                                        <div align=""><strong>NUMERO DOCUMENTO</strong></div>
                                    </th>
                                    <th width="40">
                                        <div align=""><strong>FECHA DE PAGO</strong></div>
                                    </th>
                                    <th width="40" colspan="2">
                                        <div align=""><strong>PROVEEDOR</strong></div>
                                    </th>
                                    <th width="40" >
                                        <div align=""><strong>AFECTO</strong></div>
                                    </th>
                                    <th width="40" >
                                        <div align=""><strong>IGV</strong></div>
                                    </th>
                                    <th width="40" >
                                        <div align=""><strong>INAFECTO</strong></div>
                                    </th>
                                    <th width="40" >
                                        <div align=""><strong>TOTAL</strong></div>
                                    </th>

                                </tr>
                            <thead>
                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    $invnum = $row['invnum'];
//                                    $usecod = $row['usecod'];
                                    $cuscod = $row['cuscod'];
                                    $sucursal = $row["sucursal"];
                                    $invfecv = $row["invfec"];
                                    $fecdocv = $row["fecdoc"];
                                    $i++;
                                    $ssss[$i] = $sucursal;
                                    if ($sucursal <> $suc[$zz]) {
                                        $zz++;
                                        $suc[$zz] = $sucursal;
                                    }
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
//                                    $e_tot = 0;
//                                    $t_tot = 0;
//                                    $c_tot = 0;
//                                    //		$inafecto = 0;
//                                    $deshabil_tot = 0;
//                                    $deshabil_gravado = 0;
//                                    $habil_inafecto11 = 0;
//                                    $habil_tot = 0;
//                                    $count = 0;
//                                    $tot = 0;
//                                    $Rentabilidad = 0;
//                                    $sumpripro = 0;
//                                    $sumpcosto = 0;
//                                    $porcentaje = 0;
//                                    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usecod'";
//                                    $result1 = mysqli_query($conexion, $sql1);
//                                    if (mysqli_num_rows($result1)) {
//                                        while ($row1 = mysqli_fetch_array($result1)) {
//                                            $user = $row1['nomusu'];
//                                        }
//                                    }



//$dafecto_tot1 = 0;
                                    $sql2 = "SELECT * FROM movmae where invnum = '$invnum'";
                                    $result2 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result2)) {
                                        while ($row2 = mysqli_fetch_array($result2)) {
                                            $invnum = $row['invnum'];
                                            $invfec = $row['invfec'];
                                            $fecdoc = $row['fecdoc'];
                                            $forpag = $row['forpag'];
                                            $numero_documento = $row['numero_documento'];
                                            $numero_documento1 = $row['numero_documento1'];
                                            $fecven = $row['fecven'];
                                            $usecod = $row['usecod'];
                                            $proveedor = $row['cuscod'];
                                            $igv = $row['igv'];
                                            $numdoc = $row['numdoc'];
                                            $sucursal = $row['sucursal'];
                                            $invtot = $row['invtot'];
                                            $valven = $row['valven'];
                                            $dafecto = $row['dafecto'];
                                            $dinafecto = $row['dinafecto'];
                                            $digv = $row['digv'];
                                            $dtotal = $row['dtotal'];
                                            $dafectototal += $row['dafecto'];
                                            $dinafectototal += $row['dinafecto'];
                                            $digvtotal += $row['digv'];
                                            $dtotaltotal += $row['dtotal'];
                                        }
                                    }
    $forpagTexto='';
if($forpag =='F'){
    $forpagTexto="Factura";
}elseif($forpag =='B'){
     $forpagTexto="Boleta";
}elseif($forpag =='G'){
     $forpagTexto="Guia";
}elseif($forpag =='O'){
     $forpagTexto="Otros";
}

                                    $sql2 = "SELECT despro,rucpro FROM proveedor WHERE codpro='$proveedor' ";
                                    $result1 = mysqli_query($conexion, $sql2);
                                    if (mysqli_num_rows($result1)) {
                                        while ($row1 = mysqli_fetch_array($result1)) {
                                            $despro = $row1['despro'];
                                            $rucpro = $row1['rucpro'];

                                            if (($rucpro == '') || ($rucpro == 0)) {
                                                $rucpro = '-----------------';
                                            } else {
                                                $rucpro = $rucpro;
                                            }
                                        }
                                    }
                                    $dafecto_tot1[$zz] = $dafecto_tot1[$zz] + $dafecto;
                                    $dinafecto_tot1[$zz] = $dinafecto_tot1[$zz] + $dinafecto;
                                    $digv_tot1[$zz] = $digv_tot1[$zz] + $digv;
                                    $dtotal_tot1[$zz] = $dtotal_tot1[$zz] + $dtotal;
                                    
                                    if (($suc[$zz - 1] <> "") and ( $suc[$zz - 1] <> $suc[$zz])) {
                                        if ($sucursal <> $ssss[$i - 1]) {
                                            ?>
                                            <tr bgcolor="#CCCCCC">


                                                <td <?php if ($ckloc == 1) { ?>
                                                        COLSPAN="9"                        



                                                    <?php } else { ?>
                                                        COLSPAN="8" 

                                                    <?php } ?>>
                                                    <div align="center"><strong>TOTAL</strong></div>
                                                </td>
                                                <td width="64">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($dafecto_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="64">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($dinafecto_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="64">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($digv_tot1[$zz - 1], 2, '.', ' '); ?></div>
                                                </td>
                                                <td width="64">
                                                    <div align="center"><?php echo $numero_formato_frances = number_format($dtotal_tot1[zz - 1], 2, '.', ' '); ?></div>
                                                </td>


                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                <!--                                <tbody>-->
                                    <tr >
                                        <?php if ($ckloc == 1) { ?><td width="15"><?php echo $sucur ?></td><?php } ?>
                                        <td width="40">
                                            <div align="center"><?php echo $invnum ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center">
                                            <a href="javascript:popUpWindow('ver_movimiento.php?invnum=<?php echo $invnum ?>&val=<?php echo $val ?>&vals=<?php echo $vals ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&mov=<?php echo $mov ?>&user=<?php echo $user ?>&local=<?php echo $local ?>&tex=<?php echo 'INGRESO POR COMPRA' ?>', 20, 90, 985, 500)"><?php echo formato($numdoc) ?></a>
                                            </div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo fecha($invfecv) ?></div>
                                        </td>
                                        
                                          <td width="40">
                                            <div align="center"><?php echo fecha($fecdoc); ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo $forpagTexto ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo $numero_documento . "-" . $numero_documento1; ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo fecha($fecven); ?></div>
                                        </td>
                                    
                                        <td width="40">
                                            <div align="center"><?php echo $despro ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"> RUC: <?php echo $rucpro ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo $dafecto ?></div>
                                        </td>
                                        
                                        <td width="40">
                                            <div align="center"><?php echo $digv ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo $dinafecto ?></div>
                                        </td>
                                        <td width="40">
                                            <div align="center"><?php echo $dtotal ?></div>
                                        </td>

                                    </tr>
                                    <!--</tbody>-->
                                <?php } ?>

                                <?php if ($zz == 1) { ?>
                                <tfoot>
                                    <tr bgcolor="#CCCCCC">


                                        <td <?php if ($ckloc == 1) { ?>
                                                COLSPAN="10"                        



                                            <?php } else { ?>
                                                COLSPAN="9" 

                                            <?php } ?>>
                                            <div align="center"><strong>TOTAL</strong></div>
                                        </td>
                                        <?php if ($doc == 1) { ?>
                                            <td></td>
                                        <?php } ?>
                                        <td >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dafectototal, 2, '.', ' '); ?></div>
                                        </td>
                                        <td >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($digvtotal, 2, '.', ' '); ?></div>
                                        </td>
                                        <td >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dinafectototal, 2, '.', ' '); ?></div>
                                        </td>
                                        <td >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dtotaltotal, 2, '.', ' '); ?></div>
                                        </td>


                                    </tr>

                                    <!--</table>-->
                                <?php } else { ?>
                                    <!--<table width="100%" border="0" align="center">-->
                                    <tr>
                                        <th <?php if ($ckloc == 1) { ?>
                                                COLSPAN="9"                        



                                            <?php } else { ?>
                                                COLSPAN="8" 

                                            <?php } ?>>
                                            <div align="center"><strong>TOTAL FINAL</strong></div>
                                        </th>
                                        <th >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dafectototal, 2, '.', ' '); ?></div>
                                        </th>
                                        <th >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dinafectototal, 2, '.', ' '); ?></div>
                                        </th>
                                        <th >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($digvtotal, 2, '.', ' '); ?></div>
                                        <th >
                                            <div align="center"><?php echo $numero_formato_frances = number_format($dtotaltotal, 2, '.', ' '); ?></div>
                                        </th>

                                    </tr>

                                    <?php
                                }
                                ?>
                            </tfoot>
                        </table>
                        <?php
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

            <!--A-->


        </table>
        <?php
    }
}
?>