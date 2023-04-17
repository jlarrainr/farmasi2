<?php
$total_paginas = 0;
include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />
    <link href="css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />

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
        });
    </script>

    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>

    <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../funciones/calendar.php"); ?>
    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES 
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES 
    ?>
    <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL 
    ?>
    <script type="text/javascript" src="../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../funciones/ajax-dynamic-list.js"></script>
    <script language="JavaScript">
        function validar() {
            var f = document.form1;
            if (f.desc.value == "") {
                alert("Ingrese el Numero del Documento");
                f.desc.focus();
                return;
            }
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "kardex1.php";
            } else {
                f.action = "kardex_prog.php";
            }
            f.submit();
        }

        function validar1() {
            var f = document.form1;
            if (f.country_ID.value == "") {
                alert("Ingrese un Producto registrado en el Sistema");
                f.country.focus();
                return;
            }
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
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "kardex1.php";
            } else {
                f.action = "kardex_prog.php";
            }
            f.submit();
        }

        function sf() {
            var f = document.form1;
            document.form1.country.focus();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../index.php";
            f.submit();
        }

        function printer() {
            window.marco.print();
        }
    </script>
</head>
<?php
$date = date('d/m/Y');
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$country_ID = isset($_REQUEST['country_ID']) ? ($_REQUEST['country_ID']) : "";
$country = isset($_REQUEST['country']) ? ($_REQUEST['country']) : "";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$SoloCompras = isset($_REQUEST['SoloCompras']) ? ($_REQUEST['SoloCompras']) : "";

$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}
////////////////////////////
$registros = 40;
$pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $registros;
}

$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
    }
}
?>


<script language="javascript" type="text/javascript">
    function st() {
        var f = document.form1;
        f.country.focus();
    }
</script>

<body onload="st();">
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE KARDEX DE PRODUCTOS</u></b>
                <form id="form1" name="form1" method="post">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td width="60" class="LETRA">SALIDA</td>
                            <td width="172" colspan="4">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <!--                                                <td width="58">&nbsp;</td>
                                                <td width="504">&nbsp;</td>-->
                            <td width="24">
                                <?php
                                if (($pagina - 1) > 0) {
                                ?>
                                    <a href="kardex2.php?val=<?php echo $val ?>&country=<?php echo $country ?>&country_ID=<?php echo $country_ID ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../images/play1.gif" width="16" height="16" border="0" /> </a>
                                <?php }
                                ?>
                            </td>
                            <td width="24">
                                <?php
                                if (($pagina + 1) <= $total_paginas) {
                                ?>
                                    <a href="kardex2.php?val=<?php echo $val ?>&country=<?php echo $country ?>&country_ID=<?php echo $country_ID ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0" /> </a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="60" class="LETRA">PRODUCTO</td>
                            <td colspan="6">
                                <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event), this.value = this.value.toUpperCase();" size="90" class="busk" value="<?php echo $country ?>" onclick="this.value = ''" autocomplete="nope" />
                                <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $country_ID ?>">
                            </td>
                        </tr>

                        <tr>
                            <td width="60" class="LETRA">COMPRAS</td>
                            <td colspan="6">
                                <input type="checkbox" name="SoloCompras" <?php if ($SoloCompras == 1) { ?>checked<?php } ?> id="SoloCompras" value="1" />
                            </td>
                        </tr>

                        <tr>
                            <td width="60" class="LETRA">FECHA INICIO</td>
                            <td width="98"><input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                                        if ($date1 == "") {
                                                                                                            echo $date;
                                                                                                        } else {
                                                                                                            echo $date1;
                                                                                                        }
                                                                                                        ?>" />
                            </td>
                            <!--<td width="23">&nbsp;</td>-->
                            <td width="106" class="LETRA">
                                <div align="right">FECHA FINAL</div>
                            </td>
                            <td width="133"><input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                                        if ($date2 == "") {
                                                                                                            echo $date;
                                                                                                        } else {
                                                                                                            echo $date2;
                                                                                                        }
                                                                                                        ?>" /></td>
                            <td width="80" class="LETRA" align="right">LOCAL</td>
                            <td width="119">
                                <select style="width:120px" name="local" id="local">
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
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
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nombre; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td width="220">
                                <input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                            </td>
                        </tr>
                    </table>

                </form>
                <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        $country = html_entity_decode($country);

        require_once("kardex2.php");
    ?>
        <!--<iframe src="kardex2.php?val=<?php echo $val; ?>&country_ID=<?php echo $country_ID; ?>&&date1=<?php echo $date1 ?>&&date2=<?php echo $date2 ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&local=<?php echo $local ?>&&country=<?php echo $country; ?>&&SoloCompras=<?php echo $SoloCompras; ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
                                </iframe>-->
    <?php
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
    $('#local').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>