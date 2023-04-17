<?php
require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
include('../../session_user.php');
include('../../local.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tabla2.css" rel="stylesheet" type="text/css" />
    <link href="../../select2/css/select2.min.css" rel="stylesheet" />

    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>
    <?php
    require_once("../../../funciones/highlight.php"); //ILUMINA CAJAS DE TEXTOS
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUME
    require_once('../../movimientos/ventas/MontosText.php');
    $rd = isset($_REQUEST['rd']) ? ($_REQUEST['rd']) : "2";
    function pintaDatos($Valor)
    {
        if ($Valor <> "") {
            return "<tr style='background-color: #ffffff;'><td style:'text-align:center ' colspan='4'><center>" . $Valor . "</center></td></tr>";
        }
    }

    function zero_fill($valor, $long = 0)
    {
        return str_pad($valor, $long, '0', STR_PAD_LEFT);
    }
    ?>
    <script>
        function sf() {
            var f = document.form1;
            f.text.focus();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function buscar() {
            var f = document.form1;
            if ((f.local.value == "") || (f.local.value == 0)) {
                alert("Seleccione una Local");
                f.local.focus();
                return;
            }
            f.method = "post";
            f.action = "index1.php";
            f.submit();
        }

        function save() {
            var f = document.form1;

            if ((f.text.value == "") || (f.text.value == 0)) {
                alert("Ingresa un nombre");
                f.text.focus();
                return;
            }
            if ((f.linea1.value == "") || (f.linea1.value == 0)) {
                alert("Este campo no puede estar vacio");
                f.linea1.focus();
                return;
            }
            if ((f.linea5.value == "") || (f.linea5.value == 0)) {
                alert("Este campo no puede estar vacio es el ruc");
                f.linea5.focus();
                return;
            }


            f.method = "post";
            f.action = "index2.php";
            f.submit();
        }
    </script>
    <style>
        select {
            width: 210px;
        }

        .tablarepor {

            border: 1px solid black;
            border-collapse: collapse;

        }

        .tablarepor tr {

            background: #ececec;
        }

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 5px;

        }

        #customers tr:nth-child(even) {
            background-color: #f0ecec;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {

            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 12px;
            font-weight: 900;
        }

        .titulos {
            border: 1px solid #ddd;
            padding: 2;
            text-align: center;
            background-color: #50ADEA;
            color: white;
            font-size: 14px;
            font-weight: 900;
        }
    </style>
    <?php
    $srch = $_REQUEST['srch'];
    $local = $_REQUEST['local'];
    if ($srch == 1) {
        $sql1 = "SELECT nombre,imprapida,habil,logo FROM xcompa where codloc = '$local'";
        $result1 = mysqli_query($conexion, $sql1);
        if (mysqli_num_rows($result1)) {
            while ($row1 = mysqli_fetch_array($result1)) {
                $nombre = $row1['nombre'];
                $imprapida = $row1['imprapida'];
                $habil = $row1['habil'];
                $logo = $row1['logo'];
            }
        }
    }

    $sql = "SELECT nlicencia FROM datagen ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nlicencia = $row['nlicencia'];
        }
    }
    $sql1 = "SELECT activacionGuiaRemision FROM datagen_det ";
    $result1 = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result1)) {
        while ($row = mysqli_fetch_array($result1)) {
            $activacionGuiaRemision = $row['activacionGuiaRemision'];
        }
    }

    $sqlTicket = "SELECT linea1,linea2,linea3,linea4,linea5,linea6,linea7,linea8,linea9,pie1,pie2,pie3,pie4,pie5,pie6,pie7,pie8,pie9,ubigeo,distrito,provincia,departamento,direccion FROM ticket where sucursal = '$local'";
    $resultTicket = mysqli_query($conexion, $sqlTicket);
    if (mysqli_num_rows($resultTicket)) {
        while ($row = mysqli_fetch_array($resultTicket)) {
            $linea1 = $row['linea1'];
            $linea2 = $row['linea2'];
            $linea3 = $row['linea3'];
            $linea4 = $row['linea4'];
            $linea5 = $row['linea5'];
            $linea6 = $row['linea6'];
            $linea7 = $row['linea7'];
            $linea8 = $row['linea8'];
            $linea9 = $row['linea9'];
            $pie1 = $row['pie1'];
            $pie2 = $row['pie2'];
            $pie3 = $row['pie3'];
            $pie4 = $row['pie4'];
            $pie5 = $row['pie5'];
            $pie6 = $row['pie6'];
            $pie7 = $row['pie7'];
            $pie8 = $row['pie8'];
            $pie9 = $row['pie9'];

            $ubigeo =       $row['ubigeo'];
            $distrito =     $row['distrito'];
            $provincia =    $row['provincia'];
            $departamento = $row['departamento'];
            $direccion =    $row['direccion'];

           
        }
    }

   if ($rd == 4) {
        $TextDoc = '';
        $nrofactura = 'T000-1';
        $tipo_comprobante = 'COMPROBANTE DE PAGO TIPO TICKET';
    } elseif ($rd == 2) {
        $TextDoc = 'Boleta de Venta Electronica';
        $nrofactura = 'B000-1';
        $tipo_comprobante = 'COMPROBANTE DE PAGO TIPO BOLETA';
    } else {
        $TextDoc = 'Factura Electronica';
        $nrofactura = 'F000-1';
        $tipo_comprobante = 'COMPROBANTE DE PAGO TIPO FACTURA';
    }
    $invfec = date('d/m/Y');
    $hora = date("H:i");
    $nomusu = 'Usuario de sistema';
    $descli = 'Cliente Asignado';
    $ruccli = '12345678901';
    $dircli = 'direccion del cliente';
    $pstcli = 'numero de puntos ';
    $SumGrabado = '1.44';
    $SumInafectos = '0.00';
    $igv = '0.26';
    $invtot = '1.70';
    $pagacon = '3.00';
    $vuelto = '1.30';
    $venta = '303';
    ?>
    <script>
        function validar() {
            var f = document.form1;
            var i;
            var c;
            for (i = 0; i < document.form1.rd.length; i++) {
                if (document.form1.rd[i].checked) {
                    f.method = "post";
                    f.action = "index1.php";
                    f.submit();
                }
            }
        }
    </script>
</head>

<body <?php if ($srch == 1) { ?>onload="sf();" <?php } ?>>
    <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
    <?php if ($desc <> '') { ?>
        <font color="<?php echo $color ?>"><?php echo $desc; ?></font>
        <br />
    <?php } ?>
    <?php if (($usuario == 1) || ($usuario == 2)) { ?>
        <form name="form1" id="form1" onClick="highlight(event)" onKeyUp="highlight(event)" enctype="multipart/form-data">
            <table width="100%" border="0">
                <tr>
                    <td width="501">
                        <table width="100%" border="0" class="tablarepor">
                            <tr>
                                <td width="69"><strong>Local </strong></td>
                                <td width="216">
                                    <select name="local" id="local">
                                        <option value="0">Seleccione un local</option>
                                        <?php
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                        $result = mysqli_query($conexion, $sql);
                                        if (mysqli_num_rows($result)) {
                                            while ($row = mysqli_fetch_array($result)) {
                                        ?>
                                                <option value="<?php echo $row[0] ?>" <?php if ($local == $row[0]) { ?>selected="selected" <?php } ?>>
                                                    <?php
                                                    if ($row[2] <> '') {
                                                        echo $row[2];
                                                    } else {
                                                        echo $row[1];
                                                    }
                                                    ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="0">NO EXISTEN LOCALES REGISTRADOS</option>
                                        <?php }
                                        ?>
                                    </select> </td>

                                <td width="179">
                                    <?php if (($usuario == 1) || ($usuario == 2)) { ?>
                                        <div align="right">
                                            <input name="srch" type="hidden" id="srch" value="1" />
                                            <input name="exit" type="button" id="exit" value="Buscar" onclick="buscar()" class="buscar" />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="69"><strong>Nombre </strong></td>
                                <td width="216">
                                    <input name="text" type="text" id="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $nombre ?>" size="40" maxlength="10" <?php if ($srch == '') { ?>disabled="disabled" <?php } ?> />
                                </td>
                                <td width="179">
                                    <div align="right">
                                        <input name="exit" type="button" id="exit" value="Salir" onclick="salir()" class="salir" /></div>
                                </td>
                            </tr>

                            <tr>
                                <td><strong>Habilitado</strong></td>
                                <td><input name="habil" type="checkbox" id="habil" value="1" <?php if ($habil == 1) { ?>checked="checked" <?php } ?> <?php if ($srch <> 1) { ?>disabled="disabled" <?php } ?> />
                                    Si</td>
                                <td width="179">
                                    <?php if (($usuario == 1) || ($usuario == 2)) { ?>
                                        <div align="right">
                                            <input name="codloc" type="hidden" id="codloc" value="<?php echo $local ?>" />
                                            <input name="grab" type="button" value="Grabar" onclick="save()" class="grabar" <?php if ($srch <> 1) { ?>disabled="disabled" <?php } ?> />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="111"><strong>Impresi&oacute;n R&aacute;pida </strong></td>
                                <td width="174"><input name="imprapida" type="checkbox" id="imprapida" value="1" <?php if ($imprapida == 1) { ?>checked="checked" <?php } ?> <?php if ($srch <> 1) { ?>disabled="disabled" <?php } ?> />
                                    Si</td>
                                <td width="179">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="111" title="Si selecciona esta opción se remplazará todos los logos de todos los locales por el logo cargado, no se podrá recuperar los antiguos logos una vez guardado." style="color:red"><strong>Logo para todos los locales</strong></td>
                                <td width="174" title="Si selecciona esta opción se remplazará todos los logos de todos los locales por el logo cargado, no se podrá recuperar los antiguos logos una vez guardado."><input name="todos" type="checkbox" id="todos" value="1" <?php if ($todos == 1) { ?>checked="checked" <?php } ?> <?php if ($srch <> 1) { ?>disabled="disabled" <?php } ?> />
                                    Si</td>
                                <td width="179">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="left">
                                    <strong>Logo del Impresion</strong>
                                </td>
                                <td>
                                    <input name="logo" id="logo" type="file" <?php if ($srch <> 1) { ?>disabled="disabled" <?php } ?> />
                                </td>
                                <td width="179" align="center">
                                    <img <?php if ($logo <> "") { ?> src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " <?php
                                                                                                                                    } else {
                                                                                                                                        if ($srch == 1) {
                                                                                                                                        ?> src="images.png" <?php
                                                                                                                                                        }
                                                                                                                                                    }
                                                                                                                                                            ?> />

                                </td>
                            </tr>




                        </table>
                        <?php if ($srch == 1) { ?>
                            <table width="100%" border='0'>
                                <tr>
                                    <th width="45%" class="titulos"><?php echo $tipo_comprobante; ?></th>
                                    <th width="55%" class="titulos">EDITAR</th>
                                </tr>
                                <tr style="background-color: #ffffff;">
                                    <td style="background-color: #ffffff;">
                                        <table width="100%" border='0'>
                                            <tr style="background-color: #ffffff;">
                                                <th class="titulos">
                                                    <input name="rd" id="boleta" type="radio" value="2" <?php if ($rd == 2) { ?>checked="checked" <?php } ?>onclick="validar()" />
                                                    <span class="boleta"><label for="boleta">BOLETA</label></span>
                                                </th>
                                                <th colspan="2" class="titulos">
                                                    <input name="rd" id="factura" type="radio" value="1" <?php if ($rd == 1) { ?>checked="checked" <?php } ?>onclick="validar()" />
                                                    <span class="factura"><label for="factura">FACTURA</label></span>
                                                </th>
                                                <th class="titulos">
                                                    <input name="rd" id="ticket" type="radio" value="4" <?php if ($rd == 4) { ?>checked="checked" <?php } ?>onclick="validar()" />
                                                    <span class="ticket"><label for="ticket">TICKET</label></span>
                                                </th>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" align="center" style="background-color: #ffffff;">
                                                    <img <?php if ($logo <> "") { ?> src="data:image/jpg;base64,<?php echo base64_encode($logo); ?> " <?php  } else {
                                                                                                                                                        if ($srch == 1) {
                                                                                                                                                        ?> src="images.png" <?php  }
                                                                                                                                                                    }  ?> />
                                                </td>
                                            </tr>

                                            <?php
                                            echo pintaDatos($linea1);
                                            echo pintaDatos($linea2);
                                            echo pintaDatos($linea3);
                                            echo pintaDatos($linea4);
                                            if ($rd <> 4) {
                                                echo pintaDatos($linea5);
                                            }
                                            echo pintaDatos($linea6);
                                            echo pintaDatos($linea7);
                                            echo pintaDatos($linea8);
                                            echo pintaDatos($linea9);
                                            ?>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td>FECHA :</td>
                                                <td align="left"><?php echo $invfec; ?></td>
                                                <td align="right">HORA :</td>
                                                <td align="left"><?php echo $hora; ?></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td>VENDEDOR :</td>
                                                <td colspan="3"><?php echo $nomusu; ?></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td>CLIENTE :</td>
                                                <td colspan="3"><?php echo $descli; ?></td>
                                            </tr>
                                            <?php
                                            if (($rd == 1)) {
                                            ?>
                                                <tr style="background-color: #ffffff;">
                                                    <td>RUC :</td>
                                                    <td colspan="3"><?php echo $ruccli; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            if (strlen($dircli) > 0) {
                                            ?>
                                                <tr style="background-color: #ffffff;">
                                                    <td>DIRECCI&Oacute;N :</td>
                                                    <td colspan="3"><?php echo $dircli; ?></td>
                                                </tr>
                                            <?php  } ?>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="font-size: 12px;">
                                                    <center><b><?php echo $TextDoc; ?> - <?php echo $nrofactura; ?></b></center>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4">
                                                    <table class="table_T" style="width: 100%">
                                                        <tr>
                                                            <th style="text-align: left; width:4%;">Cant</th>
                                                            <th style="width:70%;">Descripcion</th>
                                                            <th style="width:7%;">Marca</th>
                                                            <th style="text-align: right; width:9.5%;">P.UNit</th>
                                                            <th style="text-align: right; width:9.5%;">S.Total</th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <hr>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left; width:4%;"><?php echo 'F1'; ?></td>
                                                            <td style="width:70%;"><?php echo 'DEXALAB 4MG X 100 TAB'; ?></td>
                                                            <td style="width:7%;"><?php echo 'LABO'; ?></td>
                                                            <td style="text-align: right; width:9.5%;"><?php echo '1.40'; ?></td>
                                                            <td style="text-align: right; width:9.5%;"><?php echo '1.40'; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align: left; width:4%;"><?php echo 'F1'; ?></td>
                                                            <td style="width:70%;"><?php echo 'CELECOXIB 200 MG X 100 CAP.'; ?></td>
                                                            <td style="width:7%;"><?php echo 'PORT'; ?></td>
                                                            <td style="text-align: right; width:9.5%;"><?php echo '0.30'; ?></td>
                                                            <td style="text-align: right; width:9.5%;"><?php echo '0.30'; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <hr>
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="text-align: right;"><b>GRAVADA: &nbsp; &nbsp; <?php echo number_format($SumGrabado, 2, '.', ''); ?></b></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="text-align: right;"><b>INAFECTO:&nbsp; &nbsp; <?php echo number_format($SumInafectos, 2, '.', ''); ?></b></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="text-align: right;"><b>IGV:&nbsp; &nbsp; <?php echo ($igv); ?></b></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="text-align: right;font-size: 12px;"><b>TOTAL:&nbsp; &nbsp;S/<?php echo $invtot; ?></b></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" style="text-align: left;font-size: 10px;">SON: <?php echo valorEnLetras($invtot); ?></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4"><b>PAG&Oacute; con:&nbsp; &nbsp; S/ <?php echo $pagacon; ?></b></td>
                                            </tr>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4"><b>VUELTO:&nbsp; &nbsp; S/ <?php echo $vuelto; ?></b></td>
                                            </tr>
                                            <?php
                                            echo pintaDatos($pie1);
                                            echo pintaDatos($pie2);
                                            echo pintaDatos($pie3);
                                            echo pintaDatos($pie4);
                                            echo pintaDatos($pie5);
                                            echo pintaDatos($pie6);
                                            echo pintaDatos($pie7);
                                            echo pintaDatos($pie8);
                                            echo pintaDatos($pie9);
                                            echo pintaDatos('N. I. -' . $venta);
                                            ?>
                                            <tr style="background-color: #ffffff;">
                                                <td colspan="4" align="center">
                                                    <?php
                                                    if (($rd == 1) || ($rd == 2)) {
                                                        echo '<img src=" qr.png" />';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- <img src="ticket.png"> -->
                                    </td>
                                    <td style="float: left;">
                                        <table align="center" border='0' width="100%" id="customers">

                                            <tr>
                                                <td width="10%" class="LETRA" align="center">LINEA 1</td>
                                                <td width="90%">
                                                    <input name="linea1" id="linea1" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea1 ?>" size="100%" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 2</td>
                                                <td> <input name="linea2" id="linea2" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea2 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 3</td>
                                                <td><input name="linea3" id="linea3" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea3 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 4</td>
                                                <td><input name="linea4" id="linea4" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea4 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 5</td>
                                                <td><input name="linea5" id="linea5" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea5 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 6</td>
                                                <td><input name="linea6" id="linea6" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea6 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 7</td>
                                                <td><input name="linea7" id="linea7" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea7 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 8</td>
                                                <td><input name="linea8" id="linea8" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea8 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">LINEA 9</td>
                                                <td><input name="linea9" id="linea9" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $linea9 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" width="100%">

                                                    <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 1</td>
                                                <td><input name="pie1" id="pie1" type="text" value="<?php echo $pie1 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 2</td>
                                                <td><input name="pie2" id="pie2" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie2 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 3</td>
                                                <td><input name="pie3" id="pie3" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie3 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 4</td>
                                                <td><input name="pie4" id="pie4" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie4 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 5</td>
                                                <td><input name="pie5" id="pie5" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie5 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 6</td>
                                                <td><input name="pie6" id="pie6" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie6 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 7</td>
                                                <td><input name="pie7" id="pie7" type="text" onKeyUp="this.value = this.value.toUpperCase();" value="<?php echo $pie7 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 8</td>
                                                <td><input name="pie8" id="pie8" type="text" value="<?php echo $pie8 ?>" size="100%" /></td>
                                            </tr>
                                            <tr>
                                                <td class="LETRA" align="center">PIE 9</td>
                                                <td><input name="pie9" id="pie9" type="text" value="<?php echo $pie9 ?>" size="100%" /></td>
                                            </tr>

                                            <?php if ($activacionGuiaRemision == '1') { ?>
                                                 <tr>
                                                 <td colspan="2" width="100%">
 
                                                     <div align="left"><img src="../../../images/line2.png"  width="100%" height="4" /> </div>
                                                 </td>
                                             </tr>
                                             <tr>
                                                 <td class="LETRA" align="center">DIRECCION</td>
                                                 <td><input name="direccion" id="direccion" type="text" value="<?php echo $direccion ?>" size="100%" /></td>
                                             </tr>
                                             <tr>
                                                 <td class="LETRA" align="center">DISTRITO</td>
                                                 <td><input name="distrito" id="distrito" type="text" value="<?php echo $distrito ?>" size="100%" /></td>
                                             </tr>
                                             <tr>
                                                 <td class="LETRA" align="center">PROVINCIA</td>
                                                 <td><input name="provincia" id="provincia" type="text" value="<?php echo $provincia ?>" size="100%" /></td>
                                             </tr>
                                             <tr>
                                                 <td class="LETRA" align="center">DEPARTAMENTO</td>
                                                 <td><input name="departamento" id="departamento" type="text" value="<?php echo $departamento ?>" size="100%" /></td>
                                             </tr>
                                             <tr>
                                                 <td class="LETRA" align="center">UBIGEO</td>
                                                 <td><input name="ubigeo" id="ubigeo" type="text" value="<?php echo $ubigeo ?>" size="100%" /></td>
                                             </tr>
                                                
                                             <?php    } ?>

                                            
                                           
                                        </table>


                                    </td>
                                </tr>
                            </table>
                        <?php } ?>

                    </td>
                </tr>
            </table>
            <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>

        </form>
    <?php } else { ?>
        <div align="center" style="margin-top: 20%;">
            <a style='color:#ff5733;font-size:30px;font-weight: bold;text-align: justify;padding: 20px; '>OPCION DISPONIBLE SOLO PARA PERSONAL AUTORIZADO </strong></blink> </a>
        </div>
    <?php } ?>
</body>

</html>
<script type="text/javascript">
    $('#local').select2();
</script>