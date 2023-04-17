<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
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

    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>

    <script src="../../select2/js/select2.min.js"></script>



    <?php require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../../funciones/calendar.php"); ?>
    <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <?php require_once("../local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    ?>
    <script language="JavaScript">
        function validar1() {
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
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "cuentas_cobrar1.php";
            } else {
                f.action = "cuentas_cobrar_prog.php";
            }
            f.submit();
        }

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }

        function printer() {
            window.marco.print();
        }
    </script>
</head>
<?php
$date = date('d/m/Y');
$val = $_REQUEST['val'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$report = $_REQUEST['report'];
$reporte = $_REQUEST['reporte'];
$tipo = $_REQUEST['tipo'];
$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}
?>

<body>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE CUENTAS POR COBRAR </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td width="76" class="LETRA">SALIDA</td>
                            <td width="135">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select> </td>
                            <td width="94" class="LETRA">
                                <div align="right">TIPO DE BUSQUEDA</div>
                            </td>
                            <td width="365">
                                <select name="tipo" id="tipo">
                                    <!--<option value="1" <?php if ($tipo == 1) { ?> selected="selected"<?php } ?>>CUENTAS POR PAGAR POR PROVEEDOR</option>
                                        <option value="2" <?php if ($tipo == 2) { ?> selected="selected"<?php } ?>>CUENTAS POR PAGAR POR FECHA DE VENCIMIENTO</option>
                                        <option value="3" <?php if ($tipo == 3) { ?> selected="selected"<?php } ?>>CUENTAS POR PAGAR POR FECHA DE INGRESO DE MERCADERIA</option>-->
                                    <option value="4" <?php if ($tipo == 4) { ?> selected="selected" <?php } ?>>CUENTAS POR COBRAR</option>
                                    <option value="5" <?php if ($tipo == 5) { ?> selected="selected" <?php } ?>>CUENTAS COBRADAS</option>
                                </select>
                            </td>
                            <td width="81" class="LETRA">TIPO DE REPORTE</td>
                            <td width="180">
                                <select name="reporte" id="reporte">
                                    <option value="1" <?php if ($reporte == 1) { ?> selected="selected" <?php } ?>>RESUMIDO </option>
                                    <!-- <option value="2" <?php if ($reporte == 2) { ?> selected="selected" <?php } ?>>RESUMIDO POR FECHA</option> -->
                                    <option value="3" <?php if ($reporte == 3) { ?> selected="selected" <?php } ?>>DETALLADO</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td width="76" class="LETRA">FECHA INICIO </td>
                            <td width="133">
                                <input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>">
                            </td>
                            <td width="94" class="LETRA">
                                <div align="right">FECHA FIN </div>
                            </td>
                            <td width="297">
                                <input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                            if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            }
                                                                                            ?>"></td>
                            <td width="306" colspan="2">
                                <div align="right">
                                    <input name="val" type="hidden" id="val" value="1" />
                                    <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                    <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                                    <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                                </div>
                            </td>
                        </tr>
                    </table>

                </form>
                <div align="left"><img src="../../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if (($val == 1) || ($vals == 2)) {
    ?>
        <iframe src="cuentas_cobrar2.php?val=<?php echo $val ?>&tipo=<?php echo $tipo ?>&reporte=<?php echo $reporte ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
        </iframe>
    <?php }
    ?>
</body>

</html>
<script>
    $('#tipo').select2();
    $('#local').select2();
    $('#reporte').select2();
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>