<?php include('../../session_user.php');

$invnum = $_SESSION['compras'];
$ckigv = $_REQUEST['ckigv'];
$busca_prov = $_REQUEST['busca_prov'];

$costo     = isset($_REQUEST['costo']) ? ($_REQUEST['costo']) : "";
$pigv     = isset($_REQUEST['pigv']) ? ($_REQUEST['pigv']) : "";
$desc1     = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
$desc2     = isset($_REQUEST['desc2']) ? ($_REQUEST['desc2']) : "";
$desc3     = isset($_REQUEST['desc3']) ? ($_REQUEST['desc3']) : "";
$text1     = isset($_REQUEST['text1']) ? ($_REQUEST['text1']) : "";

// $costo      = $_REQUEST['costo']; //text2
// $pigv      = $_REQUEST['pigv']; //pigv
// $desc1      = $_REQUEST['desc1']; //text3
// $desc2      = $_REQUEST['desc2']; //text4
// $desc3      = $_REQUEST['desc3']; //text5
// $text1      = $_REQUEST['text1']; //text1

// $text1 = isset($_REQUEST['text1']) ? ($_REQUEST['text1']) : "";
// $costo = isset($_REQUEST['text2']) ? ($_REQUEST['text2']) : "";
// $desc1 = isset($_REQUEST['text3']) ? ($_REQUEST['text3']) : "";
// $desc2 = isset($_REQUEST['text4']) ? ($_REQUEST['text4']) : "";
// $desc3 = isset($_REQUEST['text5']) ? ($_REQUEST['text5']) : "";
// $pigv = isset($_REQUEST['pigv']) ? ($_REQUEST['pigv']) : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>



    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <?php
    require_once 'funciones_compras.php';
    ?>


    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
    require_once("../funciones/compras.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../../local.php"); //LOCAL DEL USUARIO

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
    //echo $sql;
    $sql1 = "SELECT porcent FROM datagen";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $porcent = $row1['porcent'];
        }
    }

    $sql1 = "SELECT utldmin FROM datagen_det";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $utldmin = $row1['utldmin'];
        }
    }

    $sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nomloc = $row['nomloc'];
        }
    }

    $val = (isset($_REQUEST['val']) ? $_REQUEST['val'] : 0);

    // $val = $_REQUEST['val'];
    $ok = $_REQUEST['ok'];
    ///////CUENTA CUANTOS REGISTROS LLEVA LA COMPRA
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count = $row[0]; ////CANTIDAD DE REGISTROS EN EL GRID
        }
    } else {
        $count = 0; ////CUANDO NO HAY NADA EN EL GRID
    }
    ///////CUENTA CUANTOS REGISTROS NO SE HAN LLENADO
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro = '0' and qtyprf = ''";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count1 = $row[0]; ////CUANDO HAY UN GRID PERO CON DATOS VACIOS
        }
    } else {
        $count1 = 0; ////CUANDO TODOS LOS DATOS ESTAN CARGADOS EN EL GRID
    }
    if ($val == 1) {
        $producto = $_REQUEST['country_ID'];
        // $producto = (isset($_REQUEST['country_ID']) ? $_REQUEST['country_ID'] : 0);

        if ($producto <> "") {
            $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$producto' and invnum = '$invnum'";
            $result1 = mysqli_query($conexion, $sql1);
            if (mysqli_num_rows($result1)) {
                $search = 1;
            } else {
                $search = 1;
            }
        } else {
            $search = 0;
        }
    } else {
        $search = 0;
    }
    require_once('../tabla_local.php');
    $valform =(isset($_REQUEST['valform']) ? $_REQUEST['valform'] : 0);
    // $valform = $_REQUEST['valform'];


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $sqlP = "SELECT porcent,Preciovtacostopro FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $porcent = $row['porcent'];
            $tipocosto = $row['Preciovtacostopro'];
        }
    }
    $sql1 = "SELECT lotec,lote,icbper FROM producto where codpro = '$producto'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $lotecfiltro = $row1['lotec']; ///para buscar el lote 
            $lotefiltro  = $row1['lote']; ///para buscar el lote 
            $icbper      = $row1['icbper']; ///para buscar el lote 
        }
    }



    if ($lotecfiltro == 1) {
        $lotenombre = "lotec";
    } else {
        $lotenombre = "lote";
    }
    $sql1 = "SELECT $lotenombre FROM producto where codpro = '$producto'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $lote = $row1[0]; ///lote de producto 
        }
    }
    $sql = "SELECT desprod,factor,margene,prevta,preuni,tcosto,tmargene,tprevta,tpreuni,igv,costpr,tcostpr,costre, s000+s001+s002+s003+s004+s005+s006+s007+s008+s009+s010+s011+s012+s013+s014+s015 as stoctal FROM producto where codpro = '$producto'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $desprod = $row['desprod'];
            $factor = $row['factor'];
        }
    }

    $sql1 = "SELECT codtemp FROM tempmovmov where  invnum = '$invnum'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        $controlmensaje = 1;
    } else {
        $controlmensaje = 0;
    }
    ?>

    <style>
        #country {
            width: 90%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: white;
            background-image: url('buscador.png');
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 5px 15px 3px 35px;
        }

        #pasos {
            font-size: 12px;
            color: red;
            font-family: courier, arial, helvética;
        }
    </style>
    <?php
    if ($valform == 1) {
        $onload = "caj1()";
    } else {
        if ($search == 1) {
            $onload = "links()";
        } else {
            $onload = "sssf()";
        }
    }
    ?>
</head>

<body onkeyup="compras2(event)" onload="<?php echo $onload; ?>">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <input type="hidden" id="busca_prov" name="busca_prov" value="<?php echo $busca_prov; ?>" />
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <!--<td width="90">DESCRIPCION</td>-->
                <td width="50%">
                    <input tabindex="11" name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event), this.value = this.value.toUpperCase();" value="" size="120" placeholder="Buscar Producto....." />
                    <input type="hidden" id="country_hidden" name="country_ID" />
                    <input type="hidden" id="ckigv" name="ckigv" value="<?php echo $ckigv; ?>" />
                    <input type="hidden" id="ok" name="ok" value="<?php echo $ok ?>" />
                    <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                    <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                </td>
                <td width="50%">
                    <input name="val" type="hidden" id="val" value="1" />

                    <div id="pasos"> </div>

                </td>
            </tr>
        </table>
        <?php

$val = (isset($_REQUEST['val']) ? $_REQUEST['val'] : 0);
        // $val = $_REQUEST['val'];


        if ($val == 1) {

            $producto = $_REQUEST['country_ID'];
            // echo '$producto; = ' . $producto . "<br>";
            if ($producto <> "") {
                $sqlCompra = "SELECT codpro,desprod,codmar,stopro,factor,$tabla,igv,pcostouni,costod,registrosanitario,digemid,icbper FROM producto where activo1 = '1' and codpro = '$producto'  order by desprod";
                // echo $sqlCompra . "<br>";
                $resultCompra = mysqli_query($conexion, $sqlCompra);
                // echo $resultCompra . "<br>";
                if (mysqli_num_rows($resultCompra)) {
        ?>

                    <table class="celda2" border="0" width="100%">

                        <tr>
                            <th width="1%" bgcolor="#0069ad" class="titulos_movimientos">COD. PRO</th>
                            <th width="11%" bgcolor="#0069ad" class="titulos_movimientos">DESCRIPCION</th>
                            <th width="4%" bgcolor="#0069ad" class="titulos_movimientos">
                                <div align="center">LAB</div>
                            </th>
                            <th bgcolor="#0069ad" class="titulos_movimientos">
                                <div align="center">FACT</div>
                            </th>
                            <th width="4%" bgcolor="#0069ad" class="titulos_movimientos">
                                <div align="right">STOCK TOTAL</div>
                            </th>
                            <th width="3%" bgcolor="#0069ad" class="titulos_movimientos">
                                <div align="right">STOCK UND </div>
                            </th>
                            <th width="3%" bgcolor="#0069ad" class="titulos_movimientos">
                                <div align="right"><?php if ($tipocosto == 1) { ?> COSTO PROMEDIO <?php } else { ?> COSTO REAL <?php } ?> </div>
                            </th>
                            <th width="3%" bgcolor="#0069ad" class="titulos_movimientos" title="Solo marcar esta casilla si la compra de este producto tiene alguna bonificación a costo cero, luego de cargar a la lista en la parte inferior va parpadear un check color rojo, darle clic para colocar la cantidad y el producto bonificado.">
                                <div align="center">BONI</div>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title="Colocar la cantidad a ingresar en cajas o unidades (ejemplo: para una caja: 1,para 50 unidades: f50 ), si la cantidad a ingresar es una caja mas fracciones colocar el total en unidades. ">
                                <div align="center">CANT</div>
                            </th>
                            <!--<th width="33" bgcolor="#50ADEA" class="titulos_movimientos"><div align="center">BONIF</div></th>-->
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title="Colocar el costo de la caja o entero, si ingresa fracciones colocar el costo de cada fraccion(unidad)">
                                <div align="right"> <b id="costo">COSTO CAJA </b><?php if ($ckigv !== "1") { ?> (-IGV)<?php } ?> </div>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title="Rellenar solo si en la factura aparece algun descuento, los descuentos son asignados en %, ejemplo: en la factura de compra figura 10%, colocar el numero 10 indicara que tiene un descuento del 10% sobre el costo de compra">
                                <div align="right">DESC1</div>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <div align="right">DESC2</div>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <div align="right">DESC3</div>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <div align="right"><b id="costo2">COSTO CAJA </b> (+IGV)</div>
                            </th>
                            <th width="4%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <div align="right">SUB TOT</div>
                            </th>
                            <th width="4%" bgcolor="#0069ad" class="titulos_movimientos" title="Este es el precio de venta actual de la caja o entero">P.V.ACT &nbsp;&nbsp;X CAJA</th>
                            <?php
                            if ($factor > 1) {
                            ?>
                                <th width="3%" bgcolor="#0069ad" class="titulos_movimientos" title="Este es el precio de venta actual de la unidad o fraccion   ">&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; X UND </th>
                            <?php
                            }
                            ?>
                            <th width="4%" bgcolor="#50ADEA" class="titulos_movimientos" title="Aquí se coloca el nuevo precio de venta de la caja, se calculara automaticamente el margen de utilidad en las opciones anteriores. ">P.VENTA &nbsp;&nbsp;X CAJA</th>
                            <?php if ($factor > 1) { ?>
                                <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title="Aquí se coloca el nuevo precio de venta de la unidad o fraccion, se calculara automaticamente el margen de utilidad en las opciones anteriores. ">: &nbsp;X UND</th>
                            <?php } ?>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title=" Si desea colocar un precio de venta en concreto saltar estas dos opciones, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, Colocar el margen de utilidad que se desea ganar en relacion al costo de la caja, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la caja.">% &nbsp;X CAJA</th>
                            <?php if ($factor > 1) { ?>
                                <th width="4%" bgcolor="#50ADEA" class="titulos_movimientos" title=" Si desea colocar un precio de venta en concreto saltar esta opcion, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, Colocar el margen de utilidad que se desea ganar en relacion al costo de la unidad, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la unidad.">% &nbsp;X UND</th>
                            <?php } ?>
                            <?php if ($lote == 1) { ?>
                                <th width="7%" bgcolor="#1c9aee" class="titulos_movimientos" title="Aquí se coloca el número de lote del producto.">N LOTE</th>
                            <?php } ?>
                            <?php if ($lote == 1) { ?>
                                <th width="18%" bgcolor="#1c9aee" class="titulos_movimientos" title="Aquí se coloca la fecha de vencimiento del producto, en la primera casilla el mes y en la segunda el año. ">
                                    <center>VENC.</center>
                                </th>
                            <?php } ?>
                            <?php if ($factor > 1) { ?>
                                <th width="3%" bgcolor="#0069ad" class="titulos_movimientos" title="Colocar el n�mero del total de unidades que contiene un blister">
                                    <center>UND x Blis.</center>
                                </th>
                            <?php } ?>
                            <?php if ($factor > 1) { ?><th width="3%" bgcolor="#0069ad" class="titulos_movimientos" title="No confundir, no es el precio total del blister, aquí se coloca el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. ">
                                    <center>P.UND X Blis.</center>
                                </th><?php } ?>
                            <!--<th width="3%" bgcolor="#50ADEA" class="titulos_movimientos" title="Colocar la cantidad del stock minimo solo en cajas o enteros.">
                                <center>STOCK MIN</center>
                            </th>-->
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <center>R. SANITARIO</center>
                            </th>
                            <th width="3%" bgcolor="#50ADEA" class="titulos_movimientos">
                                <center>DIGEMID</center>
                            </th>
                        </tr>
                        <?php
                        if (($val == 1) && ($valform <> 1) && ($controlmensaje == 0)) {
                            if (($ckigv == 1)) {
                                echo '<script type="text/javascript">
                                                alert("ESTA INCLUYENDO IGV A LA COMPRA");
                                            </script>';
                            } else {
                                echo '<script type="text/javascript">
                                                alert(" NO ESTA INCLUYENDO IGV A LA COMPRA");
                                            </script>';
                            }
                        }
                        while ($row = mysqli_fetch_array($resultCompra)) {
                            // echo 'entrooo ' . "<br>";
                            $codpro         = $row['codpro'];  //codgio
                            $desprod        = $row['desprod'];
                            $codmar         = $row['codmar'];
                            $stopro         = $row['stopro'];
                            $factor         = $row['factor'];
                            $igv            = $row['igv'];
                            $cant_loc       = $row[5];
                            $rsanitario     = $row['registrosanitario'];
                            $digemid        = $row['digemid'];
                            $icbper         = $row['icbper'];
                            // echo $codpro . "<br>";
                            // echo substr($desprod, 0, 45) . "<br>";
                            require 'operaciones_compras.php';


                        ?>
                            <tr height="20">

                                <td width="1%" bgcolor="#fce60f "><?php echo $codpro ?></td>
                                <!--DESCRIPCION-->
                                <td width="11%" bgcolor="#fce60f ">
                                    <?php if ($control == 0) { ?>
                                        <a id="l1" href="compras2.php?country_ID=<?php echo $producto ?>&ok=<?php echo $ok ?>&val=1&valform=1&cprod=<?php echo $codpro ?>&ckigv=<?php echo $ckigv; ?>&busca_prov=<?php echo $busca_prov; ?>"><?php echo substr($desprod, 0, 45); ?></a>
                                    <?php
                                    } else {
                                        echo substr($desprod, 0, 45);
                                    }
                                    ?>
                                </td>
                                <?php
                                $cprod = $_REQUEST['cprod'];
                                ?>
                                <!--MARCA-->
                                <td width="10%" bgcolor="#fce60f "><?php echo substr($marca, 0, 25) ?></td>

                                <td width="4%" align="center" bgcolor="#fce60f "><?php echo $factor; ?></td>
                                <!--MI LOCAL-->
                                <td width="3%" bgcolor="#fce60f ">
                                    <div align="right" bgcolor="#fce60f"><?php echo $div ?> F <?php echo $tot ?></div>
                                </td>

                                <td width="3%" bgcolor="#fce60f ">
                                    <div align="right"><?php echo $stopro ?></div>
                                </td>

                                <td width="3%" bgcolor="#fce60f ">
                                    <div align="right"><?php echo $costpr ?></div>
                                </td>
                                <!--BONIF-->
                                <td width="3%" bgcolor="#fce60f " title="Solo marcar esta casilla si la compra de este producto tiene alguna bonificación a costo cero, luego de cargar a la lista en la parte inferior va parpadear un check color rojo, darle clic para colocar la cantidad y el producto bonificado.">
                                    <div align="center">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="bonifi" type="checkbox" id="bonifi" value="1" />
                                        <?php } ?>
                                    </div>
                                </td>

                                <!--CANT-->
                                <td width="3%" bgcolor="#FFFFCC" title="Colocar la cantidad a ingresar en cajas o unidades (ejemplo: para una caja: 1,para 50 unidades: f50 ), si la cantidad a ingresar es una caja mas fracciones colocar el total en unidades.">
                                    <!--AQUI-->
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="text1" type="text" id="text1" size="2" onkeypress="return evento_compra(event,<?php echo $comparativa ?>)" value="" onKeyUp="precio();" onfocus="mensaje(1)" onchange="recomendacion();" />
                                            <input name="number" type="hidden" id="number" value="" />
                                            <input type="hidden" name="factor" id="factor" value="<?php echo $factor; ?>" />
                                            <input type="hidden" name="icbper" id="icbper" value="<?php echo $icbper; ?>" />

                                            <input type="hidden" name="stockpro" value="<?php echo $stopro; ?>" />
                                            <input type="hidden" name="lotee" id="lotee" value="<?php echo $lote; ?>" />
                                            <input type="hidden" name="years" id="years" value="<?php echo $ycar; ?>" />
                                            <input type="hidden" name="mes" id="mes" value="<?php echo $m; ?>" />
                                            <input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc ?>" />
                                            <input name="cr" type="hidden" id="cr" value="<?php echo $i ?>" />
                                            <!--<input name="minim" type="hidden" id="minim" size="4" value="<?php echo $stock_min ?>" />-->
                                            <input type="hidden" name="porcentaje" value="<?php
                                                                                            if ($igv == 1) {
                                                                                                echo $porcent;
                                                                                            }
                                                                                            ?>" />

                                            <input type="hidden" name="prevta" id="prevta" value="<?php echo $prevta; ?>" />

                                            <input type="hidden" name="costpr" id="costpr" value="<?php
                                                                                                    if ($tipocosto == 1) {
                                                                                                        echo $costpr;
                                                                                                    } else {
                                                                                                        echo $costpr;
                                                                                                    }
                                                                                                    ?>" />
                                            <input type="hidden" name="utldmin" id="utldmin" value="<?php echo $utldmin; ?>" />

                                            <input name="PrecioPrint" type="hidden" id="PrecioPrint" value="<?php echo $PrecioPrint ?>" />
                                            <!--costo de caja-->
                                            <input name="tpreblister" type="hidden" id="tpreblister" value="<?php echo $preblister ?>" />
                                            <input name="tprevta" type="hidden" id="tprevta" value="<?php echo $tprevta ?>" />
                                            <!--precio de venta de caja-->
                                            <input name="preunin" type="hidden" id="preunin" value="<?php
                                                                                                    if ($tpreuni <> 0) {
                                                                                                        echo $tpreuni;
                                                                                                    } else {
                                                                                                        echo $preuni;
                                                                                                    }
                                                                                                    ?>" />
                                            <!--precio de unidad-->

                                            <input name="cod" type="hidden" id="cod" value="<?php echo $codpro; ?>" />
                                            <input name="ok" type="hidden" id="ok" value="<?php echo $ok; ?>" />
                                        <?php
                                        } else {

                                            // if ($qtyprf1 <> "") {
                                            //     // echo $qtyprf1;
                                            // } else {
                                            //     //echo $qtypro1;
                                            // }
                                        }
                                        ?>
                                    </div>
                                </td>



                                <!--COSTO CAJA-->
                                <td width="2%" bgcolor="#FFFFCC" title="Colocar el costo de la caja o entero, si ingresa fracciones colocar el costo de cada fraccion(unidad)">
                                    <!--AQUI-->
                                    <div align="left">
                                        <?php
                                        if (($valform == 1) && ($cprod == $codpro)) {
                                        ?>
                                            <input name="text2" type="text" id="text2" value="<?php echo $PrecioPrint ?>" size="4" onkeypress="return evento_compra(event,2)" onKeyUp="precio();" onfocus="mensaje(2)" />
                                            <input name="costoCaja" type="hidden" id="costoCaja" value="<?php echo $PrecioPrint ?>" />

                                        <?php
                                        } else {
                                            echo $PrecioPrint;
                                        }
                                        ?>

                                    </div>

                                </td>
                                <!---DESC1-->
                                <td width="2%" bgcolor="#FFFFCC" title="Rellenar solo si en la factura aparece algun descuento, los descuentos son asignados en %, ejemplo: en la factura de compra figura 10%, colocar el numero 10 indicara que tiene un descuento del 10% sobre el costo de compra">
                                    <!--AQUI-->
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="text3" type="text" class="input_text1" id="text3" value="<?php echo $desc1 ?>" size="4" maxlength="5" onkeypress="return evento_compra(event,2)" onkeyup="precio();" onfocus="mensaje(3)" />
                                        <?php
                                        } else {
                                            echo $desc1;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <!---DESC2-->
                                <td width="2%" bgcolor="#FFFFCC ">
                                    <!--AQUI-->
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="text4" type="text" class="input_text1" id="text4" value="<?php echo $desc2 ?>" size="4" maxlength="5" onkeypress="return evento_compra(event,2)" onkeyup="precio();" onfocus="mensaje(4)" />
                                        <?php
                                        } else {
                                            echo $desc2;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <!---DESC3-->
                                <td width="2%" bgcolor="#FFFFCC ">
                                    <!--AQUI-->
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="text5" type="text" class="input_text1" id="text5" value="<?php echo $desc3 ?>" size="4" maxlength="5" onkeypress="return evento_compra(event,2)" onkeyup="precio();" onfocus="mensaje(5)" />
                                        <?php
                                        } else {
                                            echo $desc3;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <!--COSTO DE CAJA+IGV-->
                                <td width="3%" align="left" bgcolor="#FFFFCC " title="v1 --text6">
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input align="left" name="text6" type="text" id="text6" size="5" class="pvta" value="<?php echo $pripro ?>" onclick="blur()" readonly />
                                        <?php
                                        } else {
                                            echo $pripro;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <!--SUB TOTAL-->
                                <td width="3%" align="left" bgcolor="#FFFFCC ">
                                    <div align="left">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input name="text7" type="text" id="text7" size="5" class="pvta" value="<?php echo $costre ?>" onclick="blur()" readonly />
                                        <?php
                                        } else {
                                            echo $costre;
                                        }
                                        ?>
                                    </div>
                                </td>

                                <!--venta actual por caja-->
                                <td width="3%" bgcolor="#fce60f ">
                                    <div align="LEFT" title="Este es el precio de venta actual de la caja o entero"><?php echo $prevta; ?></div>
                                </td>
                                <?php if ($factor > 1) { ?>
                                    <!--venta actual por unidad-->
                                    <td width="3%" bgcolor="#fce60f " title="Este es el precio de venta actual de la unidad o fraccion   ">
                                        <div align="LEFT"><?php echo $preuni; ?></div>
                                    </td>
                                <?php } ?>

                                <!--digito el precio por caja-->
                                <td width="4%" bgcolor="#FFFFCC " title="Aqui se coloca el nuevo precio de venta de la caja, se calculara automaticamente el margen de utilidad en las opciones anteriores ">


                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input name="price2" type="text" id="price2" value="<?php
                                                                                            if ($tprevta <> 0) {
                                                                                                echo $tprevta;
                                                                                            }
                                                                                            ?>" size="5" onkeypress="return evento_compra(event,2)" onKeyUp="precio1();" onfocus="mensaje(6)" />
                                    <?php
                                    } else {
                                        if ($tprevta <> 0) {
                                            echo $tprevta;
                                        }
                                    }
                                    ?>
                                </td>
                                <?php if ($factor > 1) { ?>

                                    <!--digito el precio por unidad-->
                                    <td width="4%" bgcolor="#FFFFCC " title="Aqui se coloca el nuevo precio de venta de la unidad o fraccion, se calculara automaticamente el margen de utilidad en las opciones anteriores ">


                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <input size="5" name="price3" type="text" id="price3" value="<?php
                                                                                                            if ($tpreuni <> 0) {
                                                                                                                echo $tpreuni;
                                                                                                            } else {
                                                                                                                echo $preuni;
                                                                                                            }
                                                                                                            ?>" onkeypress="return evento_compra(event,2)" onKeyUp="precioUni1();" onfocus="mensaje(7)" />
                                        <?php
                                        } else {
                                            if ($tpreuni <> 0) {
                                                echo $tpreuni;
                                            } else {
                                                echo $preuni;
                                            }
                                        }
                                        ?>
                                        <?php // echo "esto" . $lote2;    
                                        ?>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <input size="4%" type="hidden" name="price3" id="price3" value="<?php echo $tprevta; ?>" />
                                <?php
                                }
                                ?>
                                <!--pocentaje en caja-->
                                <td width="3%" bgcolor="#FFFFCC" title="SI DESEA COLOCAR UN PRECIO DE VENTA EN CONCRETO SALTAR ESTAS DOS OPCIONES, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, colocar el margen de utilidad que se desea ganar en relacion al costo de la caja, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la caja.  ">

                                    <?php
                                    if (($valform == 1) && ($cprod == $codpro)) {
                                    ?>
                                        <input name="price1" type="text" id="price1" value="<?php
                                                                                            if ($tmargene <> 0) {
                                                                                                echo $tmargene;
                                                                                            } else {
                                                                                                echo $margene;
                                                                                            }
                                                                                            ?>" size="5" onkeypress="return evento_compra(event,2)" onKeyUp="precioo();" onfocus="mensaje(8)" />
                                    <?php
                                    } else {
                                        if ($tmargene <> 0) {
                                            echo $tmargene;
                                        } else {
                                            echo $margene;
                                        }
                                    }
                                    ?>


                                </td>

                                <!--porcentaje en unidad-->
                                <?php if ($factor > 1) { ?>
                                    <td width="3%" bgcolor="#FFFFCC " title="SI DESEA COLOCAR UN PRECIO DE VENTA EN CONCRETO SALTAR ESTAS DOS OPCIONES, RELLENAR SOLO SI DESEA GENERAR UN PRECIO DE VENTA POR MARGENES DE UTILIDAD, colocar el margen de utilidad que se desea ganar en relacion al costo de la unidad, ejemplo: si coloco 10, estaria generando un precio de venta en el que ganaria el 10% del costo de la unidad.">


                                        <?php
                                        if (($valform == 1) && ($cprod == $codpro)) {
                                        ?>
                                            <input size="5" name="priceU" type="text" id="priceU" <?php if ($factor == 1) { ?>readonly<?php } ?> value="<?php
                                                                                                                                                        if ($tmargene2 <> 0) {
                                                                                                                                                            echo $margene2;
                                                                                                                                                        } else {
                                                                                                                                                            echo $margene2;
                                                                                                                                                        }
                                                                                                                                                        ?>" size="4" onkeypress="return evento_compra(event,2)" onKeyUp="precioUni();" onfocus="mensaje(9)" />
                                        <?php
                                        } else {
                                            if ($tmargene2 <> 0) {
                                                echo $margene2;
                                            } else {
                                                echo $margene2;
                                            }
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <input type="hidden" name="priceU" size="4" id="priceU" value="0" />

                                <?php
                                }
                                ?>

                                <?php if ($lote2 == 1) { ?>
                                    <td width="<?php if ($lote2 == 1) { ?> 6% <?php } else { ?>0<?php } ?>" bgcolor="#FFFFCC " title="Aquí se coloca el número de lote del producto.">
                                        <div align="left">
                                            <?php if ($lote2 == 1) { ?>
                                                <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                                    <input name="countryL" type="text" id="countryL" size="5" value="<?php echo $numlote ?>" onkeypress="return evento_compra(event,3)" onkeypress="this.value = this.value.toUpperCase();" onfocus="mensaje(10)" />
                                                    <input name="codpro" type="hidden" id="codpro" value="<?php echo $cod ?>" />
                                                    <input name="lote" type="hidden" id="lote" value="<?php echo $lote ?>" />
                                                    <input type="hidden" id="country_hidden" name="country_ID" value="" />
                                                <?php
                                                } else {
                                                    echo $numlote;
                                                }
                                                ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>

                                <?php if ($lote2 == 1) { ?>
                                    <td bgcolor="#FFFFCC " title="Aquí se coloca la fecha de vencimiento del producto, en la primera casilla el mes y en la segunda el año. ">
                                        <div align="center">
                                            <?php if ($lote2 == 1) { ?>
                                                <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                                    <input name="mesL" type="text" id="mesL" size="4" maxlength="2" placeholder="MM" value="<?php echo $m ?>" onkeypress="return evento_compra(event,1)" onfocus="mensaje(11)" />

                                                    /
                                                    <input name="yearsL" type="text" id="yearsL" size="2" maxlength="4" placeholder="AAAA" value="<?php echo $ycar ?>" onkeypress="return evento_compra(event,1)" onfocus="mensaje(12)" />
                                                    <!--            <input name="save" type="button" id="save" value="Grabar" onclick="grabar()" class="grabar" <?php if ($search == 0) { ?> disabled="disabled"<?php } ?>/>-->
                                                <?php
                                                }
                                                ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                <?php } ?>
                                <?php if ($factor > 1) { ?>
                                    <td width="2%" bgcolor="#FFFFCC " title="Colocar el n�mero del total de unidades que contiene un blister">
                                        <div align="right">
                                            <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                                <input name="blister" type="text" id="blister" size="4" value="<?php echo $blisters ?>" onKeyUp="return acceptNum()(event);" onkeypress="return evento_compra(event,1)" onfocus="mensaje(13)" />
                                                <input name="blis" type="hidden" id="blis" value="<?php echo $blisters ?>" />
                                            <?php
                                            } else {
                                                echo $blisters;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                <?php } ?>
                                <?php if ($factor > 1) { ?>
                                    <td width="2%" bgcolor="#FFFFCC " title="No confundir, no es el precio total del blister, aquí se coloca el precio de venta de cada unidad o tableta que se asignara cuando compren la cantidad indicada en el blister. ">
                                        <div align="right">
                                            <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                                <input name="p3" type="text" id="p3" size="4" value="<?php echo $preblister ?>" onkeypress="return evento_compra(event,2)" onKeyUp="return ent(event)" onfocus="mensaje(14)" />
                                            <?php
                                            } else {
                                                echo $preblister;
                                            }
                                            ?>
                                        </div>
                                    </td>
                                <?php } ?>
                                <!-- <td width="3%" bgcolor="#FFFFCC " title="Colocar la cantidad del stock minimo solo en cajas o enteros.">-->
                                <div align="right">

                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <?php ?>
                                        <!--<input name="minim" type="text" id="minim" size="4" value="<?php echo $stock_min ?>" onkeypress="return evento_compra(event,1)" onfocus="mensaje(15)" />-->
                                        <input name="codloc" type="hidden" id="codloc" value="<?php echo $codloc ?>" />
                                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
                                        <input name="country_ID" type="hidden" id="country_ID" value="<?php echo $marca ?>" />
                                        <input name="cr" type="hidden" id="cr" value="<?php echo $cr ?>" />
                                        <!--<input type="button" id="boton" onClick="validar_prod()" alt="GUARDAR"/>-->
                                        <!--<input type="button" id="boton1" onClick="validar_grid()" alt="ACEPTAR"/>-->

                                    <?php
                                    } else {
                                    ?>
                                        <div align="CENTER">
                                            <?php if (($blister <> "") || ($factor == 0)) { ?>
                                                <?php echo $div1 ?> F <?php echo $tot1 ?> U
                                            <?php } else { ?>
                                                <?php echo $div1 ?> F
                                            <?php } ?>
                                        </div>

                                        <!--echo $stock_min;-->
                                    <?php }
                                    ?>
                                </div>
                                </td>
                                <td width="3%" bgcolor="#FFFFCC ">
                                    <div align="right">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <?php ?>
                                            <input name="rsanitario" type="text" id="rsanitario" size="4" value="<?php echo $rsanitario ?>" onkeypress="return evento_compra(event,3)" onfocus="mensaje(16)" />
                                        <?php
                                        } else {
                                            echo $rsanitario;
                                        }
                                        ?>
                                    </div>
                                </td>
                                <td width="3%" bgcolor="#FFFFCC ">
                                    <div align="right">
                                        <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                            <?php ?>
                                            <input name="digemid" type="text" id="digemid" size="4" value="<?php echo $digemid ?>" onkeypress="return evento_compra(event,1)" onfocus="mensaje(17)" />
                                        <?php
                                        } else {
                                            echo $digemid;
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </table>
                <?php
                }
            } else {
                ?>
                <center><br><br><br><br><br><br>
                    <span class="text_combo_select">
                        <h1>NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</h1>
                    </span>
                </center>
        <?php
            }
        }
        ?>
    </form>
</body>

</html>