<?php include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../titulo_sist.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <style>
        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/icon-16-checkin.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }
    </style>
    <script>
        function validar_grid() {
            document.form1.method = "get";
            document.form1.submit();
        }

        function validar_prod() {
            var f = document.form1;
            f.method = "get";
            f.action = "grabar_datos.php";
            f.submit();
        }

        function sf() {
            document.form1.p1.focus();
        }

        function precio() {
            var f = document.form1;
            var v1 = parseFloat(document.form1.p2.value); //PRECIO VENTA
            var factor = parseFloat(document.form1.factor.value); //FACTOR
            var pcu = parseFloat(document.form1.pcostouni.value); //PCOSTO
            var t = v1 / pcu;
            var tt = (t * 100) - 100;
            var pvu = v1 / factor;
            tt = Math.round(tt * Math.pow(10, 2)) / Math.pow(10, 2);
            pvu = Math.round(pvu * Math.pow(10, 2)) / Math.pow(10, 2);
            document.form1.p1.value = tt;
            document.form1.margene1.value = tt;
            document.form1.p3.value = pvu;
        }
    </script>
    <style type="text/css">
        .Estilo1 {
            color: #ffffff;
            font-weight: bold;
        }

        .Estilo2 {
            color: #ff0000;
            font-weight: bold;
        }

        .Estilo3 {
            font-style: italic;
            font-weight: bold;
            font-size: 2em;
            color: #ffffff;
            font-family: 'Helvetica', 'Verdana', 'Monaco', sans-serif;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }


        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;

        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #customers td a {
            color: #4d9ff7;
            font-weight: bold;
            font-size: 15px;
            text-decoration: none;

        }

        #customers #total {

            text-align: center;
            background-color: #fe5050;
            color: white;
            font-size: 16px;
            font-weight: 900;
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
    </style>
</head>
<?php $sql1 = "SELECT codloc FROM usuario where usecod = '$usuario'";    ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc    = $row1['codloc'];
    }
}
$sql = "SELECT nomloc FROM xcompa where codloc = '$codloc'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nomloc    = $row['nomloc'];
    }
}
require_once("../../../funciones/functions.php");    //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");    //IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");    //ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");    //LOCAL DEL USUARIO
require_once("../../local.php");    //LOCAL DEL USUARIO
$search = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val    = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$sql = "SELECT * FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $user    = $row['nomusu'];
    }
}
function formato($c)
{
    printf("%08d", $c);
}
$codpros = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
?>

<body <?php if ($valform == 1) { ?>onload="sf();" <?php } ?>>
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
        <table width="100%" border="0" class="tabla2" cellpadding="0" cellspacing="0">
            <tr>
                <td width="951">
                    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="9"></td>
                            <td width="116">&nbsp;</td>
                            <td width="10"> </td>
                            <td width="191">&nbsp;</td>
                            <td width="300">
                                <div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
                            </td>
                            <td width="263">
                                <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
                            </td>
                        </tr>
                    </table>

                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" />
                        <?php if ($val <> "") {
                            $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codmar,blister,preblister FROM producto where codpro = '$search' and eliminado ='0'";
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                        ?>
                                <table width="915" border="0" align="center" id="customers" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th width="5%"><strong>CODIGO</strong></th>
                                        <th width="15%"><strong>PRODUCTO</strong></th>
                                        <th width="15%"><strong>MARCA</strong></th>
                                        <th width="5%"><strong>FACTOR</strong></th>
                                        <th width="5%">
                                            <div align="center"><strong>PRECIO COSTO</strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>MARGEN % </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>PRECIO VENTA CAJA </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>PRECIO VENTA UNIT </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>Blister </strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>Pre.Uni X Blis.</strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="center"><strong>MODIFICAR</strong></div>
                                        </th>
                                    </tr>
                                    <?php while ($row = mysqli_fetch_array($result)) {
                                        $codpro         = $row['codpro'];
                                        $desprod        = $row['desprod'];
                                        $pcostouni      = $row['pcostouni'];
                                        $costre         = $row['costre'];
                                        $margene        = $row['margene'];
                                        $prevta         = $row['prevta'];
                                        $preuni         = $row['preuni'];
                                        $factor         = $row['factor'];
                                        $codmar         = $row['codmar'];
                                        $blister        = $row['blister'];
                                        $preblister     = $row['preblister'];
                                        $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab    = $row1['destab'];
                                            }
                                        }
                                    ?>
                                        <tr onmouseover="this.style.backgroundColor='#FFFF99';this.style.cursor='hand';" onmouseout="this.style.backgroundColor='#ffffff';">
                                            <td><?php echo $codpro ?></td>
                                            <td><?php echo $desprod ?></td>
                                            <td><?php echo $destab ?></td>
                                            <td align="center"><?php echo $factor ?></td>
                                            <td>
                                                <div align="center">
                                                    <?php echo $pcostouni;
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    echo $margene;
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    echo $prevta;
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php
                                                    echo $preuni;
                                                    ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div align="center">
                                                    <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                        <input name="blister" type="text" id="blister" size="8" value="<?php echo $blister ?>" onkeypress="return acceptNum()(event);" />
                                                    <?php } else {
                                                        echo $blister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                        <input name="p3" type="text" id="p3" size="8" value="<?php echo $preblister ?>" onkeypress="return decimal(event);" />
                                                    <?php } else {
                                                        echo $preblister;
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div align="center">
                                                    <?php if (($valform == 1) and ($codpros == $codpro)) { ?>
                                                        <input name="val" type="hidden" id="val" value="<?php echo $val ?>" />
                                                        <input name="search" type="hidden" id="search" value="<?php echo $search ?>" />
                                                        <input name="codpro" type="hidden" id="codpro" value="<?php echo $codpro ?>" />
                                                        <input name="button" type="button" id="boton" onclick="validar_prod()" alt="GUARDAR" />
                                                        <input name="button2" type="button" id="boton1" onclick="validar_grid()" alt="ACEPTAR" />
                                                    <?php } else {
                                                    ?>
                                                        <?php if ($factor <> 1) {  ?>
                                                            <a href="pventa2.php?val=<?php echo $val ?>&&search=<?php echo $search ?>&&valform=1&&codpros=<?php echo $codpro ?>">
                                                                <img src="../../../images/add1.gif" width="14" height="15" border="0" /> </a>

                                                        <?php }  ?>
                                                    <?php }  ?>
                                                </div>
                                            </td>
                                        </tr>

                                    <?php }
                                    if ($factor == 1) {
                                    ?>

                                        <tr>
                                            <td align="center" colspan="12" id="total">
                                                No se puede modificar el producto por que el factor no es mayor a 1
                                            </td>
                                        </tr>
                                    <?php }

                                    ?>
                                </table>
                        <?php }
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>