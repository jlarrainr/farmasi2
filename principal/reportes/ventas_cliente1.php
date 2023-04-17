<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

            <title>Documento sin t&iacute;tulo</title>
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <link href="css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
                <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
                <link rel="STYLESHEET" type="text/css" href="../../funciones/codebase/dhtmlxcombo.css">
                <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
                    <script>
                        window.dhx_globalImgPath = "../../funciones/codebase/imgs/";
                    </script>
                    <script  src="../../funciones/codebase/dhtmlxcommon.js"></script>
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
                    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
                    <?php require_once("../../convertfecha.php"); //DESHABILITA TECLAS?>
                    <?php require_once("../../funciones/calendar.php"); ?>
                    <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES?>
                    <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES?>
<!--<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
<link href="../select2/css/select2.min.css" rel="stylesheet" />
<script src="../select2/js/select2.min.js"></script>-->

                    <script language="JavaScript">
                        function buscar()
                        {
                            var f = document.form1;
                            var tip = document.form1.report.value;
                            if (tip == 1)
                            {
                                f.action = "ventas_cliente1.php";
                            } else
                            {
                                f.action = "ventas_cliente_prog.php";
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
                        function sf()
                        {
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
                    $cliente = $_REQUEST['cliente'];
                    $vendedor = $_REQUEST['vendedor'];
                    $t1 = $_REQUEST['t1'];
                    $t2 = $_REQUEST['t2'];
                    $opcion = $_REQUEST['opcion'];
                    $sql = "SELECT export FROM usuario where usecod = '$usuario'";
                    $result = mysqli_query($conexion, $sql);
                    if (mysqli_num_rows($result)) {
                        while ($row = mysqli_fetch_array($result)) {
                            $export = $row['export'];
                        }
                    }
///////////////////////////////////
                    $registros = 3;
                    $pagina = $_REQUEST["pagina"];
                    if (!$pagina) {
                        $inicio = 0;
                        $pagina = 1;
                    } else {
                        $inicio = ($pagina - 1) * $registros;
                    }
                    if ($cliente == "") {
                        $cliente = "all_cli";
                    }
                    if ($local <> 'all') {
                        require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
                    }
////////////////////////////////////
                    ?>
                    <body onload="sf();">
                        <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
                            <table width="100%" border="0">
                                <tr>
                                    <td><b><u>REPORTE POR VENTAS DE CLIENTES </u></b>
                                        <form id="form1" name="form1" method = "post" action="">
                                            <table class="tablarepor" width="100%" border="0">
                                                <tr>
                                                    <td width="97" class="LETRA">SALIDA</td>
                                                    <td colspan="3" width="194"><select name="report" id="report">
                                                            <option value="1">POR PANTALLA</option>
                                                            <?php if ($export == 1) { ?>
                                                                <option value="2">EN ARCHIVO XLS</option>
                                                            <?php } ?>
                                                        </select>              </td>
<!--                                                    <td width="566">&nbsp;</td>-->
                                                    <td width="24"><?php
                                                        if (($pagina - 1) > 0) {
                                                            ?>
                                                            <a href="ventas_dia1.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&cliente=<?php echo $cliente ?>&vendedor=<?php echo $vendedor ?>&t1=<?php echo $t1 ?>&t2=<?php echo $t2 ?>&opcion=<?php echo $opcion ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"><img src="../../images/play1.gif" width="16" height="16" border="0"/> </a>
                                                        <?php }
                                                        ?></td>
                                                    <td width="24"><?php
                                                        if (($pagina + 1) <= $total_paginas) {
                                                            ?>
                                                            <a href="ventas_dia1.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&cliente=<?php echo $cliente ?>&vendedor=<?php echo $vendedor ?>&t1=<?php echo $t1 ?>&t2=<?php echo $t2 ?>&opcion=<?php echo $opcion ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0"/> </a>
                                                        <?php }
                                                        ?></td>
                                                </tr>

                                                

                                                <tr>
                                                    <td width="50" class="LETRA"><div align="left">CLIENTE</div></td>
                                                    <td width="200" align="left">
                                                        <select name="cliente" id="cliente">
                                                            <option value="all_cli">PUBLICO EN GENERAL</option>
                                                            <?php
                                                            $sql = "SELECT codcli,descli  FROM cliente where descli <> 'PUBLICO EN GENERAL' order by descli";
                                                            $result = mysqli_query($conexion, $sql);
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $select_cli = $row["codcli"];
                                                                $cliente_slc = $row["descli"];
                                                                ?>
                                                                <option value="<?php echo $row["codcli"] ?>" <?php if ($cliente == $select_cli) { ?> selected="selected"<?php } ?>><?php
                                                                    echo substr($row["descli"], 0, 70);
                                                                    echo '...';
                                                                    ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>

                                                    <td width="57" class="LETRA"><div align="right">VENDEDOR</div></td>
                                                    <td  width="150">
                                                        <select name="vendedor" id="vendedor">
                                                            <option value="all">TODOS LO VENDEDORES</option>
                                                            <?php
                                                            $sql = "SELECT usecod, nomusu FROM usuario inner join grupo_user on usuario.codgrup = grupo_user.codgrup where nomgrup = 'VENDEDOR' order by nomusu";
                                                            $result = mysqli_query($conexion, $sql);
                                                            while ($row = mysqli_fetch_array($result)) {
                                                                $select_ven = $row["usecod"];
                                                                ?>
                                                                <option value="<?php echo $row["usecod"]; ?>" <?php if ($vendedor == $select_ven) { ?> selected="selected" <?php } ?>><?php echo strtoupper($row["nomusu"]); ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td  colspan="2"width="350" class="LETRA"><div >OPCIONES
                                                            <select name="opcion" id="opcion">
                                                                <option value="1" <?php if ($opcion == 1) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE RESUMIDO</option>
                                                                <option value="2" <?php if ($opcion == 2) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE DETALLADO POR DOCUMENTO</option>
                                                                <option value="3" <?php if ($opcion == 3) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE DETALLADO POR PRODUCTO</option>
                                                                <option value="4" <?php if ($opcion == 4) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE RESUMIDO POR MARCA</option>
                                                                <option value="5" <?php if ($opcion == 5) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE RESUMIDO POR PRODUCTO</option>
                                                                <option value="6" <?php if ($opcion == 6) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE RESUMIDO POR LINEA DE PRODUCTO</option>
                                                                <option value="7" <?php if ($opcion == 7) { ?> selected="selected"<?php } ?>>VENTAS POR CLIENTE RESUMIDO POR CLASE DE PRODUCTO </option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td width="20" class="LETRA">DESDE</td>
                                                    <td width="100"><input type="text" name="date1" id="date1" size="12" value="<?php
                                                        if ($date1 == "") {
                                                            echo $date;
                                                        } else {
                                                            echo $date1;
                                                        }
                                                        ?>" /></td>
                                                    <td width="20" align="right" class="LETRA">HASTA</td>
                                                    <td width="103"><input type="text" name="date2" id="date2" size="12" value="<?php
                                                        if ($date2 == "") {
                                                            echo $date;
                                                        } else {
                                                            echo $date2;
                                                        }
                                                        ?>" /></td>
                                                    



                                                    <td  colspan="2" width="150"><label>
                                                            <div align="right">
                                                           <!--   <input name="t1" type="text" id="t1" size="6" onKeyPress="return decimal(event)" value="<?php echo $t1 ?>"/>
                                                            A 
                                                            <input name="t2" type="text" id="t2" size="6" onKeyPress="return decimal(event)" value="<?php echo $t2 ?>"/>-->
                                                                <input name="val" type="hidden" id="val" value="1" />
                                                                <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()"/>
                                                                <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                                                <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>
                                                            </div>
                                                        </label></td>
                                                    
                                                </tr>
                                            </table>
                                           
                                               <!--<table width="100%" border="0">
                                                   
                                              <tr>
                                                <!--<td width="2"><div align="left">RANGO DE VENTAS </div></td>
                                                <td width="100"><label>
                                                  <div align="left">
                                                 <!--   <input name="t1" type="text" id="t1" size="6" onKeyPress="return decimal(event)" value="<?php echo $t1 ?>"/>
                                                  A 
                                                  <input name="t2" type="text" id="t2" size="6" onKeyPress="return decimal(event)" value="<?php echo $t2 ?>"/>
                                                  <input name="val" type="hidden" id="val" value="1" />
                                                  <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()"/>
                                                  <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir"/>
                                                  <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir"/>
                                                  </div>
                                                </label></td>
                                                <td width="110"></td>
                                                
                                              </tr>
                                            </table>-->
                                        </form>
                                        <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
                                </tr>
                            </table>
                            <br>
                                <?php
                                if ($val == 1) {
                                    
                                     require_once('ventas_cliente2.php');
                                    ?>
                                   <!-- <iframe src="ventas_cliente2.php?val=<?php echo $val ?>&date1=<?php echo $date1 ?>&date2=<?php echo $date2 ?>&cliente=<?php echo $cliente ?>&vendedor=<?php echo $vendedor ?>&t1=<?php echo $t1 ?>&t2=<?php echo $t2 ?>&opcion=<?php echo $opcion ?>" name="marco" id="marco" width="100%" height="460" scrolling="Automatic" frameborder="0" allowtransparency="0">
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
                                    $('#cliente').select2();
                                    $('#vendedor').select2();
                                    $('#tipo').select2();
                                    $('#opcion').select2();
                                </script>
                                <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                                <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
