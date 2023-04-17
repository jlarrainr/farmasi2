<?php
include('../../session_user.php');
$invnum = isset($_SESSION['ingresos_val']) ? $_SESSION['ingresos_val'] : 0;
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
    require_once('../../../titulo_sist.php');
    require_once("functions.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../convertfecha.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once '../../../textos_generales.php';
    //error_log("En Ingresos Varios 3");

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
    $sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }

    $sql1 = "SELECT drogueria FROM datagen_det";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $drogueria = $row1['drogueria'];
        }
    }
    if ($drogueria == 1) {
        $lotenombre = "lote";
    } else {
        $lotenombre = "lotec";
    }
    require_once('../tabla_local.php');
    ?>

<style>
        .Estilo2 {
            color: black;
            font-size: 25px;
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

            <table id="customers" cellpadding="0" cellspacing="0">
                <tr>
                    <!-- <th width="35"> BONIF</th> -->
                    <th width="35"> CODIGO</th>
                    <th width="304" align="left">DESCRIPCION</th>
                    <th width="115">
                        <div align="left">MARCA/LABORATORIO</div>
                    </th>
                    <th width="91">
                        <div align="center">FACTOR</div>
                    </th>
                    <th width="91">
                        <div align="center">LOCAL</div>
                    </th>
                    <th width="78">
                        <div align="center">STOCK ACTUAL</div>
                    </th>

                    <th width="81">
                        <div align="center">CANTIDAD</div>
                    </th>
                    <th width="78">
                        <div align="center">NUMERO LOTE</div>
                    </th>
                    <th width="100">
                        <div align="center">VENCIMENTO</div>
                    </th>
                    <th width="73">
                        <div align="center">COSTO REPOSICION </div>
                    </th>
                    <th width="58">
                        <div align="center">SUB TOT</div>
                    </th>

                    <!--   <th width="27" ><div align="center">LOTE</div></th>-->

                    <th width="64">&nbsp;</th>
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
                    $numlote = $row['numlote'];





                    $sql2 = "SELECT vencim FROM templote where numerolote  = '$numlote' and codpro = '$codpro' and codtemp='$codtemp' ";
                    $result2 = mysqli_query($conexion, $sql2);
                    if (mysqli_num_rows($result2)) {
                        while ($row2 = mysqli_fetch_array($result2)) {
                            $vencimi = $row2['vencim'];
                            //                                list($m, $ycar) = split('[/.-]', $vencimi);
                            //                                $search = 0;
                        }
                    }
                    $fecaven = explode('/', $vencimi);
                    $sql1 = "SELECT porcent FROM datagen";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $porcent = $row1['porcent'];
                        }
                    }
                    $sql1 = "SELECT desprod,codmar,factor,pcostouni,stopro,$tabla, $lotenombre as lote,codpro FROM producto where codpro = '$codpro'";
                    $result1 = mysqli_query($conexion, $sql1);
                    if (mysqli_num_rows($result1)) {
                        while ($row1 = mysqli_fetch_array($result1)) {
                            $desprod = $row1['desprod'];
                            $codmar = $row1['codmar'];
                            $factor = $row1['factor'];
                            //$costpr     = $row1['costpr'];  ///COSTO PROMEDIO

                            $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                            $cant_loc = $row1[5];
                            $lote = $row1['lote'];
                            $codpro = $row1['codpro'];



                            if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
                            } elseif ($precios_por_local == 0) {
                                $costpr = $row1['pcostouni'];  ///COSTO PROMEDIO
                            }

                            if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                $sql_precio = "SELECT $costpr_p FROM precios_por_local where codpro = '$codpro'";
                                $result_precio = mysqli_query($conexion, $sql_precio);
                                if (mysqli_num_rows($result_precio)) {
                                    while ($row_precio = mysqli_fetch_array($result_precio)) {
                                        $costpr = $row_precio[0];  ///COSTO PROMEDIO
                                    }
                                }
                            }
                        }
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
                    $codtempfiltro = $_REQUEST['codtempfiltro'];
                ?>

                    <tr>
                        <?php
                        // if ($bonif == 1) {
                        ?>
                        <!-- <div align="center"><img src="../../../images/tickg.gif" width="19" height="18" /></div> -->
                        <?php //}
                        ?>
                        <!-- </td> -->
                        <td align="center" valign="bottom"><?php echo $codpro; ?></td>

                        <td width="305" valign="bottom">
                            <a href="javascript:popUpWindow('ver_prod.php?cod=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>', 435, 110, 560, 200)" title="EL FACTOR ES <?php echo $factor ?>"><?php echo $desprod ?> </a>
                        </td>
                        <td width="115" valign="bottom"><?php echo substr($marca, 0, 10) ?></td>
                        <td width="91" valign="bottom" align="center"><?php echo $factor ?></td>
                        <td width="91" valign="bottom" align="center"><?php echo $nomloc ?></td>
                        <!--<td width="78" valign="bottom"><div align="center"><?php echo $cant_loc ?></div></td>-->
                        <td width="75">
                            <div align="center"><?php echo stockcaja($cant_loc, $factor); ?></div>
                        </td>

                        <td width="81" valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>

                                    <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                    <input type="hidden" name="costpr" value="<?php echo $costre; ?>" />
                                    <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                    <input type="hidden" name="factor" value="<?php echo $factor; ?>" />
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
                                                                                                            ?>" size="4" maxlength="6" onKeyPress="return f(event)" onKeyUp="precio();" />
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


                        <!--<td valign="bottom"><div align="center"><?php echo $numlote; ?></div></td>-->

                        <td width="74" valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="numlote" type="text" id="numlote" size="8" class="input_text1" value="<?php echo $numlote; ?>" />
                                <?php
                                } else {
                                    echo $numlote;
                                }
                                ?>
                            </div>
                        </td>

                        <td valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="mesL" type="text" id="mesL" size="1" maxlength="2" class="input_text1" value="<?php echo $fecaven[0]; ?>" />
                                    /
                                    <input name="yearsL" type="text" id="yearsL" size="3" class="input_text1" maxlength="4" value="<?php echo $fecaven[1]; ?>" />




                                    <input name="locall" type="hidden" id="locall" value="<?php echo $codloc ?>" />
                                    <input name="usu" type="hidden" id="usu" value="<?php echo $usuario ?>" />
                                <?php
                                } else {
                                    echo $vencimi;
                                }
                                ?>
                            </div>
                        </td>

                        <!-- <td valign="bottom"><div align="center"><?php echo $vencimi ?></div></td>-->



                        <td width="74" valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text2" type="text" id="text2" size="4" class="pvta" value="<?php echo $costre; ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $costre;
                                }
                                ?>
                            </div>
                        </td>
                        <td width="59" valign="bottom">
                            <div align="right">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="text3" type="text" id="text3" size="4" class="pvta" value="<?php echo $prisal; ?>" onclick="blur()" />
                                <?php
                                } else {
                                    echo $prisal;
                                }
                                ?>
                            </div>
                        </td>

                        <!--<td width="27">
                                <a href="javascript:popUpWindow('lote/lote.php?cod=<?php echo $codpro ?>&invnum=<?php echo $invnum ?>&ncompra=<?php echo $ncompra ?>&ok=<?php echo $ok ?>', 435, 110, 560, 200)" title="LOTE DE PRODUCTOS">
                                    <div align="center"><?php if ($lote == 1) { ?><img src="../../../images/add.gif" width="14" height="15" border="0"/><?php } ?></div>
                                </a>	  
                            </td>-->

                        <td width="61" valign="bottom">
                            <div align="center">
                                <?php if (($valform == 1) && ($cod == $codpro) && ($codtempfiltro == $codtemp)) { ?>
                                    <input name="number" type="hidden" id="number" />
                                    <input name="codtemp" type="hidden" id="codtemp" value="<?php echo $codtemp ?>" />
                                    <input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR" />
                                    <input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR" />
                                <?php } else { ?>
                                    <a href="ingresos_varios3.php?cod=<?php echo $codpro ?>&valform=1&codtempfiltro=<?php echo $codtemp ?>"><img src="../../../images/edit_16.png" width="16" height="16" border="0" /></a>
                                    <a href="ingresos_varios4.php?cod=<?php echo $codtemp ?>" target="comp_principal"><img src="../../../images/del_16.png" width="16" height="16" border="0" /></a>
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
            <br><br><br><br><br>
            <center>  <h1 class='Estilo2'> <?php echo TEXT_MENSAJE_DE_LISTAS_MOVIMIENTOS; ?></h1> </center>
        <?php }
        ?>
        </form>
</body>

</html>