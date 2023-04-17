<?php
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
require_once('../../session_user.php');
require_once('session_ventas_temp.php');

$tventa = $_SESSION['tventa'];
$UsuarioPrincipal = $_SESSION['codigo_user'];

$sql = "SELECT * FROM venta2 where invnum = '$tventa'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $usecod = $row['usecod'];
    }
}

$sql = "SELECT * FROM usuario where usecod = '$usecod'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $codloc = $row['codloc'];
    }
}
$sql = "SELECT * FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc = $row['nomloc'];
    }
}

$_SESSION['UsuarioPrincipal'] = $UsuarioPrincipal;
$CVendedor = isset($_REQUEST['CodClaveVendedor']) ? $_REQUEST['CodClaveVendedor'] : "";
$tecKey = isset($_REQUEST['tecKey']) ? $_REQUEST['tecKey'] : ""; //F8,F9

if ($CVendedor <> "") {
    $sql1 = "SELECT usecod FROM usuario where claveventa = '$CVendedor'";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row1 = mysqli_fetch_array($result1)) {
            $CodUsuarioVendedor = $row1['usecod'];
        }
    }
    $_SESSION['codigo_user'] = $CodUsuarioVendedor;
    $usuario = $CodUsuarioVendedor;
}

mysqli_query($conexion, "UPDATE venta2 set usecod = '$usuario',tipteclaimpresa = '$tecKey' where invnum = '$tventa'");

$stockParaVenta = true;
$descProducto = "";

$sql = "SELECT * FROM detalle_venta2 where invnum = '$tventa'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($stockParaVenta && $row = mysqli_fetch_array($result)) {
        $codtemp = $row['codtemp'];
        $codpro = $row['codpro'];
        $canpro = $row['canpro'];
        $fraccion = $row['fraccion'];
        $factor = $row['factor'];
        $fraccion = $row['fraccion'];
        if ($fraccion == "F") {
            $cantemp = $canpro * $factor;
        } else {
            $cantemp = $canpro;
        }
        $sql2 = "SELECT stopro, factor, desprod, s000, s001, s002, s003, s004,
            s005, s006, s007, s008, s009, s010, s011, s012, s013, s014, s015, 
            s016, s017, s018, s019, s020
            FROM producto where codpro = '$codpro'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            if ($row2 = mysqli_fetch_array($result2)) {
                $stopro = $row2['stopro'];
                $factor2 = $row2['factor'];
                $desprod = $row2['desprod'];
                $s000 = $row2['s000'];
                $s001 = $row2['s001'];
                $s002 = $row2['s002'];
                $s003 = $row2['s003'];
                $s004 = $row2['s004'];
                $s005 = $row2['s005'];
                $s006 = $row2['s006'];
                $s007 = $row2['s007'];
                $s008 = $row2['s008'];
                $s009 = $row2['s009'];
                $s010 = $row2['s010'];
                $s011 = $row2['s011'];
                $s012 = $row2['s012'];
                $s013 = $row2['s013'];
                $s014 = $row2['s014'];
                $s015 = $row2['s015'];
                $s016 = $row2['s016'];
                $s017 = $row2['s017'];
                $s018 = $row2['s018'];
                $s019 = $row2['s019'];
                $s020 = $row2['s020'];

                if ($nomloc == "LOCAL0") {
                    $candisponible = $s000;
                } elseif ($nomloc == "LOCAL1") {
                    $candisponible = $s001;
                } elseif ($nomloc == "LOCAL2") {
                    $candisponible = $s002;
                } elseif ($nomloc == "LOCAL3") {
                    $candisponible = $s003;
                } elseif ($nomloc == "LOCAL4") {
                    $candisponible = $s004;
                } elseif ($nomloc == "LOCAL5") {
                    $candisponible = $s005;
                } elseif ($nomloc == "LOCAL6") {
                    $candisponible = $s006;
                } elseif ($nomloc == "LOCAL7") {
                    $candisponible = $s007;
                } elseif ($nomloc == "LOCAL8") {
                    $candisponible = $s008;
                } elseif ($nomloc == "LOCAL9") {
                    $candisponible = $s009;
                } elseif ($nomloc == "LOCAL10") {
                    $candisponible = $s010;
                } elseif ($nomloc == "LOCAL11") {
                    $candisponible = $s011;
                } elseif ($nomloc == "LOCAL12") {
                    $candisponible = $s012;
                } elseif ($nomloc == "LOCAL13") {
                    $candisponible = $s013;
                } elseif ($nomloc == "LOCAL14") {
                    $candisponible = $s014;
                } elseif ($nomloc == "LOCAL15") {
                    $candisponible = $s015;
                } elseif ($nomloc == "LOCAL16") {
                    $candisponible = $s016;
                } elseif ($nomloc == "LOCAL17") {
                    $candisponible = $s017;
                } elseif ($nomloc == "LOCAL18") {
                    $candisponible = $s018;
                } elseif ($nomloc == "LOCAL19") {
                    $candisponible = $s019;
                } elseif ($nomloc == "LOCAL20") {
                    $candisponible = $s020;
                }

                if ($cantemp > $candisponible) {
                    mysqli_query($conexion, "DELETE from detalle_venta2 where invnum = '$tventa' and codpro = '$codpro'");
                    $stockParaVenta = false;
                    $descProducto = $desprod;
                }
            }
        }
    }
}


//error_log("Producto: ". $descProducto);
//error_log("stockParaVenta: ". $stockParaVenta);

if (!$stockParaVenta) {
//    error_log("Ejecutando script");
    ?> 

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <title>IMPRESION DE VENTA</title>
            <style type="text/css">
                a:link {
                    color: #666666;
                }
                a:visited {
                    color: #666666;
                }
                a:hover {
                    color: #666666;
                }
                a:active {
                    color: #666666;
                }
                .Letras {font-size: <?php echo $fuente; ?>px;}
            </style>
            <SCRIPT LANGUAGE="JavaScript">
                alert("No hay suficiente stock del producto <?php echo $descProducto; ?>.");
                window.opener.location.reload(true);
                window.close();
            </script>
        </head>
        <body>	
        </body>
        <?php
//    error_log("Ejecutando script2");

        exit;
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

                <link href="css/ventas_index2.css" rel="stylesheet" type="text/css" />
                <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
                <title><?php echo $desemp ?></title>
                <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
                <link href="f9/css/autocomplete.css" rel="stylesheet" type="text/css" />
                <link href="../../archivo/css/select_cli.css" rel="stylesheet" type="text/css"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.core.css"  type="text/css" media="screen"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.theme.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.tabs.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.deshab.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery-ui.css" type="text/css" media="screen"/>
                <link rel="stylesheet" href="f9/jquery-ui/jquery.ui.autocomplete.css" type="text/css" media="screen"/>

                <script language="JavaScript" type="text/javascript" src="f9/jquery.js"></script>
                <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery-ui.min.js"></script>
                <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.core.js"></script>
                <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.widget.js"></script>
                <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.position.js"></script>
                <script language="JavaScript" type="text/javascript" src="f9/jquery-ui/jquery.ui.autocomplete.js"></script>
                <script type="text/javascript">
                function fc()
                {
                    document.form1.country.focus();
                }
                function cerrar_popup()
                {
                    window.close();
                }
                function escapes(e)
                {
                    tecla = e.keyCode;
                    if (tecla === 27)
                    {
                        window.close();
                    }
                    if (tecla === 13)
                    {
                        var f = document.form1;
                        var monto = f.monto_total.value;
                        var paga = f.pagacon.value;
                        var vuelto;
                        if (paga !== "")
                        {
                            vuelto = paga - monto;
                            if (vuelto < 0)
                            {
                                alert("El monto ingresado es incorrecto");
                                return;
                            }
                            f.vueltos.value = vuelto;
                        }
                        f.action = "imprimir_temp.php";
                        f.method = "post";
                        f.submit();
                    }
                }

                function enter(e)
                {
                    tecla = e.keyCode;
                    if (tecla === 13)
                    {
                        var f = document.form1;
                        f.pagacon.focus();
                    }
                }
                function sf()
                {
                    var f = document.form1;
                    f.correo.focus();
                }
                function calculo()
                {
                    var f = document.form1;
                    var monto = f.monto_total.value;
                    f.vuelto.value = f.pagacon.value - monto;
                }
                function grabar()
                {
                    var f = document.form1;
                    var monto = f.monto_total.value;
                    var paga = f.pagacon.value;
                    var vuelto;
                    if (paga !== "")
                    {
                        vuelto = paga - monto;
                        if (vuelto < 0)
                        {
                            alert("El monto ingresado es incorrecto");
                            return;
                        }
                        f.vueltos.value = vuelto;
                    }
                    f.action = "imprimir.php";
                    f.method = "post";
                    f.submit();
                }
                $(function ()
                {

                    $("#cliente").autocomplete({
                        source: "f9/ajax-list-countries.php",
                        minLength: 2,
                        select: function (event, ui) {
                            $('#cliente_ID').val(ui.item.id);
                            $('#correo').val(ui.item.Mail);
                            $('#ruc').val(ui.item.Ruc);
                        }
                    });
                });
                </script>
                <?php
                require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
                require_once('../../../funciones/functions.php'); //DESHABILITA TECLAS
                require_once('../../../funciones/highlight.php'); //ILUMINA CAJAS DE TEXTOS
                require_once('../../../funciones/botones.php'); //COLORES DE LOS BOTONES
                require_once("f9/funciones/call_combo.php");
                require_once("calcula_monto.php");
                $sqlVent = "SELECT invnum,nrovent,invfec,cuscod,usecod,codven,forpag,sucursal,fecven,correlativo FROM venta2 where usecod = '$usuario' and estado ='1' and invnum = '$venta'";
                $resultVent = mysqli_query($conexion, $sqlVent);
                if (mysqli_num_rows($resultVent)) {
                    while ($row = mysqli_fetch_array($resultVent)) {
                        $invnum = $row['invnum'];
                        $nrovent = $row['nrovent'];
                        $invfec = $row['invfec'];
                        $cuscod = $row['cuscod'];
                        $usecod = $row['usecod'];
                        $codven = $row['codven'];
                        $forpag = $row['forpag'];
                        $sucursal = $row['sucursal'];
                        $fecven = $row['fecven'];
                        $correlativo = $row['correlativo'];
                    }
                }
                $sqlSum = "SELECT SUM(pripro) FROM detalle_venta2 where invnum = '$invnum'";
                $resultSum = mysqli_query($conexion, $sqlSum);
                if (mysqli_num_rows($resultSum)) {
                    while ($row = mysqli_fetch_array($resultSum)) {
                        $monto = $row[0];
                    }
                }
                $sqlCli = "SELECT codcli,descli,email,ruccli, dnicli FROM cliente where codcli = '$cuscod'";
                $resultCli = mysqli_query($conexion, $sqlCli);
                if (mysqli_num_rows($resultCli)) {
                    while ($row = mysqli_fetch_array($resultCli)) {
                        $codcli = $row["codcli"];
                        $descli = $row["descli"];
                        $email = $row["email"];
                        $ruccli = $row["ruccli"];
                        $dnicli = $row["dnicli"];
                    }
                }

                $TicketDefecto = 0;
                $numCopias = 1;
                $sqlGen = "SELECT montoboleta,TicketDefecto, numerocopias FROM datagen"; ////por defecto 5
                $resultGen = mysqli_query($conexion, $sqlGen);
                if (mysqli_num_rows($resultGen)) {
                    while ($row = mysqli_fetch_array($resultGen)) {
                        $montoboleta = $row["montoboleta"];
                        $TicketDefecto = $row["TicketDefecto"];
                        $numCopias = $row["numerocopias"];
                    }
                }
                $sqlXComp = "SELECT imprapida FROM xcompa where codloc = '$sucursal'";
                $resultXComp = mysqli_query($conexion, $sqlXComp);
                if (mysqli_num_rows($resultXComp)) {
                    while ($row = mysqli_fetch_array($resultXComp)) {
                        $imprapida = $row["imprapida"]; ////puede ser 0 o 1 o ""
                    }
                }

                function formato($c) {
                    printf("%08d", $c);
                }
                ?>
        </head>
        <body onkeyup="escapes(event)" onload="sf();">
            <table width="868" height="535" border="1">
                <tr>
                    <td width="855" height="372" bgcolor="#FFFFCC">
                        <table width="481" border="0" align="center">
                            <tr>
                                <td width="398">
                                    <?php
                                    if (!$stockParaVenta) {
                                        echo "<center>
                            <font color='red' size='+2'>
                                <b>No hay suficiente stock del producto: </b></font>
                            <font color='red' size='+1'>
                                    <b>" . $descProducto . "</b></font><br />
                            <font color='red' size='+1'>
                                <b>Cantidad Actual disponible: " . $candisponible . "</b></font></center>";
                                        return;
                                    }
                                    $FactDefecto = 0;
                                    $BolDefecto = 0;
                                    $TickDefecto = 0;
                                    if ($TicketDefecto == 1) {
                                        $titulo = "TICKET DE VENTA";
                                        $color = "#00CC00";
                                        $FactDefecto = 0;
                                        $BolDefecto = 0;
                                        $TickDefecto = 1;
                                    } else {
                                        $FactDefecto = 0;
                                        $BolDefecto = 1;
                                        $TickDefecto = 0;
                                        $titulo = "COMPROBANTE";
                                        $color = "#FF0000";
                                    }
                                    ?>
                                    <center><font color="<?php echo $color; ?>" size="+4"><b><?php echo $titulo; ?></b></font></center>
                                </td>
                            </tr>
                        </table>
                        <br /><br /><br />
                        <table width="512" height="204" border="0" align="center" class="tabla2">
                            <tr>
                                <td width="504"><u><strong>IMPRESION DE VENTAS</strong></u><br>
                                        <table width="494" border="0" align="center">
                                            <tr>
                                                <td width="71"><strong>N&ordm; DE VENTA</strong> </td>
                                                <td width="263"><?php echo formato($correlativo); ?></td>
                                                <td width="51"><strong>FECHA</strong></td>
                                                <td width="91"><?php echo $invfec ?></td>
                                            </tr>
                                        </table>
                                        <form id="form1" name="form1">
                                            <input type="hidden" name="CVendedor" value="<?php echo $CVendedor; ?>"/>
                                            <table width="494" border="0" align="center">
                                                <tr>
                                                    <td valign="top">BUSCAR</td>
                                                    <td valign="top">
                                                        <input value="<?php echo $descli; ?>" type="text" style="width: 80%" name="cliente" id="cliente" autofocus/>
                                                        <input name="cliente_ID" id="cliente_ID" value="<?php echo $codcli; ?>" type="hidden"/>
                                                        <input name="val" type="hidden" id="val" value="1" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="ruc" id="ruc" style="width: 80%" value="<?php echo $ruccli; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">ANOTACIÃN</td>
                                                    <td>
                                                        <input name="anotacion" id="anotacion" style="width: 80%" maxlength="15" type="text"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">MAIL</td>
                                                    <td>
                                                        <input name="correo" id="correo" style="width: 80%" type="text" value="<?php echo $email; ?>"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>TIPO DOCUMENTO</td>
                                                    <td>
                                                        <?php
                                                        if (strlen($ruccli) >= 11) {
                                                            ?>
                                                            <input type="radio" value="1" checked name="rd"/><span style='color:red;font-size: 18px;'><b>FACTURA</b></span>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input type="radio" value="4" name="rd" <?php if ($TickDefecto == 1) { ?>checked<?php } ?>/><span style='color:green;font-size: 18px;'><b>TICKET</b></span>
                                                            <input type="radio" <?php
                                                            if ($dnicli == "") {
                                                                echo "disabled ";
                                                            }
                                                            ?>
                                                                   value="2" name="rd" <?php if ($BolDefecto == 1) { ?>checked<?php } ?>/><span style='color:blue;font-size: 18px;'><b>BOLETA</b></span>
                                                            <input type="radio" disabled value="1" name="rd" <?php if ($FactDefecto == 1) { ?>checked<?php } ?>/><span style='color:red;font-size: 18px;'><b>FACTURA</b></span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>NUMERO DE COPIAS</td>
                                                    <td>
                                                        <input type="radio" value="1" name="numCopias" <?php if ($numCopias == 1) { ?>checked<?php } ?>/><span><b>1</b></span>
                                                        <input type="radio" value="2" name="numCopias" <?php if ($numCopias == 2) { ?>checked<?php } ?>/><span><b>2</b></span>
                                                        <input type="radio" value="3" name="numCopias" <?php if ($numCopias == 3) { ?>checked<?php } ?>/><span><b>3</b></span>
                                                        <input type="radio" value="4" name="numCopias" <?php if ($numCopias == 4) { ?>checked<?php } ?>/><span><b>4</b></span>
                                                    </td>
                                                </tr>
                                                <!--<tr>
                                                    <td width="101" height="22"><div align="right"><strong>NRO DOCUMENTO</strong></div></td>
                                                    <td width="383">
                                                      <input name="factura" type="text" class="cant" id="factura" onkeypress="enter(event);" value="" size="42"/>                </td>
                                                </tr>-->
                                                <tr>
                                                    <td height="22"><div align="right"><strong>PAG&Oacute; CON </strong></div></td>
                                                    <td>
                                                        <input name="pagacon" type="text" class="cant" id="pagacon" onkeypress="return decimal(event)" onkeyup="calculo();" size="10"/>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="22"><div align="right"><strong>VUELTO</strong></div></td>
                                                    <td>
                                                        <input name="vuelto" type="text" class="cant1" id="vuelto" onkeypress="return decimal(event)" disabled="disabled" size="10"/>
                                                        <input name="monto_total" type="hidden" id="monto_total" value="<?php echo $monto_total; ?>"/>
                                                        <input name="vueltos" type="hidden" id="vueltos"/>
                                                        <input type="button" name="Submit" value="GRABAR" onclick="grabar();"/>                 
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
    </html>
