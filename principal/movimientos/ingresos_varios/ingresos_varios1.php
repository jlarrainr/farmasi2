<?php
include('../../session_user.php');
$sum33 = 0;
$sum1 = 0;
$sum2 = 0;
$filtro = isset($_REQUEST['filtro']) ? ($_REQUEST['filtro']) : "";
$valor = isset($_REQUEST['valor']) ? ($_REQUEST['valor']) : "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css2/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/select.css" rel="stylesheet" type="text/css" />
    <link href="../../../funciones/alertify/alertify.min.css" rel="stylesheet" />
    <script src="../../../funciones/alertify/alertify.min.js"></script>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("ajax_compras.php"); //FUNCIONES DE AJAX PARA COMPRAS Y SUMAR FECHAS
    require_once("functions.php"); //FUNCIONES DE ESTA PANTALLA
    require_once("../../local.php"); //LOCAL DEL USUARIO
    require_once '../../../textos_generales.php';
    //error_log("En Ingresos Varios 1");
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //error_log("usuario".$usuario);
    $sql = "SELECT invnum FROM movmae where usecod = '$usuario' and proceso = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum = $row["invnum"];  //codigo
        }
    }
    //error_log("invnum".$invnum);
    $_SESSION['ingresos_val'] = $invnum;
    //error_log("Session 1: ".$_SESSION['ingresos_val']);
    ////////////////////////////////////////////////////////////////////////////////////////////////
    $sql = "SELECT invnum,invfec,numdoc,refere,codusu,sucursal1 FROM movmae where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $cod = $row['invnum'];  //codgio
            $fecha = $row['invfec'];
            $numdoc = $row['numdoc'];
            $refere = $row['refere'];
            $codusu = $row['codusu'];
            $sucursal1 = $row['sucursal1'];
        }
    }

    function formato($c)
    {
        printf("%08d", $c);
    }

    function formato1($c)
    {
        printf("%06d", $c);
    }
    $sql = "SELECT invnum FROM movmae where invnum = '$invnum'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $invnum_filtro = $row["invnum"];  //codigo

        }
    }
    $sql1 = "SELECT nomusu FROM usuario where usecod = '$usuario'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $user = $row1['nomusu'];
        }
    }
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
    $sql = "SELECT count(*) FROM tempmovmov where invnum = '$invnum' and qtypro <> '0' or qtyprf <> ''";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $count2 = $row[0];
        }
    } else {
        $count2 = 0;
    }

    $sql1 = "SELECT codpro,pripro,costre,prisal FROM tempmovmov where invnum = '$invnum'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $codpro = $row1['codpro'];
            $pripro = $row1['pripro'];
            $costre = $row1['costre'];
            $prisal = $row1['prisal'];
            $sum1 = $sum1 + $pripro;
            $sum2 = $sum2 + $prisal;
        }
        //                $sum1 = $numero_formato_frances = number_format($sum1, 2, '.', ',');
        $sum2 = $numero_formato_frances = number_format($sum2, 2, '.', ',');
    } else {
    }
    ?>
    <script>
        function mensaje_error() {
            ventana = confirm('Tienes el mismo usuario abierto en otro computador esta lista se eliminara');
            if (ventana) {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                // f.action = "../ventas/logout.php";
                f.action = "ingresos_varios_del.php";
                f.submit();
            } else {
                var f = document.form1;
                f.method = "POST";
                f.target = "_top";
                // f.action = "../ventas/logout.php";
                f.action = "ingresos_varios_del.php";
                f.submit();
            }
        }

        function prints_Ingresos_Varios(valor) {
            var f = document.form1;
            f.action = "";
            if (f.referencia.value === "") {
                alert("Ingrese una referencia");
                f.referencia.focus();
                return;
            }
            if (f.mont2.value === "") {
                alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                f.mont2.focus();
                return;
            }
            var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
            window.open("imprimir_ingresos_varios.php?cod=" + valor, opciones);
            //return false;
        }

        function cancelar() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "ingresos_varios_del.php";
            f.submit();
        }

        function compras1(e) {
            tecla = e.keyCode;
            var f = document.form1;
            var a = f.carcount.value;
            var b = f.carcount1.value;
            if (tecla === 119) {
                if ((a === 0) || (b > 0)) {
                    alert('No se puede grabar este Documento');
                    return;
                } else {
                    var f = document.form1;
                    if (f.referencia.value === "") {
                        alert("Ingrese una referencia");
                        f.referencia.focus();
                        return;
                    }
                    if (f.mont2.value === "") {
                        alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                        f.mont2.focus();
                        return;
                    }
                    if (confirm("ï¿½Desea Grabar esta informacion?")) {
                        alert("EL NUMERO REGISTRADO ES <?php echo $numdoc ?>");
                        f.method = "POST";
                        f.target = "_top";
                        f.action = "ingresos_varios1_reg.php";
                        f.submit();
                    }
                }
            }
            if (tecla === 120) {
                if ((a === 0) || (b > 0)) {
                    alert('No se puede realizar la impresiï¿½n de este Documento');
                    return;
                } else {
                    var f = document.form1;
                    if (f.referencia.value === "") {
                        alert("Ingrese una referencia");
                        f.referencia.focus();
                        return;
                    }
                    if (f.mont2.value === "") {
                        alert("El sistema arroja un TOTAL = a 0. Revise por Favor!");
                        f.mont2.focus();
                        return;
                    }
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "ingresos_varios1op_reg.php";
                    f.submit();

                }
            }
        }
    </script>
    <style>
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

<body onkeyup="compras1(event)" <?php if (($invnum_filtro == 0) || ($invnum_filtro == '') || ($filtro == 1)) { ?> onLoad="mensaje_error();" <?php } ?>>
    <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
        <?php if ($valor == 1) {
            echo '<script> alertify.alert("<h1>ALERTA DE LOTE </h1>", "<h3> Este lote ya existe, se mantendr\u00E1 la fecha de vencimiento anteriormente registrada.</h3> " )</script>';
        } elseif ($valor == 2) {
            echo '<script> alertify.alert("<h1>ALERTA DE LOTE</h1> ", "<h3> Este lote ya esta asignado a un producto de esta lista, no puede haber 2 productos con el mismo lote, el producto sera eliminado.</h3>" )</script>';
        }
        ?>
        <table width="100%" border="0">
            <tr>
                <td width="958">
                    <table width="100%" border="0">
                        <tr>
                            
                            <td width="10"><strong>NUMERO DOCUMENTO</strong></td>
                            <td width="101"><input style="border-radius:5px;background-color: #dbdbd7;" name="textfield" type="text" size="15" disabled="disabled" value="<?php echo formato($numdoc) ?>" /></td>
                            <td width="11">
                                <div align="right"><strong>FECHA</strong></div>
                            </td>
                            <td width="129"><input style="border-radius:5px;background-color: #dbdbd7;" name="textfield2" type="text" size="15" disabled="disabled" value="<?php echo fecha($fecha) ?>" /></td>
                           
                            <!--<td width="302">
                                <div align="center">
                                  <input name="first" type="button" id="first" value="Primero" class="primero" disabled="disabled"/>
                                  <input name="prev" type="button" id="prev" value="Anterior" class="anterior" disabled="disabled"/>
                                  <input name="next" type="button" id="next" value="Siguiente" class="siguiente" disabled="disabled"/>
                                  <input name="fin" type="button" id="fin" value="Ultimo" class="ultimo" disabled="disabled"/>
                                </div>
                              </td>-->

                            <td width="606"><label>
                                    <div align="right">
                                        <!-- <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?> onclick="prints_Ingresos_Varios(<?php echo $invnum; ?>);"/>
                                          <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                                          <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>-->
                                        <input name="carcount" type="hidden" id="carcount" value="<?php echo $count ?>" />
                                        <input name="carcount1" type="hidden" id="carcount1" value="<?php echo $count1 ?>" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
                                        <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
                                        <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0) || ($count1 > 0) || ($invnum_filtro == 0) || ($invnum_filtro == '') || ($filtro == 1)) { ?>disabled="disabled" <?php } ?> />
                                        <input name="ext" type="button" id="ext" value="Cancelar" onclick="cancelar()" class="cancelar" />
                                    </div>
                                </label>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                   

                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="76" class="LETRA">REFERENCIA</td>
							<td>
								<input name="referencia" type="text" id="referencia" size="140" onkeyup="cargarContenido();this.value = this.value.toUpperCase();" value="<?php echo $refere; ?>" placeholder="<?php echo TEXT_PLACEHOLDER_REFERENCIA; ?>" />
							</td>
							<td width="436">
								<div align="right" class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></div>
							</td>
							<td width="134">
								<div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <?php echo $nombre_local ?></span> </div>
							</td>

						</tr>
					</table>

                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0">
                        <tr>
                            <td width="948">
                                <iframe src="ingresos_varios2.php" name="iFrame1" width="100%" height="218" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0">
                                </iframe>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0">
                        <tr>
                            <td width="955">
                                <iframe src="ingresos_varios3.php" name="iFrame2" width="100%" height="350" scrolling="Automatic" frameborder="0" id="iFrame2" allowtransparency="0"> </iframe>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                    <table width="100%" border="0" align="center">
                        <tr>
                            <td width="72">
                                <div align="right"></div>
                            </td>
                            <td width="130">&nbsp;</td>
                            <td width="49">
                                <div align="right"></div>
                            </td>
                            <td width="130">&nbsp;</td>
                            <td width="49">
                                <div align="right"></div>
                            </td>

                            <!--<td width="50"><div align="right"><strong>PRECIO PROMEDIO</strong> </div></td>-->
                            <!--                                <td width="23">
                                    <div align="left">
                                        <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="10" value="<?php if ($count > 0) { ?> <?php echo $sum1 ?> <?php } else { ?>0.00<?php } ?>"/>
                                    </div></td>-->
                            <td width="5">
                                <div align="right"><strong>TOTAL</strong></div>
                            </td>
                            <td width="58">
                                <div align="left">
                                    <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="10" value="<?php if ($count > 0) { ?> <?php echo $sum2 ?> <?php } else { ?>0.00<?php } ?>" />
                                </div>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                    <br>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>