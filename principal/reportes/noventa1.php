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
        <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css"/>
        <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
            <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
            <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
            <script type="text/javascript">
                window.addEvent('domready', function () {
                    myCal = new Calendar({date1: 'd/m/Y'});
                    myCal = new Calendar({date2: 'd/m/Y'});
                });
            </script>

            <link href="../select2/css/select2.min.css" rel="stylesheet" />
            <script src="../select2/jquery-3.4.1.js"></script>
            <script src="../select2/js/select2.min.js"></script>


            <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
            <?php require_once("../../funciones/calendar.php"); ?>
            <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
            <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
            <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
            <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
            <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL?>
            <script language="JavaScript">
                function validar1()
                {
                    var f = document.form1;
                    if (f.date1.value == "")
                    {
                        alert("Ingrese una Fecha");
                        f.date1.focus();
                        return;
                    }
                    if (f.date2.value == "")
                    {
                        alert("Ingrese una Fecha");
                        f.date2.focus();
                        return;
                    }
                    var tip = document.form1.report.value;
                    if (tip == 1)
                    {
                        f.action = "noventa1.php";
                    } else
                    {
                        f.action = "noventa_prog.php";
                    }
                    f.submit();
                }
                function salir()
                {
                    var f = document.form1;
                    f.method = "POST";
                    f.target = "_top";
                    f.action = "../index.php";
                    f.submit();
                }
                function printer()
                {
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
    $local = $_REQUEST['local'];
    $resumen = $_REQUEST['resumen'];
    $sql = "SELECT export FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
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
    if ($local <> 'all') {
        require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
    }
////////////////////////////
    if ($val == 1) {
        if ($local == 'all') {
            $sql = "SELECT venta_nosave.invfec,codpro,canpro,fraccion,prisal,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave.invfec between '$date1' and '$date2'";
        } else {
            $sql = "SELECT venta_nosave.invfec,codpro,canpro,fraccion,prisal,pripro FROM venta_nosave inner join venta_nosave_detalle on venta_nosave.invnum = venta_nosave_detalle.invnum where venta_nosave.invfec between '$date1' and '$date2' and sucursal = '$local'";
        }
        $sql = mysqli_query($conexion, $sql);
        $total_registros = mysqli_num_rows($sql);
        $total_paginas = ceil($total_registros / $registros);
    }

    $sql = "SELECT nlicencia FROM datagen ";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $nlicencia = $row['nlicencia'];
        }
    }
    ?>
    <body>
        <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
            <table width="100%" border="0">
                <tr>
                    <td><b><u>REPORTE DE VENTAS NO REALIZADAS </u></b>
                        <form id="form1" name="form1" method = "post" action="">
                            <table class="tablarepor" width="100%" border="0">
                                <tr>
                                    <td width="119" class="LETRA">SALIDA</td>
                                    <td width="208">
                                        <select name="report" id="report">
                                            <option value="1">POR PANTALLA</option>
                                            <?php if ($export == 1) { ?>
                                                <option value="2">EN ARCHIVO XLS</option>
                                            <?php } ?>
                                        </select>            </td>
                                    <td width="50" class="LETRA"><div align="right">LOCAL</div></td>
                                    <td width="161">
                                        <select style="width:150px" name="local" id="local">
                                            <?php if ($nombre_local == 'LOCAL0') { ?>
                                                <option value="all" <?php if ($local == 'all') { ?> selected="selected"<?php } ?>>TODOS LOS LOCALES</option>
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
                                                $nombre = $row["nombre"];
                                                if ($nombre == '') {
                                                    $locals = $nloc;
                                                } else {
                                                    $locals = $nombre;
                                                }
                                                ?>
                                                <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected"<?php } ?>><?php echo $locals ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="50" class="LETRA" align="right">RESUMEN			</td>
                                    <td width="255"><label>
                                            <select name="resumen" id="resumen">
                                                <option value="1" <?php if ($resumen == 1) { ?>selected="selected"<?php } ?>>RESUMEN POR SUCURSAL</option>
                                                <option value="2" <?php if ($resumen == 2) { ?>selected="selected"<?php } ?>>RESUMEN POR VENDEDOR</option>
                                                <option value="3" <?php if ($resumen == 3) { ?>selected="selected"<?php } ?>>RESUMEN POR MARCA</option>
                                                <option value="4" <?php if ($resumen == 4) { ?>selected="selected"<?php } ?>>RESUMEN POR PRODUCTO</option>
                                                <option value="5" <?php if ($resumen == 5) { ?>selected="selected"<?php } ?>>RESUMEN POR LINEA Y USO DEL PRODUCTO</option>
                                            </select>
                                        </label></td>
                                    <td width="23">
                                        <?php
                                        if (($pagina - 1) > 0) {
                                            ?>
                                            <a href="noventa2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&resumen=<?php echo $resumen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                        <?php }
                                        ?></td>
                                    <td width="27"><?php
                                        if (($pagina + 1) <= $total_paginas) {
                                            ?>
                                            <a href="noventa2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&resumen=<?php echo $resumen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                        <?php }
                                        ?></td>
                                </tr>
                                
                                <tr>
                                    <td width="119" class="LETRA">FECHA INICIO</td>
                                    <td width="98"><input type="text" name="date1" id="date1" size="12" value="<?php
                                        if ($date1 == "") {
                                            echo $date;
                                        } else {
                                            echo $date1;
                                        }
                                        ?>" /></td>
                                    <!--<td width="80">&nbsp;</td>-->
                                    <td width="76" class="LETRA"> <div align="right">FECHA FINAL</div></td>
                                    <td width="162"><input type="text" name="date2" id="date2" size="12" value="<?php
                                        if ($date2 == "") {
                                            echo $date;
                                        } else {
                                            echo $date2;
                                        }
                                        ?>" /></td>
                                    <td width="1">&nbsp;</td>
                                    <td  colspan="3"width="220"><input name="val" type="hidden" id="val" value="1" />
                                        <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar"/>
                                        <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir"/>
                                        <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir"/></td>
                                </tr>
                            </table>
                            <div align="left"><img src="../../images/line2.png" width="940" height="4" /></div>
                            <table width="100%" border="0">
                                
                            </table>
                        </form>
                        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
                </tr>
            </table>
            <br>
                <?php
                if (($val == 1) || ($vals == 2)) {
                    
                   //  require_once("noventa2.php");
                    ?>
                    <iframe src="noventa2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&resumen=<?php echo $resumen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
                    </iframe>
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
                    $('#resumen').select2();

                </script>
                <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                <script type="text/javascript" src="../../funciones/js/calendar.js"></script>

