<?php
include('../../session_user.php');
require_once('../../../conexion.php');
require_once('../../../convertfecha.php');
require_once('../../../titulo_sist.php');
$ct = 0;

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php echo $desemp ?></title>
    <link href="../css/css/style1.css" rel="stylesheet" type="text/css" />
    <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
    <style>
        .siniformacion {
            font-family: Tahoma;
            font-size: 20px;
            line-height: normal;
            color: #e65a3d;
            padding: 20px;
            font-weight: bold;
            /*margin-top:  20px;*/
        }

        #boton {
            background: url('../../../images/save_16.png') no-repeat;
            border: none;
            width: 16px;
            height: 16px;
        }

        #boton1 {
            background: url('../../../images/x2.png') no-repeat;
            border: none;
            width: 26px;
            height: 26px;
        }

        a:link,
        a:visited {
            color: #0066CC;
            border: 0px solid #e7e7e7;
            text-decoration: none;
        }

        a:hover {
            background: #fff;
            border: 0px solid #ccc;
            font-size: 15px;
            color: #ec5e5c;
            background-color: #FFFF66;
        }

        a:focus {
            background-color: #FFFF66;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        a:active {
            background-color: #FFFF66;
            color: #0066CC;
            border: 0px solid #ccc;
        }

        /* para las tablas */
        /* #customers a {
			text-decoration: none;

		}

		#customers a:hover {
			text-decoration: solid;
			font-size: 15px;

		} */

        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers th {
            border: 1px solid #ddd;
            padding: 1px;

        }

        #customers td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 12px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #FFFF66;
        }

        #customers th {
            padding: 2px;
            text-align: left;
            background-color: #2e91d2;
            color: white;
            font-size: 15px;
        }

        a {

            padding: 0 20px 0 20px;
        }

        #tooltip1 {
            position: relative;
        }

        #tooltip1 a span {
            display: none;
            color: #FFFFFF;
        }

        #tooltip1 a:hover span {
            display: block;
            position: absolute;
            text-align: left;
            width: auto;
            font-size: 14px;
            background: #aaa url(oscuro.jpg);
            height: 100px;
            color: #FFFFFF;
            padding: 0 5px;
            margin-left: -200px;
        }
    </style>
    <script>
        function validar_grid() {
            document.form1.method = "post";
            document.form1.submit();
        }

        function sf() {
            document.form1.p2.focus();
        }

        function AddBonificacion(Codigo) {
            window.open('productos.php?CProducto=' + Codigo, 'PopupName', 'toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=100,left=0,height=450,width=1300');
        }
    </script>
</head>
<?php

$sql1 = "SELECT codloc,nomusu FROM usuario where usecod = '$usuario'";    ////CODIGO DEL LOCAL DEL USUARIO
$result1 = mysqli_query($conexion, $sql1);
if (mysqli_num_rows($result1)) {
    while ($row1 = mysqli_fetch_array($result1)) {
        $codloc     = $row1['codloc'];
        $user       = $row1['nomusu'];
    }
}
//**CONFIGPRECIOS_PRODUCTO**//
$nomlocalG = "";
$sqlLocal = "SELECT nomloc FROM xcompa where habil = '1' and codloc = '$sucursal'";
$resultLocal = mysqli_query($conexion, $sqlLocal);
if (mysqli_num_rows($resultLocal)) {
    while ($rowLocal = mysqli_fetch_array($resultLocal)) {
        $nomlocalG = $rowLocal['nomloc'];
    }
}


$numero_xcompa = substr($nomlocalG, 5, 2);
$tabla = "s" . str_pad($numero_xcompa, 3, "0", STR_PAD_LEFT);

require_once("../../../funciones/functions.php");    //DESHABILITA TECLAS
require_once("../../../funciones/funct_principal.php");    //IMPRIMIR-NUME
require_once("../../../funciones/highlight.php");    //ILUMINA CAJAS DE TEXTOS
require_once("tabla_local.php");    //LOCAL DEL USUARIO
require_once("../../local.php");    //LOCAL DEL USUARIO
function formato($c)
{
    printf("%08d", $c);
}
$cr         = isset($_REQUEST['cr']) ? ($_REQUEST['cr']) : "";
$search     = isset($_REQUEST['search']) ? ($_REQUEST['search']) : "";
$val        = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$codpros    = isset($_REQUEST['codpros']) ? ($_REQUEST['codpros']) : "";
$valform    = isset($_REQUEST['valform']) ? ($_REQUEST['valform']) : "";
?>

<body <?php if ($valform == 1) { ?>onload="sf();" <?php } else { ?> onload="getfocus();" <?php } ?> id="body">
    <form id="form1" name="form1" onKeyUp="highlight(event)" onClick="highlight(event)">
        <table width="100%" border="0" class="tabla2">
            <tr>
                <td width="951">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td width="70%"></td>

                            <td width="10%">
                                <div align="right"><span class="text_combo_select"><strong>LOCAL:</strong> <img src="../../../images/controlpanel.png" width="16" height="16" /> <?php echo $nombre_local ?></span></div>
                            </td>
                            <td width="20%">
                                <div align="right"><span class="text_combo_select"><strong>USUARIO :</strong> <img src="../../../images/user.gif" width="15" height="16" /> <?php echo $user ?></span></div>
                            </td>
                        </tr>
                    </table>

                    <div align="center"><img src="../../../images/line2.png" width="100%" height="4" />
                        <?php
                        if ($val <> "") {
                            if ($val == 1) {

                                if (is_numeric($search)) {
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codprobonif,codmar,stopro,$tabla,cantventaparabonificar,cantbonificable FROM producto where codbar = '$search' or codpro = '$search' and eliminado='0'";
                                } else {
                                    $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codprobonif,codmar,stopro,$tabla,cantventaparabonificar,cantbonificable FROM producto where desprod like '$search%' and eliminado='0'";
                                }
                            }
                            if ($val == 2) {
                                $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codprobonif,codmar,stopro,$tabla,cantventaparabonificar,cantbonificable FROM producto where codmar = '$search' and eliminado='0'";
                            }
                            if ($val == 3) {
                                $sql = "SELECT codpro,desprod,pcostouni,costre,margene,prevta,preuni,factor,codprobonif,codmar,stopro,$tabla,cantventaparabonificar,cantbonificable FROM producto where $tabla > 0 and eliminado='0'";
                            }
                            $result = mysqli_query($conexion, $sql);
                            if (mysqli_num_rows($result)) {
                        ?>
                                <table width="100%" border="0" align="center" id="customers" cellpadding="0" cellspacing="0">

                                    <tr>
                                        <th width="5%">CODIGO</th>
                                        <th width="30%"><strong>PRODUCTO</strong></th>
                                        <th width="20%">
                                            <div align="left"><strong>MARCA</strong></div>
                                        </th>

                                        <th width="10%">
                                            <div align="center"><strong>FACTOR</strong></div>
                                        </th>
                                        <th width="10%">
                                            <div align="center"><strong>STOCK</strong></div>
                                        </th>
                                        <th width="5%">
                                            <div align="left"><strong>BONIFICADO</strong></div>
                                        </th>
                                        <th width="15%">
                                            <div align="center"><strong>BONIF</strong></div>
                                        </th>
                                    </tr>
                                    <?php
                                    $cr = 1;
                                    $cont = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codpro                 = $row['codpro'];
                                        $desprod                = $row['desprod'];
                                        $pcostouni              = $row['pcostouni'];
                                        $costre                 = $row['costre'];
                                        $margene                = $row['margene'];
                                        $prevta                 = $row['prevta'];
                                        $preuni                 = $row['preuni'];
                                        $factor                 = $row['factor'];
                                        $codmar                 = $row['codmar'];
                                        $stopro                 = $row['stopro'];
                                        $stoproLoc              = $row[10];



                                        if (($zzcodloc == 1) && ($precios_por_local == 1)) {
                                            $codprobonif            = $row['codprobonif'];
                                            $cantventaparabonificar = $row['cantventaparabonificar'];
                                            $cantbonificable         = $row['cantbonificable'];
                                        } elseif ($precios_por_local == 0) {
                                            $codprobonif            = $row['codprobonif'];
                                            $cantventaparabonificar = $row['cantventaparabonificar'];
                                            $cantbonificable         = $row['cantbonificable'];
                                        }

                                        if (($zzcodloc <> 1) && ($precios_por_local == 1)) {

                                            $sql_precio = "SELECT $codprobonif_p,$cantventaparabonificar_p,$cantbonificable_p FROM precios_por_local where codpro = '$codpro'";
                                            $result_precio = mysqli_query($conexion, $sql_precio);
                                            if (mysqli_num_rows($result_precio)) {
                                                while ($row_precio = mysqli_fetch_array($result_precio)) {
                                                    $codprobonif                = $row_precio[0];
                                                    $cantventaparabonificar     = $row_precio[1];
                                                    $cantbonificable            = $row_precio[2];
                                                }
                                            }
                                        }



                                        if ($codprobonif <> 0) {

                                            $sql1 = "SELECT desprod FROM producto where codpro = '$codprobonif'";
                                            $result1 = mysqli_query($conexion, $sql1);
                                            if (mysqli_num_rows($result1)) {
                                                while ($row1 = mysqli_fetch_array($result1)) {
                                                    $desprod_title    = $row1['desprod'];
                                                }
                                            }
                                            if (!is_numeric($cantventaparabonificar)) {
                                                $tipo_cv = 'CAJA(S)';
                                            } else {
                                                $tipo_cv = 'UND(S)';
                                            }
                                            if (!is_numeric($cantbonificable)) {
                                                $tipo_b = 'CAJA(S)';
                                            } else {
                                                $tipo_b = 'UND(S)';
                                            }

                                            $title = 'Por Cada Venta de ' . $cantventaparabonificar . ' ' . $tipo_cv . ' del Producto  ' . $desprod . ', ' . "<br>" . ' Se le Bonificara ' . $cantbonificable . ' ' . $tipo_b . ' del Producto ' . $desprod_title;
                                            $accion = 'SI';
                                        } else {
                                            $accion = 'NO';
                                        }



                                        $sql1 = "SELECT destab FROM titultabladet where tiptab = 'M' and codtab = '$codmar'";
                                        $result1 = mysqli_query($conexion, $sql1);
                                        if (mysqli_num_rows($result1)) {
                                            while ($row1 = mysqli_fetch_array($result1)) {
                                                $destab    = $row1['destab'];
                                            }
                                        }
                                        if ($ct == 1) {
                                            $color = "#99CCFF";
                                        } else {
                                            $color = "#FFFFFF";
                                        }
                                        $t = $cont % 2;
                                        if ($t == 1) {
                                            $color = "#D2E0EC";
                                        } else {
                                            $color = "#ffffff";
                                        }
                                        $cont++;
                                    ?>
                                        <tr bgcolor="<?php echo $color; ?>" onmouseover=this.style.backgroundColor='#FFFF99' ;this.style.cursor='hand' ; onmouseout=this.style.backgroundColor="<?php echo $color; ?>" ;>
                                            <td>
                                                <div align="center"><?php echo $codpro; ?></div>
                                            </td>
                                            <td><a id="l<?php echo $cr; ?>" href="javascript:AddBonificacion(<?php echo $codpro; ?>);"><?php echo $desprod ?></a></td>
                                            <td>
                                                <div align="left"><?php echo $destab; ?></div>
                                            </td>
                                            <td>
                                                <div align="center"><?php echo $factor; ?></div>
                                            </td>
                                            <td>
                                                <div align="center"><?php echo stockcaja($stopro, $factor); ?></div>
                                            </td>

                                            <td align="center" <?php if ($codprobonif <> 0) { ?>style="background-color: #92cf59;" <?php } else { ?>style="background-color: #ec5e5c;" <?php } ?>>
                                                <?php if ($codprobonif <> 0) { ?>
                                                    <div id="tooltip1">
                                                        <a href="#"><?php echo $accion; ?>
                                                            <span>
                                                                <?php echo $title; ?>
                                                            </span>
                                                        </a>
                                                    </div>
                                                <?php } else {
                                                    echo $accion;
                                                } ?>

                                            </td>



                                            <td>
                                                <div align="center">
                                                    <a href="javascript:AddBonificacion(<?php echo $codpro; ?>);">
                                                        <img src="../../../images/add1.gif" width="14" height="15" border="0" />
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </table>
                        <?php
                                $cr++;
                            }
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </form>
</body>

</html>