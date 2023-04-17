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
            
            <link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
            <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css"/>
            
                <link href="../../css/calendar/calendar.css" rel="stylesheet" type="text/css">
                    <?php //require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
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
                        <?php //require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
                        ?>
                        <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
                        ?>
                        <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
                        ?>
                        <?php
                        require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL

                        $date = date('d/m/Y');
//                        $val = isset($_REQUEST['val']) ? ($_REQUEST['val']) : "";
                        $vals = isset($_REQUEST['vals']) ? ($_REQUEST['vals']) : "";
//                        $val3 = isset($_REQUEST['val3']) ? ($_REQUEST['val3']) : "";
//                        $desc = isset($_REQUEST['desc']) ? ($_REQUEST['desc']) : "";
//                        $desc1 = isset($_REQUEST['desc1']) ? ($_REQUEST['desc1']) : "";
                        $date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
                        $date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
                        $fpago = isset($_REQUEST['fpago']) ? ($_REQUEST['fpago']) : "";
                        $report = isset($_REQUEST['report']) ? ($_REQUEST['report']) : "";
//                        $doc = isset($_REQUEST['doc']) ? ($_REQUEST['doc']) : "";
//                        $doc2 = isset($_REQUEST['doc2']) ? ($_REQUEST['doc2']) : "";
                        $ck = isset($_REQUEST['ck']) ? ($_REQUEST['ck']) : "";
                        $ck1 = isset($_REQUEST['ck1']) ? ($_REQUEST['ck1']) : "";
                        $ckloc = isset($_REQUEST['ckloc']) ? ($_REQUEST['ckloc']) : "";
                        $ckprod = isset($_REQUEST['ckprod']) ? ($_REQUEST['ckprod']) : "";
                        $local = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "";
                        $loca1l = isset($_REQUEST['local']) ? ($_REQUEST['local']) : "1";
                        $fpago = isset($_REQUEST['fpago']) ? ($_REQUEST['fpago']) : "1";
                        $doc = $_REQUEST['doc'];
                        $doc2 = $_REQUEST['doc2'];
                        
                       
                        ?>
                        <script language="JavaScript">
                            

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

                                var tip = document.form1.report.value;
                                if (tip == 1) {
                                    f.action = "reg_comp1.php";
                                } else {
                                    f.method = 'get';
                                    f.action = "reg_compexcel.php";
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
                      
                        ?>

                        
                        <table width="100%" border="0">
                            <tr>
                                <td><b><u>REPORTE REGISTRO DE COMPRA </u></b>
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
                                                        <?php if ($nombre_local == 'LOCAL0'){?>
                                                          <option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option>
                                                          <?php }  ?>
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

                                                </td>
                                                
                                                
                                                <td colspan="2">
                                                    <label for="fpago" class="LETRA"> Tipo de Documento</label>
                                                    <select style='width:250px;' id="fpago" name="fpago" >
                                    <option value="all" <?php if ($fpago == "all") { ?> selected="selected" <?php } ?> >Todos</option>
                                    
                                    <option value="F"  <?php if ($fpago == "F") { ?> selected="selected" <?php } ?>>Factura</option>
                                    <option value="B"  <?php if ($fpago == "B") { ?> selected="selected" <?php } ?>>Boleta </option>
                                    <option value="G"  <?php if ($fpago == "G") { ?> selected="selected" <?php } ?>>Guia   </option>
                                    <option value="O"  <?php if ($fpago == "O") { ?> selected="selected" <?php } ?>>Otros  </option>
                                   <!-- <option value="E"  <?php if ($fpago == "E") { ?> selected="selected" <?php } ?>>Efectivo</option>-->
                                </select>
                                                   
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
                                                     <input name="ckloc" type="checkbox" id="ckloc" value="1" <?php if ($ckloc == 1) { ?>checked="checked" <?php } ?> />
                                                    <label for="ckloc" class="LETRA"> Mostrar Local </label>
                                                </td>
                                                <td>
                                                    <input name="vals" type="hidden" id="vals" value="2" />
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
                            if (($vals == 2)) {
                                require_once("reg_comp2.php");
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
                        $('#fpago').select2();
                    </script>
                    <script type="text/javascript" src="../../funciones/js/mootools.js"></script>
                    <script type="text/javascript" src="../../funciones/js/calendar.js"></script>