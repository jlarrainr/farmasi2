<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="gb18030">

    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
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
    <script language="JavaScript">
        var statSend = false;
        function generarPrepedido() {
            if (!statSend) {


                var f = document.form1;

                ventana = confirm("Desea Generar Prepedido");
                if (ventana) {
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "prepedido/prepedido_reg.php";
                    f.submit();

                    statSend = true;
                    return true;
                } else {
                    statSend = false;
                    return false;
                }



            } else {
                alert("El formulario ya se esta enviando...");
                return false;
            }
        }

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
                f.action = "sugerencia_drogueria1.php";
            } else {
                f.action = "sugerencia1_prog.php";
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
$date         = date('d/m/Y');
$val         = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
$date1         = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2         = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$report     = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
$local         = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
$TipBusk     = isset($_REQUEST['TipBusk']) ? ($_REQUEST['TipBusk']) : "";
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
if ($local <> 'all') {
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}
////////////////////////////
if ($local == 'all') {
    $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2' and estado = '0' and val_habil = '0' group by usecod order by nrovent";
} else {
    $sql = "SELECT usecod FROM venta where invfec between '$date1' and '$date2' and estado = '0' and val_habil = '0' and sucursal = '$local' group by usecod order by nrovent";
}
$sql = mysqli_query($conexion, $sql);
$total_registros = mysqli_num_rows($sql);
$total_paginas = ceil($total_registros / $registros);
?>

<body>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE DE SUGERENCIA DE COMPRAS - SIN TRANSFERENCIAS</u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table class="tablarepor" width="100%" border="0">
                        <tr>
                            <td width="119" class="LETRA">SALIDA</td>
                            <td width="172">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="58" class="LETRA">
                                <div align="right">LOCAL</div>
                            </td>
                            <td width="250">
                                <select name="local" id="local" style="width:auto;">
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
                            <td width="70" class="LETRA">
                                <div align="center">BUSCAR POR</div>
                            </td>
                            <td width="180">
                                <select name="TipBusk" id="TipBusk">
                                    <option <?php if ($TipBusk == 1) { ?>selected<?php } ?> value="1">Todos los productos vendidos</option>
                                    <option <?php if ($TipBusk == 4) { ?>selected<?php } ?> value="4">Pronóstico de demanda(stock de seguridad x2)</option>
                                    <option <?php if ($TipBusk == 3) { ?>selected<?php } ?> value="3">Compra mínima sugerida</option>
                                    <option <?php if ($TipBusk == 2) { ?>selected<?php } ?> value="2">Solo productos agotados</option>
                                </select>
                            </td>
                            <td width="24">
                                <?php
                                if (($pagina - 1) > 0) {
                                ?>
                                    <a href="sugerencia_drogueria1.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../images/play1.gif" width="16" height="16" border="0" /> </a>
                                <?php }
                                ?>
                            </td>
                            <td width="24"><?php
                                            if (($pagina + 1) <= $total_paginas) {
                                            ?>
                                    <a href="sugerencia_drogueria1.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0" /> </a>
                                <?php }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="119" class="LETRA">FECHA INICIO</td>
                            <td width="98">
                                <input type="text" name="date1" id="date1" size="12" value="<?php if ($date1 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date1;
                                                                                            } ?>">
                            </td>
                            <!--<td width="23">&nbsp;</td>-->
                            <td width="106" class="LETRA">
                                <div align="right">FECHA FINAL</div>
                            </td>
                            <td width="133">
                                <input type="text" name="date2" id="date2" size="12" value="<?php if ($date2 == "") {
                                                                                                echo $date;
                                                                                            } else {
                                                                                                echo $date2;
                                                                                            } ?>">
                            </td>
                            <!--<td width="199">&nbsp;</td>-->
                            <td align="right" colspan="4" width="250"><input name="val" type="hidden" id="val" value="1" />
                                <?php
                                if ($local != '' && $local != 'all') {
                                ?>
                                      <input type="button" name="prepedido" value="Prepedido" onclick="generarPrepedido()" class="grabarventa"/>
                                <?php
                                }
                                ?>

                                <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />
                                <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                    <table width="100%" border="0">

                    </table>
                </form>
                <div align="center"><img src="../../images/line2.png" width="940" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        require_once("sugerencia_drogueria2.php");
    ?>
        <!--   <iframe src="sugerencia2.php?val=<?php echo $val ?>&TipBusk=<?php echo $TipBusk; ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
                </iframe>-->
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
    <script src="js/gotop.js"></script>
</body>

</html>
<script>
    $('#local').select2();
    $('#TipBusk').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>