<?php
include('../../session_user.php');
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
$venta = $_SESSION['cotiz'];
$sql = "SELECT invnum,cuscod,invfec,ndias FROM cotizacion where usecod = '$usuario' and estado ='1'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $invnum = $row['invnum'];
        $cuscod = $row['cuscod'];
        $invfec = $row['invfec'];
        $venta = $invnum;
        $ndias = $row['ndias'];
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Documento sin t&iacute;tulo</title>
        <link href="css/ventas_index1.css" rel="stylesheet" type="text/css" />
        <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
        <link href = "../../../funciones/alertify/alertify.min.css" rel = "stylesheet" />
            <script src = "../../../funciones/alertify/alertify.min.js"></script>
        <?php
        require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS

        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
        require_once("funciones/ventas_index1/funct_principal.php"); //IMPRIMIR-NUME
        require_once("../../local.php"); //LOCAL DEL USUARIO
        require_once("ajax_forma_pago.php");  //FUNCIONES DE AJAX PARA VENTAS
        require_once("funciones/datos_generales.php"); //FUNCIONES DE AJAX PARA VENTAS
        require_once("funciones/ventas_index1.php"); //FUNCIONES DE ESTA PANTALLA
        require_once('calcula_monto.php');    //CALCULO DE LOS MONTOS POR LA VENTA
////////////////////////////////////////////////////////////////////////////////////////////////

        $sql_usuario = "SELECT nomusu,codgrup FROM usuario where usecod = '$usuario'";
        $result_usuario = mysqli_query($conexion, $sql_usuario);
        if (mysqli_num_rows($result_usuario)) {
            while ($row_usuario = mysqli_fetch_array($result_usuario)) {
                $nomusu = $row_usuario['nomusu'];
                $codgrup = $row_usuario['codgrup'];
            }
        }
        $sql_grupo_user = "SELECT nomgrup FROM grupo_user  where codgrup = '$codgrup'";
        $result_grupo_user = mysqli_query($conexion, $sql_grupo_user);
        if (mysqli_num_rows($result_grupo_user)) {
            while ($row_grupo_user = mysqli_fetch_array($result_grupo_user)) {
                $nomgrup = $row_grupo_user['nomgrup'];
            }
        }
        $correlativo = 1;
        $sql = "SELECT correlativo FROM venta where sucursal = '$codloc' order by correlativo desc limit 1";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result)) {
            while ($row = mysqli_fetch_array($result)) {
                $correlativo = $row['correlativo'] + 1;
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
        $_SESSION['cotiz'] = $invnum;

        function formato($c) {
            printf("%08d", $c);
        }

        function formato1($c) {
            printf("%04d", $c);
        }
        ?>
        <script>
            function abrir_index1(e)
            {
                tecla = e.keyCode;
                /////F11/////
                if (tecla == 122)
                {
                    var popUpWin = 0;
                    var left = 90;
                    var top = 120;
                    var width = 895;
                    var height = 420;
                    if (popUpWin)
                    {
                        if (!popUpWin.closed)
                            popUpWin.close();
                    }
                    popUpWin = open('venta_index2_incentivo.php', 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,minimizable = no, resizable=no,copyhistory=yes,width=' + width + ',height=' + height + ',left=' + left + ', top=' + top + ',screenX=' + left + ',screenY=' + top + '');
                }
            }

        </script>
    </head>
    <body onkeyup="abrir_index1(event)">
        <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)">
            <table width="100%" border="0">
                <tr>
                    <td width="100%">

                        <table width="100%" border="0" style="margin-top: -24px;">
                            <?php if ($msj <> "") { ?>
                                <tr>
                                    <td width="100%" colspan='8'>
                                        <marquee direction=left height=15 onMouseOut=this.scrollAmount =4 onMouseOver=this.scrollAmount =0 scrollamount=4 width=100%>
                                            <span class="scroll_text1"><?php echo $msj ?></span> 
                                        </marquee>		
                                    </td>
                                </tr>

                            <?php } ?>
                            <tr>
                                <td width="100%" colspan='8'  align="center" bordercolor="#FFCC00" bgcolor="#CCFF33"style="font-weight:900;color:#ff0000;font-size:17px;font-family: "Trebuchet MS", Verdana, Arial, Helvetica, sans-serif;">
                                    <div align="center" > <sctrong><blink>MODULO DE COTIZACION</blink></sctrong></div>   
                                </td>

                            </tr>
                            <tr>
                                <td width="4%" align="center"><strong>N. I.</strong></td>
                                <td width="8%">
                                    <input class="inpu" style="background: #d7d7d7;" name="textfield" type="text" size="10" disabled="disabled" value="<?php echo formato($invnum); ?>"/>
                                </td>
                                &nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;
                                <td width="4%" align="left"><strong>FECHA</strong></td>
                                <td width="36%">
                                    <input class="inpu" style="background: #d7d7d7;" name="textfield2" type="text" size="12" disabled="disabled" value="<?php echo fecha($invfec) ?>"/></td>
                                &nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;
                                <!--<td width="8%" align="left"><strong>FORMA DE PAGO</strong></td>
                                <td width="20%">
                                    <input  class="inpu" name="fpago" type="text" onkeypress="return forma_pago(event);" onkeyup="cargarContenido()" size="1" maxlength="1" value="<?php echo $forpag ?>"/>
                                    (E, C, T)	&nbsp;&nbsp;&nbsp;
                                    <strong>N&ordm; DIAS</strong>
                                    <input class="inpu" name="ndias" type="text" id="ndias" onkeyup="cargarContenido()" value="<?php echo $ndias ?>" size="2" maxlength="3"/>
                                </td>-->

                                <td width="40%">
                                    <div align="right"><span class="blues"><b>&nbsp; <?php echo "USUARIO" . " " . $nomgrup; ?>:</b> <?php echo $nomusu ?></span></div>
                                </td>
                                <td width="8%"  align="right"><span class="blues"><b style="font-size:11px;">&nbsp; &nbsp;SUCURSAL:&nbsp;<?php echo $nombre_local ?></span></b></td>
                            </tr>
                        </table>


                        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                        <table width="100%" border="0">
                            <tr>
                                <td width="100%">
                                    <iframe src="venta_index2.php" name="index1" width="100%" height="420" scrolling="Automatic" frameborder="0" id="index1" allowtransparency="0">
                                    </iframe>			  
                                </td>
                            </tr>
                        </table>
                        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                        <table width="100%" border="0" align="center">
                            <tr>
                               <!-- <td width="10%">
                                    <div align="right" class="LETRA">MONTO BRUTO </div>
                                </td>
                                <td width="10%">
                                    <input name="mont1" class="sub_totales" type="text" id="mont1" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($mont_bruto, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
                                </td>
                                <td width="10%">
                                    <div align="right" class="LETRA">DCTO</div>
                                </td>
                                <td width="10%">
                                    <input name="mont2" class="sub_totales" type="text" id="mont2" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($total_des, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>" />
                                </td>
                                <td width="10%">
                                    <div align="right" class="LETRA">V. VENTA </div>
                                </td>
                                <td width="10%">
                                    <input name="mont3" class="sub_totales" type="text" id="mont3" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($valor_vent1, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>"/>
                                </td>
                                <td width="10%">
                                    <div align="right" class="LETRA">IGV</div>
                                </td>
                                <td width="10%">
                                    <input name="mont4" class="sub_totales" type="text" id="mont4" onclick="blur()" size="15" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($sum_igv, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>"/>
                                </td>-->
                                <td width="90%">
                                    <div align="right" class="LETRA">NETO</div>
                                </td>
                                <td width="10%">
                                    <div align="right">
                                        <input name="mont5" class="monto_tot" type="text" id="mont5" onclick="blur()" size="8" value="<?php if ($count2 > 0) { ?> <?php echo $numero_formato_frances = number_format($monto_total, 2, '.', ' '); ?> <?php } else { ?>0.00<?php } ?>"/>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /> </div>
                       <!-- <br />
                        <table width="100%" height="30" border="0" align="center" class="tabla2">
                            <tr>
                                <td width="100%" valign="middle"><div align="right">

                                        <input name="nuevo" type="button" id="nuevo" value="Nuevo" class="nuevo" disabled="disabled"/>
                                        <input name="modif" type="button" id="modif" value="Modificar" class="modificar" disabled="disabled"/>
                                        <input name="documento" type="hidden" id="documento" value="<?php echo $nrovent ?>" />
                                        <input name="cod" type="hidden" id="cod" value="<?php echo $invnum ?>" />
                                        <input name="sum33" type="hidden" id="sum33" value="<?php echo $sum33 ?>" />
                                        <input name="save" type="button" id="save" value="Grabar" onclick="grabar1()" class="grabar" <?php if (($count == 0) || ($count1 > 0)) { ?>disabled="disabled" <?php } ?>/>
                                        <input name="ext" type="button" id="ext" value="Buscar" onclick="buscar()" class="buscar"/>
                                        <input name="ext3" type="button" id="ext3" value="Cancelar" onclick="cancelar()" class="cancelar"/>
                                        <input name="ext2" type="button" id="ext2" value="Salir" onclick="salir1()" class="salir"/>
                                        <input name="printer" type="button" id="printer" value="Imprimir" class="imprimir" onclick="imprimir()"/>
                                    </div>
                                </td>
                            </tr>
                        </table>-->
                        
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
