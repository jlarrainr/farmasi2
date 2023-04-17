<link href="css/style1.css" rel="stylesheet" type="text/css" />
<link href="css/tablas.css" rel="stylesheet" type="text/css" />
</head>

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
$sql = "SELECT Preciovtacostopro FROM datagen";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $i++;

        $Preciovtacostopro = $row["Preciovtacostopro"];
    }
}
$date = date('Y-m-d');
$hour = date(G);
//$hour   = CalculaHora($hour);
$min = date(i);
if ($hour <= 12) {
    $hor = "am";
} else {
    $hor = "pm";
}
//$val    = $_REQUEST['val'];
//$local  = $_REQUEST['local'];
//$inicio = $_REQUEST['inicio'];
//$pagina = $_REQUEST['pagina'];
$tot_pag = $_REQUEST['tot_pag'];
//$registros  = $_REQUEST['registros'];
if ($local == 1) {
    $local = 'all';
}
if ($local <> 'all') {
    require_once("datos_generales.php");
}
?>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0">
                    <tr>
                        <td width="361"><strong><?php echo $desemp ?></strong></td>
                        <td width="221"><strong>REPORTE DE PRODUCTOS POR PRECIOS </strong></td>
                        <td width="30">&nbsp;</td>
                        <td width="284">
                            <div align="right"><strong>FECHA: <?php echo date('d/m/Y'); ?> - HORA : <?php echo $hour; ?>:<?php echo $min; ?> <?php echo $hor ?></strong></div>
                        </td>
                    </tr>

                </table>
                <table width="100%" border="0">
                    <tr>
                        <td width="134"></td>
                        <td width="633">
                            <div align="center"><b><?php
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
    ?>

        <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php
                    $i = 0;
                    if ($local == 'all') {
                        $sql = "SELECT codpro,desprod,pcostouni,preuni,margene,costpr,costre,factor,prevta,codmar FROM producto and eliminado='0' order by desprod LIMIT $inicio,$registros";
                    } else {
                        $sql = "SELECT codpro,desprod,pcostouni,preuni,margene,costpr,costre,factor,prevta,codmar FROM producto where $tabla > 0 and eliminado='0' order by desprod LIMIT $inicio, $registros";
                    }
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                    ?>
                        <table width="100%" border="0" align="center" id="customers">
                            <tr>
                                <th><strong>CODIGO</strong></th>
                                <th>
                                    <div align="left"><strong>PRODUCTO</strong></div>
                                </th>
                                <th>
                                    <div align="left"><strong>MARCA</strong></div>
                                </th>
                                <th>
                                    <div align="center"><strong>FACTOR</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>PRECIO DE COSTO</strong></div>
                                </th>
                                <!--<th width="80"><div align="right"><strong>MARGEN</strong></div></th>-->
                                <th>
                                    <div align="right"><strong>PRECIO VTA</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>COSTO UNI.</strong></div>
                                </th>
                                <th>
                                    <div align="right"><strong>PRECIO VTA X UNI.</strong></div>
                                </th>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $producto = $row['desprod'];
                                $codpro = $row['codpro'];
                                $factor = $row['factor'];
                                $codmar = $row['codmar'];


                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                    $pcostouni  = $row['pcostouni'];
                                    $preuni     = $row['preuni'];
                                    $margene    = $row['margene'];
                                    $costpr     = $row['costpr'];
                                    $costre     = $row['costre'];
                                    $prevta     = $row['prevta'];
                                } elseif ($precios_por_local == 0) {
                                    $pcostouni  = $row['pcostouni'];
                                    $preuni     = $row['preuni'];
                                    $margene    = $row['margene'];
                                    $costpr     = $row['costpr'];
                                    $costre     = $row['costre'];
                                    $prevta     = $row['prevta'];
                                }
                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $pcostouni_p,$preuni_p,$margene_p,$costpr_p,$costre_p,$prevta_p  FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $pcostouni  = $row_precio[0];
                                            $preuni     = $row_precio[1];
                                            $margene    = $row_precio[2];
                                            $costpr     = $row_precio[3];
                                            $costre     = $row_precio[4];
                                            $prevta     = $row_precio[5];
                                        }
                                    }
                                }


                                $sql2 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                $result2 = mysqli_query($conexion, $sql2);
                                if (mysqli_num_rows($result2)) {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        $destab = $row2['destab'];
                                        $abrev = $row2['abrev'];
                                        if ($abrev <> '') {
                                            $destab = $abrev;
                                        }
                                    }
                                }
                                $i++;
                            ?>
                                <tr>
                                    <td><?php echo $codpro ?></td>
                                    <td><?php echo $producto ?></td>
                                    <td><?php echo $destab ?></td>
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
                                        <div align="right"><?php
                                                            if ($Preciovtacostopro == 1) {
                                                                echo $numero_formato_frances = number_format($costpr / $factor, 2, '.', ' ');
                                                            } else {
                                                                echo $numero_formato_frances = number_format($costre / $factor, 2, '.', ' ');
                                                            }
                                                            ?></div>
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
    <?php }   //////cierro el if (val)
    ?>