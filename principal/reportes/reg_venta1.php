<?php
include('../session_user.php');
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">


            <title><?php echo $desemp ?></title>
            <link href="css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <link href="css/tablas.css" rel="stylesheet" type="text/css" />
            <link href="../../css/style.css" rel="stylesheet" type="text/css" />
            <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
                <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
                   <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
                    <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
                    ?>

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


                    </style>
                    </head>

                    <body>
                        <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                        <script type="text/javascript" src="../../funciones/js/calendar.js"></script>
                        <script type="text/javascript">
                            window.addEvent('domready', function () {
                                myCal = new Calendar({
                                    date1: 'd/m/Y'
                                });
                                myCal = new Calendar({
                                    date2: 'd/m/Y'
                                });

                                myCal3 = new Calendar({
                                    date3: 'd/m/Y'
                                }, {
                                    classes: ['i-heart-ny'],
                                    direction: 1
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
                        <?php
                        require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL

                        $date = date('d/m/Y');
                        $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
                        $vals = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
                        $val3 = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
                        $desc = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
                        $desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
                        $date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
                        $date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
                        $report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
                        $doc = isset($_REQUEST['doc']) ? ($_REQUEST['doc']) : "";
                        $doc2 = isset($_REQUEST['doc2']) ? ($_REQUEST['doc2']) : "";
                        $ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";
                        $ck1 = isset($_REQUEST['ck1']) ? ($_REQUEST['ck1']) : "";
                        $ckloc = isset($_REQUEST['ckloc']) ? ($_REQUEST['ckloc']) : "";
                        $ckprod = isset($_REQUEST['ckprod']) ? ($_REQUEST['ckprod']) : "";
                        $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
                        $loca1l = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "1";
                        $doc = $_REQUEST['doc'];
                        $doc2 = $_REQUEST['doc2'];
                        ?>
                        <script language="JavaScript">
                            function validar() {
                                var f = document.form1;
                                if (f.desc.value == "") {
                                    alert("Ingrese el Numero del Documento");
                                    f.desc.focus();
                                    return;
                                }
                                document.form1.vals.value = "";
                                document.form1.ck1.value = "";
                                var tip = document.form1.report.value;
                                if (tip == 1) {
                                    f.action = "reg_venta1.php";
                                } else {
                                    f.action = "reg_veng.php";
                                }
                                f.submit();
                            }

                            function resumen() {
                                //  	 window.open('ver_resumenxdia1.php','PopupName','toolbar=0,location=0,status=0,menubar=0,scrollbars=1,resizable=0,top=160,left=120,width=1000,height=350');
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

                                document.form1.val.value = "";
                                document.form1.ck.value = "";
                                var tip = document.form1.report.value;
                                if (tip == 1) {
                                    f.action = "reg_venta1.php";
                                } else {
                                    f.method = 'get';
                                    f.action = "reg_veng.php";
                                }
                                f.submit();
                            }
                            function printerpdf2() {

                                window.open('pdfre.php?date1=<?php echo $date1; ?>&date2=<?php echo $date2; ?>');
                            }



                            function validar3() {
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

                                document.form1.val.value = "";
                                document.form1.ck.value = "";
                                var tip = document.form1.report.value;
                                if (tip == 1) {
                                    f.action = "reg_venta1.php";
                                } else {
                                    f.method = 'get';
                                    f.action = "reg_veng.php";
                                }
                                f.submit();
                            }

                            function desab() {
                                var f = document.form1;
                                if (f.ckprod.checked == true) {
                                    //alert("hola1");
                                    f.ck.disabled = true;
                                    f.ck1.disabled = true;
                                } else {
                                    //alert("hola2");
                                    f.ck.disabled = false;
                                    f.ck1.disabled = false;
                                }
                            }

                            function desab() {
                                var f = document.form1;
                                if (f.ckprod.checked == true) {
                                    //alert("hola1");
                                    f.ck.disabled = true;
                                    f.ck1.disabled = true;
                                } else {
                                    //alert("hola2");
                                    f.ck.disabled = false;
                                    f.ck1.disabled = false;
                                }
                            }

                            function sf() {
                                var f = document.form1;
                                document.form1.desc.focus();
                            }

                            function salir() {
                                var f = document.form1;
                                f.method = "POST";
                                f.target = "_top";
                                f.action = "../index.php";
                                f.submit();
                            }

                            function printer() {
                                window.print();
                            }
                        </script>
                        <?php
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
                        $registros = 20;
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
                        if ($ckprod == 1) {
                            if ($val == 1) { ///	PRIMER BOTON
                                if ($local == 'all') { ////TODOS LOS LOCALES
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";
                                } else { ///UN SOLO LOCAL
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local'";
                                }
                            } else { ///	SEGUNDO BOTON
                                if ($local == 'all') { ////TODOS LOS LOCALES
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and invtot <> '0' and estado = '0'";
                                } else { ///UN SOLO LOCAL
                                    //echo $date1; echo "<br>"; echo $date2;
                                    //$sql="SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' and invtot <> '0' and estado = '0'";
                                    $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
                                }
                            }
                            $sql = mysqli_query($conexion, $sql);
                            $total_registros = mysqli_num_rows($sql);
                            $total_paginas = ceil($total_registros / $registros);
                            //echo $sql;
                        }
                        if ($ckprod == 1) {
                            if ($val == 1) { ///	PRIMER BOTON
                                if ($local == 'all') { ////TODOS LOS LOCALES
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0'";
                                } else { ///UN SOLO LOCAL
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta on venta.invnum = detalle_venta.invnum where nrovent between '$desc' and '$desc1' and estado = '0' and invtot <> '0' and sucursal = '$local'";
                                }
                            } else { ///	SEGUNDO BOTON
                                if ($local == 'all') { ////TODOS LOS LOCALES
                                    $sql = "SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and invtot <> '0' and estado = '0'";
                                } else { ///UN SOLO LOCAL
                                    //echo $date1; echo "<br>"; echo $date2;
                                    //$sql="SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' and invtot <> '0' and estado = '0'";
                                    $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
                                }
                            }
                            $sql = mysqli_query($conexion, $sql);
                            $total_registros = mysqli_num_rows($sql);
                            $total_paginas = ceil($total_registros / $registros);
                            //echo $sql;
                        } else {
                            if (($ck == '') && ($ck1 == '')) {
                                if (($val == 1) || ($vals == 2)) {
                                    if ($val == 1) {
                                        if ($local == 'all') {
                                            $sql = "SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' group by usecod";
                                        } else {
                                            $sql = "SELECT usecod FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local' group by usecod";
                                        }
                                    }
                                    if (($vals == 2)) {
                                        if ($local == 'all') {
                                            $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' group by usecod order by nrovent";
                                        } else {
                                            //$sql="SELECT venta.invnum FROM venta inner join detalle_venta where detalle_venta.invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' and invtot <> '0' and estado = '0'";
                                            $sql = "SELECT usecod FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' group by usecod order by nrovent";
                                        }
                                    }

                                    $sql = mysqli_query($conexion, $sql);
                                    $total_registros = mysqli_num_rows($sql);
                                    $total_paginas = ceil($total_registros / $registros);
                                }
                            }
                            if (($ck == 1) || ($ck1 == 1)) {
                                if (($val == 1) || ($vals == 2)) {
                                    if ($val == 1) {
                                        if ($local == 'all') {
                                            $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where nrovent between '$desc' and '$desc1'";
                                        } else {
                                            $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where nrovent between '$desc' and '$desc1' and sucursal = '$local'";
                                        }
                                    }
                                    if ($vals == 2) {
                                        if ($local == 'all') {
                                            $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' order by nrovent";
                                        } else {
                                            $sql = "SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invfec between 'fecha1($date1)' and 'fecha1($date2)' and sucursal = '$local' order by nrovent";
                                            //$sql="SELECT invnum,usecod,nrovent,forpag,val_habil,invtot FROM venta where invfec between fecha1('$date1') and fecha1('$date2') and sucursal = '$local' order by nrovent";
                                        }
                                    }

                                    $sql = mysqli_query($conexion, $sql);
                                    $total_registros = mysqli_num_rows($sql);
                                    $total_paginas = ceil($total_registros / $registros);
                                }
                            }
                        }
                        ?>

                        <?php
                        /*
                          if ($doc==1) {
                          $resp="SELECT nrofactura FROM venta WHERE  nrofactura LIKE 'B%'";
                          $result = mysqli_query($conexion,$resp);
                          while ($row = mysqli_fetch_array($result)){
                          $boleta	= $row["nrofactura"];

                          echo $boleta;
                          }}if($doc==2){

                          $resp="SELECT nrofactura FROM venta WHERE  nrofactura LIKE 'F%'";
                          $result = mysqli_query($conexion,$resp);
                          while ($row = mysqli_fetch_array($result)){
                          $boleta	= $row["nrofactura"];

                          echo $boleta;
                          }

                          } if($doc==3){

                          $resp="SELECT nrofactura FROM venta WHERE  nrofactura LIKE 'T%'";
                          $result = mysqli_query($conexion,$resp);
                          while ($row = mysqli_fetch_array($result)){
                          $boleta	= $row["nrofactura"];

                          echo $boleta;
                          }
                          }
                         */
                        ?>
                        <table width="100%" border="1">
                            <tr>
                                <td><b><u>REPORTE DE VENTAS </u></b>
                                    <form id="form1" name="form1" method="post" action="">
                                        <table class="tablarepor"width="100%" border="0">
                                            <tr bgcolor="#ececec">

                                                <td class="LETRA">SALIDA</td>
                                                <td>
                                                    <select style="width:150px" name="report" id="report">
                                                        <option value="1">POR PANTALLA</option>
                                                        <?php if ($export == 1) { ?>
                                                            <option value="2">EN ARCHIVO XLS</option>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                                <td class="LETRA">
                                                    <div align="right">LOCAL</div>
                                                </td>
                                                <td>
                                                    <select style="width:150px" name="local" id="local">
                                                        <?php /* if ($nombre_local == 'LOCAL0'){?>
                                                          <option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option>
                                                          <?php } */ ?>
                                                        <?php
                                                        if ($nombre_local == 'LOCAL0') {
                                                            $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                                        } else {
                                                            $sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local'";
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
                                                            <option value="<?php echo $row["codloc"] ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nombre; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--	<input name="ckloc" type="checkbox" id="ckloc" value="1" <?php if ($ckloc == 1) { ?>checked="checked"<?php } ?>/>
                             Mostrar Local
            <input name="ckprod" type="checkbox" id="ckprod" value="1" <?php if ($ckprod == 1) { ?>checked="checked"<?php } ?> onclick="desab()"/>
                            Mostrar Detalle de Productos-->
                                                </td>
                                                <td colspan="2">
                                                    <input name="ckloc" type="checkbox" id="ckloc" value="1" <?php if ($ckloc == 1) { ?>checked="checked" <?php } ?> />
                                                    <label for="ckloc" class="LETRA"> Mostrar Local </label>
                                                    <!-- <input name="ckprod" type="checkbox" id="ckprod" value="1" <?php if ($ckprod == 1) { ?>checked="checked" <?php } ?> onclick="desab()" />
                                                    <label for="ckprod" class="LETRA"> Mostrar Detalle de Productos </label> -->
                                                </td>


                                            </tr>

                                            <tr bgcolor="#ececec">

                                                <td class="LETRA">NUEVO</td>
                                                <td>
                                                    <select style="width:150px" name="doc2" id="doc2">


                                                        <option value="2" <?php if ($doc2 == 2) { ?> selected="selected" <?php } ?> >WCONT</option>
                                                        <option value="0" <?php if ($doc2 == 0) { ?> selected="selected" <?php } ?>>NORMAL</option>
                                                       <!-- <option value="1" <?php if ($doc2 == 1) { ?> selected="selected" <?php } ?>>STANDARD</option>
                                                        <option value="3" <?php if ($doc2 == 3) { ?> selected="selected" <?php } ?>>SISCON</option>
                                                        <option value="4" <?php if ($doc2 == 4) { ?> selected="selected" <?php } ?>>CONCART</option>-->

                                                    </select>
                                                </td>

                                                <td align="right" class="LETRA">TIPO. DOC</td>
                                                <td>
                                                    <select style="width:150px" name="doc" id="doc">

                                                        <option value="1" <?php if ($doc == 1) { ?> selected="selected" <?php } ?>>POR BOLETA</option>
                                                        <option value="2" <?php if ($doc == 2) { ?> selected="selected" <?php } ?>>POR FACTURA</option>
                                                        <option value="3" <?php if ($doc == 3) { ?> selected="selected" <?php } ?>>POR TICKET</option>
                                                        <option value="5" <?php if ($doc == 5) { ?> selected="selected" <?php } ?>>POR BOLETA / FACTURA (SOLO POR FECHAS) </option>
                                                        <option value="4" <?php if ($doc == 4) { ?> selected="selected" <?php } ?>>POR NOTA DE CREDITO</option>


                                                    </select>
                                                </td>

                                                <td>

                                                </td>

                                                <td><input name="val3" type="hidden" id="val3" value="3" />
                                                        <!--                                      <input type="button" name="Submit" value="RESUMEN X DIA" onclick="resumen()" class="buscar"/>-->
                                                    <input type="button" name="Submit" value="RESUMEN X DIA" onclick="validar3()" class="buscar" />

                                                </td>


                                            </tr>
                                            <tr bgcolor="#ececec">

                                                <td class="LETRA">NRO DE VENTA INICIAL</td>
                                                <td><input name="desc" type="text" id="desc" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc ?>" /></td>
                                                <td class="LETRA">
                                                    <div align="right">NRO DE VENTA FINAL</div>
                                                </td>
                                                <td><input name="desc1" type="text" id="desc1" onkeypress="return acceptNum(event)" size="8" maxlength="8" value="<?php echo $desc1 ?>" /> </td>
                                                <td>
                                                    <input name="ck" type="checkbox" id="ck" value="1" <?php if ($ck == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />

                                                    <label for="ck" class="LETRA"> Mostrar Lista detallada por N&ordm; </label>
                                                </td>

                                                <td><input name="val" type="hidden" id="val" value="1" />
                                                    <input type="button" name="Submit" value="Buscar" onclick="validar()" class="buscar" />
                                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir" />



                                                    <input type="button" name="Submit32" value="Salir" onclick="salir()" class="salir" />
                                                </td>

                                            </tr>

                                            <tr bgcolor="#ececec">
                                                <td class="LETRA">FECHA INICIO</td>
                                                <td>
                                                    <input type="text" name="date1" id="date1" size="12" value="<?php
                                                    if ($date1 == "") {
                                                        echo $date;
                                                    } else {
                                                        echo $date1;
                                                    }
                                                    ?>">
                                                </td>

                                                <td class="LETRA">
                                                    <div align="right">FECHA FINAL</div>
                                                </td>
                                                <td>
                                                    <input type="text" name="date2" id="date2" size="12" value="<?php
                                                    if ($date2 == "") {
                                                        echo $date;
                                                    } else {
                                                        echo $date2;
                                                    }
                                                    ?>">
                                                </td>
                                                <td>
                                                    <input name="ck1" type="checkbox" id="ck1" value="1" <?php if ($ck1 == 1) { ?>checked="checked" <?php } ?> <?php if ($ckprod == 1) { ?>disabled="disabled" <?php } ?> />


                                                    <label for="ck1" class="LETRA"> Mostrar Lista detallada por Fecha </label>
                                                </td>
                                                <td><input name="vals" type="hidden" id="vals" value="2" />
                                                    <input type="button" name="Submit2" value="Buscar" onclick="validar1()" class="buscar" />
                                                    <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir" />

                                                    <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir" />
                                                </td>
                                            </tr>

                                        </table>

                                    </form>

                            </tr>
                        </table>
                        <br>
                            <?php
                            if (($val == 1) || ($vals == 2) || ($val3 == 3)) {
                                require_once("reg_venta2.php");
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
                        $('#doc2').select2();
                        $('#doc').select2();
                        $('#local').select2();
                    </script>
                    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>