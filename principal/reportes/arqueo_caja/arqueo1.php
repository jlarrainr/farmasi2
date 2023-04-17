<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />
    <link href="../css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
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
    <style>
        .table {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .LETRA {
            font-family: Tahoma;
            font-size: 11px;
            line-height: normal;
            color: '#5f5e5e';
            font-weight: bold;
        }

        input {
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 12px;
            background-color: white;
            background-position: 3px 3px;
            background-repeat: no-repeat;
            padding: 2px 1px 2px 5px;

        }

        .LETRA2 {
            background: #d7d7d7
        }

        #date1,
        #date2 {
            width: auto;
        }
    </style>
    <?php
    require_once('../../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once('../../../titulo_sist.php'); //CONEXION A BASE DE DATOS
    require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../../funciones/calendar.php");
    require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    require_once("../local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    require_once('../../../convertfecha.php');
    ?>

    <script language="JavaScript">
        function buscar() {


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
            // document.form1.val.value = "";
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "arqueo1.php";
            } else {
                f.action = "arqueo_excel.php";
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
$val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";


$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$vendedor = isset($_REQUEST['vendedor']) ? ($_REQUEST['vendedor']) : "";

$ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";

$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}

//OBTIENE LA PRIMERA FECHAA DE REGISTRO DE MOVMAE
$sql = "SELECT invfec FROM movmae order by invfec asc limit 1";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $PrimeraFecha = $row['invfec'];
    }
}


?>

<body>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE ARQUEO DE CAJA </u></b>
                <form id="form1" name="form1" method="post" action="">

                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td class="LETRA">SALIDA</td>
                            <td><label>
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </td>
                            <td class="LETRA">USUARIOS</td>
                            <td>

                                <select name="vendedor" id="vendedor">
                                    <option value="all"> Todos los usuarios </option>
                                    <?php
                                    $sql = "SELECT usecod,nomusu FROM usuario where estado='1'";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $usecod = $row["usecod"];
                                        $nomusu = $row["nomusu"];
                                    ?>
                                        <option value="<?php echo $usecod; ?>" <?php if ($vendedor == $usecod) { ?> selected="selected" <?php } ?>><?php echo $nomusu; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                            <td width="10%" class="LETRA">FECHA INICIO</td>
                            <td>
                                <input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>">
                            </td>
                            <td width="10%" class="LETRA">
                                <div align="right">FECHA FINAL</div>
                            </td>
                            <td width="133">
                                <input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                            if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            }
                                                                                            ?>">
                            </td>

                            <td>
                                <input name="ck" type="checkbox" id="ck" value="1" <?php if ($ck == 1) { ?>checked="checked" <?php } ?> />
                                <label for="ck" class="LETRA">Mostrar Cierres de Cajas Distintos</label>
                            </td>
                            <td><input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit2" value="Buscar" onclick="buscar()" class="buscar" />
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

        require_once("arqueo2.php");
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
    <script src="../js/gotop.js"></script>
</body>

</html>
<script>
    $('#vendedor').select2();
    $('#report').select2();
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>