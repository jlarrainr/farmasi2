<?php
include('../../session_user.php');
require_once('../../../conexion.php');    //CONEXION A BASE DE DATOS
require_once('../../../titulo_sist.php');

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
$ActionForm     = isset($_REQUEST['ActionForm']) ? ($_REQUEST['ActionForm']) : "";
$CProducto      = isset($_REQUEST['CProducto']) ? ($_REQUEST['CProducto']) : "";
$CProductoBonif = isset($_REQUEST['CProductoBonif']) ? ($_REQUEST['CProductoBonif']) : "";
$ProductoBusk   = isset($_REQUEST['ProductoBusk']) ? ($_REQUEST['ProductoBusk']) : "";
$Cantidad       = isset($_REQUEST['Cantidad']) ? ($_REQUEST['Cantidad']) : "";
$CantidadBonif  = isset($_REQUEST['CantidadBonif']) ? ($_REQUEST['CantidadBonif']) : "";

$desprodBonif       = "";
$CantidadaVender2   = "";
//$CProductoBonif = "";
//$CantidadBonif  = "";
if ($ActionForm == "RegistrarBonificacion") {
    if (!is_numeric($Cantidad)) {
        $Cantidad = strtoupper($Cantidad);
    }

    if (!is_numeric($CantidadBonif)) {
        $CantidadBonif = strtoupper($CantidadBonif);
    }
    if ($precios_por_local == 1) {

        if (($zzcodloc == 1)) {

            mysqli_query($conexion, "UPDATE producto set "
                . "cantventaparabonificar = '$Cantidad',"
                . "codprobonif= '$CProductoBonif', "
                . "cantbonificable = '$CantidadBonif' "
                . "where codpro = '$CProducto'");
        } else {

            mysqli_query($conexion, "UPDATE precios_por_local set "
                . "$cantventaparabonificar_p = '$Cantidad',"
                . "$codprobonif_p= '$CProductoBonif', "
                . "$cantbonificable_p = '$CantidadBonif' "
                . "where codpro = '$CProducto'");
        }
    } else {

        mysqli_query($conexion, "UPDATE producto set "
            . "cantventaparabonificar = '$Cantidad',"
            . "codprobonif= '$CProductoBonif', "
            . "cantbonificable = '$CantidadBonif' "
            . "where codpro = '$CProducto'");
    }
}

if ($ActionForm == "EliminaBonificacion") {
    if ($precios_por_local == 1) {
        if (($zzcodloc == 1)) {
            mysqli_query($conexion, "UPDATE producto set "
                . "cantventaparabonificar = '',"
                . "codprobonif= '', "
                . "cantbonificable = '' "
                . "where codpro = '$CProducto'");
        } else {
            mysqli_query($conexion, "UPDATE precios_por_local set "
                . "$cantventaparabonificar_p = '',"
                . "$codprobonif_p= '', "
                . "$cantbonificable_p = '' "
                . "where codpro = '$CProducto'");
        }
    } else {
        mysqli_query($conexion, "UPDATE producto set "
            . "cantventaparabonificar = '',"
            . "codprobonif= '', "
            . "cantbonificable = '' "
            . "where codpro = '$CProducto'");
    }
    $ActionForm     = "";
    $CProductoBonif = "";
    $Cantidad       = "";
    $desprodBonif       = "";
    $ProductoBusk       = "";
}


$sql = "SELECT desprod,cantventaparabonificar,codprobonif,cantbonificable,factor FROM producto where codpro = '$CProducto'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $desprod            = $row['desprod'];
        $CantidadaVender2   = $row['cantventaparabonificar'];
        $CProductoBonif2    = $row['codprobonif'];
        $CantidadBonif2     = $row['cantbonificable'];
        $factorx     = $row['factor'];
    }

    if ($CantidadBonif2 == 0) {
        $CantidadBonif2 = '';
    }
    if ($CProductoBonif == "") {
        $CProductoBonif = $CProductoBonif2;
    }

    //DATOS DEL PRODUCTO BONIFICADO
    if ((strlen($CProductoBonif) > 0) and ($CProductoBonif <> 0)) {
        $sql2 = "SELECT desprod FROM producto where codpro = '$CProductoBonif'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $desprodBonif    = $row2['desprod'];
            }
        }
    }
    if ($desprodBonif == '') {
        $des = $ProductoBusk;
    } else {
        $des = $desprodBonif;
    }
    if ($Cantidad == "") {
        $Cantidad = $CantidadaVender2;
    }
    if ($Cantidad == 0) {
        $Cantidad = '';
    }

    if ($des <> '') {

        $sql2 = "SELECT codpro,factor  FROM producto where desprod = '$des'";
        $result2 = mysqli_query($conexion, $sql2);
        if (mysqli_num_rows($result2)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                $codpro_campo    = $row2['codpro'];
                $factor_campo    = $row2['factor'];
                $factor_campo2    = 'factor = ' . $row2['factor'];
            }
        }
    }

    require_once("../../../funciones/botones.php");    //COLORES DE LOS BOTONES
?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $desprod ?></title>
        <link href="../css/css/tablas.css" rel="stylesheet" type="text/css" />
        <!-- <link href="../../css/body.css" rel="stylesheet" type="text/css" /> -->
        <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
        <?php
        require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
        ?>
        <link href="../../../funciones/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <script src="../../../funciones/datatable/jquery-3.3.1.js"></script>
        <script src="../../../funciones/datatable/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            function cantida_venta() {
                var f = document.Formulario;
                var cantidad_a_vender = parseFloat(f.Cantidad.value); //FACTOR
                var factor = parseFloat(f.factor_venta.value); //FACTOR
                var desprod_principal = f.desprod_principal.value; //FACTOR

                if (factor == 1) {
                    var valor = isNaN(cantidad_a_vender);
                    if (valor == true) ////NO ES NUMERO
                    {
                        var cantidad_a_vender = f.Cantidad.value.substring(1);
                        if (f.Cantidad.value != '') {
                            f.Cantidad.value = 'C' + cantidad_a_vender;
                            document.getElementById("tipo_de_venta").innerHTML = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            f.tipo_de_venta_text.value = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            document.getElementById("tipo_de_venta").style.color = "red"; //rojo
                            f.CantidadBonif.disabled = false;
                        } else {
                            f.Cantidad.value = '';
                            document.getElementById("tipo_de_venta").innerHTML = '';
                            f.CantidadBonif.disabled = true;
                        }
                    } else {
                        if (f.Cantidad.value != '') {
                            f.Cantidad.value = 'C' + cantidad_a_vender;
                            document.getElementById("tipo_de_venta").innerHTML = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            f.tipo_de_venta_text.value = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            document.getElementById("tipo_de_venta").style.color = "red"; //rojo
                            f.CantidadBonif.disabled = false;
                        } else {
                            f.Cantidad.value = '';
                            document.getElementById("tipo_de_venta").innerHTML = '';
                            f.CantidadBonif.disabled = true;
                        }
                    }

                } else {
                    var valor = isNaN(cantidad_a_vender);
                    if (valor == true) ////NO ES NUMERO
                    {
                        if ((f.Cantidad.value != '')) {
                            var cantidad_a_vender = f.Cantidad.value.substring(1);
                            document.getElementById("tipo_de_venta").innerHTML = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            f.tipo_de_venta_text.value = 'Por Cada Venta de ' + cantidad_a_vender + ' Caja(s) del Producto ' + desprod_principal;
                            document.getElementById("tipo_de_venta").style.color = "red"; //rojo
                            f.CantidadBonif.disabled = false;
                        } else {
                            document.getElementById("tipo_de_venta").innerHTML = '';
                            f.tipo_de_venta_text.value = '';
                            f.CantidadBonif.disabled = true;
                        }
                    } else {
                        if ((f.Cantidad.value != '')) {
                            document.getElementById("tipo_de_venta").innerHTML = 'Por Cada Venta de ' + cantidad_a_vender + ' Und(s) del Producto ' + desprod_principal;
                            f.tipo_de_venta_text.value = 'Por Cada Venta de ' + cantidad_a_vender + ' Und(s) del Producto ' + desprod_principal;
                            document.getElementById("tipo_de_venta").style.color = "red"; //rojo
                            f.CantidadBonif.disabled = false;
                        } else {
                            document.getElementById("tipo_de_venta").innerHTML = '';
                            f.tipo_de_venta_text.value = '';
                            f.CantidadBonif.disabled = true;
                        }
                    }
                }
            }

            function cantida_a_bonificar() {
                var f = document.Formulario;
                var tipo_de_venta_text = f.tipo_de_venta_text.value; //FACTOR
                var al_producto = f.ProductoBusk.value; //FACTOR
                var factor = parseFloat(f.factor.value); //FACTOR
                var cantidad_a_bonificar = parseFloat(f.CantidadBonif.value); //FACTOR

                if (factor == 1) {
                    var valor = isNaN(cantidad_a_bonificar);
                    if (valor == true) ////NO ES NUMERO
                    {
                        var cantidad_a_bonificar = f.CantidadBonif.value.substring(1);
                        if (f.CantidadBonif.value != '') {
                            f.CantidadBonif.value = 'C' + cantidad_a_bonificar;
                            document.getElementById("tipo_de_bonificacion").innerHTML = tipo_de_venta_text + ', se Bonificara ' + cantidad_a_bonificar + ' Caja(s) del Producto ' + al_producto;
                            document.getElementById("tipo_de_bonificacion").style.color = "red"; //rojo

                        } else {

                            f.CantidadBonif.value = '';
                            document.getElementById("tipo_de_bonificacion").innerHTML = '';
                        }
                    } else {
                        if (f.CantidadBonif.value != '') {
                            f.CantidadBonif.value = 'C' + cantidad_a_bonificar;
                            document.getElementById("tipo_de_bonificacion").innerHTML = tipo_de_venta_text + ', se Bonificara ' + cantidad_a_bonificar + ' Caja(s) del Producto ' + al_producto;
                            document.getElementById("tipo_de_bonificacion").style.color = "red"; //rojo
                        } else {
                            f.CantidadBonif.value = '';
                            document.getElementById("tipo_de_bonificacion").innerHTML = '';
                        }
                    }

                } else {
                    var valor = isNaN(cantidad_a_bonificar);
                    if (valor == true) ////NO ES NUMERO
                    {
                        if ((f.CantidadBonif.value != '') && (f.tipo_de_venta_text.value != '')) {
                            var cantidad_a_bonificar = f.CantidadBonif.value.substring(1);
                            document.getElementById("tipo_de_bonificacion").innerHTML = tipo_de_venta_text + ', se Bonificara ' + cantidad_a_bonificar + ' Caja(s) del Producto ' + al_producto;
                            document.getElementById("tipo_de_bonificacion").style.color = "red"; //rojo
                        } else {
                            document.getElementById("tipo_de_bonificacion").innerHTML = '';
                        }
                    } else {
                        if ((f.CantidadBonif.value != '') && (f.tipo_de_venta_text.value != '')) {
                            document.getElementById("tipo_de_bonificacion").innerHTML = tipo_de_venta_text + ', se Bonificara ' + cantidad_a_bonificar + ' Und(s) del Producto ' + al_producto;
                            document.getElementById("tipo_de_bonificacion").style.color = "red"; //rojo
                        } else {
                            document.getElementById("tipo_de_bonificacion").innerHTML = '';
                        }
                    }
                }
            }

            function producto_no_cargado() {
                var f = document.Formulario;
                f.ProductoBusk.focus();
            }

            function producto_si_cargado() {
                var f = document.Formulario;
                f.Cantidad.focus();
            }

            function Salir() {
                window.close();
            }

            function buscar() {
                var f = document.Formulario;
                if (f.ProductoBusk.value === "") {
                    f.ProductoBusk.focus();
                    alert("Ingrese un producto a buscar");
                    return false;
                }
                f.ActionForm.value = "BuscarProducto";
                f.CProductoBonif.value = "";
                f.submit();
            }

            function eliminar() {
                var Formulario = "Formulario";
                var f = document.getElementById(Formulario);
                if (confirm('Desea limpiar este registro')) {
                    f.ActionForm.value = "EliminaBonificacion";
                    f.submit();
                } else {
                    return;
                }
            }

            function SelecProducto(Valor) {
                var f = document.Formulario;
                f.ActionForm.value = "";
                f.CProductoBonif.value = Valor;
                f.submit();
            }

            function GrabarBonificacion() {
                var f = document.Formulario;


                if (f.CProductoBonif.value === "") {
                    alert("Seleccione un Producto a Bonificar");
                    return false;
                }
                if (f.Cantidad.value === "") {
                    f.Cantidad.focus();
                    alert("Seleccione una cantidad de Venta");
                    return false;
                }
                if ((f.ProductoBusk.value === "") || (f.ProductoBusk.value == 0)) {
                    f.ProductoBusk.focus();
                    alert("Ingrese un Producto a Bonificar ");
                    return false;
                }
                if ((f.CantidadBonif.value === "") || (f.CantidadBonif.value == 0)) {
                    f.CantidadBonif.focus();
                    alert("Ingrese una cantidad a Bonificar diferente a 0 o vacio");
                    return false;
                }
                f.ActionForm.value = "RegistrarBonificacion";
                f.submit();
            }

            function letracc(evt) {
                //var key=evt.keyCode;
                var key = evt ? evt.which : evt.keyCode;
                return (key == 67 || key == 99 || key <= 13 || (key >= 48 && key <= 57));
            }
        </script>
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

            #customers_1 {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers_1 th {
                border: 1px solid #ddd;
                padding: 1px;

            }

            #customers_1 td {
                border: 1px solid #ddd;
                padding: 5px;
                font-size: 12px;
            }

            #customers_1 tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            #customers_1 tr:hover {
                background-color: #FFFF66;
            }

            #customers_1 th {
                padding: 2px;
                text-align: left;
                background-color: #2e91d2;
                color: white;
                font-size: 15px;
            }


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

            table {
                width: 100%;
            }
        </style>
    </head>

    <body <?php if ($ActionForm == "RegistrarBonificacion") { ?>onload="Salir();" <?php } elseif ($codpro_campo == "") { ?> onload="producto_no_cargado();" <?php } elseif ($codpro_campo <> "") { ?> onload="producto_si_cargado();" <?php } ?>width="100%">
        <form name="Formulario" id="Formulario" action="productos.php" method="post" width="100%">
            <input type="hidden" name="ActionForm" value="" />
            <input type="hidden" name="CProducto" value="<?php echo $CProducto; ?>" />
            <input type="hidden" name="CProductoBonif" value="<?php echo $CProductoBonif; ?>" />
            <input type="hidden" name="factor" id="factor" value="<?php echo $factor_campo; ?>">
            <input type="hidden" name="factor_venta" id="factor_venta" value="<?php echo $factorx; ?>">
            <input type="hidden" name="tipo_de_venta_text" id="tipo_de_venta_text" value="">
            <input type="hidden" name="desprod_principal" id="desprod_principal" value="<?php echo $desprod; ?>">
            <table border="0" style="width: 100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td <?php if ($ActionForm <> "") { ?> style="float:left;" align="right" width="49%" <?php } else { ?> width="100%" <?php } ?>>

                        <table style="width: 100%" border="1" id="customers_1" cellpadding="0" cellspacing="0">
                            <tr>
                                <th style="width: 25%" class="LETRA">PRODUCTO PRINCIPAL</th>
                                <th style="width: 75%">
                                    <?php echo $CProducto . ' - ' . $desprod . '- ( FACTOR = ' . $factorx . ' )'; ?>
                                </th>
                            </tr>
                            <tr>
                                <th class="LETRA">CANTIDAD A VENDER</th>
                                <td>
                                    <input type="text" placeholder="Cantidad a Vender" name="Cantidad" maxlength="4" id="Cantidad" onkeypress="return letracc(event);" value="<?php echo $Cantidad; ?>" onkeyup="cantida_venta();" <?php if ($codpro_campo == "") { ?> disabled="disabled" class="letra2" <?php } ?> />
                                    <a id="tipo_de_venta"></a>
                                </td>
                            </tr>
                            <tr>
                                <th class="LETRA">PRODUCTO BONIFICADO</th>
                                <td>
                                    <input class="letra2" type="text" value="<?php echo $codpro_campo; ?>" size="5" readonly />
                                    <input class="letra2" type="text" value="<?php echo $factor_campo2; ?>" size="10" readonly />
                                    <input name="ProductoBusk" type="text" maxlength="100" id="ProductoBusk" style="width: 40%;" value="<?php echo $des; ?>" placeholder="Ingrese a Buscar Producto ..." onclick="this.value = ''" />
                                    <input name="search" type="button" id="search" value="Buscar" onclick="buscar()" class="buscar" />
                                    <?php
                                    if ((strlen($CProductoBonif) > 0) and ($CProductoBonif <> 0)) {
                                    ?>
                                        <input name="delete" type="button" id="delete" value="Quitar" onclick="eliminar()" class="limpiar" />
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="LETRA">CANTIDAD BONIFICADA</th>
                                <td>
                                    <input type="text" placeholder="Cantidad a Bonificar" maxlength="4" name="CantidadBonif" onkeypress="return letracc(event);" id="CantidadBonif" value="<?php echo $CantidadBonif2; ?>" <?php if ($codpro_campo == "") { ?> disabled="disabled" class="letra2" <?php } ?> onkeyup="cantida_a_bonificar();" />
                                    <a id="tipo_de_bonificacion"></a>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <?php
                                    if (strlen($CProductoBonif) > 0) {
                                    ?>
                                        <input type="button" name="Grabar" id="Grabar" class="grabarventa" value="Grabar Datos" onclick="GrabarBonificacion();" />
                                    <?php
                                    }
                                    ?>
                                    <input name="exit" type="button" id="exit" value="Salir" onclick="Salir()" class="salir" />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <?php if ($ActionForm <> "") {                    ?>
                        <td width="50%" style="float:right;">

                            <!-- <iframe src="productos_lista.php?ProductoBusk=<?php echo $ProductoBusk ?>" name="iFrame1" width="100%" height="600" scrolling="Automatic" frameborder="0" id="iFrame1" allowtransparency="0"> </iframe> -->
                            <table style="width: 100%" id="customers">
                                <?php
                                if (is_numeric($ProductoBusk)) {
                                    $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where codbar = '$ProductoBusk' or codpro = '$ProductoBusk' and eliminado='0' ";
                                } else {
                                    $sql3 = "SELECT codpro,desprod,codmar,factor FROM producto where desprod like '$ProductoBusk%' and eliminado='0' ";
                                }
                                $result3 = mysqli_query($conexion, $sql3);
                                if (mysqli_num_rows($result3)) {
                                ?>
                                    <thead id="Topicos_Cabecera_Datos">

                                        <tr>
                                            <th style="text-align: left;" class="LETRA">CODIGO</th>
                                            <th style="text-align: left;" class="LETRA">SELECCIONE UN PRODUCTO</th>
                                            <th style="text-align: left;" class="LETRA">MARCA</th>
                                            <th style="text-align: left;" class="LETRA">FACTOR</th>
                                            <th style="text-align: left;" class="LETRA"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="gtnp_Listado_Datos">
                                        <?php
                                        $i = 0;
                                        while ($row3 = mysqli_fetch_array($result3)) {
                                            $codpro         = $row3['codpro'];
                                            $desprod        = $row3['desprod'];
                                            $codmar         = $row3['codmar'];
                                            $factor         = $row3['factor'];
                                            $sqlMarcaDet = "SELECT destab,abrev FROM titultabladet where codtab = '$codmar'";
                                            $resultMarcaDet = mysqli_query($conexion, $sqlMarcaDet);
                                            if (mysqli_num_rows($resultMarcaDet)) {
                                                while ($row1 = mysqli_fetch_array($resultMarcaDet)) {
                                                    $marca     = $row1['destab'];
                                                    $abrev     = $row1['abrev'];
                                                    if ($abrev == '') {
                                                        $marca = substr($marca, 0, 4);
                                                    } else {
                                                        $marca = substr($abrev, 0, 4);
                                                    }
                                                }
                                            }
                                            $t = $i % 2;
                                            if ($t == 1) {
                                                $Color = "#f5f8f9";
                                            } else {
                                                $Color = "#D4D0C8";
                                            }
                                        ?>
                                            <tr>
                                                <td><?php echo $codpro; ?></td>
                                                <td><?php echo $desprod; ?></td>
                                                <td><?php echo $marca; ?></td>
                                                <td style="text-align: center;"><?php echo $factor; ?></td>
                                                <td style="text-align: center;"><input type="button" class="limpiar" name="Seleccionar" value="Seleccionar" onclick="SelecProducto(<?php echo $codpro; ?>);" /></td>
                                            </tr>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </tbody>
                                <?php
                                } else {
                                ?>

                                    <div class="siniformacion">
                                        <center>
                                            No se logro encontrar informacion con los datos ingresados
                                        </center>
                                    </div>
                                <?php
                                }
                                ?>


                            </table>
                        </td>
                    <?php } ?>
                </tr>
            </table>

        </form>
    </body>

    </html>
<?php
}
?>


<script>
    $(document).ready(function() {
            $('#customers').DataTable({
                // "pageLength": 25,
                language: {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "NingÃºn dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Ãltimo",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                }
            });
        }

    );
</script>