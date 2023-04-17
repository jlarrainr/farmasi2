<?php
include('../../session_user.php');
$invnum = $_SESSION['transferencia_sal'];
function convertir_a_numero($str)
{
    $legalChars = "%[^0-9\-\. ]%";
    $str = preg_replace($legalChars, "", $str);
    return $str;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once '../../../textos_generales.php';
    require_once('../../../titulo_sist.php');
    require_once("../funciones/transferencia.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES

    $sqlP = "SELECT precios_por_local,salidaTransferenciaSucursal,salidaTransferenciaSucursalPorcentaje FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
            $salidaTransferenciaSucursal = $row['salidaTransferenciaSucursal'];
            $salidaTransferenciaSucursalPorcentaje = $row['salidaTransferenciaSucursalPorcentaje'];
        }
    }

    if ($salidaTransferenciaSucursal == 1) {
        $COSTOCAJA = 'PRECIO VENTA CAJA';
        $COSTOUNIT = 'PRECIO VENTA UNIT';
        $COSTOPRODUCTO = 'PRECIO PRODUCTO';
    } else if ($salidaTransferenciaSucursal == 2) {
        $COSTOCAJA = 'COSTO PROM CAJA';
        $COSTOUNIT = 'COSTO PROM UNIT';
        $COSTOPRODUCTO = 'COSTO PRODUCTO';
    } else if ($salidaTransferenciaSucursal == 3) {
        $COSTOCAJA = 'COSTO REAL CAJA ("' . $salidaTransferenciaSucursalPorcentaje . '")%  MARGEN DE RENTABILIDAD ';
        $COSTOUNIT = 'COSTO REAL UNIT ("' . $salidaTransferenciaSucursalPorcentaje . '")%  MARGEN DE RENTABILIDAD';
        $COSTOPRODUCTO = 'COSTO PRODUCTO ("' . $salidaTransferenciaSucursalPorcentaje . '")%  MARGEN DE RENTABILIDAD';
    }

    if ($precios_por_local  == 1) {
        require_once '../../../precios_por_local.php';
    }

    $sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $codloc = $row['codloc'];
        }
    }
    $sql = "SELECT nomloc,nombre FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
            $nombre = $row['nombre'];
        }
    }

    $sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
    $resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
    if (mysqli_num_rows($resultP_drogueria)) {
        while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
            $drogueria = $row_drogueria['drogueria'];
        }
    }


    $sql1 = "SELECT codloc,codgrup FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codloc = $row1['codloc'];
            $codgrupve = $row1['codgrup'];
        }
    }

    $sql1_codgrup = "SELECT * FROM `grupo_user` WHERE codgrup = '$codgrupve' and (nomgrup LIKE '%VENDEDOR%')"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_codgrup = mysqli_query($conexion, $sql1_codgrup);
    if (mysqli_num_rows($result1_codgrup)) {
        $controleditable = 1;
    } else {
        $controleditable = 0;
    }

    if ($precios_por_local  == 1) {
        require_once '../../../precios_por_local.php';
    }

    if ($controleditable == 1) {
        $typo = 'hidden';
    } else {

        $typo = 'text';
    }

    require_once('../tabla_local.php');
    ?>
    <script>
        function precioeditar() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.text1.value);
            var costre = parseFloat(document.form1.costre.value);
            var factor = parseFloat(document.form1.factor.value);


            var valor = isNaN(v1);
            if (valor == true) ////NO ES NUMERO
            {
                var v11 = document.form1.text1.value.substring(1);

                var multiplicador = parseFloat(costre / factor);
                multiplicador = Math.round(multiplicador * Math.pow(10, 2)) / Math.pow(10, 2);
                subtotal = parseFloat(multiplicador * v11);
            } else {
                var multiplicador = costre;
                multiplicador = Math.round(multiplicador * Math.pow(10, 2)) / Math.pow(10, 2);
                subtotal = parseFloat(multiplicador * v1);
            }

            multiplicador = Math.round(multiplicador * Math.pow(10, 2)) / Math.pow(10, 2);
            subtotal = Math.round(subtotal * Math.pow(10, 2)) / Math.pow(10, 2);

            if (document.form1.text1.value != '') {
                document.form1.text2.value = multiplicador;
                document.form1.text3.value = subtotal;


            } else {
                document.form1.text2.value = '';
                document.form1.text3.value = '';

            }
        }
    </script>

    <style>
        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }

        .LETRA2 {
            font-family: Tahoma, Verdana, Arial;
            font-size: 12px;
            color: #FF0000;
            background-color: #fdbfbf;
            border: #FF0000;
            border-style: solid;
            border-top-width: 1px;
            border-right-width: 1px;
            border-bottom-width: 1px;
            border-left-width: 1px;
            width: 4;

        }

        .Estilo2 {
            color: #ff4b0d;
            font-size: 30px;
            /* font-weight: bold; */
        }
    </style>
</head>

<body onload="fc()">
    <?php
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count = $row[0];
        }
    } else {
        $count = 0;
    }
    $sql = "SELECT * FROM tempmovmov where invnum = '$invnum' order by codtemp";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
    ?>
        <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">

            <table width="100%" id="customers" cellpadding="0" cellspacing="0">
                <tr>

                    <th width="5%" align="left">CODIGO</th>
                    <th width="20%" align="left">DESCRIPCION</th>
                    <th width="10%">
                        <div align="left">LABORATORIO /MARCA</div>
                    </th>
                    <th width="5%">
                        <div align="center">FACTOR</div>
                    </th>
                    <th width="8%">
                        <div align="center">STOCK ACTUAL</div>
                    </th>
                    <?php if ($drogueria == 1) { ?>
                        <th width="76">
                            <div align="center">STOCK VENCIDO</div>
                        </th>
                    <?php } ?>



                    <?php if ($drogueria == 1) { ?>
                        <th width="8%">
                            <div align="center">STOCK DISPONIBLE</div>
                        </th>
                    <?php } ?>
                    <th>
                        <div align="center">LOCAL EMISOR</div>
                    </th>

                    <?php if ($controleditable == 0) { ?>
                        <th width="5%">
                            <div align="center"><?php echo $COSTOCAJA; ?></div>
                        </th>
                    <?php } ?>

                    <?php if ($controleditable == 0) { ?>
                        <th width="5%">
                            <div align="center"><?php echo $COSTOUNIT; ?></div>
                        </th>

                    <?php } ?>

                    <th width="5%">
                        <div align="center">CANT</div>
                    </th>

                    <?php if ($controleditable == 0) { ?>
                        <th width="5%">
                            <div align="right"> <?php echo $COSTOPRODUCTO; ?> </div>
                        </th>

                    <?php } else { ?>
                        <th width="68">
                            <div align="right"> </div>
                        </th>
                    <?php }  ?>

                    <th width="5%">
                        <div align="right">SUB TOTAL</div>
                        </div>
                    </th>
                    <th width="5%">&nbsp;</th>
                </tr>
                <?php
                $i = 0;
                while ($row = mysqli_fetch_array($result)) {
                    $i++;
                    $codtemp = $row['codtemp'];
                    $codpro = $row['codpro'];  //codgio
                    $qtypro = $row['qtypro'];
                    $qtyprf = $row['qtyprf'];
                    $desc1 = $row['desc1'];
                    $desc2 = $row['desc2'];
                    $desc3 = $row['desc3'];
                    $prisal = $row['prisal'];
                    $pripro = $row['pripro'];
                    $costre = $row['costre'];

                    $sql1 = "SELECT porcent FROM datagen";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $porcent = $row1['porcent'];
                        }
                    }
                    $sql1 = "SELECT desprod,codmar,factor,costpr,stopro,$tabla,costre,mardis,codpro,prevta,preuni FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factor = $row1['factor'];
                            $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                            $cant_loc1 = $row1[5];
                            $codpro = $row1['codpro'];
                            $prevta = $row1['prevta'];
                            $preuni = $row1['preuni'];
                            

                            if ($drogueria == 1) {

                                $sql1_movlote = "SELECT  SUM(stock) FROM movlote where codpro = '$codpro' and codloc='$codloc' and stock > 0 and date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d') >= NOW() ORDER BY date_format(str_to_date(concat('01/',vencim),'%d/%m/%Y'),'%Y-%m-%d')   ";
                                $result1_movlote = mysqli_query($conexion, $sql1_movlote);
                                if (mysqli_num_rows($result1_movlote)) {
                                    while ($row1_movlote = mysqli_fetch_array($result1_movlote)) {
                                        $stock_movlote = $row1_movlote[0];
                                    }
                                }

                                $cant_loc = $stock_movlote;
                            } else {

                                $cant_loc = $cant_loc1;
                            }

                            $stock_vencido = $cant_loc1 - $cant_loc;


                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                                $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                $costrep = $row1['costre'];
                                $mardis = $row1['mardis'];
                            } elseif ($precios_por_local == 0) {

                                $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                $costrep = $row1['costre'];
                                $mardis = $row1['mardis'];
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $costpr_p,$costre_p,$mardis_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costpr = $row_precio[0];  ///COSTO PROMEDIO
                                        $costrep = $row_precio[1];
                                        $mardis = $row_precio[2];
                                    }
                                }
                            }
                        }
                    }
                    if ($salidaTransferenciaSucursal == 1) {
                        $costre2 = $prevta;
                    } else  if ($salidaTransferenciaSucursal == 2) {
                        $costre2 = $costpr;
                    } else  if ($salidaTransferenciaSucursal == 3) {
                        $costre2 = $costre * (1 + $salidaTransferenciaSucursalPorcentaje / 100);
                    } else {
                        $costre2 = $prevta;
                    }

                    $convert1 = $cant_loc / $factor;
                    $div1 = floor($convert1);
                    $UNI1 = ($cant_loc - ($div1 * $factor));
                    $sql1 = "SELECT codpro FROM ventas_bonif_unid where codpro = '$codpro' and unid <> 0";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        $bonif = 1;
                    } else {
                        $bonif = 0;
                    }
                    $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $ltdgen = $row1['ltdgen'];
                        }
                    }
                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";

                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $marca = $row1['destab'];
                        }
                    }
                    $valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
                    $cod = isset($_REQUEST['cod']) ? ($_REQUEST['cod']) : "";


                    if ($qtyprf <> "") {
                        $cantidad_solicitada =  convertir_a_numero($qtyprf);
                    } else {
                        $cantidad_solicitada = $qtypro * $factor;
                    }
                ?>

                    <tr <?php if (($cant_loc == '0') || ($cantidad_solicitada > $cant_loc)) {  ?> bgcolor='#f07878' <?php } ?>>
                        <!--<td width="35" valign="bottom">
                            <?php
                            if ($bonif == 1) {
                            ?>
                                                                                        <div align="center"><img src="../../../images/tickg.gif" width="19" height="18" /></div>
                            <?php }
                            ?>
                            </td>	-->
                        <td>
                            <?php echo $codpro ?>
                        </td>
                        <td valign="bottom">
                            <a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>', 435, 110, 560, 200)" title="EL FACTOR ES <?php echo $factor ?>"><?php echo $desprod ?> </a>
                        </td>
                        <td valign="bottom"><?php echo substr($marca, 0, 10) ?></td>
                        <td valign="bottom" align="center"><?php echo $factor ?></td>

                        <td bgcolor="#eaa35f">
                            <div align="center"><?php echo  stockcaja($cant_loc1, $factor); ?></div>
                        </td>

                        <?php if ($drogueria == 1) { ?>
                            <td <?php if ($stock_vencido > 0) { ?> bgcolor="#f2837c" <?php } else { ?> bgcolor="#a2ea5f" <?php } ?>>
                                <div align="center"><?php echo  stockcaja($stock_vencido, $factor); ?></div>
                            </td>
                        <?php } ?>

                        <?php if ($drogueria == 1) { ?>
                            <td bgcolor="#a2ea5f">
                                <div align="center"><?php echo  stockcaja($cant_loc, $factor); ?></div>
                            </td>
                        <?php } ?>

                        <td align="center" bgcolor="#5fa1ea"><?php echo $nombre ?></td>
                        <?php if ($controleditable == 0) { ?>
                            <td align="center"><?php echo $costre2 ?></td>
                            <td align="center"><?php echo $numero_formato_frances = number_format($costre2 / $factor, 2, '.', ' '); ?></td>

                        <?php } ?>

                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                    <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                    <input type="hidden" name="costpr" value="<?php echo $costpr; ?>" />
                                    <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                    <input type="hidden" name="factor" value="<?php echo $factor; ?>" />
                                    <input name="costre" type="hidden" id="costre" value="<?php echo $costre2; ?>" />
                                    <input name="number2" type="hidden" id="number2" />
                                    <input type="hidden" name="porcentaje" value="<?php
                                                                                    if ($igv == 1) {
                                                                                        echo $porcent;
                                                                                    }
                                                                                    ?>" />
                                    <input name="text1" type="text" class="input_text1" id="text1" value="<?php
                                                                                                            if ($qtyprf <> "") {
                                                                                                                echo $qtyprf;
                                                                                                            } else {
                                                                                                                echo $qtypro;
                                                                                                            }
                                                                                                            ?>" size="4" maxlength="6" onkeypress="return ent(event)" onKeyUp="precioeditar();" />


                                <?php
                                } else {
                                    if ($qtyprf <> "") {
                                        echo $qtyprf;
                                    } else {
                                        echo $qtypro;
                                    }
                                }
                                ?>
                            </div>
                        </td>

                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                    <input name="text2" type="text" id="text2" size="4" class="LETRA2" style="background: #d7d7d7;" value="<?php echo $pripro ?>" onclick="blur()" />
                                <?php
                                } else {
                                    if ($controleditable == 0) {
                                        echo $pripro;
                                    }
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                    <input name="text3" type="text" id="text3" size="4" class="LETRA2" style="background: #d7d7d7;" value="<?php echo $costre ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $costre;
                                }
                                ?>
                            </div>
                        </td>
                        <td valign="bottom">
                            <div align="center">
                                <!--a href="javascript:popUpWindow('lote/lote.php?cod=<?php echo $codpro ?>', 435, 110, 560, 200)" title="LOTE DE PRODUCTOS"><img src="../../../images/add.gif" width="14" height="15" border="0" title="LOTE DE PRODUCTOS"/></a-->
                                <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                    <input name="number" type="hidden" id="number" />
                                    <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                    <input name="stocklocal" type="hidden" id="stocklocal" value="<?php echo $cant_loc ?>" />
                                    <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
                                    <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR" />
                                <?php } else { ?>
                                    <a href="transferencia3_sal.php?cod=<?php echo $codpro ?>&valform=1"><img src="../../../images/edit_16.png" width="16" height="16" border="0" /></a>
                                    <a href="transferencia4_sal.php?cod=<?php echo $codtemp ?>" target="tranf_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0" /></a>
                                <?php } ?>
                            </div>
                        </td>
                    </tr>

                <?php }
                ?>
            </table>
        <?php
    } else {
        ?>
            <br>
            <div style="padding: 30px">
                <center>
                    <h1 class='Estilo2'> <?php echo TEXT_MENSAJE_DE_LISTAS_MOVIMIENTOS; ?></h1>
                </center>
            </div>
        <?php }
        ?>
        </form>
</body>

</html>