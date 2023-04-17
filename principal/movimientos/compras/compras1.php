<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
include('../../session_user.php');
$ok = isset($_REQUEST['ok']) ? ($_REQUEST['ok']) : "";
$valor = isset($_REQUEST['valor']) ? ($_REQUEST['valor']) : "";
$msg = isset($_REQUEST['msg']) ? ($_REQUEST['msg']) : "";
$ckigv = isset($_REQUEST['ckigv']) ? ($_REQUEST['ckigv']) : "";
//$busca_num      = $_REQUEST['busca_num'];
$busca_num = isset($_REQUEST['nrocompra']) ? ($_REQUEST['nrocompra']) : "";
$busca_prov = isset($_REQUEST['busca_prov']) ? ($_REQUEST['busca_prov']) : "";
$DatosProveedor = isset($_REQUEST['DatosProveedor']) ? ($_REQUEST['DatosProveedor']) : "";
$filtro = isset($_REQUEST['filtro']) ? ($_REQUEST['filtro']) : "";
$dateRecarga = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
//echo '$dateRecarga = '.$dateRecarga."<br>";
if ($DatosProveedor <> "") {
    $busca_prov = $DatosProveedor;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">


    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'd/m/Y'
            });
        });
    </script>
    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>
    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>

    <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../funciones/compras.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("ajax_compras.php"); //FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
    require_once("../../local.php"); //LOCAL DEL USUARIO
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $sql = "SELECT invnum,nro_compra FROM movmae where usecod = '$usuario' and proceso = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row["invnum"];  //codigo
            $ncompra = $row["nro_compra"];  //codigo
        }
    }
    $_SESSION['compras'] = $invnum;


    /////////////////////////////////////////////////////////////////////////////////////////////////
    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user = $row1['nomusu'];
        }
    }
    $sql1 = "SELECT porcent FROM datagen";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $porcent = $row1['porcent'];
        }
    }

    $sql = "SELECT invnum FROM movmae where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum_filtro = $row["invnum"];  //codigo

        }
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $sql = "SELECT * FROM movmae where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row['invnum'];  //codgio
            $nro_compra = $row['nro_compra'];  //codgio
            $fecha = $row['invfec'];
            $fecdoc = $row['fecdoc'];
            $fecven = $row['fecven'];
            $numdoc = $row['numdoc'];
            $ndoc = $row['numero_documento'];
            $ndoc1 = $row['numero_documento1'];
            $plazo = $row['plazo'];
            //                        $moneda = $row['moneda'];
            $forpag = $row['forpag'];

            $dafecto = $row['dafecto'];
            $dinafecto = $row['dinafecto'];
            $digv = $row['digv'];
            $dtotal = $row['dtotal'];


            if ($fecdoc == "0000-00-00") {
                $fecdoc = date('d/m/Y');
            } else {
                $fecdoc = fecha($fecdoc);
            }
        }
    }
    if($dateRecarga ==''){
        $fecdoc=$fecdoc;
    }else{
        $fecdoc=$dateRecarga;
    }

//echo '$fecdoc === '.$fecdoc."<br>";
    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }

    function redondear_dos_decimal($valor)
    {
        $float_redondeado = round($valor * 100) / 100;
        return $float_redondeado;
    }
    ?>
    <script>
        $(document).ready(function() {

            $('form').keypress(function(e) {
                if (e == 13) {
                    return false;
                }
            });

            $('input').keypress(function(e) {
                if (e.which == 13) {
                    return false;
                }
            });

        });
        var nav4 = window.Event ? true : false;
        // Valida y ejecuta busqueda de compras cuando usuario da ENTER
        function nums(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            if (key == 13) {
                var f = document.form1;
                if (f.alfa1.value == "") {
                    alert("Seleccione un Proveedor");
                    f.alfa1.focus();
                    return;
                }
                if (f.alfa1.value == 0) {
                    alert("Seleccione un Proveedor");
                    f.alfa1.focus();
                    return;
                }
                if (f.nrocompra.value == "") {
                    alert("Ingrese el Numero de la Orden de Compra");
                    f.nrocompra.focus();
                    return;
                }
                f.method = "post";
                f.action = "compras_busca.php";
                f.submit();
            }
            return (key <= 13 || key == 115 || key == 83 || (key >= 48 && key <= 57));
        }
        var nav4 = window.Event ? true : false;

        function forma_pago(evt) {
            // NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57
            var key = nav4 ? evt.which : evt.keyCode;
            return (key == 101 || key == 102 || key == 103 || key == 111 || key == 70 || key == 71 || key == 79 || key == 69 || key == 8);
        }

        // Valida los datos del formulario antes de grabar (compras1_reg.php)


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
            if (tecla == 120) {
                if ((a == 0) || (b > 0)) {
                    alert('No se puede realizar la impresiÃ¯Â¿Â½n de este Documento');
                } else {
                    //alert("hola");
                    //window.open('pre_imprimir.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=60,left=120,width=885,height=630');
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
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "comprasop_reg.php";
                    f.submit();
                    //if (window.print)
                    //window.print()
                    //else
                    //alert("Disculpe, su navegador no soporta esta opciÃ¯Â¿Â½n.");
                }
            }
        }
    </script>
    <?php

    function convertir_a_numero($str)
    {
        $legalChars = "%[^0-9\-\. ]%";

        $str = preg_replace($legalChars, "", $str);
        return $str;
    }

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
    ///////CONTADOR PARA CONTROLAR LOS TOTALES
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and costre <> '0'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count2 = $row[0];
        }
    } else {
        $count2 = 0;
    }
    $sql1 = "SELECT * FROM tempmovmov where invnum = '$invnum'  order by codtemp";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codpro = $row1['codpro'];
            $qtypro = $row1['qtypro'];
            $qtyprf = $row1['qtyprf'];
            $prisal = $row1['prisal'];
            $pripro = $row1['pripro'];
            $costre = $row1['costre'];
            $d1 = $row1['desc1'];
            $d2 = $row1['desc2'];
            $d3 = $row1['desc3'];
            $igv = 0;
            //////////////VERIFICO SI TIENE IGV
            /// aqui es
            $sql2 = "SELECT igv,factor FROM producto where codpro = '$codpro'";
            $result2 = mysqli_query($conexion, $sql2);
            if (mysqli_num_rows($result2)) {
                while ($row2 = mysqli_fetch_array($result2)) {
                    $igv = $row2['igv'];
                    $factor = $row2['factor'];
                }
            }
            //var_dump($igv);
            ////CANTIDADES///////////
            if ($qtyprf == "") {
                $cantidad_comp = $qtypro;
            } else {
                $cantidad_comp = convertir_a_numero($qtyprf);
            }
            //////////CALCULO DEL MONTO BRUTO - SIN DESCUENTO CON IGV
            $sum_mont1 = $prisal * $cantidad_comp;
            $mont_bruto = $mont_bruto + $sum_mont1;
            //////////CALCULO DEL VALOR VENTA
            //if (($igv == 1) || ($ckigv == 1))
            $porcent_igv = ($igv == 1) ? $porcent : 0;  // Si aplica IGV, colocar porcentaje, sino 0
            if ($ckigv <> 1) {

                $valor_vent = ($pripro / (($porcent_igv / 100) + 1)) * $cantidad_comp;
                $valor_vent1 = $valor_vent1 + $valor_vent;


                //Sleep(5);
            } else {
                $valor_vent = ($pripro / (($porcent_igv / 100) + 1)) * $cantidad_comp;
                $valor_vent1 = $valor_vent1 + $valor_vent;
                //			Echo $ckigv ;
                //Echo  $valor_vent;
                //Echo  $pripro;
                //Echo  $porcent;
                //Sleep(5);//		Sleep(45);
            }
            $monto_total = $monto_total + $costre;
        }
        //////////CALCULO DEL IGV
        $total_des = $mont_bruto - $valor_vent1;
        $sum_igv = ($monto_total - $valor_vent1);
        $sum1 = $numero_formato_frances = number_format($mont_bruto, 2, '.', ',');
        $sum2 = $numero_formato_frances = number_format($total_des, 2, '.', ',');
        $sum3 = $numero_formato_frances = number_format($valor_vent1, 2, '.', ',');
        $sum4 = $numero_formato_frances = number_format($sum_igv, 2, '.', ',');
        $sum5 = $numero_formato_frances = number_format($monto_total, 2, '.', ',');
    }
    ?>

    <style>
        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
            font-weight: bold;
            padding: 0 3px 0 3px;
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

        h1 {
            color: red;
            font-family: Arial, Helvetica;
            font-size: 60px;
        }

        h3 {
            font-family: Arial, Helvetica;
            font-size: 20px;
            margin-top: -55px;
        }
    </style>
</head>

<body onkeyup="compras11(event)" <?php if (($ok == 1) || ($ok == 4) || ($msg == 2)) { ?> onload="carga();" <?php } else { ?> <?php if (($invnum_filtro == 0) || ($invnum_filtro == '') || ($filtro == 1)) { ?> onLoad="mensaje_error();" <?php } else { ?> onload="carga1();" <?php }
                                                                                                                                                                                                                                                                        } ?>>
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" method="post">
        <?php if ($valor == 1) {
            echo '<script> alertify.alert("<h1>ALERTA DE LOTE </h1>", "<h3> Este lote ya existe, se mantendr\u00E1 la fecha de vencimiento anteriormente registrada.</h3> " )</script>';
        } elseif ($valor == 2) {
            echo '<script> alertify.alert("<h1>ALERTA DE LOTE</h1> ", "<h3> Este lote ya esta asignado a un producto de esta lista, no puede haber 2 productos con el mismo lote, el producto sera eliminado.</h3>" )</script>';
        }
        ?>
        <table width="100%" border="0">

            <tr>
                <div align="right" style="margin-top: -15px; margin-right: 10px;">
                    <span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local ?></span>
                </div>


                <td>
                    <!--	<div align="left"><img src="../../../images/line2.png" width="1400" height="4" /> </div>-->
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td class="LETRA">NUMERO</td>
                            <td><input class="LETRA2" name="textfield" type="text" size="12" disabled="disabled" value="<?php echo formato($numdoc) ?>" /></td>
                            <td class="LETRA">FECHA</td>
                            <td><input class="LETRA2" name="textfield2" type="text" size="16" disabled="disabled" value="<?php echo fecha($fecha) ?>" /></td>
                            <td class="LETRA">PROVEEDOR *</td>
                            <td colspan="3">
                                <input type="hidden" id="DatosProveedor" name="DatosProveedor" value="<?php echo $DatosProveedor; ?>" />

                                <select style='width:250px;' id="combo_zone1" name="alfa1" onchange="searchs2();">
                                    <option value="0">Seleccione un Proveedor...</option>
                                    <?php
                                    $sql = "SELECT codpro,despro,rucpro FROM proveedor order by despro";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $s_prov = $row["codpro"];
                                        $rucpro = $row["rucpro"];
                                    ?>
                                        <option value="<?php echo $row["codpro"]; ?>" <?php if ($busca_prov == $s_prov) { ?> selected="selected" <?php } ?>><?php echo substr($row["despro"], 0, 55) . ' - ' . $rucpro; ?></option>
                                    <?php } ?>
                                </select>
                                <script>
                                    var z = dhtmlXComboFromSelect("combo_zone1");
                                    z.enableFilteringMode(true);
                                </script>
                                <?php
                                //}
                                ?>
                                <input name="ext" type="button" id="ext" value="NUEVO" onclick="proveedor()" class="buscar" />
                            </td>
                            <td colspan="2" class="LETRA" align="right">

                                N&ordm; MOVIMIENTO
                            </td>
                            <td colspan="2">
                                <input name="nrocompra" type="text" id="nrocompra" size="4" value="<?php echo $busca_num ?>" onKeyPress="return nums(event)" />
                                <input name="srch" type="button" id="srch" value="Buscar" class="buscar" onclick="searchs()" />
                            </td>


                            <td colspan="2"><label>
                                    <div align="center">
                                        <!--<input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimirerror()" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?>/>
                                                    <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                                                    <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>-->
                                        <input name="cant_registros" type="hidden" id="cant_registros" value="<?php echo $count ?>" />
                                        <input name="ncompra" type="hidden" id="ncompra" value="<?php echo $ncompra ?>" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
                                        <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
                                        <input name="mont_bruto" type="hidden" id="mont_bruto" value="<?php echo $mont_bruto ?>" />
                                        <input name="total_des" type="hidden" id="total_des" value="<?php echo $total_des ?>" />
                                        <input name="valor_vent1" type="hidden" id="valor_vent1" value="<?php echo $valor_vent1 ?>" />
                                        <input name="sum_igv" type="hidden" id="sum_igv" value="<?php echo $sum_igv ?>" />
                                        <input name="monto_total" type="hidden" id="monto_total" value="<?php echo $monto_total ?>" />
                                        <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                                        <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                                        <input name="count2" type="hidden" id="count2" value="<?php echo $count2 ?>" />
                                        <input name="save" type="button" id="save" value="Grabar" <?php if (($invnum_filtro == 0) || ($invnum_filtro == '') || ($filtro == 1)) { ?> onLoad="mensaje_error();" <?php } else { ?> onclick="grabar1()" <?php } ?> class="grabar" <?php if (($count == 0) || ($count1 > 0) || ($invnum_filtro == 0) || ($invnum_filtro == '') || ($filtro == 1)) { ?>disabled="disabled" <?php } ?> />
                                        <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar" />
                                    </div>
                                </label></td>
                        </tr>
                        <tr>
                            <td class="LETRA">TIPO *</td>
                            <td width="120" title="F / G / O / E">
                                <select style='width:250px;' id="fpago" name="fpago" onkeyup="cargarContenido()" onchange="cargarContenido();">
                                    <option value="">Seleccione un tipo...</option>
                                    <option value="F" <?php if ($forpag == "F") { ?> selected="selected" <?php } ?>>Factura</option>
                                    <option value="B" <?php if ($forpag == "B") { ?> selected="selected" <?php } ?>>Boleta </option>
                                    <option value="G" <?php if ($forpag == "G") { ?> selected="selected" <?php } ?>>Guia </option>
                                    <option value="O" <?php if ($forpag == "O") { ?> selected="selected" <?php } ?>>Otros </option>
                                </select>

                            </td>
                            <td class="LETRA">FECHA EMISION *</td>
                            <td>
                                <input tabindex="2" type="text" name="date1" id="date1" size="25" value="<?php echo $fecdoc; ?>"  onclick="cargarContenido();" onkeyup="cargarContenido()" onchange="cargarContenido();" >
                            </td>

                            <td class="LETRA">N DOC *</td>
                            <td colspan="3">

                                <input tabindex="3" name="n1" type="text" id="n1" onkeypress="return this.value = this.value.toUpperCase();" size="5" maxlength="6" onkeyup="cargarContenido()" value="<?php echo $ndoc ?>" />
                                -
                                <input tabindex="4" name="n2" type="text" id="n2" onkeypress="return acceptNum(event)" size="15" maxlength="8" onkeyup="cargarContenido()" value="<?php echo $ndoc1 ?>" />
                            </td>

                            <td class="LETRA" colspan="6">
                                <label>INCL. IGV * &nbsp;&nbsp;&nbsp; <input tabindex="5" value="1" <?php if ($ckigv == 1) { ?>checked<?php } ?> type="checkbox" name="ckigv" id="ckigv" onclick="ValidarIGV();" /> </label>
                                <input type="hidden" id="valida_igv" name="valida_igv" value="<?php echo $ckigv ?>" />
                            </td>


                        </tr>
                        <tr>
                            <td class="LETRA">FECHA DIG </td>
                            <td><label>
                                    <input class="LETRA2" name="textfield3" type="text" size="12" onfocus="blur()" value="<?php echo fecha($fecha) ?>" />
                                </label></td>
                            <td class="LETRA">PLAZO</td>
                            <td><label>
                                    <input tabindex="6" name="plazo" type="text" id="plazo" onkeypress="return acceptNum(event)" size="12" maxlength="3" onkeyup="cargarContenido()" value="<?php echo $plazo ?>" />
                                </label></td>
                            <td class="LETRA">FECHA VTO. </td>

                            <td><input class="LETRA2" name="date2" type="text" id="date2" onfocus="blur()" size="15" value="<?php echo fecha($fecven) ?>" />
                                <input name="ok" type="hidden" id="ok" value="<?php echo $ok ?>" />
                            </td>

                            <td class="LETRA" align="right">
                                GRAVADO
                            </td>
                            <td>
                                <input tabindex="7" type="text" name="dafecto" id="dafecto" size="9" value="<?php echo $dafecto ?>" onkeyup="cargarContenido()" onkeypress="return decimal(event)" />
                            </td>

                            <td class="LETRA" align="right">
                                INAFECTO
                            </td>
                            <td>
                                <input tabindex="8" type="text" name="dinafecto" id="dinafecto" size="9" value="<?php echo $dinafecto ?>" onkeyup="cargarContenido()" onkeypress="return decimal(event)" />
                            </td>
                            <td class="LETRA" align="right">
                                IGV
                            </td>
                            <td>
                                <input tabindex="9" type="text" name="digv" id="digv" size="9" value="<?php echo $digv ?>" onkeyup="cargarContenido()" onkeypress="return decimal(event)" />
                            </td>
                            <td class="LETRA" align="right">
                                TOTAL
                            </td>
                            <td>
                                <input tabindex="10" type="text" name="dtotal" id="dtotal" size="9" value="<?php echo $dtotal ?>" onkeyup="cargarContenido()" onkeypress="return decimal(event)" />
                            </td>


                        </tr>
                    </table>


                    <!--<table width="1250" border="0">
                                                <tr>
                                                        <td><a href="javascript:popUpWindow('pendientes.php', 40, 90, 455, 120)">INGRESOS PENDIENTES</a></td>
                                                        <td width="74">&nbsp;</td>
                                                        <td width="445" class="login"><div align="right">F8 = GRABAR </div></td>
                                                        <td width="90" class="login"><div align="right">F9 = IMPRIMIR </div></td>
                                                </tr>
                                        </table>-->
                    <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0">
                        <?php //echo '$ok'.$ok."<br>" ;
                        ?>
                        <tr>
                            <td width="955">
                                <?php
                                // if ($ok <> 4) {
                                if (($ok == 0) || ($ok == 1)) {
                                ?>
                                    <iframe src="compras3.php?ok=<?php echo $ok ?>&ckigv=<?php echo $ckigv; ?>&busca_prov=<?php echo $busca_prov; ?>" name="iFrame2" width="100%" height="394" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                                <?php
                                } else {
                                ?>
                                    <iframe src="compras2.php?ok=<?php echo $ok ?>&ckigv=<?php echo $ckigv; ?>&busca_prov=<?php echo $busca_prov; ?>&date1=<?php echo $fecdoc; ?>&n1=<?php echo $ndoc; ?>&n2=<?php echo $ndoc1; ?>&forpag=<?php echo $forpag; ?>&plazo=<?php echo $plazo; ?>&date2=<?php echo $fecven; ?>" name="iFrame3" width="100%" height="160" scrolling="Automatic" frameborder="0" id="iFrame3" allowtransparency="0"> </iframe>
                                    <iframe src="compras3.php?ok=<?php echo $ok ?>&ckigv=<?php echo $ckigv; ?>&busca_prov=<?php echo $busca_prov; ?>" name="iFrame2" width="100%" height="250" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                    <!--<a href="javascript:popUpWindows('../../archivo/mov_prod.php', 205, 40, 498, 270)" > <img src="../../../images/tickg.gif" width="19" height="18" border="0"/> </a>-->
                    <input name="ext" type="button" id="ext" value="CREAR PRODUCTO" onclick="producto()" class="buscar" />
                    <input name="ext" type="button" id="ext" value="CREAR PROVEEDOR" onclick="proveedor()" class="buscar" />
                    <!--<input name="ext" type="button" id="ext" value="CREAR PROVEEDORES" onclick="producto()" class="cancelar"/>-->
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>



                    <table width="100%" border="0" align="left">
                        <tr>

                            <td width="10" class="LETRA">
                                <div align="right">V. VENTA </div>
                            </td>
                            <td width="90">
                                <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $sum3 ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                            <td width="90" class="LETRA">
                                <div align="right">IGV</div>
                            </td>
                            <td width="50">
                                <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $sum4 ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                            <td width="10" class="LETRA">
                                <div align="right">TOTAL</div>
                            </td>
                            <td width="50">
                                <input name="mont5" class="sub_totales" type="text" id="mont5" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $sum5 ?> <?php } else { ?>0.00<?php } ?>" />
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>

                </td>
            </tr>
        </table>
    </form>
</body>

</html>

<script type="text/javascript">
    $('#combo_zone1').select2();
    $('#fpago').select2();
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>