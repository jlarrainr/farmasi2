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
                    alert("Ingrese el A�o Inicial");
                    f.year.focus();
                    return;
                }
                if (f.year1.value == "")
                {
                    alert("Ingrese el A�o Final");
                    f.year1.focus();
                    return;
                }
                var tip = document.form1.report.value;
                if (tip == 1)
                {
                    f.action = "ventas_mes1.php";
                } else
                {
                    f.action = "ventas_mesprog.php";
                }
                f.submit();
            }
            function validar1()
            {
                var f = document.form1;
                if (f.year.value == "")
                {
                    alert("Ingrese el A�o Inicial");
                    f.year.focus();
                    return;
                }
                if (f.year1.value == "")
                {
                    alert("Ingrese el A�o Final");
                    f.year1.focus();
                    return;
                }
                var tip = document.form1.report.value;
                if (tip == 1)
                {
                    f.action = "ventas_mes1.php";
                } else
                {
                    f.action = "ventas_mesprog.php";
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
            /*<!--*/
            .Estilo1 {
                color: #FF0000;
                font-weight: bold;
            }
            /*-->*/
        </style>
    </head>
    <?php
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
    $date = date("Y-m-d");
    $val = $_REQUEST['val'];
    $mes = $_REQUEST['mes'];
    $year = $_REQUEST['year'];
    $mes1 = $_REQUEST['mes1'];
    $year1 = $_REQUEST['year1'];
    $report = $_REQUEST['report'];
    $tipo = $_REQUEST['tipo'];


    // echo  $mes . "<br>"; 

    

    // echo $mes1 . "<br>";


    // echo $year . "<br>";

    // echo $year1 . "<br>";


    // echo $tipo . "<br>";

    // echo $val. "<br>";

    
    $sql = "SELECT export,nomusu FROM usuario where usecod = '$usuario'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result)) {
        while ($row = mysqli_fetch_array($result)) {
            $export = $row['export'];
            $user = $row['nomusu'];
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
    if ($tipo == 2) {
        if ($val == 1) {
            $sql = "SELECT month(invfec),year(invfec),sum(invtot),sucursal FROM venta where (month(invfec) between '$mes' and '$mes1') and (year(invfec) between '$year' and '$year1') group by month(invfec),year(invfec),sucursal";
            $sql = mysqli_query($conexion, $sql);
            $total_registros = mysqli_num_rows($sql);
            $total_paginas = ceil($total_registros / $registros);

            // echo $sql;
        }
    }


    if ($tipo == 4) {
        if ($val == 1) {
            $sql = "SELECT month(venta.invfec),year(venta.invfec),sum(invtot),codmar FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where (month(venta.invfec) between '$mes' and '$mes1') and (year(venta.invfec) between '$year' and '$year1') group by month(venta.invfec), year(venta.invfec), codmar";
            $sql = mysqli_query($conexion, $sql);
            $total_registros = mysqli_num_rows($sql);
            $total_paginas = ceil($total_registros / $registros);
        }
    }


    if ($tipo == 3) {
        if ($val == 1) {
            $sql = "SELECT month(venta.invfec),year(venta.invfec),sum(invtot),codpro FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where (month(venta.invfec) between '$mes' and '$mes1') and (year(venta.invfec) between '$year' and '$year1') group by month(venta.invfec), year(venta.invfec), codpro";
            $sql = mysqli_query($conexion, $sql);
            $total_registros = mysqli_num_rows($sql);
            $total_paginas = ceil($total_registros / $registros);
        }
    }


    if ($tipo == 5) {
        if ($val == 1) {
            $sql = "SELECT month(invfec),year(invfec),sum(invtot),usecod FROM venta where (month(invfec) between '$mes' and '$mes1') and (year(invfec) between '$year' and '$year1') group by month(invfec),year(invfec),usecod";
            $sql = mysqli_query($conexion, $sql);
            $total_registros = mysqli_num_rows($sql);
            $total_paginas = ceil($total_registros / $registros);
        }
    }


    ?>
    <body>
        <table width="100%" border="0">
            <tr>
                <td><b><u>REPORTE DE VENTAS MENSUALES </u></b>
                    <form id="form1" name="form1" >
                        <table width="100%" border="0" class="tablarepor" >
                            <tr>
                                <td width="102" class="LETRA">SALIDA</td>
                                <td width="188">
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>            </td>
                                <td width="122"><div align="right" class="LETRA">TIPO DE MONTO </div></td>
                                <td width="441"><label>
                                        <?php
                                        if ($tipo == "") {
                                            $tipo = 2;
                                        }
                                        ?>
                                        <select name="tipo" id="tipo">
                                            <option value="2" <?php if ($tipo == 2) { ?>selected="selected"<?php } ?>>POR SUCURSAL</option>
                                            <option value="4" <?php if ($tipo == 4) { ?>selected="selected"<?php } ?>>POR LABORATORIO</option>
                                            <option value="3" <?php if ($tipo == 3) { ?>selected="selected"<?php } ?>>POR PRODUCTO</option>
                                            <option value="5" <?php if ($tipo == 5) { ?>selected="selected"<?php } ?>>POR VENDEDOR</option>
                                        </select>
                                    </label>
                                </td>
                                <td width="24">
                                    <?php
                                    if (($pagina - 1) > 0) {
                                        ?>
                                        <a href="ventas_mes1.php?val=<?php echo $val ?>&mes=<?php echo $mes ?>&year=<?php echo $year ?>&mes1=<?php echo $mes1 ?>&year1=<?php echo $year1 ?>&tipo=<?php echo $tipo ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                    <?php }
                                    ?></td>
                                <td width="24"><?php
                                    if (($pagina + 1) <= $total_paginas) {
                                        ?>
                                        <a href="ventas_mes1.php?val=<?php echo $val ?>&mes=<?php echo $mes ?>&year=<?php echo $year ?>&mes1=<?php echo $mes1 ?>&year1=<?php echo $year1 ?>&tipo=<?php echo $tipo ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                    <?php }
                                    ?></td>
                            </tr>

                            <tr>
                                <td width="102" class="LETRA">DEL MES DE </td>
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
                                    ?>"/>
                                </td>
                                <td width="37" class="LETRA"><div align="right">AL</div></td>
                                <td width="156">
                                    <?php
                                    if ($mes1 == "") {
                                        $mes1 = date('m');
                                    }
                                    ?>
                                    <select name="mes1" class="Estilodany" id="select">
                                        <option value="1" <?php if ($mes1 == 1) { ?>selected="selected"<?php } ?> class="Estilodany">Enero</option>
                                        <option value="2" <?php if ($mes1 == 2) { ?>selected="selected"<?php } ?> class="Estilodany">Febrero</option>
                                        <option value="3" <?php if ($mes1 == 3) { ?>selected="selected"<?php } ?> class="Estilodany">Marzo</option>
                                        <option value="4" <?php if ($mes1 == 4) { ?>selected="selected"<?php } ?> class="Estilodany">Abril</option>
                                        <option value="5" <?php if ($mes1 == 5) { ?>selected="selected"<?php } ?> class="Estilodany">Mayo</option>
                                        <option value="6" <?php if ($mes1 == 6) { ?>selected="selected"<?php } ?> class="Estilodany">Junio</option>
                                        <option value="7" <?php if ($mes1 == 7) { ?>selected="selected"<?php } ?> class="Estilodany">Julio</option>
                                        <option value="8" <?php if ($mes1 == 8) { ?>selected="selected"<?php } ?> class="Estilodany">Agosto</option>
                                        <option value="9" <?php if ($mes1 == 9) { ?>selected="selected"<?php } ?> class="Estilodany">Setiembre</option>
                                        <option value="10" <?php if ($mes1 == 10) { ?>selected="selected"<?php } ?> class="Estilodany">Octubre</option>
                                        <option value="11" <?php if ($mes1 == 11) { ?>selected="selected"<?php } ?> class="Estilodany">Noviembre</option>
                                        <option value="12" <?php if ($mes1 == 12) { ?>selected="selected"<?php } ?> class="Estilodany">Diciembre</option>
                                    </select>
                                    <input name="year1" type="text" class="Estilodany" id="year1" size="6" maxlength="4" onkeypress="return acceptNum(event)" value="<?php
                                    if ($year1 == "") {
                                        echo $year_d;
                                    } else {
                                        echo $year1;
                                    }
                                    ?>"/></td>
                                <!--<td width="199">&nbsp;</td>-->
                                <td colspan="2" width="220"><input name="val" type="hidden" id="val" value="1" />
                                    <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar"/>
                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                    <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir"/></td>
                            </tr>
                        </table>
                        
                        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
                    </form>
                </td>
            </tr>
        </table>
        <br>
            <?php
            //   echo '$val22  ='.$val ."<br>";
            if ($val == 1) {
                require_once('ventas_mes2.php');
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
    $('#select').select2();
    $('#mes').select2();
    $('#tipo').select2();
    $('#opcion').select2();
    $('#report').select2();
</script>
<script type="text/javascript" src="../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../funciones/js/calendar.js"></script>

