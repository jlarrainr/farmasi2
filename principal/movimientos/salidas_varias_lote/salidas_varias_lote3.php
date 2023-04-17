<?php
include('../../session_user.php');
$invnum = $_SESSION['transferencia_sal_val'];
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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once '../../../textos_generales.php';
    require_once('../../../titulo_sist.php');
    require_once("functions.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../convertfecha.php"); //ILUMINA CAJAS DE TEXTOS
    $sqlP_drogueria = "SELECT  drogueria  FROM datagen_det";
    $resultP_drogueria = mysqli_query($conexion, $sqlP_drogueria);
    if (mysqli_num_rows($resultP_drogueria)) {
        while ($row_drogueria = mysqli_fetch_array($resultP_drogueria)) {
            $drogueria = $row_drogueria['drogueria'];
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
    require_once('../tabla_local.php');
    ?>

    <style>
        .Estilo2 {
            color: #0b55c4;
            font-size: 35px;
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
                    <th width="4%">ID LOTE</th>
                    <th width="4%">CODPRO</th>
                    <th width="20%">DESCRIPCION</th>
                    <th width="10%">
                        <div align="center">MARCA</div>
                    </th>
                    <th width="5%">
                        <div align="center">FACTOR</div>
                    </th>


                    <th width="5%">
                        <div align="center">NUMERO LOTE</div>
                    </th>
                    <th width="5%">
                        <div align="center">VENCIMIENTO</div>
                    </th>
                    <th width="5%">
                        <div align="center">STOCK LOTE</div>
                    </th>

                    <th width="5%">
                        <div align="center">CANT</div>
                    </th>
                    <th width="5%">
                        <div align="center">COSTO</div>
                    </th>
                    <th width="5%">
                        <div align="center">SUB TOTAL</div>
                    </th>
                    <th width="3%">&nbsp;</th>
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
                    $idlote_salida = $row['idlote_salida'];


                    $sql_movlote = "SELECT numlote, vencim,stock FROM  movlote where idlote ='$idlote_salida'";
                    $result_movlote = mysqli_query($conexion, $sql_movlote);
                    if (mysqli_num_rows($result_movlote)) {
                        while ($row_movlote = mysqli_fetch_array($result_movlote)) {
                            $numlote_lote = $row_movlote['numlote'];
                            $vencim_lote = $row_movlote['vencim'];
                            $cant_loc = $row_movlote['stock'];
                        }
                    }

                    $sql1 = "SELECT porcent FROM datagen";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $porcent = $row1['porcent'];
                        }
                    }
                    $sql1 = "SELECT desprod,codmar,factor,costpr,stopro,$tabla,costre,codpro FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factor = $row1['factor'];
                            $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                            // $cant_loc1 = $row1[5];
                            $codpro = $row1['codpro'];  ///COSTO PROMEDIO

                            if ($factor == 1) {
                                $comparativa = 4;
                            } else {
                                $comparativa = 1;
                            }

                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {

                                $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                $costre2 = $row1['costre'];
                            } elseif ($precios_por_local == 0) {

                                $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                $costre2 = $row1['costre'];
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $costpr_p,$costre_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costpr = $row_precio[0];  ///COSTO PROMEDIO
                                        $costre2 = $row_precio[1];
                                    }
                                }
                            }
                        }
                    }


                    $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = 'M'";

                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $marca = $row1['destab'];
                        }
                    }


                    $valform = $_REQUEST['valform'];
                    $cod = $_REQUEST['cod'];


                    if ($qtyprf <> "") {
                        $cantidad_solicitada =  convertir_a_numero($qtyprf);
                    } else {
                        $cantidad_solicitada = $qtypro * $factor;
                    }

                    if ($qtyprf <> "") {
                        $cantidadMuestra = $qtyprf;
                    } else {
                        $cantidadMuestra = $qtypro;
                    }

                ?>

                    <tr>
                        <td <?php if (($cant_loc == '0') || ($cantidad_solicitada > $cant_loc)) {  ?>bgcolor="#f07878" style="color: #fff;font-size:16px" <?php } ?>>

                            <?php if (($cant_loc == '0') || ($cantidad_solicitada > $cant_loc)) {  ?>
                                <div align="center">
                                    <blink>
                                        <?php echo $idlote_salida; ?>
                                    </blink>
                                </div>
                            <?php } else { ?>
                                <div align="center">
                                    <?php echo $idlote_salida; ?>
                                </div>
                            <?php } ?>


                        </td>
                        <td valign="bottom" align="center">
                            <?php echo $codpro; ?>
                        </td>

                        <td valign="bottom">
                            <a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $idlote_salida ?>&invnum=<?php echo $invnum ?>', 435, 110, 560, 200)" title="EL FACTOR ES <?php echo $factor ?>"><?php echo $desprod ?> </a>
                        </td>

                        <td valign="bottom"><?php echo substr($marca, 0, 10); ?></td>

                        <td valign="bottom" align="center"><?php echo $factor; ?></td>


                        <td bgcolor="#eaa35f">
                            <div align="center"><?php echo  $numlote_lote; ?></div>
                        </td>
                        <td bgcolor="#eaa35f">
                            <div align="center"><?php echo  $vencim_lote; ?></div>
                        </td>
                        <td bgcolor="#a2ea5f">
                            <div align="center"><?php echo  stockcaja($cant_loc, $factor); ?></div>
                        </td>


                        <!--CANTIDAD-->
                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $idlote_salida)) { ?>
                                    <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                    <input type="hidden" name="costpr" value="<?php echo $costpr; ?>" />
                                    <input name="costre" type="hidden" id="costre" value="<?php echo $costre2 ?>" />
                                    <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                    <input type="hidden" name="factor" value="<?php echo $factor; ?>" />

                                    <input name="subtotal2" type="hidden" id="subtotal2" />

                                    <input type="hidden" name="porcentaje" value="<?php
                                                                                    if ($igv == 1) {
                                                                                        echo $porcent;
                                                                                    }
                                                                                    ?>" />
                                    <input name="text1" type="text" class="input_text1" id="text1" value="<?php echo $cantidadMuestra; ?>" size="4" maxlength="6" onkeypress="return ent(event,<?php echo $comparativa ?>)" onKeyUp="precio();" />


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
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $idlote_salida)) { ?>
                                    <input name="text2" type="text" id="text2" size="4" class="pvta" value="<?php echo $costre;  ?>" onclick="blur()" readonly />
                                <?php
                                } else {
                                    echo $costre;
                                }
                                ?>
                            </div>
                        </td>

                        <td valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $idlote_salida)) { ?>
                                    <input name="text3" type="text" id="text3" size="4" class="pvta" value="<?php echo $pripro ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $pripro;
                                }
                                ?>
                            </div>
                        </td>

                        <td valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $idlote_salida)) { ?>
                                    <input name="number" type="hidden" id="number" />
                                    <input name="cod" type="hidden" id="cod" value="<?php echo $idlote_salida ?>" />
                                    <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                    <input name="invnum" type="hidden" id="invnum" value="<?php echo $invnum ?>" />
                                    <input type="button" id="boton" onClick="validar_prod_update()" alt="GUARDAR" />
                                    <input type="button" id="boton1" onClick="validar_grid_update()" alt="ACEPTAR" />


                                <?php } else { ?>
                                    <a href="salidas_varias_lote3.php?cod=<?php echo $idlote_salida ?>&valform=1"><img src="../../../images/edit_16.png" width="16" height="16" border="0" /></a>
                                    <a href="transferencia4_sal.php?cod=<?php echo $idlote_salida ?>&codtemp=<?php echo $codtemp; ?>&invnum=<?php echo $invnum ?>&delete=1 " target="comp_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0" /></a>
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
            <br><br><br><br><br><br><br><br>

            <div align="center" class="botones" style="padding: 15px">
                <h1 class='Estilo2'> <?php echo TEXT_MENSAJE_DE_LISTAS_MOVIMIENTOS; ?></h1>
            </div>



        <?php }
        ?>
        </form>
</body>

</html>