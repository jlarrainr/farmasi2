<link href="../css/style1.css" rel="stylesheet" type="text/css" />
<link href="../css/tablas.css" rel="stylesheet" type="text/css" />

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

    #customers th {

        text-align: center;
        background-color: #50ADEA;
        color: white;
        font-size: 12px;
        font-weight: 900;
    }
</style>
<?php
$sql = "SELECT nomusu,codloc FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user = $row['nomusu'];
        $codloc = $row['codloc'];
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
 
 
 
  
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="377"><strong><?php echo $desemp ?></strong></td>
                        <td width="205"><strong>REPORTE DE ARCHIVO MAESTRO</strong></td>
                        <td width="284">
                            <div align="center"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>
<tr>
<td></td>
                        <td >
                            <div align="center"><b> <?php
                                                                                            if ($local == 'all') {
                                                                                                echo 'TODOS LOS LOCALES';
                                                                                            } else {
                                                                                                echo $nomloc;
                                                                                            }
                                                                                            ?></b></div>
                        </td>
                        <td  >
                            <div align="center">USUARIO:<span class="text_combo_select"><?php echo $user ?></span></div>
                        </td>
                    </tr>
                </table>
                 
                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <?php
    if ($val == 1) {
    ?>

            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <?php
                         $digemid ='';
                         $registrosanitario ='';
                         $blister ='';
                         $preblister ='';
                        //$sql = "SELECT codpro,desprod,$tabla,costpr,costre,margene,prevta,preuni,preblister,blister,registrosanitario,digemid,incentivado,codmar,factor FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' AND $tabla>0  order by destab,desprod ";
                        $sql = "SELECT P.codpro,P.desprod,P.$tabla,P.costpr,P.costre,P.margene,P.prevta,P.preuni,P.preblister,P.blister,P.registrosanitario,P.digemid,P.incentivado,P.codmar,P.factor,MV.numlote,MV.vencim,MV.stock FROM producto as P inner join titultabladet as T on P.codmar = T.codtab INNER JOIN movlote as MV on MV.codpro=P.codpro where T.destab between '$marca1' and '$marca2' AND P.$tabla>0 order by T.destab,P.desprod ";
                        $result = mysqli_query($conexion, $sql);
                        if (mysqli_num_rows($result)) {
                        ?>
                            <table width="100%" border="0" align="center" id="customers">
                                <tr>
                                     <th>CODIGO PRODUCTO</th>
                                     <th>DESCRIPCION</th>
                                     <th>MARCA/LABORATORIO</th>
                                     <th>FACTOR</th>
                                     <th>CANTIDAD STOCK</th>
                                     <th>COSTO POR CAJA + IGV</th>
                                     <th>COSTO POR UNIDAD + IGV</th>
                                     <th>PORCENTAJE DE UTILIDAD X CAJA</th>
                                     <th>PRECIO VENTA X CAJA + IGV</th>
                                     <th>PRECIO VENTA X UNIDAD + IGV</th>
                                     <th>PRECIO VENTA BLISTER + IGV</th>
                                     <th>CANTIDAD BLISTER</th>
                                     <th>PROVEEDOR</th>
                                     <th>LOTE</th>
                                     <th>FECHA VENCIMIENTO</th>
                                     <th>REGISTRO SANITARIO</th>
                                     <th>DIGEMID</th>
                                     <th>VALOR INCENTIVO</th>
                                </tr>
                                <?php 
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codpro             = $row['codpro'];
                                        $desprod            = $row['desprod'];
                                        $stock_local        = $row[2];
                                        $costpr             = $row['costpr'];
                                        $costre             = $row['costre'];
                                        $margene            = $row['margene'];
                                        $prevta             = $row['prevta'];
                                        $preuni             = $row['preuni'];
                                        $preblister         = $row['preblister'];
                                        $blister            = $row['blister'];
                                        $registrosanitario  = $row['registrosanitario'];
                                        $digemid            = $row['digemid'];
                                        $incentivado        = $row['incentivado'];
                                        $codmar             = $row['codmar'];
                                        $factor             = $row['factor'];
                                        $numlote            = $row['numlote'];
                                        $vencimnnn          = $row['vencim'];
                                        $stock          = $row['stock'];

                                   /*     $vencimnnn = "";
                                        $numlote = "";
                                        $sql1_movlote = "SELECT numlote,vencim FROM movlote where codpro = '$codpro'  and codloc= '$codloc'  and stock <> 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') limit 1";
                                        $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                        if (mysqli_num_rows($result1_movlote)) {
                                            while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                                $numlote = $row1_movlote['numlote'];
                                                $vencimnnn = $row1_movlote['vencim'];
                                            }
                                        }
*/
                                        ////////////////////proveedor ultimo
                                        $desproveedor = "OTROS INGRESOS";
                                        $sql1 = "SELECT P.despro FROM movmae as ME INNER JOIN movmov as MV on MV.invnum=ME.invnum INNER JOIN  proveedor AS P ON P.codpro=ME.cuscod WHERE MV.codpro='$codpro' and ME.tipmov='1' and ME.tipdoc='1' and ME.numero_documento <> '' and ME.numero_documento1 <> '' ORDER BY MV.invnum DESC LIMIT 1";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $desproveedor = $row1[0];
                                            }
                                        }
                                        $pripro_incentivado ='';
                                        $sql1 = "SELECT  ID.pripro FROM incentivadodet as ID INNER JOIN incentivado as I on I.invnum=ID.invnum  WHERE ID.codpro='$codpro' and I.estado='1' and I.invnum='$incentivado' ";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $pripro_incentivado = $row1[0];
                                            }
                                        }
                                        $destab='';
                                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab = $row1['destab'];
                                                 
                                            }
                                        }
                                ?>
                                <tr>
                                    <td align="center"><?php echo  $codpro;?></td>
                                    <td><?php echo $desprod;?></td>
                                    <td><?php echo $destab;?></td>
                                    <td align="center"><?php echo $factor;?></td>
                                    <td align="center"><?php echo stockcaja( $stock,$factor);?></td>
                                    <td align="center"><?php echo $costpr;?></td>
                                    <td align="center"><?php echo round(($costpr/$factor),2);?></td>
                                    <td align="center"><?php echo $margene;?></td>
                                    <td align="center"><?php echo $prevta;?></td>
                                    <td align="center"><?php echo $preuni;?></td>
                                    <td align="center"><?php echo $preblister;?></td>
                                    <td align="center"><?php echo $blister;?></td>
                                    <td align="center"><?php echo $desproveedor;?></td>
                                    <td align="center"><?php echo $numlote ;?></td>
                                    <td align="center"><?php echo $vencimnnn;?></td>
                                    <td align="center"><?php echo $registrosanitario;?></td>
                                    <td align="center"><?php echo $digemid;?></td>
                                    <td align="center"><?php echo $pripro_incentivado;?></td>
                                </tr>
                                <?php } ?>

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
    ?>
</body>

</html>

 