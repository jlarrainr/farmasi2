<?php
include('../../session_user.php');
$invnum = $_SESSION['transferencia_sal_val'];

$val = $_REQUEST['val'];
$valform = $_REQUEST['valform'];
$cprod = $_REQUEST['cprod'];
$producto = $_REQUEST['country_ID'];
// $movlotecargado = $_REQUEST['movlotecargado'];

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
    require_once("../funciones/salida_varias_lote.php");    //COLORES DE LOS BOTONES
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
        function validar_grid() {
            var f = document.form1;
            var cod_producto = document.form1.cod_producto.value; //CANTIDAD
            alert(cod_producto);
            f.method = "POST";
            f.action = "salidas_varias_lote2.php?val=0";
            f.submit();
        }

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


        function caj1() {
            document.form1.text1.focus();
        }

        function validar_grid() {
            var f = document.form1;
            f.method = "POST";
            f.action = "salidas_varias_lote2.php";
            f.submit();
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

if ($val == 1) {


    if ($producto <> "") {
        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$producto' and invnum = '$invnum'";

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


// echo '$val = ' . $val . "<br>";
// echo '$producto = ' . $producto . "<br>";
// echo '$valform = ' . $valform . "<br>";
// echo '$cprod = ' . $cprod . "<br>";
// echo '$movlotecargado = ' . $movlotecargado . "<br>";

if ($valform == 1) {
    $colspan = '2';
    $accion = 'GRABAR / CANCELAR';
} else {
    $colspan = '1';
    $accion = 'MODIFICAR';
}

?>
<!-- sf -->

<body onload="<?php if ($valform == 1) { ?> caj1();<?php
                                                } else {
                                                    if ($search == 1) {
                                                    ?>links()<?php } else { ?>sf()<?php
                                                                                }
                                                                            }
                                                                                    ?>">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <table width="100%" border="0">
            <tr>

                <td width="614">
                    <input name="country" type="text" id="country" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event), this.value = this.value.toUpperCase();" placeholder="<?php echo TEXT_PLACEHOLDER_BUSCAR_PRODUCTO; ?>" value="" size="160" />
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
        if (($val == 1) && ($producto <> '')) {
            $i = 0;
            $producto = $_REQUEST['country_ID'];
            $sql_lote = "SELECT `idlote`, `codpro`, `numlote`, `vencim`, `stock`, `codloc` FROM `movlote` WHERE codpro='$producto' AND stock>0  and codloc='$codloc' ";
            $result_lote = mysqli_query($conexion, $sql_lote);
            if (mysqli_num_rows($result)) {
        ?>

                <table width="100%" id="customers" cellpadding="0" cellspacing="0">
                    <tr>

                        <th width="4%">ID LOTE</th>
                        <th width="4%">CODIGO PRODUCTO</th>
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
                        <th width="5%" colspan=" <?php echo $colspan; ?>">
                            <div align="center"> <?php echo $accion; ?> </div>
                        </th>
                    </tr>
                    <?php
                    while ($row_lote = mysqli_fetch_array($result_lote)) {
                        $i++;
                        $idlote_lote = $row_lote['idlote'];  //codgio
                        $codpro = $row_lote['codpro'];  //codgio
                        $numlote_lote = $row_lote['numlote'];  //codgio
                        $vencim_lote = $row_lote['vencim'];  //codgio
                        $cant_loc = $row_lote['stock'];  //codgio
                        $codloc_lote = $row_lote['codloc'];  //codgio

                        $sql1 = "SELECT desprod,codmar,factor,costpr,stopro,costre,codpro FROM producto where codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $desprod = $row1['desprod'];
                                $codmar = $row1['codmar'];
                                $factor = $row1['factor'];
                                $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                                $codpro = $row1['codpro'];  ///COSTO PROMEDIO

                                if ($factor == 1) {
                                    $comparativa = 4;
                                } else {
                                    $comparativa = 1;
                                }


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

                        $sql1 = "SELECT destab FROM titultabladet where codtab = '$codmar' and tiptab = 'M'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $marca = $row1['destab'];
                            }
                        }

                        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$codpro' and idlote_salida = '$idlote_lote'  and invnum = '$invnum' ";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $control = 1;
                        } else {
                            $control = 0;
                        }

                    ?>
                        <tr>
                            <td align="center"><?php echo $idlote_lote ?></td>
                            <td align="center"><?php echo $codpro ?></td>
                            <td>
                                <?php
                                if ($control == 0) {
                                    if ($cant_loc > 0) {
                                ?>
                                        <a id="l1" href="salidas_varias_lote2.php?country_ID=<?php echo $producto ?>&valform=1&val=<?php echo $val ?>&cprod=<?php echo $idlote_lote ?>"><?php echo $desprod ?>
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
                                <div align="center"><?php echo  $numlote_lote; ?></div>
                            </td>
                            <td bgcolor="#eaa35f">
                                <div align="center"><?php echo  $vencim_lote; ?></div>
                            </td>
                            <td bgcolor="#a2ea5f">
                                <div align="center"><?php echo  stockcaja($cant_loc, $factor); ?></div>
                            </td>

                            <!--CANTIDAD-->
                            <td>
                                <div align="center">
                                    <?php if (($valform == 1) && ($cprod == $idlote_lote)) { ?>
                                        <input name="text1" type="text" id="text1" size="5" onkeypress="return ent(event,<?php echo $comparativa ?>)" onKeyUp="precio();" value="<?php echo $cantidadMuestra; ?>" />
                                        <input name="number" type="hidden" id="number" />
                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                        <input name="costre" type="hidden" id="costre" value="<?php echo $costre ?>" />
                                        <input name="text3" type="hidden" id="text3" />
                                        <input name="subtotal2" type="hidden" id="subtotal2" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $codpro; ?>" />
                                        <input name="idlote_lote" type="hidden" id="idlote_lote" value="<?php echo $idlote_lote; ?>" />
                                        <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                        <input name="ok" type="hidden" id="ok" value="<?php echo $ok; ?>" />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                            <!--COSTRO-->
                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $idlote_lote)) { ?>
                                        <input class="LETRA2" name="text2" type="text" id="text2" value="<?php echo $costre; ?>" size="8" readonly />
                                    <?php
                                    }
                                    ?>
                                </div>
                            </td>
                            <!--SUB TOTAL-->
                            <td>
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $idlote_lote)) { ?>
                                        <input class="LETRA2" name="subtotal" type="text" id="subtotal" value="" size="8" readonly />
                                    <?php } ?>
                                </div>
                            </td>


                            <?php if (($valform == 1) && ($cprod == $idlote_lote)) {
                            ?>
                                <td>
                                    <div align="center">


                                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />



                                    </div>
                                </td>
                                <td>
                                    <div align="center">
                                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                                    </div>
                                </td>
                                <?php
                            } else {
                                if ($control == 0) {
                                ?>
                                    <td colspan=" <?php echo $colspan; ?>">
                                        <div align="center">
                                            <a href="salidas_varias_lote2.php?country_ID=<?php echo $producto ?>&valform=1&val=<?php echo $val ?>&cprod=<?php echo $idlote_lote ?>">
                                                <img src="../../../images/add1.gif" width="14" height="15" border="0" />
                                            </a>
                                        </div>
                                    </td>
                            <?php  }
                            }
                            ?>
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