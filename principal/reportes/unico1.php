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
        <link href="css/style1.css" rel="stylesheet" type="text/css" />
        <link href="css/tablas.css" rel="stylesheet" type="text/css" />
   <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
        <link href="../select2/css/select2.min.css" rel="stylesheet" />
        <script src="../select2/jquery-3.4.1.js"></script>
        <script src="../select2/js/select2.min.js"></script>

        <?php
        require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
        require_once('../../titulo_sist.php');
        ?>
        <?php require_once("../../funciones/calendar.php"); ?>
        <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
        <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
        <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
        <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL  ?>
        <script language="JavaScript">
            function validar()
            {
                var f = document.form1;
                if (f.year.value == "")
                {
                    alert("Ingrese un A�o");
                    f.year.focus();
                    return;
                }
                var tip = document.form1.report.value;
                if (tip == 1)
                {
                    f.action = "unico1.php";
                } else
                {
                    f.action = "unicoprog.php";
                }
                f.submit();
            }
            function sf() {
                var f = document.form1;
                document.form1.yeart.focus();
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
                window.print();
            }
        </script>
        <style type="text/css">
            <!--
            .Estilo1 {
                color: #FF0000;
                font-weight: bold;
            }
            -->
        </style>
    </head>
    <?php
    $date = date('d/m/Y');
    $val = $_REQUEST['val'];
    $mes = $_REQUEST['mes'];
    $year = $_REQUEST['year'];
    $local = $_REQUEST['local'];
    $report = $_REQUEST['report'];
    $tipo = $_REQUEST['tipo'];
    $sql = "SELECT export,nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
            $user = $row['nomusu'];
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
////////////////////////////

    $sql = "SELECT idreporte FROM reporteunico where mes = '$mes' and anio = '$year' order by codpro";
    $sql = mysqli_query($conexion, $sql);
    $total_registros = mysqli_num_rows($sql);
    $total_paginas = ceil($total_registros / $registros);
    ?>
    <body>
        <table width="100%" border="0">
            <tr>
                <td><b><u>REPORTE DE VENTAS MENSUALES </u></b>
                    <form id="form1" name="form1" >
                        <table class="tablarepor" width="100%" border="0">
                            <tr>
                                <td width="102" class="LETRA">SALIDA</td>
                                <td width="188">
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                    </select>            </td>
                                <td width="122" class="LETRA"><div align="right">LOCAL</div></td>
                                <td width="441"><label><select style="width:150px" name="local" id="local">
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
                                                <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected"<?php } ?>><?php echo $nloc ?></option>
                                            <?php } ?>
                                        </select></label></td>
                                <td width="24">
                                    <?php
                                    if (($pagina - 1) > 0) {
                                        ?>
                                        <a href="unico1.php?val=<?php echo $val ?>&mes=<?php echo $mes ?>&year=<?php echo $year ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>&local=<?php echo $local ?>&tipo=<?php echo $tipo ?>"><img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                    <?php }
                                    ?></td>
                                <td width="24"><?php
                                    if (($pagina + 1) <= $total_paginas) {
                                        ?>
                                        <a href="unico1.php?val=<?php echo $val ?>&mes=<?php echo $mes ?>&year=<?php echo $year ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>&local=<?php echo $local ?>&tipo=<?php echo $tipo ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                    <?php }
                                    ?></td>
                            </tr>
                             <tr>
                                <td width="102" class="LETRA">FECHA</td>
                                <td width="188">
                                    <?php
                                    if ($mes == "") {
                                        $mes = date('m');
                                    }
                                    $year_d = date('Y');
                                    ?>
                                    <select name="mes" class="Estilodany" id="mes">
                                        <option value="1" <?php if ($mes == 1) { ?>selected="selected"<?php } ?> class="Estilodany">Enero</option>
                                        <option value="2" <?php if ($mes == 2) { ?>selected="selected"<?php } ?> class="Estilodany">Febrero</option>
                                        <option value="3" <?php if ($mes == 3) { ?>selected="selected"<?php } ?> class="Estilodany">Marzo</option>
                                        <option value="4" <?php if ($mes == 4) { ?>selected="selected"<?php } ?> class="Estilodany">Abril</option>
                                        <option value="5" <?php if ($mes == 5) { ?>selected="selected"<?php } ?> class="Estilodany">Mayo</option>
                                        <option value="6" <?php if ($mes == 6) { ?>selected="selected"<?php } ?> class="Estilodany">Junio</option>
                                        <option value="7" <?php if ($mes == 7) { ?>selected="selected"<?php } ?> class="Estilodany">Julio</option>
                                        <option value="8" <?php if ($mes == 8) { ?>selected="selected"<?php } ?> class="Estilodany">Agosto</option>
                                        <option value="9" <?php if ($mes == 9) { ?>selected="selected"<?php } ?> class="Estilodany">Setiembre</option>
                                        <option value="10" <?php if ($mes == 10) { ?>selected="selected"<?php } ?> class="Estilodany">Octubre</option>
                                        <option value="11" <?php if ($mes == 11) { ?>selected="selected"<?php } ?> class="Estilodany">Noviembre</option>
                                        <option value="12" <?php if ($mes == 12) { ?>selected="selected"<?php } ?> class="Estilodany">Diciembre</option>
                                    </select>
                                    <input name="year" type="text" class="Estilodany" id="year" size="6" maxlength="4" onkeypress="return acceptNum(event)" value="<?php
                                    if ($year == "") {
                                        echo $year_d;
                                    } else {
                                        echo $year;
                                    }
                                    ?>"/>			</td>
                                <td>&nbsp;</td>
                                <td colspan="3" width="220"><input name="val" type="hidden" id="val" value="1" />
                                    <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                    <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/></td>
                            </tr>
                        </table>
                        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
                        <table width="100%" border="0">
                           
                        </table>
                        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
                    </form>
                </td>
            </tr>
        </table>
        <br>
            <?php
            if ($val == 1) {
                require_once('unico2.php');
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
    $('#mes').select2();

</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>

