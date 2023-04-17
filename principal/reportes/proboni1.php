<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
    <script type="text/javascript">
        window.addEvent('domready', function() {
            myCal = new Calendar({
                date1: 'Y-m-d'
            });
            myCal = new Calendar({
                date2: 'Y-m-d'
            });
        });
    </script>
    <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../titulo_sist.php');
    require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL  
    ?>
    <?php require_once("../../funciones/calendar.php"); ?>
    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <script type="text/javascript" src="../../funciones/ajax.js"></script>
    <script type="text/javascript" src="../../funciones/ajax-dynamic-list1.js"></script>
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>

    <script language="JavaScript">
        function validar1() {
            var f = document.form1;
            if (f.country.value == "") {
                alert("Ingrese la Marca");
                f.country.focus();
                return;
            }
            document.form1.vals.value = "";
            document.form1.ck1.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "proboni1.php";
            } else {
                f.action = "proboni_prog.php";
            }
            f.submit();
        }


        function validar2() {
            var f = document.form1;
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
            document.form1.val.value = "";

            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "proboni1.php";
            } else {
                f.action = "proboni_prog.php";
            }
            f.submit();
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
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
$val = $_REQUEST['val'];
$vals = $_REQUEST['vals'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$ck1 = $_REQUEST['ck1'];
$local = $_REQUEST['local'];



$country = $_REQUEST['country'];
$report = $_REQUEST['report'];
$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}
$sql = "SELECT nlicencia FROM datagen ";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $nlicencia = $row['nlicencia'];
    }
}
////////////////////////////
$registros = 40;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $registros;
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
            <td><b><u>REPORTE DE PRODUCTOS BONIFICADOS </u></b>
                <form id="form1" name="form1" method="post">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td width="119" class="LETRA">SALIDA</td>
                            <td width="172" colspan="3">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td class="LETRA" align="right">LOCAL</td>
                            <td>
                                <select style="width:150px" name="local" id="local">
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                    } else {
                                        $sql = "SELECT * FROM xcompa where codloc = '$codigo_local' ORDER BY codloc ASC LIMIT $nlicencia";
                                    }
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $loc = $row["codloc"];

                                        $nombre = $row["nombre"];

                                    ?>
                                        <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nombre ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <!--                                    <td width="58">&nbsp;</td>
                                    <td width="504">&nbsp;</td>-->
                        </tr>
                        <tr>
                            <td width="119" class="LETRA">MARCA</td>
                            <td colspan="4">
                                <input name="country" type="text" id="country" size="50" class="busk" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event)" size="70" onclick="this.value = ''" value="<?php echo $country ?>" />
                                <input name="val" type="hidden" id="val" value="1" />
                            </td>
                            <td>
                                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />

                            </td>
                        </tr>

                        <tr bgcolor="#ececec">
                            <td class="LETRA">FECHA INICIO</td>
                            <td>
                                <input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>">
                            </td>

                            <td class="LETRA">
                                <div align="right">FECHA FINAL</div>
                            </td>
                            <td>
                                <input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                            if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            }
                                                                                            ?>">
                            </td>
                            <td>
                                <input name="ck1" type="checkbox" id="ck1" value="1" <?php if ($ck1 == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />


                                <label for="ck1" class="LETRA"> Mostrar Lista detallada por Fecha </label>
                            </td>
                            <td><input name="vals" type="hidden" id="vals" value="2" />
                                <input type="button" name="Submit2" value="Buscar" onclick="validar2()" class="buscar" />
                                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />

                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                            </td>
                        </tr>
                    </table>
                    <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0">

                    </table>
                </form>
                <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if (($val == 1) || ($vals == 2)) {
    ?>
        <iframe src="proboni2.php?val=<?php echo $val ?>&country=<?php echo $country ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&vals=<?php echo $vals ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&ck1=<?php echo $ck1 ?>&local=<?php echo $local ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
        </iframe>
    <?php }
    ?>
</body>

</html>
<script>
    $('#local').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>