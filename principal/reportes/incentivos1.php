<?php include('../session_user.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>

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

    <?php 

        require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
  
        require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    
        //require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
        
        require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    
        require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


        $dateI = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] :  date("d/m/Y");
        $dateF = isset($_REQUEST["date2"]) ?  $_REQUEST["date2"]:  date("d/m/Y");


    ?>
    <script language="JavaScript">
 

        function buscar() {
            var f = document.form1;
            if (f.nro.value == "") {
                alert("Ingrese el Numero del Documento");
                f.nro.focus();
                return;
            }
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "incentivos1.php";
            } else {

                var date1 = document.getElementById('date1').value;
                var date2 = document.getElementById('date2').value;

                var dts1 = date1.replace("/", "-");
                var dts2 = date2.replace("/", "-");


                var urlincentivo = "incentivos1_prog.php?date1=" + dts1.replace("/", "-") + "&date2=" + dts2.replace("/", "-") ;

                //alert(urlincentivo);


                f.action = urlincentivo;
            }
            f.submit();
        }

        var nav4 = window.Event ? true : false;

        function comas(evt) {
            var key = nav4 ? evt.which : evt.keyCode;
            return (key <= 13 || key == 44 || key == 37 || key == 39 || (key >= 48 && key <= 57));
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

        function sf() {
            document.form1.nro.focus();
        }

    </script>
    <style>
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
    </style>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
</head>
<?php
//////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
$val = $_REQUEST['val'];
$nro = $_REQUEST['nro'];
$tipo = $_REQUEST['tipo'];
$local = $_REQUEST['local'];
if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}
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
///////////////////////////////////
?>

<body onload="sf();">
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE PRODUCTOS INCENTIVADOS </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td width="145" class="LETRA">SALIDA</td>
                            <td width="146"><select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select> </td>
                            <td width="58" class="LETRA">
                                <div align="right">TIPO</div>
                            </td>
                            <td width="504" colspan="2">
                                <select name="tipo" id="tipo" style="width:auto;">
                                    <option value="1" <?php if ($tipo == 1) { ?>selected="selected" <?php } ?>>DETALLADO POR VENTA</option>
                                    <option value="2" <?php if ($tipo == 2) { ?>selected="selected" <?php } ?>>RESUMIDO POR PRODUCTO</option>
                                    <option value="3" <?php if ($tipo == 3) { ?>selected="selected" <?php } ?>>RESUMIDO POR VENDEDOR</option>
                                    <option value="4" <?php if ($tipo == 4) { ?>selected="selected" <?php } ?>>RESUMIDO POR SUCURSAL</option>
                                    <option value="5" <?php if ($tipo == 5) { ?>selected="selected" <?php } ?>>DETALLADO POR VENDEDOR</option>
                                    <option value="6" <?php if ($tipo == 6) { ?>selected="selected" <?php } ?>>DETALLADO POR VENDEDOR CON SUCURSAL</option>
                                    <option value="7" <?php if ($tipo == 7) { ?>selected="selected" <?php } ?>>DETALLADO POR VENTA POR VENDEDOR</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td width="100" class="LETRA">NRO DE INCENTIVO </td>
                            <td width="100">
                                <input name="nro" type="text" id="nro" onkeypress="return comas(event)" size="14" maxlength="14" value="<?php echo $nro ?>" /> </td>
                            <td width="58" class="LETRA">
                                <div align="right">LOCAL</div>
                            </td>
                            <td width="153">
                                <select style="width:242px" name="local" id="local">
                                    <?php if ($nombre_local == 'LOCAL0') { ?>
                                        <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
                                    <?php } ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                    } else {
                                        $sql = "SELECT * FROM xcompa where codloc = '$codigo_local'";
                                    }
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $loc = $row["codloc"];
                                        $nloc = $row["nomloc"];
                                    ?>
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $row["nombre"] ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="330"><input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" onclick="buscar()" class="buscar" />
                                <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir" /></td>
                            <!--                                <td width="70">&nbsp;</td>-->
                        </tr>
                        <tr>
                            <td width="100" class="LETRA">FECHA INICIO</td>
                            <td width="153">
                                <input type="date" name="date1" id="date1" size="12" value="<?=$dateI?>">
                            </td>
                            
                            <td width="10" class="LETRA">FECHA FIN</td>
                            <td width="10">
                                <input type="date" name="date2" id="date2" size="12" value="<?=$dateF?>">
                            </td>
                        </tr>
                    </table>

                </form>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {

        require_once("incentivos2.php");
    ?>
        <!-- <iframe src="incentivos2.php?nro=<?php echo $nro ?>&tipo=<?php echo $tipo ?>&val=<?php echo $val ?>&local=<?php echo $local ?>" name="marco" id="marco" width="100%" height="480" scrolling="Automatic" frameborder="0" allowtransparency="0">
        </iframe> -->
    <?php }
    ?>
    <!-- <div class="go-top-container" title="Vuelve al comienzo">
        <div class="go-top-button" title="Vuelve al comienzo">
            <a id="volver-arriba" href="#" title="Vuelve al comienzo" style="  cursor:pointer;">
                <i class="fas fa-chevron-up" title="Vuelve al comienzo">

                </i>
            </a>
        </div>
    </div>
    <script src="js/gotop.js"></script> -->
</body>

</html>
<script>
    $('#local').select2();
    $('#tipo').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>