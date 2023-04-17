<?php
include('../session_user.php');
$total_paginas = 0;
$pagina = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            <title>Documento sin t&iacute;tulo</title>
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <link href="css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
<link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
                <link href="../select2/css/select2.min.css" rel="stylesheet" />
                <script src="../select2/jquery-3.4.1.js"></script>
                <script src="../select2/js/select2.min.js"></script>

                <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
                <?php require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS?>
                <?php require_once("../../funciones/calendar.php"); ?>
                <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
                <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
                <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
                <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL ?>
                <script language="JavaScript">
                    function buscar()
                    {
                        var f = document.form1;
                        var tip = document.form1.report.value;
                        if (tip == 1)
                        {
                            f.action = "rentabilidad1.php";
                        } else
                        {
                            f.action = "rentabilidad_prog.php";
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
                    function selected()
                    {
                        var f = document.form1;
                        var l = document.form1.local.value;
                        if (l == "LOCAL0")
                        {
                            document.form1.local1.disabled = false;
                        } else
                        {
                            document.form1.local1.disabled = true;
                        }
                    }
                    function sf()
                    {
                        var f = document.form1;
                        document.form1.local1.disabled = true;
                    }
                    function printer()
                    {
                        window.marco.print();
                    }
                </script>
                <style>
                    .select2-container .select2-selection--single {
                        height:20px
                    }
                </style>
                </head>
                <?php
                $date = date('d/m/Y');
                $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
                $date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
                $date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
                $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
                $marca = isset($_REQUEST['marca']) ? ($_REQUEST['marca']) : "";
                $det = isset($_REQUEST['det']) ? ($_REQUEST['det']) : "";
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
/////////////////////////////////
                $registros = 3;
                $pagina = isset($_REQUEST['pagina']) ? ($_REQUEST['pagina']) : "";
                if (!$pagina) {
                    $inicio = 0;
                    $pagina = 1;
                } else {
                    $inicio = ($pagina - 1) * $registros;
                }
/////////////////////////////////
                $sql = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $ltdgen = $row['ltdgen'];
                    }
                }
                $sql = "SELECT destab FROM titultabladet where tiptab = '$ltdgen' order by destab asc limit 1";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $marca1 = $row['destab'];
                    }
                }
                $sql = "SELECT destab FROM titultabladet where tiptab = '$ltdgen' order by destab desc limit 1";
                $result = mysqli_query($conexion, $sql);
                if (mysqli_num_rows($result)) {
                    while ($row = mysqli_fetch_array($result)) {
                        $marca2 = $row['destab'];
                    }
                }
                ?>

                <body>
                    <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
                        <table width="100%" border="0">
                            <tr>
                                <td><b><u>REPORTE POR MARCAS </u></b>
                                    <form id="form1" name="form1" method = "post" action="">
                                        <table width="100%" border="0" class="tablarepor">
                                            <tr>
                                                <td width="77" class="LETRA">SALIDA</td>
                                                <td colspan="6" width="840"><label>
                                                        <select name="report" id="report">
                                                            <option value="1">POR PANTALLA</option>
                                                            <?php if ($export == 1) { ?>
                                                                <option value="2">EN ARCHIVO XLS</option>
                                                            <?php } ?>
                                                        </select>
                                                    </label></td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="5" class="LETRA">PERIODO DESDE </td>

                                                <td width="15"><input type="text" name="date1" id="date1" size="12" value="<?php
                                                    if ($date1 == "") {
                                                        echo $date;
                                                    } else {
                                                        echo $date1;
                                                    }
                                                    ?>" /></td>

                                                <td width="5" class="LETRA"><div align="right">HASTA</td>
                                                <td width="15"><div align="Left"><input type="text" name="date2" id="date2" size="12" value="<?php
                                                        if ($date2 == "") {
                                                            echo $date;
                                                        } else {
                                                            echo $date2;
                                                        }
                                                        ?>" /></td>


                                                <td colspan="3"width="450"><label>
                                                        <select name="det" id="det">
                                                            <option value="1" <?php if ($det == 1) { ?> selected="selected"<?php } ?>>DETALLADA</option>
                                                            <option value="2" <?php if ($det == 2) { ?> selected="selected"<?php } ?>>RESUMIDA</option>
                                                        </select>
                                                    </label>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td width="5" class="LETRA"><div align="Left">LOCAL</div></td>
                                                <td width="19">
                                                    <select style="width:150px" name="local" id="local" onchange="selected()">
                                                        <?php if ($nombre_local == 'LOCAL0') { ?>
                                                            <option value="all" <?php if ($local == 'all') { ?> selected="selected"<?php } ?>>TODOS LOS LOCALES</option>
                                                        <?php } ?>
                                                        <?php
                                                        if ($nombre_local == 'LOCAL0') {
                                                            $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                                        } else {
                                                            $sql = "SELECT * FROM xcompa where codloc = '$codigo_local' ";
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
                                                            <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected"<?php } ?>><?php echo $nombre; ?></option>
                                                        <?php } ?>
                                                    </select></td>
                                                <td width="73" class="LETRA"><div align="right">MARCA</div></td>
                                                <td width="13"><select name="marca" id="marca">
                                                        <option value="all" <?php if ($marca == 'all') { ?> selected="selected"<?php } ?>>TODAS LAS MARCAS</option>
                                                        <?php
                                                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab";
                                                        $result = mysqli_query($conexion, $sql);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            $codtab = $row["codtab"];
                                                            $destab = $row["destab"];
                                                            ?>
                                                            <option value="<?php echo $row["codtab"]; ?>" <?php if ($marca == $codtab) { ?> selected="selected"<?php } ?>><?php echo $destab ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </td>


                                                <td width="217"><input name="val" type="hidden" id="val" value="1" />
                                                    <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()"/>
                                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                                    <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>			  </td>
                                                <td width="60"><?php
                                                    if (($pagina - 1) > 0) {
                                                        ?>
                                                        <a href="marcas1.php?val=<?php echo $val ?>&amp;&amp;tipo=<?php echo $tipo ?>&amp;&amp;tipo1=<?php echo $tipo1 ?>&amp;&amp;ltdgen=<?php echo $ltdgen ?>&amp;&amp;local=<?php echo $local ?>&amp;&amp;inicio=<?php echo $inicio ?>&amp;&amp;registros=<?php echo $registros ?>&amp;&amp;pagina=<?php echo $pagina - 1 ?>&amp;&amp;marca=<?php echo $marca ?>"> <img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                                    <?php }
                                                    ?></td>
                                                <td width="60"><?php
                                                    if (($pagina + 1) <= $total_paginas) {
                                                        ?>
                                                        <a href="marcas1.php?val=<?php echo $val ?>&amp;&amp;tipo=<?php echo $tipo ?>&amp;&amp;tipo1=<?php echo $tipo1 ?>&amp;&amp;ltdgen=<?php echo $ltdgen ?>&amp;&amp;local=<?php echo $local ?>&amp;&amp;inicio=<?php echo $inicio ?>&amp;&amp;registros=<?php echo $registros ?>&amp;&amp;pagina=<?php echo $pagina + 1 ?>&amp;&amp;marca=<?php echo $marca ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                                    <?php }
                                                    ?></td>
                                            </tr>
                                        </table>
                                        <table width="100%" border="0">
                                            
                                            
                                        </table>
                                        <!--<table width="100%" border="0">
                                          <tr>
                                               <td width="5"><div align="Left">LOCAL</div></td>
                                            <td width="169">
                                                        <select style="width:150px" name="local" id="local" onchange="selected()">
                                        <?php if ($nombre_local == 'LOCAL0') { ?>
                                                                                  <option value="all" <?php if ($local == 'all') { ?> selected="selected"<?php } ?>>TODOS LOS LOCALES</option>
                                        <?php } ?>
                                        <?php
                                        if ($nombre_local == 'LOCAL0') {
                                            $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                        } else {
                                            $sql = "SELECT * FROM xcompa where codloc = '$codigo_local' ";
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
                                                                  <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected"<?php } ?>><?php echo $nloc ?></option>
                                        <?php } ?>
                                            </select></td>
                                            <td width="73"><div align="right">MARCA</div></td>
                                                         <td width="153"><select name="marca" id="marca">
                                               <option value="all" <?php if ($marca == 'all') { ?> selected="selected"<?php } ?>>TODAS LAS MARCAS</option>
                                        <?php
                                        $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M' order by destab";
                                        $result = mysqli_query($conexion, $sql);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $codtab = $row["codtab"];
                                            $destab = $row["destab"];
                                            ?>
                                                                   <option value="<?php echo $row["codtab"]; ?>" <?php if ($marca == $codtab) { ?> selected="selected"<?php } ?>><?php echo $destab ?></option>
                                        <?php } ?>
                                             </select></td>
                                             
                                             
                                            <td width="217"><input name="val" type="hidden" id="val" value="1" />
                                            <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()"/>
                                            <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                            <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>			  </td>
                                                        <td width="18"><?php
                                        if (($pagina - 1) > 0) {
                                            ?>
                                                                  <a href="marcas1.php?val=<?php echo $val ?>&amp;&amp;tipo=<?php echo $tipo ?>&amp;&amp;tipo1=<?php echo $tipo1 ?>&amp;&amp;ltdgen=<?php echo $ltdgen ?>&amp;&amp;local=<?php echo $local ?>&amp;&amp;inicio=<?php echo $inicio ?>&amp;&amp;registros=<?php echo $registros ?>&amp;&amp;pagina=<?php echo $pagina - 1 ?>&amp;&amp;marca=<?php echo $marca ?>"> <img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                        <?php }
                                        ?></td>
                                                        <td width="23"><?php
                                        if (($pagina + 1) <= $total_paginas) {
                                            ?>
                                                                  <a href="marcas1.php?val=<?php echo $val ?>&amp;&amp;tipo=<?php echo $tipo ?>&amp;&amp;tipo1=<?php echo $tipo1 ?>&amp;&amp;ltdgen=<?php echo $ltdgen ?>&amp;&amp;local=<?php echo $local ?>&amp;&amp;inicio=<?php echo $inicio ?>&amp;&amp;registros=<?php echo $registros ?>&amp;&amp;pagina=<?php echo $pagina + 1 ?>&amp;&amp;marca=<?php echo $marca ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                        <?php }
                                        ?></td>
                                          </tr>
                                        </table>-->
                                    </form>
                                    <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
                            </tr>
                        </table>
                        <br>
                            <?php
                            if ($val == 1) {
                                require_once("rentabilidad2.php");
                                ?>
                                <!--<iframe src="rentabilidad2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&local=<?php echo $local ?>&det=<?php echo $det ?>&ltdgen=<?php echo $ltdgen ?>&amp;&amp;marca=<?php echo $marca ?>" name="marco" id="marco" width="100%" height="430" scrolling="Automatic" frameborder="0" allowtransparency="0">
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
                                $('#marca').select2();
                                $('#local').select2();
                            </script>
                            <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                            <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
                            <script type="text/javascript">
                                window.addEvent('domready', function () {
                                    myCal = new Calendar({date1: 'd/m/Y'});
                                    myCal = new Calendar({date2: 'd/m/Y'});
                                });
                            </script>