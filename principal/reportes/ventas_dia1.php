<?php
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo $desemp ?></title>
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />


    <?php //require_once("../../funciones/functions.php"); //DESHABILITA TECLAS 
    ?>
    <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse;
        }

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
    </style>

    <script src="js/jqueryscroll.min.js" type="text/javascript"></script>
</head>

<body>
    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'd/m/Y'
            });
            myCal = new Calendar({
                date2: 'd/m/Y'
            });

            myCal3 = new Calendar({
                date3: 'd/m/Y'
            }, {
                classes: ['i-heart-ny'],
                direction: 1
            });
        });
    </script>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>

    <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../funciones/calendar.php"); ?>
    <?php ///require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL 
    ?>
    <script language="JavaScript">
        function validar() {
            var f = document.form1;
            if (f.desc.value == "") {
                alert("Ingrese el Numero del Documento");
                f.desc.focus();
                return;
            }
            document.form1.vals.value = "";
            document.form1.valTipoDoc.value = "";
            document.form1.ck1.value = "";
            document.form1.ck2.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "ventas_dia1.php";
            } else {
                f.action = "ventas_prog.php";
            }
            f.submit();
        }

        function desdelivery() {
            var f = document.form1;
            if (f.delivery.checked == true) {

                f.sunat.disabled = true;
                f.ckprod.disabled = true;

            } else {

                f.sunat.disabled = false;
                f.ckprod.disabled = false;

            }
        }

        function dessunat() {
            var f = document.form1;
            if (f.sunat.checked == true) {
                //alert("hola1");
                //f.ck.disabled = true;
                //f.ck1.disabled = true;
                //f.ck2.disabled = true;
                f.ckprod.disabled = true;
                f.delivery.disabled = true;
            } else {
                //alert("hola2");
                //f.ck.disabled = false;
                //f.ck1.disabled = false;
                //f.ck2.disabled = false;
                f.ckprod.disabled = false;
                f.delivery.disabled = false;
            }
        }

        function desab() {
            var f = document.form1;
            if (f.ckprod.checked == true) {
                //alert("hola1");
                f.ck.disabled = true;
                f.ck1.disabled = true;
                f.ck2.disabled = true;
                f.delivery.disabled = true;
                f.sunat.disabled = true;
            } else {
                //alert("hola2");
                f.ck.disabled = false;
                f.ck1.disabled = false;
                f.ck2.disabled = false;
                f.delivery.disabled = false;
                f.sunat.disabled = false;
            }
        }

        function validar1() {
            var f = document.form1;
            if (f.date1.value == "") {
                alert("Ingrese una Fecha");
                f.date1.focus();
                return;
            }
            if (f.date2.value == "") {
                alert("Ingrese una Fecha");
                f.date2.focus();
                return;
            }
            document.form1.val.value = "";
            document.form1.valTipoDoc.value = "";
            document.form1.ck.value = "";
            document.form1.ck2.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "ventas_dia1.php";
            } else {
                f.method = 'get';
                f.action = "ventas_prog.php";
            }
            f.submit();
        }

        function validarTipoDoc() {
            var f = document.form1;
            if (f.from.value == "") {
                alert("Ingrese un nÃÂºmero inicial");
                f.from.focus();
                return;
            }
            if (f.until.value == "") {
                alert("Ingrese un nÃÂºmero final");
                f.until.focus();
                return;
            }
            document.form1.val.value = "";
            document.form1.vals.value = "";
            document.form1.ck.value = "";
            document.form1.ck1.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "ventas_dia1.php";
            } else {
                f.method = 'get';
                f.action = "ventas_prog.php";
            }
            f.submit();
        }

        function sf() {
            var f = document.form1;
            document.form1.desc.focus();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../index.php";
            f.submit();
        }

        function printer() {
            window.print();
        }

        function printerTipoDoc() {
            window.print();
        }
    </script>
    <?php
    $date = date('d/m/Y');
    $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
    $vals = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
    $valTipoDoc = isset($_REQUEST['valTipoDoc']) ? ($_REQUEST['valTipoDoc']) : "";
    $desc = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
    $desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
    $date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
    $date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
    $tipoDoc = isset($_REQUEST['tipoDoc']) ? ($_REQUEST['tipoDoc']) : "";
    $from = isset($_REQUEST['from']) ? ($_REQUEST['from']) : "";
    $until = isset($_REQUEST['until']) ? ($_REQUEST['until']) : "";
    $report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
    $ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";
    $ck1 = isset($_REQUEST['ck1']) ? ($_REQUEST['ck1']) : "";
    $ck2 = isset($_REQUEST['ck2']) ? ($_REQUEST['ck2']) : "";
    $ckloc = isset($_REQUEST['ckloc']) ? ($_REQUEST['ckloc']) : "";
    $ckprod = isset($_REQUEST['ckprod']) ? ($_REQUEST['ckprod']) : "";
    $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
    $delivery = isset($_REQUEST['delivery']) ? ($_REQUEST['delivery']) : "";
    $sunat = isset($_REQUEST['sunat']) ? ($_REQUEST['sunat']) : "";
    $vendedor = isset($_REQUEST['vendedor']) ? ($_REQUEST['vendedor']) : "";

    $sql = "SELECT export,nomusu FROM usuario where usecod = '$usuario'";

    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
            $user = $row['nomusu'];
        }
    }
    ////////////////////////////
    $registros = 20;
    $pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $registros;
    }
    if ($local <> 'all') {
        require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
    }
    ////////////////////////////
    if ($ckprod == 1) {
        if ($val == 1) { ///	PRIMER BOTON
            if ($local == 'all') { ////TODOS LOS LOCALES
                $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where invnum between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";
            } else { ///UN SOLO LOCAL
                $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where invnum between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local'";
            }
        } elseif ($vals == 2) { ///	SEGUNDO BOTON
            if ($local == 'all') { ////TODOS LOS LOCALES
                $sql = "SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and invtot <> '0' and estado = '0'";
            } else { ///UN SOLO LOCAL
                $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
            }
        } else { // TERCER BOTON
            if ($local == 'all') { ////TODOS LOS LOCALES
                $sql = "SELECT venta.invnum FROM venta inner join detalle_venta where venta.correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and invtot <> '0' and estado = '0'";
            } else { ///UN SOLO LOCAL
                $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' group by usecod order by nrovent";
            }
        }
        $sql = mysqli_query($conexion, $sql);
        $total_registros = mysqli_num_rows($sql);
        $total_paginas = ceil($total_registros / $registros);
        //echo $sql;
    } else {
        if (($ck == '') && ($ck1 == '') && ($ck2 == '')) {
            if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)) {
                if ($val == 1) {
                    if ($local == 'all') {
                        $sql = "SELECT usecod FROM venta where invnum between '$desc' and '$desc1' group by usecod";
                    } else {
                        $sql = "SELECT usecod FROM venta where invnum between '$desc' and '$desc1' and sucursal = '$local' group by usecod";
                    }
                }
                if ($vals == 2) {
                    if ($local == 'all') {
                        $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
                    } else {
                        $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' group by usecod order by nrovent";
                    }
                }
                if ($valTipoDoc == 1) {
                    if ($local == 'all') {
                        $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' group by usecod order by nrovent";
                    } else {
                        $sql = "SELECT usecod FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' group by usecod order by nrovent";
                    }
                }
                $sql = mysqli_query($conexion, $sql);
                $total_registros = mysqli_num_rows($sql);
                $total_paginas = ceil($total_registros / $registros);
            }
        }
        if (($ck == 1) || ($ck1 == 1) || ($ck2 == 1)) {
            if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)) {
                if ($val == 1) {
                    if ($local == 'all') {
                        $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invnum between '$desc' and '$desc1'";
                    } else {
                        $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invnum between '$desc' and '$desc1' and sucursal = '$local'";
                    }
                }
                if ($vals == 2) {
                    if ($local == 'all') {
                        $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' order by nrovent";
                    } else {
                        $sql = "SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' order by nrovent";
                    }
                }
                if ($valTipoDoc == 1) {
                    if ($local == 'all') {
                        $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' order by nrovent";
                    } else {
                        $sql = "SELECT invnum,usecod,nrofactura,forpag,val_habil,invtot FROM venta where correlativo between '$from' and '$until' and tipdoc='$tipoDoc' and sucursal = '$local' order by nrovent";
                    }
                }
                $sql = mysqli_query($conexion, $sql);
                $total_registros = mysqli_num_rows($sql);
                $total_paginas = ceil($total_registros / $registros);
            }
        }
    }
    ?>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE VENTAS DIARIAS</u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table class="tablarepor" width="100%" border="0">
                        <tr bgcolor="#ececec">
                            <td align="left" width="90" class="LETRA">SALIDA</td>
                            <td width="120">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="150">
                                <div align="left" class="LETRA">LOCAL</div>
                            </td>
                            <td width="220">
                                <select style="width:200px" name="local" id="local">
                                    <?php if ($nombre_local == 'LOCAL0') { ?>
                                        <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
                                    <?php } ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc";
                                    } else {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local'";
                                    }
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $loc = $row["codloc"];
                                        $nloc = $row["nomloc"];
                                        $nombre = $row["nombre"];
                                        if ($nombre == '') {
                                            $locals = $nloc;
                                        } else {
                                            $locals = $nombre;
                                        }
                                    ?>
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals; ?></option>
                                    <?php } ?>
                                </select>

                            </td>

                            <td width="100">
                                <div align="left" class="LETRA">VENDEDOR</div>
                            </td>
                            <td width="200">
                                <select style="width:200px" name="vendedor" id="vendedor">
                                    <?php /* if ($nombre_local == 'LOCAL0') { */ ?>
                                        <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS VENDEDORES</option>
                                    <?php /* } */ ?> 
                                    <?php

                                    $sql = "SELECT usuario.usecod, usuario.codloc, usuario.nomusu, xcompa.nombre FROM usuario 
                                    INNER JOIN xcompa ON usuario.codloc = xcompa.codloc 
                                    WHERE (usuario.codgrup=1 AND usuario.estado=1) OR (usuario.codgrup=2 AND usuario.estado=1 AND usuario.usecod>7743)";
                                    
                                    $result = mysqli_query($conexion, $sql);

                                    while ($row = mysqli_fetch_array($result)) 
                                    {
                                        $vend = $row["codloc"];
                                        $nvend = $row["usecod"];
                                        $nombrevend = $row["nomusu"];
                                        $nombre_sucursal = $row["nombre"];

                                        echo '<option value="' . $nvend  . '" ' . (($vendedor == $nvend)? 'selected' : '') . '>' . $nombrevend . '-' . $nombre_sucursal . '</option>';
                                    } ?>
                                </select>

                            </td>

                            <td colspan="2">
                                <input name="ckloc" type="checkbox" id="ckloc" value="1" checked="checked" />
                                <label for="ckloc" class="LETRA"> Mostrar Local </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="delivery" type="checkbox" id="delivery" value="1" <?php if ($delivery == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?><?php if ($sunat == 1) { ?>disabled="disabled" <?php } ?> onclick="desdelivery()" />
                                <label for="delivery" class="LETRA"> Delivery </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="sunat" type="checkbox" id="sunat" value="1" <?php if ($sunat == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> <?php if ($delivery == 1) { ?>disabled="disabled" <?php } ?>onclick="dessunat()" />
                                <label for="sunat" class="LETRA">Ver Informacion Sunat </label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input name="ckprod" type="checkbox" id="ckprod" value="1" <?php if ($ckprod == 1) { ?>checked="checked" <?php } ?><?php if ($delivery == 1) { ?>disabled="disabled" <?php } ?> <?php if ($sunat == 1) { ?>disabled="disabled" <?php } ?>onclick="desab()" />
                                <label for="ckprod" class="LETRA"> Mostrar Detalle de Productos</label>

                            </td>
                        </tr>


                        <tr bgcolor="#ececec">
                            <td class="LETRA">Nº INICIAL CORRELATIVO</td>
                            <td><input name="desc" type="text" id="desc" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc ?>" /></td>
                            <td>
                                <div align="left" class="LETRA">Nº FINAL CORRELATIVO</div>
                            </td>
                            <td><input name="desc1" type="text" id="desc1" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc1 ?>" /> </td>
                            <td> </td>
                            <td> </td>
                            <td>
                                <input name="ck" type="checkbox" id="ck" value="1" <?php if ($ck == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />

                                <label for="ck" class="LETRA">Mostrar Lista detallada por N&ordm;</label>
                            </td>

                            <td><input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar" />
                                <!-- <input type="button" name="Submit22" value="Imprimir" onClick="self.location.href = 'ventas_dia2_1.php?ventas_dia2_1.php?val=<?php echo $val ?>&vals=<?php echo $vals ?>&valTipoDoc=<?php echo $valTipoDoc ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&tipoDoc=<?php echo $tipoDoc ?>&from=<?php echo $from ?>&until=<?php echo $until ?>&report=<?php echo $report ?>&ck=<?php echo $ck ?>&ck1=<?php echo $ck1 ?>&ck2=<?php echo $ck2 ?>&ckloc=<?php echo $ckloc ?>&ckprod=<?php echo $ckprod ?>&local=<?php echo $local ?>&delivery=<?php echo $delivery ?>&sunat=<?php echo $sunat ?>'" class="imprimir" /> -->
                                <!-- <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir" /> -->
                            </td>
                        </tr>

                        <tr bgcolor="#ececec">
                            <td class="LETRA">FECHA INICIO</td>
                            <td>
                                <input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>">
                            </td>

                            <td>
                                <div align="left" class="LETRA">FECHA FINAL</div>
                            </td>
                            <td>
                                <input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                            if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            }
                                                                                            ?>">
                            </td>
                             <td> </td>
                            <td> </td>
                            <td>
                                <input name="ck1" type="checkbox" id="ck1" value="1" <?php if ($ck1 == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />
                                <label for="ck1" class="LETRA"> Mostrar Lista detallada por N&ordm; </label>

                            </td>

                            <td><input name="vals" type="hidden" id="vals" value="2" />
                                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                <input type="button" name="Submit222" id="im" value="Imprimir" onClick="self.location.href = 'ventas_dia2_1.php?ventas_dia2_1.php?val=<?php echo $val ?>&vals=<?php echo $vals ?>&valTipoDoc=<?php echo $valTipoDoc ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&tipoDoc=<?php echo $tipoDoc ?>&from=<?php echo $from ?>&until=<?php echo $until ?>&report=<?php echo $report ?>&ck=<?php echo $ck ?>&ck1=<?php echo $ck1 ?>&ck2=<?php echo $ck2 ?>&ckloc=<?php echo $ckloc ?>&ckprod=<?php echo $ckprod ?>&local=<?php echo $local ?>'" class="imprimir" />
                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                            </td>
                        </tr>


                        <tr bgcolor="#ececec">
                            <td class="LETRA">TIPO DOC</td>
                            <td>
                                <select style="width:100px" name="tipoDoc" id="tipoDoc">
                                    <option value="2" <?php if ($tipoDoc == 2) { ?>selected<?php } ?>>BOLETA</option>
                                    <option value="4" <?php if ($tipoDoc == 4) { ?>selected<?php } ?>>TICKET</option>
                                    <option value="1" <?php if ($tipoDoc == 1) { ?>selected<?php } ?>>FACTURA</option>
                                </select>

                            </td>

                            <td align="left" class="LETRA">DESDE
                            <input name="from" type="text" id="from" size="8" onkeypress="return acceptNum(event)" maxlength="10" value="<?php echo $from ?>" />
                            
                            </td>
                            <td>
                                <label align="right" class="LETRA">HASTA</label>
                                <input name="until" type="text" id="until" size="8" onkeypress="return acceptNum(event)" maxlength="10" value="<?php echo $until ?>" />

                            </td>
                            <td> </td>
                            <td> </td>

                            <td>
                                <input name="ck2" type="checkbox" id="ck2" value="1" <?php if ($ck2 == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />
                                <label for="ck2" class="LETRA"> Mostrar Lista detallada por N&ordm;</label>
                            </td>
                            <td><input name="valTipoDoc" type="hidden" id="valTipoDoc" value="1" />
                                <input type="button" name="SubmitTipoDoc" value="Buscar" onclick="validarTipoDoc()" class="buscar" />
                                 <!-- <input type="button" name="SubmitPrintTipoDoc" value="Imprimir" onClick="self.location.href = 'ventas_dia2_1.php?ventas_dia2_1.php?val=<?php echo $val ?>&vals=<?php echo $vals ?>&valTipoDoc=<?php echo $valTipoDoc ?>&desc=<?php echo $desc ?>&desc1=<?php echo $desc1 ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&tipoDoc=<?php echo $tipoDoc ?>&from=<?php echo $from ?>&until=<?php echo $until ?>&report=<?php echo $report ?>&ck=<?php echo $ck ?>&ck1=<?php echo $ck1 ?>&ck2=<?php echo $ck2 ?>&ckloc=<?php echo $ckloc ?>&ckprod=<?php echo $ckprod ?>&local=<?php echo $local ?>'" class="imprimir" /> -->
                                <!-- <input type="button" name="SubmitSalirTipoDoc" value="Salir" onclick="salir()" class="salir" />  -->
                            </td>
                        </tr>
                    </table>


                </form>

        </tr>
    </table>
    <br>
    <?php
    if (($val == 1) || ($vals == 2) || ($valTipoDoc == 1)) {
        require_once("ventas_dia2.php");
    }
    ?>

    <div class="go-top-container" title="Vuelve al comienzo">
        <div class="go-top-button" title="Vuelve al comienzo">
            <a id="volver-arriba" href="#" title="Vuelve al comienzo" style="  cursor:pointer;">
                <i class="fas fa-chevron-up" title="Vuelve al comienzo">

                </i>
            </a>
        </div>
    </div>
    <script src="js/gotop.js"></script>
</body>

</html>
<script>
    $('#tipoDoc').select2();
    $('#local').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>