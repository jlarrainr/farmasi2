<?php include('../../session_user.php');
require_once('../../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="../../../css/calendar/calendar.css" rel="stylesheet" type="text/css" />
    <link href="../css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
     <script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
    <script type="text/javascript" src="../../../funciones/js/calendar.js"></script>
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
    <?php require_once('../../../conexion.php');  //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../../funciones/functions.php");  //DESHABILITA TECLAS
    ?>
    <?php require_once("../../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../../funciones/botones.php");  //COLORES DE LOS BOTONES
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="../../../funciones/js/jquery.js"></script>

    <?php require_once('../../../titulo_sist.php'); ?>
    <?php require_once("../local.php");  //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    ?>
    <script language="JavaScript">
        function buscar() {
            var f = document.form1;
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "archivoBalance1.php";
            } else {
                f.action = "archivoBalance_excel.php";
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
            window.print();
        }
    </script>

    <link href="../../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../../select2/jquery-3.4.1.js"></script>
    <script src="../../select2/js/select2.min.js"></script>





    <script>
        $(document).ready(function() {
            $('#marca1').select2();
            $('#marca2').select2();
            $('#local').select2();
            $('#tipo').select2();
            $('#tipo1').select2();
        });

        function salir() {
            var f = document.form1;
            f.method = "POST";
            f.target = "_top";
            f.action = "../../index.php";
            f.submit();
        }
    </script>
</head>
<?php

$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}
if ($precios_por_local  == 1) {
    require_once '../../../precios_por_local.php';
}

//////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date('d/m/Y');
$val = $_REQUEST['val'];
// $tipo = $_REQUEST['tipo'];
//$tipo1 = $_REQUEST['tipo1']:;
// $tipo1 = isset($_REQUEST['tipo1']) ? ($_REQUEST['tipo1']) : "2";
$date1 = isset($_REQUEST['date1']) ? ($_REQUEST['date1']) : "";
$date2 = isset($_REQUEST['date2']) ? ($_REQUEST['date2']) : "";
$todo = isset($_REQUEST['todo']) ? ($_REQUEST['todo']) : "";

$local = $_REQUEST['local'];
$orden = $_REQUEST['orden'];
$marca1 = $_REQUEST['marca1'];
$marca2 = $_REQUEST['marca2'];
$cat1 = $_REQUEST['cat1'];
$cat2 = $_REQUEST['cat2'];
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
///////////////////////////////////
$registros = 30;
$pagina = $_REQUEST["pagina"];
if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
    $inicio = ($pagina - 1) * $registros;
}
if ($local <> 'all') {
    require_once("../datos_generales.php");  //COGE LA TABLA DE UN LOCAL
}

 
////////////////////////////////////
$sql = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $ltdgen = $row['ltdgen'];
    }
}

 
?>
<?php
//              if ($tipo == 3){
?>
<script>
    function habilitar(value) {
        if (value == "3" || value == true) {

            document.getElementById("cat2").disabled = false;
        } else if (value == "0" || value == false) {
            document.getElementById("cat2").disabled = true;
        }
    }
</script>

<body>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE POR BALANCE INGRESOS Y EGRESOS</u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="1" class="tablarepor">
                        <tr>
                            <td width="8%" class="LETRA">SALIDA</td>
                            <td width="20%" ><label>
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </td>



                            <td  width="8%" class="LETRA" align="right">LOCAL</td>
                            <td width="20%"  >
                                <select style="width:120px" name="local" id="local">
                                    <?php /* if ($nombre_local == 'LOCAL0'){?><option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option><?php } */ ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                    } else {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa where codloc = '$codigo_local' ORDER BY codloc ASC LIMIT $nlicencia";
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
                                        <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" name="todo" <?php if ($todo == 1) { ?>checked<?php } ?> id="todo" value="1" />
                                <label for="todo" class="LETRA"> Mostrar Todos los Movimientos </label>
                            </td>
                        </tr>

                        <tr>

                            <td width="60" class="LETRA">FECHA INICIO</td>
                            <td >
                               <input type="text" name="date1" id="date1" size="12" value="<?php
                                                                                                        if ($date1 == "") {
                                                                                                            echo $date;
                                                                                                        } else {
                                                                                                            echo $date1;
                                                                                                        }
                                                                                                        ?>" />
                            </td>


                           <td width="106" class="LETRA">
                                <div align="right">FECHA FINAL</div>
                            </td>
                            <td  >
                                <input type="text" name="date2" id="date2" size="12" value="<?php
                                                                                                        if ($date2 == "") {
                                                                                                            echo $date;
                                                                                                        } else {
                                                                                                            echo $date2;
                                                                                                        }
                                                                                                        ?>" />
                            </td>
                             
                            
                            <td align="right">
                                <input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                                <input type="button" name="Submit22" value="Imprimir"  class="imprimir" />
                                <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir" />
                            </td>
                        </tr>
                        
 
                    </table>

                </form>
                <div align="center"><img src="../../../images/line2.png" width="100%" height="4" /></div>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        require_once("archivoBalance2.php");
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

 
<script type="text/javascript" src="../../../funciones/js/mootools.js"></script>
<script type="text/javascript" src="../../../funciones/js/calendar.js"></script>