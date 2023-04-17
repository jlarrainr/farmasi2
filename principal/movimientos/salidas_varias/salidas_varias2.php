<?php
include('../../session_user.php');
$invnum = $_SESSION['transferencia_sal_val'];
$movlotecargado = isset($_REQUEST['movlotecargado']) ? ($_REQUEST['movlotecargado']) : "";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>

    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once '../../../textos_generales.php';
    require_once('../../../titulo_sist.php');
    require_once("functions.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../funciones/salida_varias.php");    //COLORES DE LOS BOTONES
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
    ?>
    <script>
        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                document.form1.method = "post";
                document.form1.submit();
            }
        }


        var statSend = false;
        var nav4 = window.Event ? true : false;

        function ent(evt, valor) {
            var valor;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (!statSend) {
                    var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
                    var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
                    var v3 = parseFloat(document.form1.stock.value); //CANTIDAD ACTUAL POR LOCAL
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    var costre = parseFloat(document.form1.costre.value); //costre

                    if ((v1 == 0) || (v1 == '')) {
                        alert('Debe ingresar un valor diferente a 0');
                        document.form1.text1.focus();
                        return;
                    }
                    var f = document.form1;
                    if (f.text1.value == "") {
                        alert("Debe Ingresar una cantidad");
                        f.text1.focus();
                        return;
                    }
                    if (f.text2.value == "") {
                        alert("Debe Ingresar el Precio");
                        f.text2.focus();
                        return;
                    }

                    //var total;
                    var valor = isNaN(v1);
                    if (valor == true) {
                        var porcion = document.form1.text1.value.substring(1);

                        var v3 = parseFloat(document.form1.stock.value);
                        var fact = parseFloat(porcion / factor);
                        var total2 = costre / factor;
                        total = total2;
                        subtotal = total * porcion;
                        document.form1.number.value = 1; ////avisa que no es numero

                        if ((porcion) > v3) {
                            alert("La cantidad Ingresada excede al Stock Actual del Producto");
                            f.text1.focus();
                            return;
                        }
                    } else {

                        total = costre;
                        subtotal = total * v1;
                        document.form1.number.value = 0; ////avisa que es numero

                        var porcion = parseFloat(v1 * factor);
                        if (porcion > v3) {
                            alert("La cantidad Ingresada excede al Stock Actual del Producto");
                            f.text1.focus();
                            return;
                        }
                    }
                    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
                    subtotal = Math.round(subtotal * Math.pow(10, 2)) / Math.pow(10, 2);

                    document.form1.text3.value = total;
                    document.form1.subtotal2.value = subtotal;

                    f.method = "post";
                    f.action = "transferencia2_sal_reg.php";
                    f.target = "comp_principal";
                    f.submit();

                    statSend = true;
                    return true;
                } else {
                    alert("El proceso esta siendo cargado espere un momento...");
                    return false;
                }

            }
            if (valor == 1) {
                // valor = 1 // para enteros
                return (key == 70 || key == 102 || (key <= 13 || (key >= 48 && key <= 57)));

            } else if (valor == 4) {
                // valor = 1 // para enteros
                return (key <= 13 || key <= 46 || (key >= 48 && key <= 57));
            }
        }
        var statSend = false;
        var nav4 = window.Event ? true : false;

        function ent1(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (!statSend) {
                    var f = document.form1;
                    if (f.text1.value == "") {
                        alert("Debe Ingresar una cantidad");
                        f.text1.focus();
                        return;
                    }
                    if (f.text2.value == "") {
                        alert("Debe Ingresar el Precio");
                        f.text2.focus();
                        return;
                    }
                    var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
                    var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
                    var v3 = parseFloat(document.form1.stock.value); //CANTIDAD ACTUAL POR LOCAL
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    if (v1 == "") {} else {
                        v1 = v1 * factor;
                        if (v1 > v3) {
                            alert("La cantidad Ingresada excede al Stock Actual del Producto");
                            f.text1.focus();
                            return;
                        }
                    }
                    var total;
                    var valor = isNaN(v1);
                    if (valor == true) {
                        var porcion = document.form1.text1.value.substring(1);
                        var v3 = parseFloat(document.form1.stock.value);
                        var fact = parseFloat(porcion / factor);
                        total = parseFloat(fact * v2);
                        document.form1.number.value = 1; ////avisa que no es numero


                        if ((porcion) > v3) {
                            alert("La cantidad Ingresada excede al Stock Actual del Producto");
                            f.text1.focus();
                            return;
                        }
                    } else {

                        var porcion = parseFloat(v1 * factor);
                        if ((porcion) > v3) {
                            alert("La cantidad Ingresada excede al Stock Actual del Producto");
                            f.text1.focus();
                            return;
                        }


                        total = parseFloat(v1 * v2);
                        document.form1.number.value = 0; ////avisa que es numero
                    }
                    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
                    f.method = "post";
                    f.action = "transferencia2_sal_reg.php";
                    f.target = "comp_principal";
                    f.submit();


                    statSend = true;
                    return true;
                } else {
                    alert("El proceso esta siendo cargado espere un momento...");
                    return false;
                }
            }
            return (key <= 13 || key == 46 || (key >= 48 && key <= 57));
        }

        function caj1() {
            document.form1.text1.focus();
        }

        function compras1(e) {
            tecla = e.keyCode;
            var f = document.form1;
            var a = f.carcount.value;
            var b = f.carcount1.value;
            if (tecla == 119) {
                if ((a == 0) || (b > 0)) {
                    alert('No se puede grabar este Documento');
                } else {
                    var f = document.form1;
                    if (f.date1.value == "") {
                        alert("Ingrese la Fecha del Documento");
                        f.date1.focus();
                        return;
                    }
                    if (f.n1.value == "") {
                        alert("Ingrese el Nro del Documento");
                        f.n1.focus();
                        return;
                    }
                    if (f.n2.value == "") {
                        alert("Ingrese el Nro del Documento");
                        f.n2.focus();
                        return;
                    }
                    if (f.fpago.value == "") {
                        alert("Ingrese el tipo de Pago");
                        f.fpago.focus();
                        return;
                    }
                    if (f.plazo.value == "") {
                        alert("Ingrese el plazo");
                        f.plazo.focus();
                        return;
                    }
                    if (f.date2.value == "") {
                        alert("Ingrese la Fecha de Vencimiento");
                        f.date2.focus();
                        return;
                    }
                    if ((f.mont5.value == "") || (f.mont5.value == "0.00")) {
                        alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                        f.mont5.focus();
                        return;
                    }
                    ventana = confirm("Desea Grabar estos datos");
                    if (ventana) {
                        f.method = "POST";
                        f.target = "_top";
                        f.action = "compras1_reg.php";
                        f.submit();
                    }
                }
            }

        }
    </script>
    <style>
        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
            font-weight: bold;
        }

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
            background: #d7d7d7
        }

        .Estilo2 {

            color: #ff4b0d;
            font-size: 20px;
            /* font-weight: bold; */
        }

        #country {
            width: 75%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: white;
            background-image: url('../compras/buscador.png');
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 5px 15px 3px 35px;
        }
    </style>
</head>
<?php
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
$val = $_REQUEST['val'];
if ($val == 1) {
    $producto = $_REQUEST['country_ID'];
    if ($producto <> "") {
        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$producto' and invnum = '$invnum'";
        //$sql1="SELECT codtemp FROM tempmovmov inner join producto on tempmovmov.codpro = producto.codpro where codmar = '$producto' and invnum = '$invnum'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            $search = 0;
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
$valform = $_REQUEST['valform'];
$cprod = $_REQUEST['cprod'];
?>

<body onload="<?php if ($valform == 1) { ?> caj1();<?php
                                                } else {
                                                    if ($search == 1) {
                                                    ?>links()<?php } else { ?>sf()<?php
                                                                                }
                                                                            }
                                                                                    ?>" onkeyup="compras1(event)">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <table width="100%" border="0">
            <tr>
                <!-- <td width="75" class="LETRA">DESCRIPCION</td>-->
                 <td width="614">
                    <input name="country" type="text" id="country" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event), this.value = this.value.toUpperCase();" placeholder="<?php echo TEXT_PLACEHOLDER_BUSCAR_PRODUCTO; ?>" value="" size="180" />
                    <input type="hidden" id="country_hidden" name="country_ID" />
                </td>
                <td width="192">
                    <input name="val" type="hidden" id="val" value="1" />
                    <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                    <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                </td>
                
            </tr>
        </table>
        <?php
        $val = $_REQUEST['val'];
        if ($val == 1) {
            $i = 0;
            $producto = $_REQUEST['country_ID'];
            $sql = "SELECT codpro,desprod,codmar,$tabla FROM producto where activo1 = '1' and codpro = '$producto' order by desprod";
            //$sql="SELECT codpro,desprod,codmar,$tabla FROM producto where codmar = '$producto' order by desprod";
            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
        ?>

                <table width="100%" id="customers" cellpadding="0" cellspacing="0">
                    <tr>

                        <th width="4%">CODPRO</th>
                        <th width="20%">DESCRIPCION</th>
                        <th width="10%">
                            <div align="center">MARCA</div>
                        </th>

                        <th width="5%">
                            <div align="center">FACTOR</div>
                        </th>
                        <th width="5%">
                            <div align="center">STOCK ACTUAL</div>
                        </th>
                        <?php if ($drogueria == 1) { ?>
                            <th width="5%">
                                <div align="center">STOCK VENCIDO</div>
                            </th>
                        <?php } ?>

                        <?php if ($drogueria == 1) { ?>
                            <th width="5%">
                                <div align="center">STOCK DISPONIBLE</div>
                            </th>
                        <?php } ?>


                        <th width="8%">
                            <div align="center">LOCAL EMISOR</div>
                        </th>



                        <th width="5%">
                            <div align="center">CANT</div>
                        </th>
                        <th width="5%">
                            <div align="center">COSTO</div>
                            </div>
                        </th>
                        <th width="5%">
                            <div align="center">SUB TOTAL</div>
                            </div>
                        </th>
                        <th width="3%">&nbsp;</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $i++;
                        $codpro = $row['codpro'];  //codgio
                        $desprod = $row['desprod'];
                        $codmar = $row['codmar'];
                        $cant_loc = $row[3];
                        $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $ltdgen = $row1['ltdgen'];
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
                                $cant_loc1 = $row1[5];
                                $codpro = $row1['codpro'];  ///COSTO PROMEDIO



                                if ($factor == 1) {
                                    $comparativa = 4;
                                } else {
                                    $comparativa = 1;
                                }

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
                                    $costre = $row1['costre'];
                                } elseif ($precios_por_local == 0) {

                                    $costpr = $row1['costpr'];  ///COSTO PROMEDIO
                                    $costre = $row1['costre'];
                                }

                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $costpr_p,$costre_p FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $costpr = $row_precio[0];  ///COSTO PROMEDIO
                                            $costre = $row_precio[1];
                                        }
                                    }
                                }
                            }
                        }
                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = '$ltdgen'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $marca = $row1['destab'];
                            }
                        }
                        $sql1 = "SELECT qtypro,qtyprf,prisal FROM tempmovmov where invnum = '$invnum' and codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $qtypro1 = $row1['qtypro'];
                                $qtyprf1 = $row1['qtyprf'];
                                $prisal1 = $row1['prisal'];
                            }
                        }
                        if ($qtyprf1 <> "") {
                            $cantidadMuestra = $qtyprf1;
                        } else {
                            $cantidadMuestra = $qtypro1;
                        }

                        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$codpro' and invnum = '$invnum'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $control = 1;
                        } else {
                            $control = 0;
                        }


                        $convert1 = $cant_loc / $factor;
                        $div1        = floor($convert1);
                        $UNI1 = ($cant_loc - ($div1 * $factor));
                    ?>
                        <tr>
                            <!--<td align="center"><?php echo $i ?></td>-->
                            <td align="center"><?php echo $codpro ?></td>
                            <td width="379">
                                <?php
                                if ($control == 0) {
                                    if ($cant_loc > 0) {
                                ?>
                                        <a id="l1" href="salidas_varias2.php?country_ID=<?php echo $producto ?>&valform=1&val=<?php echo $val ?>&cprod=<?php echo $codpro ?>"><?php echo $desprod ?>
                                        </a>
                                <?php
                                    } else {
                                        echo $desprod;
                                    }
                                } else {
                                    echo $desprod;
                                }
                                ?>
                            </td>
                            <td><?php echo $marca ?></td>
                            <td>
                                <div align="center"><?php echo $factor ?></div>
                            </td>
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


                            <!--CANTIDAD-->
                            <td>
                                <div align="center">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input name="text1" type="text" id="text1" size="5" onkeypress="return ent(event,<?php echo $comparativa ?>)" onKeyUp="precio();" value="<?php echo $cantidadMuestra; ?>" />
                                        <input name="number" type="hidden" id="number" />
                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                        <input name="costre" type="hidden" id="costre" value="<?php echo $costre ?>" />
                                        <input name="text3" type="hidden" id="text3" />
                                        <input name="subtotal2" type="hidden" id="subtotal2" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $codpro; ?>" />
                                        <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                        <input name="ok" type="hidden" id="ok" value="<?php echo $ok; ?>" />
                                    <?php
                                    } else {
                                        echo $cantidadMuestra;
                                    }
                                    ?>
                                </div>
                            </td>

                            <!--COSTRO-->
                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input class="LETRA2" name="text2" type="text" id="text2" value="<?php

                                                                                                            echo $costre;

                                                                                                            ?>" size="8" onKeyPress="return ent1(event)" disabled="disabled" />
                                    <?php
                                    } else {
                                        echo $costre;
                                    }
                                    ?>
                                </div>
                            </td>


                            <!--SUB TOTAL-->
                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input class="LETRA2" name="subtotal" type="text" id="subtotal" value="" size="8" onKeyPress="return ent1(event)" disabled="disabled" />
                                    <?php } ?>
                                </div>
                            </td>

                            <!--EDITAR-->
                            <td>
                                <div align="center"><?php
                                                    if ($control == 0) {
                                                        if ($cant_loc > 0) {
                                                    ?> <a href="transferencia2_sal_reg.php?cod=<?php echo $codpro ?>" target="comp_principal"><img src="../../../images/add.gif" width="14" height="15" border="0" /></a><?php
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                            ?><img src="../../../images/icon-16-checkin.png" width="16" height="16" border="0" /><?php } ?></div>
                            </td>
                        </tr>
                    <?php }
                    ?>
                </table>
            <?php
            } else {
            ?>
                <div align="center" style="padding: 10px">
                    <h3 class='Estilo2'><?php echo TEXT_MENSAJE_DE_LISTAS_MOVIMIENTOS; ?></h1>
                </div>
        <?php
            }
        }
        ?>
    </form>
</body>

</html>