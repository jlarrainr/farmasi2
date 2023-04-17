<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once('../../session_user.php');

// $venta = $_SESSION['venta'];

// echo 'venta  =' . $venta . "<br>";

$forpag = "";

$venta = isset($_SESSION['venta']) ? $_SESSION['venta'] : "";
$cotizacion = isset($_REQUEST['cotizacion']) ? $_REQUEST['cotizacion'] : "";
$delivery = isset($_REQUEST['delivery']) ? $_REQUEST['delivery'] : "";
// $forpag22 = isset($_REQUEST['forpag2']) ? $_REQUEST['forpag2'] : "";
// echo '$forpag22 111111 = ' . $forpag22 . "<br>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php');
    require_once('../../../titulo_sist.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once('../../../funciones/highlight.php');
    require_once('../../../funciones/functions.php');
    require_once('../../../funciones/botones.php');
    require_once('funciones/ventas_index1/funct_principal.php');
    require_once('../../local.php');
    require_once('ajax_forma_pago.php');
    require_once('funciones/ventas_index1.php');
    require_once('calcula_monto.php');

    $sql_usuario = "SELECT nomusu,codgrup FROM usuario where usecod = '$usuario'";
    $result_usuario = mysqli_query($conexion, $sql_usuario);
    if (mysqli_num_rows($result_usuario)) {
        while ($row_usuario = mysqli_fetch_array($result_usuario)) {
            $nomusu = $row_usuario['nomusu'];
            $codgrup = $row_usuario['codgrup'];
        }
    }


    if ($usuariosEspeciales_ArqueoCaja == 1) {

        if (($usuario == '1') || ($usuario == '2') || ($usuario == '7742') || ($codgrup == '2')) {
            $bloqueoUsuario = '1';
        } else {
            $bloqueoUsuario = '0';
        }
    } else {
        $bloqueoUsuario = '0';
    }

    if (($arqueo_caja == 1) && ($bloqueoUsuario == 0)) {

        $fecha_actual_arqueo = date('Y/m/d');

        $sql_arqueo_no_cerraron_dias_antes = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio<>'$fecha_actual_arqueo' and estado ='0' ORDER by fecha_inicio LIMIT 1 ";
        $result_arqueo_no_cerraron_dias_antes = mysqli_query($conexion, $sql_arqueo_no_cerraron_dias_antes);
        if (mysqli_num_rows($result_arqueo_no_cerraron_dias_antes)) {
            while ($row_result_arqueo_no_cerraron_dias_antes = mysqli_fetch_array($result_arqueo_no_cerraron_dias_antes)) {
                $id_arqueo = $row_result_arqueo_no_cerraron_dias_antes['id'];
            }
            $arqueo_arqueo_no_cerraron_dias_antes = 1;
        } else {
            $arqueo_arqueo_no_cerraron_dias_antes = 0;
        }

        $sql_arqueo = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo'";
        $result_arqueo = mysqli_query($conexion, $sql_arqueo);
        if (mysqli_num_rows($result_arqueo)) {
            $arqueo = 1;
        } else {
            $arqueo = 0;
        }


        if ($arqueo == 1) {

            $sql_arqueo_bloqueo_cierre = "SELECT id FROM arqueo_caja WHERE codigo_usuario='$usuario' and fecha_inicio='$fecha_actual_arqueo' and fecha_cierre='$fecha_actual_arqueo' and  monto_cierre > 0";
            $result_arqueo_bloqueo_cierre = mysqli_query($conexion, $sql_arqueo_bloqueo_cierre);
            if (mysqli_num_rows($result_arqueo_bloqueo_cierre)) {
                // $arqueo_bloqueo = 0;
                $arqueo_bloqueo_1 = 1;
            } else {
                $arqueo_bloqueo_1 = 0;
            }
        } else {
            $arqueo_bloqueo_1 = 0;
        }
    } else {
        $arqueo = 1;
        $arqueo_arqueo_no_cerraron_dias_antes = 0;
        $arqueo_bloqueo_1 = 0;
    }



    $sql_grupo_user = "SELECT nomgrup FROM grupo_user  where codgrup = '$codgrup'";
    $result_grupo_user = mysqli_query($conexion, $sql_grupo_user);
    if (mysqli_num_rows($result_grupo_user)) {
        while ($row_grupo_user = mysqli_fetch_array($result_grupo_user)) {
            $nomgrup = $row_grupo_user['nomgrup'];
        }
    }

    function numberOfWeek($dia, $mes, $ano)
    {
        $Hora = date("H");
        $Min = date("i");
        $Sec = date("s");
        $fecha = mktime($Hora, $Min, $Sec, $mes, 1, $ano);
        $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
        return $numberOfWeek;
    }

    if (isset($_SESSION['venta'])) {
        $sessionVenta = $_SESSION['venta'];
        $sql = "SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias,delivery,forpag,n_cotizacion FROM venta where invnum = '$sessionVenta' and usecod = '$usuario' and estado ='1'";
    } else {
        // Tomar datos para la venta (local, cliente, numero de venta, correlativo)
        $sql_U = "SELECT codloc FROM usuario where usecod = '$usuario'";
        $result_U = mysqli_query($conexion, $sql_U);
        if (mysqli_num_rows($result_U)) {
            while ($row_U = mysqli_fetch_array($result_U)) {
                $codloc = $row_U['codloc'];
            }
        }
        $sql_C = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
        $result_C = mysqli_query($conexion, $sql_C);
        if (mysqli_num_rows($result_C)) {
            while ($row = mysqli_fetch_array($result_C)) {
                $codcli = $row['codcli'];
            }
        }
        // $sql_coti = "SELECT count(*) FROM cotizacion where sucursal = '$codloc' and baja = '0' and invtot <> 0 and estado='0' and estado_venta ='0' order by invnum DESC";
        // $result_coti = mysqli_query($conexion, $sql_coti);
        // if (mysqli_num_rows($result_coti)) {
        //     while ($row_coti = mysqli_fetch_array($result_coti)) {
        //         $count_coti = $row_coti[0];
        //     }
        // }



        // if ($count_coti > 0) {
        //     $n_count_coti = 'Mostrar Cotizaciones - ' . $count_coti;
        // } else {
        //     $n_count_coti = 'Mostrar Cotizaciones';
        // }

        $date = date("Y-m-d");
        $fecha = explode("-", $date);
        $daysem = $fecha[2];
        $messem = $fecha[1];
        $yearsem = $fecha[0];
        $correlativo = 1;
        $sql_venta = "SELECT max(correlativo) correlativo FROM venta where sucursal = '$codloc'";
        $result_venta = mysqli_query($conexion, $sql_venta);
        if (mysqli_num_rows($result_venta)) {
            while ($row_venta = mysqli_fetch_array($result_venta)) {
                $correlativo = $row_venta['correlativo'] + 1;
            }
        }
        $semana = numberOfWeek($daysem, $messem, $yearsem);
        mysqli_query($conexion, "INSERT INTO venta (nrovent,invfec,usecod,cuscod,forpag,estado,sucursal,tipdoc,correlativo,semana,nrofactura) values ('$correlativo','$date','$usuario','$codcli','E','1','$codloc','2','$correlativo','$semana','')");
        $lastVentaId = mysqli_insert_id($conexion);

        $_SESSION['venta'] = $lastVentaId;
        $sql = "SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias,delivery,forpag,n_cotizacion FROM venta where invnum = '$lastVentaId' and usecod = '$usuario' and estado ='1'";
    }

    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row['invnum'];
            $cuscod = $row['cuscod'];
            $invfec = $row['invfec'];
            $nrovent = $row['nrovent'];
            $correlativo = $row['correlativo'];
            $ndias = $row['ndias'];
            $delivery2 = $row['delivery'];
            $forpag2 = $row['forpag'];
            $n_cotizacion = $row['n_cotizacion'];
        }
    }

    if ($forpag == "") {
        $forpag = $forpag2;
    }
     if ($forpag == 'E') {
         $forpag_text = 'EFECTIVO';
     } elseif ($forpag == 'C') {
         $forpag_text = 'CREDITO';
     } elseif ($forpag == 'T') {
         $forpag_text = 'TARJETA';
     }
    if ($delivery2 == 1) {
        $delivery = $delivery2;
    }
    $tt = "";
    $vt = "";
    $sql_datagen_det = "SELECT focuscotiz, mensaje FROM datagen_det";
    $result_datagen_det = mysqli_query($conexion, $sql_datagen_det);
    if (mysqli_num_rows($result_datagen_det)) {
        while ($row_datagen_det = mysqli_fetch_array($result_datagen_det)) {
            $focuscotiz = $row_datagen_det['focuscotiz'];
            $msj = $row_datagen_det['mensaje'];
        }
    }
    // Determinar cantidad de filas en temp venta
    $contador = 0;

    if (isset($_SESSION['arr_detalle_venta'])) {
        $arr_detalle_venta = $_SESSION['arr_detalle_venta'];
    } else {
        $arr_detalle_venta = array();
    }
    if (!empty($arr_detalle_venta)) {
        $contador = sizeof($arr_detalle_venta);
    }

    if ($msj <> "") {
    ?>
        <link href="css/scroll.css" rel="stylesheet" type="text/css" />
    <?php
    }
    $sql_cliente = "SELECT descli FROM cliente where codcli = '$cuscod'";
    $result_cliente = mysqli_query($conexion, $sql_cliente);
    if (mysqli_num_rows($result_cliente)) {
        while ($row_cliente = mysqli_fetch_array($result_cliente)) {
            $descli = $row_cliente['descli'];
        }
    }
    // echo 'descli  =' . $descli . "<br>";
    // echo 'cuscod  =' . $cuscod . "<br>";
    $_SESSION['venta'] = $invnum;
    $msn = isset($_REQUEST['msn']) ? $_REQUEST['msn'] : "";
    $cotizacions = isset($_REQUEST['cotizacions']) ? $_REQUEST['cotizacions'] : "";

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%04d", $c);
    }
    ?>
    <script>
        // Valida valor de cotizacion
        function cotiz() {
            var f = document.form1;
            if ((f.cotizacion.value == "") || (f.cotizacion.value == 0)) {
                alert("Ingrese un Valor Valido");
                f.cotizacion.focus();
                return;
            }
            f.method = "post";
            f.action = "asigna_cotiz.php";
            f.submit();
        }
        // Valida cuando usuario presiona ENTER
        function nums(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            /////F4/////
            if (key == 13) {
                cotiz();
            }
            return (key <= 13 || key == 37 || key == 39 || (key >= 48 && key <= 57));
        }
        // Abre ventana cuando presiona F11
        function abrir_index1(e) {
            tecla = e.keyCode;
            /////F11/////
            if (tecla == 122) {
                var popUpWin = 0;
                var left = 90;
                var top = 120;
                var width = 895;
                var height = 420;
                if (popUpWin) {
                    if (!popUpWin.closed)
                        popUpWin.close();
                }
                popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            }
        }

        function cc() {
            var f = document.form1;
            f.cotizacion.focus();
        }

        function cp() {
            var f = document.form1;
            alert("LA COTIZACION INGRESADA O YA SE ENCUENTRA REGISTRADA O NO EXISTE ");
            f.cotizacion.focus();
        }
        // Mostrar ventana de pendientes
        var popUpWin = 0;

        function cotizacion1() {
            ////boton///
            var left = 400;
            var top = 120;
            var width = 950;
            var height = 430;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

        function arqueo_caja() {
            ////boton///
            var left = 400;
            var top = 200;
            var width = 450;
            var height = 200;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('arqueo_caja/arqueo_caja.php?entrada=1', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }

        function arqueo_caja_no_cerraron_dias_antes(valor) {
            ////boton///
            var valor;
            var left = 400;
            var top = 200;
            var width = 450;
            var height = 380;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('arqueo_caja/arqueo_caja.php?entrada=3&id_arqueo=' + valor, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>

</head>

<?php

// echo 'arqueo  =' . $arqueo . "<br>";
// echo 'arqueo_arqueo_no_cerraron_dias_antes  =' . $arqueo_arqueo_no_cerraron_dias_antes . "<br>";
// echo 'msn  =' . $msn . "<br>";
// echo 'focuscotiz  =' . $focuscotiz . "<br>";
// echo 'contador  =' . $contador . "<br>";
// echo 'contador  =' . $contador . "<br>";
?>

<body onkeyup="abrir_index1(event)" <?php if (($arqueo == 0) && ($arqueo_arqueo_no_cerraron_dias_antes == 0)) { ?> onload="arqueo_caja()" ; <?php } elseif ($arqueo_arqueo_no_cerraron_dias_antes == 1) { ?> onload="arqueo_caja_no_cerraron_dias_antes(<?php echo $id_arqueo; ?>)" ; <?php } ?> <?php if ($msn == 1) { ?> onload="cp()" <?php } else {
                                                                                                                                                                                                                                                                                                                                            if ($focuscotiz == 1) {
                                                                                                                                                                                                                                                                                                                                                if (($contador == 0) || ($contador == '')) { ?> onload="cc()" <?php   }
                                                                                                                                                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                                                                                                                                                    } ?>>
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">

        <table width="100%" border="0">
            <tr>
                <td width="100%">

                    <table width="100%" style="margin-top:-25px;margin-bottom:-9px;" border="0">
                        <?php if ($msj <> "") { ?>
                            <tr>
                                <td width="100%" colspan='9'>
                                    <marquee direction=left height=15 onMouseOut=this.scrollAmount=4 onMouseOver=this.scrollAmount=0 scrollamount=4 width=100%>
                                        <span class="scroll_text1"><?php echo $msj ?></span>
                                    </marquee>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td width="3%" align="center"><strong>N. I.</strong></td>
                            <td width="7%">
                                <input class="inpu" style="background: #d7d7d7;" name="textfield" type="text" size="10" disabled="disabled" value="<?php echo formato($invnum); ?>" />
                            </td>
                            &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                            <td width="3%" align="left"><strong>FECHA</strong></td>
                            <td width="7%">
                                <input class="inpu" style="background: #d7d7d7;" name="textfield2" type="text" size="12" disabled="disabled" value="<?php echo fecha($invfec) ?>" />
                            </td>
                            &nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                            <td width="5%" align="left"><strong>FORMA DE PAGO</strong></td>
                            <td width="15%">
                                <input class="inpu" name="fpago" id="fpago_prueba" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="2" maxlength="1" value="<?php echo $forpag; ?>" readonly />
                                <label title="E = EFECTIVO / C = CREDITO / T = TARJETA " style="color:red;">
                                    <?php echo $forpag_text;?>
                                      &nbsp;&nbsp;&nbsp;
                                </label>
                                <strong>N&ordm; DIAS</strong>
                                <input class="inpu" name="ndias" type="text" id="ndias" onkeyup="cargarContenido()" value="<?php echo $ndias ?>" size="2" maxlength="3" />
                            </td>
                            <td width="7%">
                                <label for="delivery"><strong>DELIVERY</strong></label>
                                <input name="delivery" type="checkbox" id="delivery" value="1" <?php if ($delivery == 1) { ?>checked="checked" <?php } ?> onclick="Validardelivery();" />
                            </td>
                            <td width="36%">
                                <div align="right"><span class="blues"><b>&nbsp; <?php echo "USUARIO" . " " . $nomgrup; ?>:</b>&nbsp;<img src="../../../images/user.gif" width="15" height="16" /> <?php echo $nomusu ?></span></div>
                            </td>
                            <td width="12%" align="right"><span class="blues"><b style="font-size:11px;">&nbsp; &nbsp;SUCURSAL:&nbsp;<img src="../../../images/controlpanel.png" width="16" height="16" /><?php echo $nombre_local ?></span></b></td>
                        </tr>
                        <tr>
                            <td width="100%" colspan='9'>
                                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                            </td>
                        </tr>
                        <tr>
                            <td width="5%" colspan='2' align="center">
                                <font color="#FF0000" style="font-size:12px;"><strong>COTIZACION</strong></font>
                            </td>
                            <td width="95%" colspan='5'>

                                <?php
                                $cotiza = isset($_REQUEST['cotizacion']) ? $_REQUEST['cotizacion'] : "";
                                if ($n_cotizacion <> '0') {
                                    $cotiza = $n_cotizacion;
                                } else {
                                    $cotiza = $cotiza;
                                }
                                ?>
                                <input name="cotizacion" type="text" onkeypress="return nums(event);" size="15" placeholder="N&ordm; de cotizacion" maxlength="6" value="<?php
                                                                                                                                                                            if ($cotizacions <> '') {
                                                                                                                                                                                echo $cotizacions;
                                                                                                                                                                            } else if ($count == 0) {
                                                                                                                                                                                echo '';
                                                                                                                                                                            } else {
                                                                                                                                                                                echo $cotiza;
                                                                                                                                                                            }
                                                                                                                                                                            ?>" />&nbsp;
                                <img style="margin-bottom: -6px;" width="2%" height="2%" src="question.svg" title="Para asignar una cotizacion tienes que realizar primero uno en movimiento/cotizacion">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                                <input type="button" name="Submit" value="Asignar" onclick="cotiz();" class="modificar" />&nbsp; &nbsp;&nbsp;
                                <input type="button" name="Submit2" value="<?php echo 'Mostrar Cotizaciones ' ?>" onclick="cotizacion1();" class="imprimir" />
                            </td>
                            <td colspan='2'>
                                <?php if ($arqueo_bloqueo_1 == 1) { ?>
                                    <blink>
                                        <a style="color:red;font-size:15px;">Usted ya cerro su caja, no puede hacer mas ventas por el resto del dia.</a>
                                    </blink>
                                <?php } ?>
                            </td>
                        </tr>
                    </table>


                    <input name="tt" type="hidden" id="tt" value="" />
                    <input name="vt" type="hidden" id="vt" value="" />
                    <div style="margin-top:10px;" align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="100%">
                                <div class="embed-container">
                                    <iframe src="venta_index2.php" name="index1" width="100%" height="520" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
                                    </iframe>
                                </div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </form>
    <?php
    mysqli_free_result($result);
    mysqli_close($conexion);
    ?>
</body>

</html>