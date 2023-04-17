<?php
require_once('../../session_user.php');
$tventa = $_SESSION['tventa'];
$forpag = "";
$cotizacion = isset($_REQUEST['cotizacion']) ? $_REQUEST['cotizacion'] : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <?php
    require_once('../../../conexion.php');
    require_once('../../../titulo_sist.php');
    require_once('../../../convertfecha.php');
    require_once('../../../funciones/highlight.php');
    require_once('../../../funciones/botones.php');
    require_once('ajax_forma_pago.php');
    require_once('../../local.php');
    require_once('calcula_monto_temp.php');

    function numberOfWeek($dia, $mes, $ano)
    {
        $Hora = date("H");
        $Min = date("i");
        $Sec = date("s");
        $fecha = mktime($Hora, $Min, $Sec, $mes, 1, $ano);
        $numberOfWeek = ceil(($dia + (date("w", $fecha) - 1)) / 7);
        return $numberOfWeek;
    }

    // Lee los datos de la nueva venta del usuario
    if (isset($_SESSION['tventa'])) {
        $sessionVenta = $_SESSION['tventa'];
        $sql = "SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias FROM venta2 where invnum = '$sessionVenta' and usecod = '$usuario' and estado ='1'";
    } else {
        // Tomar datos para la venta (local, cliente, numero de venta, correlativo)
        $sql = "SELECT codloc FROM usuario where usecod = '$usuario'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codloc = $row['codloc'];
            }
        }
        $sql = "SELECT codcli FROM cliente where descli = 'PUBLICO EN GENERAL'";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $codcli = $row['codcli'];
            }
        }
        $date = date("Y-m-d");

        $fecha = explode("-", $date);
        $daysem = $fecha[2];
        $messem = $fecha[1];
        $yearsem = $fecha[0];
        $correlativo = 1;
        $sql = "SELECT correlativo FROM venta2 where sucursal = '$codloc' order by correlativo desc limit 1";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $correlativo = $row['correlativo'] + 1;
            }
        }
        $semana = numberOfWeek($daysem, $messem, $yearsem);
        mysqli_query($conexion, "INSERT INTO venta2 (nrovent,invfec,usecod,cuscod,forpag,estado,sucursal,tipdoc,correlativo,semana,nrofactura) values ('$correlativo','$date','$usuario','$codcli','E','1','$codloc','2','$correlativo','$semana','')");

        $lastVentaId = mysqli_insert_id($conexion);

        $_SESSION['tventa'] = $lastVentaId;
        //	error_log('==================');
        //	error_log('Creando la venta '.$lastVentaId);
        //	error_log('==================');
        $sql = "SELECT invnum,cuscod,invfec,nrovent,correlativo,ndias FROM venta2 where invnum = '$lastVentaId' and usecod = '$usuario' and estado ='1'";
    }

    //error_log("Obteniendo datos de venta");
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row['invnum'];
            $cuscod = $row['cuscod'];
            $invfec = $row['invfec'];
            $nrovent = $row['nrovent'];
            $correlativo = $row['correlativo'];
            $ndias = $row['ndias'];
        }
    }
    //error_log($invnum);
    //error_log($cuscod);
    $tt = "";
    $vt = "";
    $sql = "SELECT focuscotiz FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $focuscotiz = $row['focuscotiz'];
        }
    }
    // Determinar cantidad de filas en temp_venta
    $contador = 0;

    //$sql="SELECT count(invnum) FROM temp_venta where invnum = '$invnum'";
    $sql = "SELECT count(invnum) FROM detalle_venta2 where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $contador = $row[0];
        }
    }

    $sql = "SELECT mensaje FROM datagen_det";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $msj = $row['mensaje'];
        }
    }
    if ($msj <> "") {
    ?>
        <link href="css/scroll.css" rel="stylesheet" type="text/css" />
    <?php
    }
    $sql = "SELECT descli FROM cliente where codcli = '$cuscod'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $descli = $row['descli'];
        }
    }
    $_SESSION['tventa'] = $invnum;
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
                popUpWin = open('venta_index_t2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
            }
        }

        function cc() {
            var f = document.form1;
            f.cotizacion.focus();
        }

        function cp() {
            var f = document.form1;
            alert("LA COTIZACION INGRESADA YA SE ENCUENTRA REGISTRADA");
            f.cotizacion.focus();
        }
        // Mostrar ventana de pendientes
        var popUpWin = 0;

        function cotizacion1() {
            ////boton///
            var left = 90;
            var top = 120;
            var width = 460;
            var height = 300;
            if (popUpWin) {
                if (!popUpWin.closed)
                    popUpWin.close();
            }
            popUpWin = open('pendientes.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
        }
    </script>
</head>

<body onkeyup="abrir_index1(event)" <?php if ($msn == 1) { ?>onload="cp()" <?php
                                                                        } else {
                                                                            if ($focuscotiz == 1) {
                                                                                if (($contador == 0) || ($contador == '')) {
                                                                            ?>onload="cc()" <?php
                                                                                }
                                                                            }
                                                                        }
                                ?>>
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
        <table width="968" border="0">
            <tr>
                <td width="958">
                    <?php
                    if ($msj <> "") {
                    ?>
                        <table width="<?php if ($resolucion == 1) { ?>700<?php } else { ?> 954<?php } ?>" border="0">
                            <tr>
                                <td>
                                    <marquee direction=left height=15 onMouseOut=this.scrollAmount=4 onMouseOver=this.scrollAmount=0 scrollamount=4 width=618>
                                        <span class="scroll_text1"><?php echo $msj ?></span>
                                    </marquee>
                                </td>
                            </tr>
                        </table>
                    <?php
                    }
                    ?>
                    <table width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>954<?php } ?>" border="0">
                        <tr>
                            <td width="58">NUMERO</td>
                            <td width="<?php if ($resolucion == 1) { ?>60<?php } else { ?>90<?php } ?>">
                                <input name="textfield" type="text" size="<?php if ($resolucion == 1) { ?>7<?php } else { ?> 12<?php } ?>" disabled="disabled" value="<?php echo formato($correlativo); ?>" /></td>
                            <td width="<?php if ($resolucion == 1) { ?>37<?php } else { ?>40<?php } ?>">FECHA</td>
                            <td width="<?php if ($resolucion == 1) { ?>80<?php } else { ?>114<?php } ?>">
                                <input name="textfield2" type="text" size="<?php if ($resolucion == 1) { ?>10<?php } else { ?> 12<?php } ?>" disabled="disabled" value="<?php echo fecha($invfec) ?>" /></td>
                            <td width="<?php if ($resolucion == 1) { ?>90<?php } else { ?>93<?php } ?>">FORMA DE PAGO</td>
                            <td width="<?php if ($resolucion == 1) { ?>270<?php } else { ?>340<?php } ?>">
                                <input name="fpago" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="<?php if ($resolucion == 1) { ?>1<?php } else { ?> 1<?php } ?>" maxlength="1" value="<?php echo $forpag ?>" />
                                (E = EFECTIVO, C = CREDITO, T = TARJETA)
                                <strong>Nï¿½ DIAS</strong>
                                <input name="ndias" type="text" id="ndias" onkeyup="cargarContenido()" value="<?php echo $ndias ?>" size="<?php if ($resolucion == 1) { ?>1<?php } else { ?> 2<?php } ?>" maxlength="3" />
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>120<?php } else { ?>189<?php } ?>">
                                <div align="right"><span class="blues"><strong>LOCAL:</strong> <?php echo $nombre_local ?></span></div>
                            </td>
                        </tr>
                    </table>

                    <table width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>954<?php } ?>" border="0">
                        <tr>
                            <td width="56">VENDEDOR</td>
                            <td width="<?php if ($resolucion == 1) { ?>240<?php } else { ?>300<?php } ?>">
                                <input name="textfield232" type="text" size="<?php if ($resolucion == 1) { ?>30<?php } else { ?> 50<?php } ?>" disabled="disabled" value="<?php echo $user ?>" /></td>
                            <td width="<?php if ($resolucion == 1) { ?>50<?php } else { ?>120<?php } ?>">
                                <div align="left"><span class="blues"><b>FECHA:</b> <?php echo date('d/m/Y'); ?></span></div>
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>50<?php } else { ?>418<?php } ?>">
                                <strong>
                                    <font color="#FF0000">Cotizacion</font>
                                </strong>
                                <?php $cotiza = isset($_REQUEST['cotizacion']) ? $_REQUEST['cotizacion'] : "";
                                ?>
                                <input name="cotizacion" type="text" onkeypress="return nums(event);" size="10" maxlength="6" value="<?php
                                                                                                                                        if ($cotizacions <> '') {
                                                                                                                                            echo $cotizacions;
                                                                                                                                        } else {
                                                                                                                                            echo $cotiza;
                                                                                                                                        }
                                                                                                                                        ?>" />
                                <input type="button" name="Submit" value="Asignar" onclick="cotiz();" />
                                <input type="button" name="Submit2" value="Mostrar Cotizaciones" onclick="cotizacion1();" />
                            </td>
                            <td width="<?php if ($resolucion == 1) { ?>319<?php } else { ?>60<?php } ?>">
                                <div align="right"><span class="blues"><b>USUARIO:</b> <?php echo formato1($usuario) ?></span></div>
                            </td>
                        </tr>
                    </table>

                    <input name="tt" type="hidden" id="tt" value="" />
                    <input name="vt" type="hidden" id="vt" value="" />
                    <div align="center"><img src="../../../images/line2.png" width="950" height="4" /></div>
                    <table width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>954<?php } ?>" border="0">
                        <tr>
                            <td width="<?php if ($resolucion == 1) { ?>715<?php } else { ?>948<?php } ?>">
                                <iframe src="venta_index_t2.php" name="index1" width="<?php if ($resolucion == 1) { ?>720<?php } else { ?>954<?php } ?>" height="495" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
                                </iframe>
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