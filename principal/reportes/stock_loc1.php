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
        <link href="../../css/autocomplete.css" rel="stylesheet" type="text/css" />
    
<link href="css/gotop.css" rel="stylesheet" type="text/css" />
        <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css"/>
        
            <link href="../select2/css/select2.min.css" rel="stylesheet" />
            <script src="../select2/jquery-3.4.1.js"></script>
            <script src="../select2/js/select2.min.js"></script>

            <?php require_once('../../conexion.php'); //CONEXION A BASE DE DATOS?>
            <?php require_once("../../funciones/calendar.php"); ?>
            <?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS?>
            <?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES ?>
            <?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES ?>
            <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL ?>
            <script type="text/javascript" src="../../funciones/ajax.js"></script>
            <script type="text/javascript" src="../../funciones/ajax-dynamic-list.js"></script>
            <script language="JavaScript">

                //por nombre de producto
                function buscar()
                {
                    var f = document.form1;
                    if (f.country.value == "")
                    {
                        alert("Ingrese el Nombre Producto para Iniciar la Busqueda");
                        f.country.focus();
                        return;
                    }

                    var f = document.form1;
                    var tip = document.form1.report.value;
                    if (tip == 1)
                    {
                        f.action = "stock_loc1.php";
                    } else
                    {
                        f.action = "stock_loc1_prog.php";
                    }
                    f.val2.value = 0;
                    f.marca.value = 0;
                    f.submit();
                }
//                por marcaa
                function lp1()
                {

                    var f = document.form1;
                    var tip = document.form1.report.value;

                    if (f.marca.value == 0)
                    {
                        alert("Seleccione un Marca a Buscar");
                        f.marca.focus();
                        return;
                    }
                    if (tip == 1)
                    {
                        f.action = "stock_loc1.php";
                    } else
                    {
                        f.action = "stock_loc1_prog.php";
                    }
                    f.val.value = 0;
                    f.country.value = "";
                    f.submit();
                }
//                function validar1()
//                {
//                    var f = document.form1;
//                    var tip = document.form1.report.value;
//                    if (tip == 1)
//                    {
//                        f.action = "stock_loc1.php";
//                    } else
//                    {
//                        f.action = "stock_loc1_prog.php";
//                    }
//                    f.submit();
//                }


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
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
    $date = date("Y-m-d");
    $val1 = $_REQUEST['val'];
    $val2 = $_REQUEST['val2'];
    $country = $_REQUEST['country'];
    $country_ID = $_REQUEST['country_ID'];
    $marca = $_REQUEST['marca'];
    $report = $_REQUEST['report'];

    if ($val1 == 1) {
        $val = $val1;
        $search = $country_ID;
    }
    if ($val2 == 2) {
        $val = $val2;
        $search = $marca;
    }

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
    ?>
    <script language="javascript" type="text/javascript">
        function st()
        {
            var f = document.form1;
            f.country.focus();
        }
    </script>
    <body onload="st();">
        <link rel='STYLESHEET' type='text/css' href='../../css/calendar.css'>
            <table width="100%" border="0">
                <tr>
                    <td><b><u>REPORTE DE STOCKS DE PRODUCTOS - LOCALES </u></b>
                        <form id="form1" name="form1" method = "post"><table width="927" border="0">
                                <tr>
                                    <td width="119" class="LETRA">SALIDA</td>
                                    <td width="172">
                                        <select name="report" id="report">
                                            <option value="1">POR PANTALLA</option>
                                            <?php if ($export == 1) { ?>
                                                <option value="2">EN ARCHIVO XLS</option>
                                            <?php } ?>
                                        </select>            </td>
                                    <td width="58">&nbsp;</td>
                                    <td width="504">&nbsp;</td>
                                </tr>
                            </table>
                            <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div>
                            <table width="100%" border="0">
                                <tr>
                                    <td width="119" class="LETRA">PRODUCTO</td>

                                    <td >
                                        <input name="country" type="text" id="country" onkeyup="ajax_showOptions(this, 'getCountriesByLetters', event), this.value = this.value.toUpperCase();" size="90" class="busk" value="<?php echo $country ?>" onclick="this.value = ''" autocomplete="nope" placeholder="Ingrese el Producto a Buscar..."/> 
                                        <input type="hidden" id="country_hidden" name="country_ID" value="<?php echo $country_ID ?>"/>  

                                    </td>
                                    <td>
                                        <input name="val" type="hidden" id="val" value="1" />
                                        <input type="button" name="search" value="Buscar" onclick="buscar()" class="buscar"/>
                                        <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir"/>
                                        <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="119" class="LETRA">MARCA</td>
                                    <td width="500" >
                                        <select name="marca" id="marca" style="width:480px;">
                                            <option value="0">Seleccionar una marca...</option>
                                            <?php
                                            $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'M'";
                                            $result = mysqli_query($conexion, $sql);
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value="<?php echo $row["codtab"] ?>" <?php if ($marca == $row["codtab"]) { ?>selected="selected"<?php } ?>><?php echo $row["destab"] ?></option>
                                            <?php } ?>
                                        </select>		  
                                    </td>
                                    <td>
                                        <input name="val2" type="hidden" id="val2" value="2"/>
                                        <input type="button" name="Submit2" value="Buscar" onclick="lp1()" class="buscar"/>
                                        <input type="button" name="Submit222" value="Imprimir" onclick="printer()" class="imprimir"/>
                                        <input type="button" name="Submit3" value="Salir" onclick="salir()" class="salir"/>
                                    </td>

                                </tr>

                            </table>
                        </form>
                        <div align="left"><img src="../../images/line2.png" width="100%" height="4" /></div></td>
                </tr>
            </table>
            <br>
                <?php
                if (($val == 1) || ($val == 2)) {
                    require_once("stock_loc2.php");
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
                    $('#marca').select2();

                </script>