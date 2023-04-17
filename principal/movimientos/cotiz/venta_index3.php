<?php
include('../../session_user.php');
$venta = $_SESSION['cotiz'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/ventas_index3.css" rel="stylesheet" type="text/css" />
    <title>Documento sin t&iacute;tulo</title>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("funciones/ventas_index3.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLOR DE BOTONES
    require_once("funciones/datos_generales.php"); //COLOR DE BOTONES

    $sqlP = "SELECT precios_por_local FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
        }
    }
    if ($precios_por_local  == 1) {
        require_once '../../../precios_por_local.php';
    }

    if ($resolucion == 1) {
        $charact = 40;
        $charactbonif = 10;
    } else {
        $charact = 40;
        $charactbonif = 14;
    }

    $sql1_usuario = "SELECT codloc,codgrup FROM usuario where usecod = '$usuario'"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_usuario = mysqli_query($conexion, $sql1_usuario);
    if (mysqli_num_rows($result1_usuario)) {
        while ($row1_usuario = mysqli_fetch_array($result1_usuario)) {
            $codloc = $row1_usuario['codloc'];
            $codgrupve = $row1_usuario['codgrup'];
        }
    }

    $sql1_grupo_user = "SELECT * FROM grupo_user WHERE codgrup = '$codgrupve' and ((nomgrup LIKE '%adm%')or (nomgrup LIKE '%sup%'))"; ////CODIGO DEL LOCAL DEL USUARIO
    $result1_grupo_user = mysqli_query($conexion, $sql1_grupo_user);
    if (mysqli_num_rows($result1_grupo_user)) {
        $controleditable = 1;
    } else {
        $controleditable = 0;
    }

    $sql1 = "SELECT priceditable FROM datagen_det";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $priceditable = $row1['priceditable'];
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
    <style>
        a {
            text-decoration: none;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers tbody td,
        #customers thead th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers tbody tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tbody tr:hover {
            background-color: #FFFF66;
        }

        #customers thead th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 1rem;
            font-weight: 900;
        }

        b {
            color: red;
        }
    </style>
</head>

<body onload="ad();" onkeyup="abrir_index2(event)">
    <?php
    $i = 1;
    $sql = "SELECT codet,codpro,canpro,fraccion,factor,prisal,pripro,fraccion,bonif FROM cotizacion_det where invnum = '$venta'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
    ?>
        <!---<u><b>PRODUCTOS AGREGADOS</b></u>
              - <b><font color="#FF0000"><u>F4 = CANCELAR VENTA</u></font></b> 
            -  <b><font color="#FF0000"><u>F9 = GRABAR VENTA</u></font></b> 
           <b><font color="#FF0000"><u>F9 = IMPRIMIR VENTA</u></font></b> -->
        <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" id="customers">
                <thead>
                    <tr>
                        <th width="2%" bgcolor="#50ADEA" style="border-top-left-radius: 10px;padding:0 5px;" class="titulos_movimientos">N&ordm;</th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos" align="center">CODIGO</th>
                        <th width="41%" bgcolor="#50ADEA" class="titulos_movimientos">DESCRIPCION</th>
                        <th width="9%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">MARCA</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">PRECIO CAJA</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">PPRECIO BLISTER</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">PRECIO UNIDAD</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">CANTIDAD</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" class="titulos_movimientos">
                            <div align="center">SUB TOTAL</div>
                        </th>
                        <th width="6%" bgcolor="#50ADEA" style="border-top-right-radius: 10px;padding:0 5px;" class="titulos_movimientos">
                            <div align="right"></div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $codtemp = $row['codet'];
                        $codpro = $row['codpro'];  //codgio
                        $canpro = $row['canpro'];
                        $fraccion = $row['fraccion'];
                        $factor = $row['factor'];
                        $prisal = $row['prisal'];
                        $pripro = $row['pripro'];
                        $fraccion = $row['fraccion'];
                        $bonif = $row['bonif'];
                        if ($fraccion == "F") {
                            $cantemp = $canpro * $factor;
                        } else {
                            $cantemp = $canpro;
                        }
                        $sql1 = "SELECT desprod,codmar,factor,costpr,stopro,incentivado,prelis,margene,blister,preblister,$tabla,$TablaPrevtaMain as PrevtaMain,$TablaPreuniMain as PreuniMain,$TablaPrevta,$TablaPreuni,codpro FROM producto where codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $desprod    = $row1['desprod'];
                                $codmar     = $row1['codmar'];
                                $factor     = $row1['factor'];
                                $stopro     = $row1['stopro'];
                                $inc        = $row1['incentivado'];
                                $cant_loc   = $row1[10];
                                $codpro     = $row1['codpro'];

                                if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                                    $costpr         = $row1['costpr'];
                                    $referencial    = $row1['prelis'];
                                    $margene        = $row1['margene'];
                                    $pblister       = $row1['blister'];
                                    $preblister     = $row1['preblister'];
                                    $prevtaMain     = $row1['PrevtaMain'];
                                    $preuniMain     = $row1['PreuniMain'];
                                    $prevta         = $row1[13];
                                    $preuni         = $row1[14];
                                } elseif ($precios_por_local == 0) {

                                    $costpr         = $row1['costpr'];
                                    $referencial    = $row1['prelis'];
                                    $margene        = $row1['margene'];
                                    $pblister       = $row1['blister'];
                                    $preblister     = $row1['preblister'];
                                    $prevtaMain     = $row1['PrevtaMain'];
                                    $preuniMain     = $row1['PreuniMain'];
                                    $prevta         = $row1[13];
                                    $preuni         = $row1[14];
                                }

                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $costpr_p,$prelis_p,$margene_p,$blister_p,$preblister_p,$prevta_p,$preuni_p FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $costpr         = $row_precio[0];
                                            $referencial    = $row_precio[1];
                                            $margene        = $row_precio[2];
                                            $pblister       = $row_precio[3];
                                            $preblister     = $row_precio[4];
                                            $prevtaMain     = $row_precio[5];
                                            $preuniMain     = $row_precio[6];
                                            $prevta         = $row_precio[5];
                                            $preuni         = $row_precio[6];
                                        }
                                    }
                                }



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
                        if (($referencial <> 0) and ($referencial <> $prevta)) {
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
                        if (($incentivado == 1) and ($cant_loc > 0)) {
                            $color = "prodincent";
                            $text = "text_prodincent";
                        } else {
                            if ($cant_loc > 0) {
                                $color = "prodnormal";
                                $text = "text_prodnormal";
                            } else {
                                $color = "prodstock";
                                $text = "text_prodstock";
                            }
                        }
                        if ($preuni > 0) {
                        } else {
                            if ($factor <> 0) {
                                $preuni = $prevta / $factor;
                            }
                        }
                        $valform = $_REQUEST['valform'];
                        $cod = $_REQUEST['cod'];
                    ?>
                        <tr>
                            <td bgcolor="#50ADEA">
                                <a style="text-decoration:none" align="center">
                                    <div style="color:#fff;font-size:1rem"><?php echo $i ?>-</div>
                                </a>
                            </td>
                            <td align="center">
                                <a style="text-decoration:none" class="<?php echo $text ?>">
                                    <div class="<?php echo $text ?>"><?php echo $codpro ?></div>
                                </a>
                            </td>
                            <td>
                                <div class="<?php echo $text ?>" title="Su factor es <?php echo $factor; ?>">
                                    <a id="l1" style="text-decoration:none" href="venta_index3.php?cod=<?php echo $codpro ?>&valform=1">
                                        <?php
                                        echo substr($desprod, 0, 40);
                                        echo " ";
                                        ?> </a>
                                </div>
                            </td>
                            <td>
                                <div align="center" class="<?php echo $text ?>"><?php
                                                                                if ($marca1 == "") {
                                                                                    echo substr($marca, 0, 5);
                                                                                    echo " ";
                                                                                } else {
                                                                                    echo substr($marca1, 0, 5);
                                                                                    echo " ";
                                                                                }
                                                                                ?></div>
                            </td>


                            <td bgcolor="#e6f3fc">
                                <div class="<?php echo $text ?>">
                                    <div align="right"><?php echo $prevta ?></div>
                                </div>
                            </td>
                            <td bgcolor="#e6f3fc">
                                <div align="right" class="<?php echo $text ?>"><?php echo $pblister . "<b>&nbsp;>&nbsp;</b>" . $preblister; ?> </div>
                            </td>
                            <!--INGRESA EL PRECIO-->
                            <td width="70" title="222">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                        <input name="t22" type="hidden" id="t22" value="<?php echo $prisal; ?>" />
                                        <!--<input name="preblis" type="hidden" id="preblis" value="<?php echo $preblister; ?>" />
                                                    <input name="blister" type="hidden" id="blister" value="<?php echo $blister; ?>" />-->
                                        <input name="t23" type="hidden" id="t23" value="<?php echo $preuni; ?>" />
                                        <input name="t24" type="hidden" id="t24" value="<?php echo $prevta; ?>" />
                                        <!--<input name="t2" type="text" id="t2" size="4" class="input_text1" value="<?php echo $prisal; ?>" <?php if (($controleditable == '0') || ($priceditable == '0')) { ?>disabled="disabled" <?php } ?> onKeyUp="precio2();" onkeypress="return letrac(event)" />-->
                                        <input name="t2" type="text" id="t2" size="4" class="input_text1" value="<?php echo $prisal; ?>" <?php
                                                                                                                                            if ($priceditable == 1) {
                                                                                                                                            } else {
                                                                                                                                                if ($controleditable == 1) {
                                                                                                                                                } else {
                                                                                                                                            ?>readonly <?php
                                                                                                                                                    }
                                                                                                                                                }
                                                                                                                                                        ?> onKeyUp="precio2();" onkeypress="return letrac(event)" />
                                    <?php } else {
                                    ?>
                                        <div class="<?php echo $text ?>">
                                            <font size="4"> <?php echo $prisal; ?> </font>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            </td>

                            <!--CANTIDAD-->
                            <td>
                                <div align="center">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                        <input name="pblister" type="hidden" id="pblister" value="<?php echo $pblister ?>" />
                                        <input name="preblister" type="hidden" id="preblister" value="<?php echo $preblister ?>" />
                                        <input type="hidden" name="cantemp" id="cantemp" value="<?php echo $cantemp; ?>" />
                                        <input type="hidden" name="stockpro" value="<?php echo $cant_loc; ?>" />
                                        <input type="hidden" name="factor" value="<?php echo $factor; ?>" />
                                        <input type="hidden" name="codpro" value="<?php echo $codpro; ?>" />
                                        <input size="4" name="t1" type="text" class="input_text1" id="t1" value="<?php
                                                                                                                    if ($fraccion == 'T') {
                                                                                                                        echo $canpro;
                                                                                                                    }
                                                                                                                    if ($fraccion == 'F') {
                                                                                                                        $canpro = "C" . $canpro;
                                                                                                                        echo $canpro;
                                                                                                                    }
                                                                                                                    ?>" size="20" onKeyUp="precio1();" onkeypress="return letrac(event)" />
                                    <?php } else {
                                    ?>
                                        <div class="<?php echo $text ?>">
                                            <?php
                                            if ($fraccion == 'T') {
                                                echo $canpro;
                                            }
                                            if ($fraccion == 'F') {
                                                $canpro = 'C' . $canpro;
                                                echo $canpro;
                                            }
                                            ?>
                                        </div><?php }
                                                ?>
                                </div>
                            </td>

                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                        <input name="t33" type="hidden" id="t33" value="<?php echo $pripro ?>" />
                                        <input name="t3" type="text" id="t3" size="4" class="pvta" value="<?php echo $pripro ?>" onclick="blur()" disabled="disabled" />
                                    <?php } else { ?>
                                        <div class="<?php echo $text ?>">
                                            <font size="4"> <?php echo $pripro; ?> </font>
                                        </div>
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <div align="center">
                                    <?php
                                    if ($pripro >= 0) {
                                    ?>
                                        <?php if (($valform == 1) && ($cod == $codpro)) { ?>
                                            <input name="number" type="hidden" id="number" />
                                            <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                            <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
                                            <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR" />
                                            <?php
                                        } else {
                                            if ($bonif2 == 0) {
                                            ?>
                                                <a href="venta_index3.php?cod=<?php echo $codpro ?>&valform=1"><img src="../../../images/edit_16.png" width="16" height="16" border="0" /></a>
                                                <a href="venta_index3_del.php?cod=<?php echo $codtemp ?>" target="venta_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0" /></a>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </td>
                        </tr>
                </tbody>
            <?php
                        $i++;
                    }
            ?>
            </table>
        </form>
    <?php } ?>
</body>

</html>