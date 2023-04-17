<?php
include('../../session_user.php');
$invnum = $_SESSION['transferencia_sal'];


$qtyprf1 = "";
$qtypro1 = "";
$prisal1 = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="../../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../../funciones/ajax-dynamic-list.js"></script>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php');
    require_once("../funciones/transferencia.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    // require_once('../tabla_local.php');
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

    ?>
    <script>
        function cerrar(e) {
            tecla = e.keyCode
            if (tecla == 27) {
                document.form1.method = "post";
                document.form1.submit();
            }
        }

        function precio() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.text1.value);
            var costre = parseFloat(document.form1.costre.value);
            var factor = parseFloat(document.form1.factor.value);

            // alert(v1);



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
                document.form1.sub.value = subtotal;


            } else {
                document.form1.text2.value = '';
                document.form1.sub.value = '';

            }
        }

        var statSend = false;
        var nav4 = window.Event ? true : false;

        function ent(evt, valor) {
            var valor;
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                if (!statSend) {
                    var f = document.form1;
                    var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
                    var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
                    var v3 = parseFloat(document.form1.stock.value); //CANTIDAD ACTUAL POR LOCAL
                    var factor = parseFloat(document.form1.factor.value); //FACTOR


                    if ((document.form1.text1.value == "")) {
                        alert('Debe ingresar un valor diferente a vacio ');
                        document.form1.text1.focus();
                        return;
                    }
                    if ((document.form1.text1.value == 0)) {
                        alert('Debe ingresar un valor diferente a 0');
                        document.form1.text1.focus();
                        return;
                    }

                    var total;
                    var valor = isNaN(v1);
                    if (valor == true) {
                        if (factor == 1) {
                            alert("El Producto tiene factor 1 solo cantidad entera");
                            document.form1.text1.focus();
                            return;
                        }
                        var porcion = document.form1.text1.value.substring(1);
                        var stockfiltro = porcion;
                        var multiplicador = v2;
                        total = parseFloat(porcion * multiplicador);
                        document.form1.number.value = 1; ////avisa que no es numero

                    } else {
                        var multiplicador = v2;
                        var stockfiltro = v1 * factor;
                        total = parseFloat(v1 * multiplicador);
                        document.form1.number.value = 0; ////avisa que es numero

                    }
                    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);



                    if (stockfiltro > v3) {
                        alert("La cantidad Ingresada excede al Stock Disponible del Producto");
                        document.form1.text1.focus();
                        return;

                    } else {
                        document.form1.text3.value = total;
                        f.method = "post";
                        f.action = "transferencia2_sal_reg.php";
                        f.target = "tranf_principal";
                        f.submit();
                    }



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
                    var v1 = parseFloat(document.form1.text1.value); //CANTIDAD
                    var v2 = parseFloat(document.form1.text2.value); //PRECIO PROMEDIO
                    var v3 = parseFloat(document.form1.stock.value); //CANTIDAD ACTUAL POR LOCAL
                    var factor = parseFloat(document.form1.factor.value); //FACTOR
                    if (v1 == "") {} else {
                        v1 = v1 * factor;
                        if (v1 > v3) {
                            alert("La cantidad Ingresada excede al Stock Disponible del Producto");
                            f.text1.focus();
                            return;
                        }
                    }
                    var total;
                    var valor = isNaN(v1);
                    if (valor == true) {
                        if (factor == 1) {
                            alert("El Producto tiene factor 1 solo cantidad entera");
                            document.form1.text1.focus();
                            return;
                        }
                        var porcion = document.form1.text1.value.substring(1);
                        var fact = parseFloat(v2 / factor);
                        total = parseFloat(fact * porcion);
                        document.form1.number.value = 1; ////avisa que no es numero
                    } else {
                        total = parseFloat(v1 * v2);
                        document.form1.number.value = 0; ////avisa que es numero
                    }
                    total = Math.round(total * Math.pow(10, 2)) / Math.pow(10, 2);
                    f.method = "post";
                    f.action = "transferencia2_sal_reg.php";
                    f.target = "tranf_principal";
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
    </script>

    <style>
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
    </style>
</head>
<?php
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
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
if ($val == 1) {
    $producto = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
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

$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
$cprod = isset($_REQUEST['cprod']) ? ($_REQUEST['cprod']) : "";
?>

<body onload="<?php if ($valform == 1) { ?> caj1();<?php
                                                } else {
                                                    if ($search == 1) {
                                                    ?>links()<?php } else { ?>sf()<?php
                                                                                }
                                                                            }
                                                                                    ?>">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)" method="post">
        <table width="910" border="0">
            <tr>

                <td width="614">
                    <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" placeholder="Escribe las primeras letras y seleccione un producto ..." value="" size="160" />
                    <input type="hidden" id="country_hidden" name="country_ID" />
                    <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                    <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                </td>
                <td width="192">
                    <input name="val" type="hidden" id="val" value="1" />
                </td>
            </tr>
        </table>
        <?php
        $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
        if ($val == 1) {
            $i = 0;
            $producto = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
            $sql = "SELECT codpro,desprod,codmar,$tabla,factor FROM producto where activo1 = '1' and codpro = '$producto' order by desprod";

            $result = mysqli_query($conexion, $sql);
            if (mysqli_num_rows($result)) {
        ?>

                <table id="customers" width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <!--<th width="32" >N&ordm;</th>-->
                        <th width="50" align="left">CODIGO</th>
                        <th width="250" align="left">DESCRIPCION</th>
                        <th width="200">
                            <div align="left">LABORATORIO /MARCA</div>
                        </th>
                        <th>
                            <div align="center">FACTOR</div>
                        </th>
                        <th width="76">
                            <div align="center">STOCK ACTUAL</div>
                        </th>

                        <?php if ($drogueria == 1) { ?>
                            <th width="76">
                                <div align="center">STOCK VENCIDO</div>
                            </th>
                        <?php } ?>



                        <?php if ($drogueria == 1) { ?>
                            <th width="76">
                                <div align="center">STOCK DISPONIBLE</div>
                            </th>
                        <?php } ?>

                        <th>
                            <div align="center">LOCAL EMISOR</div>
                        </th>

                        <?php if ($controleditable == 0) { ?>
                            <th>
                                <div align="center"><?php echo $COSTOCAJA; ?></div>
                            </th>
                        <?php } ?>

                        <?php if ($controleditable == 0) { ?>
                            <th>
                                <div align="center"><?php echo $COSTOUNIT; ?></div>
                            </th>
                        <?php } ?>

                        <th width="72">
                            <div align="center">CANT</div>
                        </th>

                        <?php if ($controleditable == 0) { ?>
                            <th width="68">
                                <div align="right"> <?php echo $COSTOPRODUCTO; ?> </div>
                            </th>
                        <?php } else { ?>
                            <th width="68">
                                <div align="right"> </div>
                            </th>
                        <?php }  ?>
                        <th width="68">
                            <div align="right">SUB TOTAL</div>
                            </div>
                        </th>
                        <th width="17">&nbsp;</th>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                        $i++;
                        $codpro = $row['codpro'];  //codgio
                        $desprod = $row['desprod'];
                        $codmar = $row['codmar'];
                        $cant_loc = $row[3];
                        $factor = $row['factor'];
                        $sql1 = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $ltdgen = $row1['ltdgen'];
                            }
                        }
                        $sql1 = "SELECT desprod,codmar,factor,costre,stopro,$tabla,mardis,codpro,costpr,prevta FROM producto where codpro = '$codpro'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            while ($row1 = mysqli_fetch_array($result1)) {
                                $desprod = $row1['desprod'];
                                $codmar = $row1['codmar'];
                                $factor = $row1['factor'];
                                $stopro = $row1['stopro']; ///STOCK EN UNIDADES DEL PRODUCTO GENERAL
                                $cant_loc1 = $row1[5];
                                $codpro = $row1['codpro'];

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

                                    $costre = $row1['costre'];  ///COSTO PROMEDIO
                                    $mardis = $row1['mardis'];
                                    $costpr = $row1['costpr'];
                                    $prevta = $row1['prevta'];
                                } elseif ($precios_por_local == 0) {

                                    $costre = $row1['costre'];  ///COSTO PROMEDIO
                                    $mardis = $row1['mardis'];
                                    $costpr = $row1['costpr'];
                                    $prevta = $row1['prevta'];
                                }

                                if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                    $sql_precio = "SELECT $costre_p,$mardis_p,$costpr_p,$prevta_p FROM precios_por_local where codpro = '$codpro'";
                                    $result_precio = mysqli_query($conexion, $sql_precio);
                                    if (mysqli_num_rows($result_precio)) {
                                        while ($row_precio = mysqli_fetch_array($result_precio)) {
                                            $costre = $row_precio[0];  ///COSTO PROMEDIO
                                            $mardis = $row_precio[1];
                                            $costpr = $row_precio[2];
                                            $prevta = $row_precio[3];
                                        }
                                    }
                                }
                            }
                        }
                        /* if ($mardis == 0) {
                            $costre2 = $costre * (1 + 5 / 100);
                        } else {
                            $costre2 = $costre * (1 + $mardis / 100);
                        }*/

                        if ($salidaTransferenciaSucursal == 1) {
                            $costre2 = $prevta;
                        } else  if ($salidaTransferenciaSucursal == 2) {
                            $costre2 = $costpr;
                        } else  if ($salidaTransferenciaSucursal == 3) {
                            $costre2 = $costre * (1 + $salidaTransferenciaSucursalPorcentaje / 100);
                        } else {
                            $costre2 = $prevta;
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
                        $sql1 = "SELECT codtemp FROM tempmovmov where codpro = '$codpro' and invnum = '$invnum'";
                        $result1 = mysqli_query($conexion, $sql1);
                        if (mysqli_num_rows($result1)) {
                            $control = 1;
                        } else {
                            $control = 0;
                        }
                    ?>
                        <tr>
                            <td><?php echo $codpro ?></td>
                            <td>
                                <?php
                                if ($control == 0) {
                                    if ($cant_loc > 0) {
                                ?>
                                        <a id="l1" href="transferencia2_sal.php?country_ID=<?php echo $producto ?>&valform=1&val=<?php echo $val ?>&cprod=<?php echo $codpro ?>">
                                            <?php echo $desprod ?>
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
                            <td align="center"><?php echo $factor ?></td>
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
                            <td>
                                <div align="center">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input name="text1" type="text" id="text1" size="4" onkeypress="return ent(event,<?php echo $comparativa ?>)" value="<?php
                                                                                                                                                                if ($qtyprf1 <> "") {
                                                                                                                                                                    echo $qtyprf1;
                                                                                                                                                                } else {
                                                                                                                                                                    echo $qtypro1;
                                                                                                                                                                }
                                                                                                                                                                ?>" onkeyup="precio()" />
                                        <input name="number" type="hidden" id="number" />
                                        <input name="costre" type="hidden" id="costre" value="<?php echo $costre2; ?>" />
                                        <input name="factor" type="hidden" id="factor" value="<?php echo $factor ?>" />
                                        <input name="text3" type="hidden" id="text3" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $codpro; ?>" />
                                        <input name="stock" type="hidden" id="stock" value="<?php echo $cant_loc ?>" />
                                        <input name="ok" type="hidden" id="ok" value="<?php echo $ok; ?>" />

                                    <?php
                                    } else {

                                        if ($qtyprf1 <> "") {
                                            echo $qtyprf1;
                                        } else {
                                            echo $qtypro1;
                                        }
                                    }
                                    ?>
                                </div>
                            </td>


                            <td width="68">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input class="LETRA2" name="text2" type="<?php echo $typo; ?>" id="text2" value="<?php echo $costre2; ?>" size="4" onKeyPress="return ent1(event)" readonly />
                                    <?php
                                    } else {
                                        if ($controleditable == 0) {
                                            echo $costre2;
                                        }
                                    }
                                    ?>
                                </div>
                            </td>


                            <td width="68">
                                <div align="right">
                                    <?php if (($valform == 1) && ($cprod == $codpro)) { ?>
                                        <input class="LETRA2" name="sub" type="text" id="sub" value=" " size="7" onKeyPress="return ent1(event)" readonly />
                                    <?php
                                    } else {
                                        echo "0.00";
                                    }
                                    ?>
                                </div>
                            </td>
                            <td width="17">
                                <div align="center"><?php
                                                    if ($control == 0) {
                                                        if ($cant_loc > 0) {
                                                    ?> <a href="transferencia2_sal_reg.php?cod=<?php echo $codpro ?>" target="tranf_principal"><?php /* ?><img src="../../../images/add.gif" width="14" height="15" border="0"/><?php */ ?></a><?php
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
                <center><u><br><br>
                        <span class="text_combo_select">NO SE LOGRO ENCONTRAR NINGUN PRODUCTO CON LA DESCRIPCION INGRESADA</span></u>
                </center>
        <?php
            }
        }
        ?>
    </form>
</body>

</html>