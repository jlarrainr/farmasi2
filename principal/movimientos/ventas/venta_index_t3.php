<?php
require_once('../../session_user.php');
require_once('session_ventas_temp.php');
$tventa = isset($_SESSION['tventa']) ? $_SESSION['tventa'] : "";
$cotizacion = isset($_SESSION['cotizacion']) ? $_SESSION['cotizacion'] : "";
$incentivado = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/ventas_index3.css" rel="stylesheet" type="text/css" />
        <title>Documento sin t&iacute;tulo</title>
        <?php
        require_once('../../../conexion.php');
        require_once('../../../funciones/highlight.php');
        require_once('../funciones/functions.php');
        require_once('funciones_temp/ventas_index3.php');
        require_once('../../../funciones/funct_principal.php');
        require_once('../../../funciones/botones.php');
        require_once('funciones_temp/datos_generales.php');
        if ($resolucion == 1) {
            $charact = 40;
            $charactbonif = 10;
        } else {
            $charact = 40;
            $charactbonif = 14;
        }

        $sqlVenta = "SELECT sucursal FROM venta2 where invnum = '$tventa'";
        $resultVenta = mysqli_query($conexion, $sqlVenta);
        if (mysqli_num_rows($resultVenta)) {
            while ($rowVenta = mysqli_fetch_array($resultVenta)) {
                $sucursal = $rowVenta['sucursal'];
            }
        }

//**CONFIGPRECIOS_PRODUCTO**//
        $nomlocalG = "";
        $sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
        $resultLocal = mysqli_query($conexion, $sqlLocal);
        if (mysqli_num_rows($resultLocal)) {
            while ($rowLocal = mysqli_fetch_array($resultLocal)) {
                $nomlocalG = $rowLocal['nomloc'];
            }
        }

        $TablaPrevtaMain = "prevta";
        $TablaPreuniMain = "preuni";
        if ($nomlocalG <> "") {
            if ($nomlocalG == "LOCAL1") {
                $TablaPrevta = "prevta1";
                $TablaPreuni = "preuni1";
            } else {
                if ($nomlocalG == "LOCAL2") {
                    $TablaPrevta = "prevta2";
                    $TablaPreuni = "preuni2";
                } else {
                    $TablaPrevta = "prevta";
                    $TablaPreuni = "preuni";
                }
            }
        } else {
            $TablaPrevta = "prevta";
            $TablaPreuni = "preuni";
        }
//**FIN_CONFIGPRECIOS_PRODUCTO**//
        ?>
    </head>
    <body onload="ad();" onkeyup="abrir_index2(event)">
        <?php
        $i = 1;
//$sql="SELECT codtemp,codpro,canpro,fraccion,factor,prisal,pripro,fraccion,bonif,bonif2 FROM temp_venta where invnum = '$tventa' order by codtemp";
        $sql = "SELECT codtemp,codpro,canpro,fraccion,factor,prisal,pripro,fraccion,bonif,bonif2 FROM detalle_venta2 where invnum = '$tventa' order by codtemp";
//error_log($sql);
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            ?>
            <u><b>PRODUCTOS AGREGADOS</b></u> - <b><font color="#FF0000"><u>F4 = CANCELAR VENTA</u></font></b> -  <b><font color="#FF0000"><u>F8 = GRABAR VENTA</u></font></b> - <b><font color="#FF0000"><u>F9 = IMPRIMIR VENTA</u></font></b> 
            <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
                <input name="CodClaveVendedor" type="hidden" id="CodClaveVendedor" value="" />
                <table class="celda2" width="<?php if ($resolucion == 1) { ?>700<?php } else { ?>910<?php } ?>">
                    <tr>
                        <td width="<?php if ($resolucion == 1) { ?>20<?php } else { ?>29<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">N&ordm;</td>
                        <td width="<?php if ($resolucion == 1) { ?>255<?php } else { ?>324<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</td>
                        <td width="<?php if ($resolucion == 1) { ?>20<?php } else { ?>80<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">MARCA</div></td>
                        <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>68<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1) { ?>P. REF<?php } else { ?>PRECIO REF<?php } ?></div></td>
                        <td width="<?php if ($resolucion == 1) { ?>40<?php } else { ?>45<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right">DCTOS</div></td>
                        <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>69<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1) { ?>CANT<?php } else { ?>CANTIDAD<?php } ?></div></td>
                        <td width="<?php if ($resolucion == 1) { ?>65<?php } else { ?>73<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1) { ?>P. CAJA<?php } else { ?>PRECIO Caja<?php } ?></div></td>
                        <td width="70" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1) { ?>P. UN<?php } else { ?>PRECIO Unid<?php } ?></div></td>
                        <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>64<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"><?php if ($resolucion == 1) { ?>SUB TOT<?php } else { ?>SUB TOTAL<?php } ?></div></td>
                        <td width="<?php if ($resolucion == 1) { ?>40<?php } else { ?>44<?php } ?>" bgcolor="#50ADEA" class="titulos_movimientos"><div align="right"></div></td>
                    </tr>
                </table>
                <table class="celda2" width="<?php if ($resolucion == 1) { ?>700<?php } else { ?>910<?php } ?>">
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $codtemp = $row['codtemp'];
                        $codpro = $row['codpro'];
                        $canpro = $row['canpro'];
                        $fraccion = $row['fraccion'];
                        $factor = $row['factor'];
                        $prisal = $row['prisal'];
                        $pripro = $row['pripro'];
                        $bonif = $row['bonif'];
                        $bonif2 = $row['bonif2'];
                        if ($fraccion == 'F') {
                            $cantemp = $canpro * $factor;
                        } else {
                            $cantemp = $canpro;
                        }
                        $sql1 = "SELECT desprod,codmar,factor,costpr,stopro,incentivado,prelis,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni FROM producto where codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $desprod = $row1['desprod'];
                                $codmar = $row1['codmar'];
                                $factor = $row1['factor'];
                                $costpr = $row1['costpr'];
                                $stopro = $row1['stopro'];
                                $inc = $row1['incentivado'];
                                $referencial = $row1['prelis'];
                                $margene = $row1['margene'];
                                $pblister = $row1['blister'];
                                $preblister = $row1['preblister'];
                                $cant_loc = $row1[10];
                                $prevtaMain = $row1['PrevtaMain'];
                                $preuniMain = $row1['PreuniMain'];
                                $prevta = $row1[13];
                                $preuni = $row1[14];

                                //**CONFIGPRECIOS_PRODUCTO**//
                                if (($prevta == "") || ($prevta == 0)) {
                                    $prevta = $prevtaMain;
                                }
                                if (($preuni == "") || ($preuni == 0)) {
                                    $preuni = $preuniMain;
                                }

                                //**FIN_CONFIGPRECIOS_PRODUCTO**//

                                if (strlen($pblister) == 0) {
                                    $pblister = 0;
                                }
                                if (strlen($preblister) == 0) {
                                    $preblister = 0;
                                }
                            }
                        }
                        if (($referencial <> 0) and ( $referencial <> $prevta)) {
                            $margenes = ($margene / 100) + 1;
                            $precio_ref = $referencial;
                            //$precio_ref     = $referencial/$factor;
                            //$precio_ref     = $referencial*$factor;
                            $precio_ref = $precio_ref * $margenes;
                            $precio_ref = number_format($precio_ref, 2, '.', ',');
                            $desc1 = $precio_ref - $preuni;
                            if ($desc1 < 0) {
                                $descuento = 0;
                            } else {
                                $descuento = (($precio_ref - $preuni) / $precio_ref) * 100;
                            }
                        } else {
                            $precio_ref = $preuni;
                            $descuento = 0;
                        }
                        $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $ltdgen = $row1['ltdgen'];
                            }
                        }
                        $sql1 = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $marca = $row1['destab'];
                                $marca1 = $row1['abrev'];
                            }
                        }
                        if (($incentivado == 1) and ( $cant_loc > 0)) {
                            $color = 'prodincent';
                            $text = 'text_prodincent';
                        } else {
                            if ($cant_loc > 0) {
                                $color = 'prodnormal';
                                $text = 'text_prodnormal';
                            } else {
                                $color = 'prodstock';
                                $text = 'text_prodstock';
                            }
                        }
                        if ($preuni > 0) {
                            
                        } else {
                            if ($factor <> 0) {
                                $preuni = $prevta / $factor;
                            }
                        }
                        $valform = isset($_REQUEST['valform']) ? $_REQUEST['valform'] : "";
                        $cod = isset($_REQUEST['cod']) ? $_REQUEST['cod'] : "";
                        ?>
                        <tr onmouseover="this.style.backgroundColor = '#FFFF99';this.style.cursor = 'hand';" onmouseout="this.style.backgroundColor = '#ffffff';">
                            <td width="<?php if ($resolucion == 1) { ?>20<?php } else { ?>29<?php } ?>">
                                <a href="#" class="<?php echo $text ?>">
                                    <div class="<?php echo $text ?>"><?php echo $i ?>-</div>
                                </a>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>255<?php } else { ?>324<?php } ?>">
                                <div class="<?php echo $text ?>">
                                    <a id="l1" href="venta_index_t3.php?cod=<?php echo $codpro ?>&valform=1">
                                        <?php
                                        echo substr($desprod, 0, $charact);
                                        echo " ";
                                        ?>	</a>
                                </div>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>20<?php } else { ?>80<?php } ?>"><div class="<?php echo $text ?>"><?php
                                    if ($marca1 == "") {
                                        echo substr($marca, 0, 5);
                                        echo " ";
                                    } else {
                                        echo substr($marca1, 0, 5);
                                        echo " ";
                                    }
                                    ?></div></td>
                            <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>68<?php } ?>"><div class="<?php echo $text ?>">
                                    <div align="right"><?php echo $numero_formato_frances = number_format($precio_ref, 2, '.', ' '); ?></div>
                                </div>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>40<?php } else { ?>45<?php } ?>"><div class="<?php echo $text ?>">
                                    <div align="right"><?php echo $numero_formato_frances = number_format($descuento, 0, '.', ' '); ?>%</div>
                                </div>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>69<?php } ?>">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                        <input name="pblister" type="hidden" id="pblister" value="<?php echo $pblister ?>" />
                                        <input name="preblister" type="hidden" id="preblister" value="<?php echo $preblister ?>" />
                                        <input type="hidden" name="cantemp" id="cantemp" value="<?php echo $cantemp; ?>"/>
                                        <input type="hidden" name="stockpro" value="<?php echo $cant_loc; ?>"/>
                                        <input type="hidden" name="factor" value="<?php echo $factor; ?>"/>
                                        <input type="hidden" name="codpro" value="<?php echo $codpro; ?>"/>
                                        <input name="t1" type="text" class="input_text1" id="t1" value="<?php
                                        if ($fraccion == 'T') {
                                            echo $canpro;
                                        } if ($fraccion == 'F') {
                                            $canpro = "c" . $canpro;
                                            echo $canpro;
                                        }
                                        ?>" size="20" onKeyUp ="precio1();" onkeypress="return letrac(event)"/>
                                           <?php } else {
                                               ?>
                                        <div class="<?php echo $text ?>">
                                            <?php
                                            if ($fraccion == 'T') {
                                                echo $canpro;
                                            }
                                            if ($fraccion == 'F') {
                                                $canpro = 'c' . $canpro;
                                                echo $canpro;
                                            }
                                            ?>
                                        </div><?php }
                                        ?>
                                </div>
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>65<?php } else { ?>73<?php } ?>"><div class="<?php echo $text ?>">
                                    <div align="right"><?php echo $prevta ?></div>
                                </div>
                            </td>
                            <td width="70">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                        <input name="t22" type="hidden" id="t22" value="<?php echo $prisal ?>"/>
                                        <input name="t23" type="hidden" id="t23" value="<?php echo $preuni ?>"/>
                                        <input name="t24" type="hidden" id="t24" value="<?php echo $prevta ?>"/>
                                        <input name="t2" type="text" id="t2" size="20" class="pvta" value="<?php echo $prisal ?>" onclick="blur()" disabled="disabled"/>
                                    <?php } else {
                                        ?> 
                                        <div class="<?php echo $text ?>"><font size="4"> <?php echo $prisal; ?> </font></div>
                                    <?php }
                                    ?>
                                </div>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>64<?php } ?>">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                        <input name="t33" type="hidden" id="t33" value="<?php echo $pripro ?>" />
                                        <input name="t3" type="text" id="t3" size="20" class="pvta" value="<?php echo $pripro ?>" onclick="blur()" disabled="disabled"/>
                                    <?php } else {
                                        ?>
                                        <div class="<?php echo $text ?>"><font size="4"> <?php echo $pripro; ?> </font></div>
                                    <?php }
                                    ?>
                                </div>	
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>40<?php } else { ?>44<?php } ?>">
                                <div align="center">
                                    <?php
                                    if ($pripro <> 0) {
                                        ?>
                                        <?php if (($valform == 1) && ($cod == $codpro)) { ?> 
                                            <input name="number" type="hidden" id="number" />
                                            <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                            <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR"/>
                                            <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR"/>
                                            <?php
                                        } else {
                                            if ($bonif2 == 0) {
                                                ?>
                                                <a href="venta_index_t3.php?cod=<?php echo $codpro ?>&valform=1"><img src="../../../images/edit_16.png" width="16" height="16" border="0"/></a>
                                                <a href="venta_index_t3_del.php?cod=<?php echo $codtemp ?>" target="venta_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0"/></a> 
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>	
                            </td>
                        </tr>
                        <?php
                        ++$i;
                    }
                    ?>
                </table>
            </form>
            <?php
        }
        mysqli_free_result($result);
        mysqli_free_result($result1);
        mysqli_close($conexion);
        ?>
    </body>
</html>
