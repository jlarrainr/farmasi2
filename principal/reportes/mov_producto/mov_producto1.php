<?php include('../../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
    <link rel="STYLESHEET" type="text/css" href="../../../funciones/codebase/dhtmlxcombo.css">
    <link href="../css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
    <script>
        window.dhx_globalImgPath = "../../../funciones/codebase/imgs/";
    </script>
    <script src="../../../funciones/codebase/dhtmlxcommon.js"></script>
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
    <?php require_once("../../../funciones/functions.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../../convertfecha.php"); //DESHABILITA TECLAS
    ?>
    <?php require_once("../../../funciones/calendar.php"); ?>
    <?php require_once("../../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    ?>
    <!--<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<link href="../select2/css/select2.min.css" rel="stylesheet" />
<script src="../select2/js/select2.min.js"></script>-->

    <script language="JavaScript">
        function buscar() {
            var f = document.form1;
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "mov_producto1.php";
            } else {
                f.action = "mov_producto_prog.php";
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

        function sf() {
            var z = dhtmlXComboFromSelect("cliente");
            z.enableFilteringMode(true);
        }
    </script>
</head>
<?php

$date = date('d/m/Y');
$val = $_REQUEST['val'];
$date1 = $_REQUEST['date1'];
$date2 = $_REQUEST['date2'];
$local = $_REQUEST['local'];
$opcion = $_REQUEST['opcion'];
$sql = "SELECT export FROM usuario where usecod = '$usuario'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $export = $row['export'];
    }
}


////////////////////////////////////
?>

<body>
    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE REGISTROS DE PRODUCTOS </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table class="tablarepor" width="100%" border="0">
                        <tr>
                            <td width="5%" class="LETRA">SALIDA</td>
                            <td width="20%"><select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="5%" class="LETRA">
                                <div align="right">LOCAL</div>
                            </td>
                            <td width="20%">
                                <select name="local" id="local" style="width:120px">
                                    <?php if ($nombre_local == 'LOCAL0') { ?>
                                        <option value="all" <?php if ($local == 'all') { ?> selected="selected" <?php } ?>>TODOS LOS LOCALES</option>
                                    <?php } ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT * FROM xcompa order by codloc";
                                    } else {
                                        $sql = "SELECT * FROM xcompa where codloc = '$codigo_local'";
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
                                        <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="55%" class="LETRA">
                                <div>OPCIONES DE PRODUCTO
                                    <select name="opcion" id="opcion" style="width:120px">
                                        <option value="1" <?php if ($opcion == 1) { ?> selected="selected" <?php } ?>>CREADO</option>
                                        <option value="2" <?php if ($opcion == 2) { ?> selected="selected" <?php } ?>>ACTUALIZADO</option>
                                       <!-- <option value="3" <?php if ($opcion == 3) { ?> selected="selected" <?php } ?>>ELIMINADO</option>-->
                                        <option value="4" <?php if ($opcion == 4) { ?> selected="selected" <?php } ?>>VER TODOS LOS MOVIMIENTOS</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="LETRA">DESDE</td>
                            <td><input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                            if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            }
                                                                                            ?>" /></td>
                            <td align="right" class="LETRA">HASTA</td>
                            <td><input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                            if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            }
                                                                                            ?>" /></td>




                            <td colspan="4" width="150"><label>
                                    <div align="right">
                                        <input name="val" type="hidden" id="val" value="1" />
                                        <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                                        <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir" />
                                        <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir" />
                                    </div>
                                </label></td>

                        </tr>
                    </table>

                </form>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
        </tr>
    </table>
    <br>
    <?php

    if ($val == 1) {

        require_once('mov_producto2.php');
    ?>

    <?php }
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
    $('#local').select2();
    $('#opcion').select2();
</script>
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>