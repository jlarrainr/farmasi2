<?php include('../session_user.php');
require_once('../../convertfecha.php'); //CONEXION A BASE DE DATOS
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Documento sin t&iacute;tulo</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/gotop.css" rel="stylesheet" type="text/css" />
    <link href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" rel="stylesheet" type="text/css" />
    <?php require_once('../../conexion.php');  //CONEXION A BASE DE DATOS
    ?>
    <?php require_once("../../funciones/functions.php");  //DESHABILITA TECLAS
    ?>
    <?php require_once("../../funciones/funct_principal.php");  //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    ?>
    <?php require_once("../../funciones/botones.php");  //COLORES DE LOS BOTONES
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="../../funciones/js/jquery.js"></script>

    <?php require_once('../../titulo_sist.php'); ?>
    <?php require_once("local.php");  //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL
    ?>
    <script language="JavaScript">
        function buscar() {
            var f = document.form1;
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "marcas1.php";
            } else {
                f.action = "marcas_prog.php";
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

    <link href="../select2/css/select2.min.css" rel="stylesheet" />
    <script src="../select2/jquery-3.4.1.js"></script>
    <script src="../select2/js/select2.min.js"></script>





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
            f.action = "../index.php";
            f.submit();
        }
    </script>
</head>
<?php

 

//////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
$val = $_REQUEST['val'];
$tipo = $_REQUEST['tipo'];
//$tipo1 = $_REQUEST['tipo1']:;
$tipo1 = isset($_REQUEST['tipo1']) ? ($_REQUEST['tipo1']) : "2";
$local = $_REQUEST['local'];
$orden = $_REQUEST['orden'];
$locales = $_REQUEST['locales'];
$marca1 = $_REQUEST['marca1'];
$marca2 = $_REQUEST['marca2'];
$cat1 = $_REQUEST['cat1'];
$cat2 = $_REQUEST['cat2'];
$alllocal = $_REQUEST['alllocal'];



$sqlP = "SELECT precios_por_local FROM datagen";
$resultP = mysqli_query($conexion, $sqlP);
if (mysqli_num_rows($resultP)) {
    while ($row = mysqli_fetch_array($resultP)) {
        $precios_por_local = $row['precios_por_local'];
    }
}

$zzcodloc=$local;
if ($precios_por_local  == 2) {
    require '../../precios_por_local.php';
}


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
    require_once("datos_generales.php");  //COGE LA TABLA DE UN LOCAL
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($val == 1) {
    if ($tipo1 == 1) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 2) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 3) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by desprod";
    }
    if ($tipo1 == 4) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by desprod";
    }
    if ($tipo1 == 5) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 6) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 7) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codmar = titultabladet.codtab where $tabla > 0 and stopro<=0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    $sql = mysqli_query($conexion, $sql);
    $total_registros = mysqli_num_rows($sql);
    $total_paginas = ceil($total_registros / $registros);
}
////////////////////////////////////
$sql = "SELECT ltdgen FROM titultabla where dsgen = 'MARCA'";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
    while ($row = mysqli_fetch_array($result)) {
        $ltdgen = $row['ltdgen'];
    }
}

/* $sql="SELECT * FROM titultabladet where tiptab = '$ltdgen' order by destab asc limit 1";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result)){
      while ($row = mysqli_fetch_array($result)){
      $marca1    = $row['destab'];
      }
      }
      $sql="SELECT * FROM titultabladet where tiptab = '$ltdgen' order by destab desc limit 1";
      $result = mysqli_query($conexion,$sql);
      if (mysqli_num_rows($result)){
      while ($row = mysqli_fetch_array($result)){
      $marca2    = $row['destab'];
      }
      }
     */
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
            <td><b><u>REPORTE POR MARCAS </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td class="LETRA">SALIDA</td>
                            <td><label>
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </td>



                            <td width="52" class="LETRA" align="right">LOCAL</td>
                            <td width="275">
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
                                <input name="orden" type="checkbox" id="orden" value="1" <?php if ($orden == 1) { ?>checked="checked" <?php } ?> />
                                <label for="orden" class="LETRA">Ordenar alfabeticamente, tipo indecopi </label> <br>

                                <input name="alllocal" type="checkbox" id="alllocal" value="1" <?php if ($alllocal == 1) { ?>checked="checked" <?php } ?> />
                                <label for="alllocal" class="LETRA">Todos los locales</label>
                            </td>

                            
                             
                            
                        </tr>

                        <tr>

                            <td class="LETRA" align="left">MARCA DESDE</td>
                            <td width="140">
                                <?php //echo $marca1
                                ?>
                                <select name="marca1" id="marca1" style="width:200px">
                                    <?php
                                    $sql = "SELECT codtab,destab,abrev FROM titultabladet where tiptab = '$ltdgen' order by destab asc";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codtab1 = $row["codtab"];
                                        $destab1 = $row["destab"];
                                        $abrev1 = $row["abrev"];

                                        $nombre1 = $destab1;
                                    ?>
                                        <option value="<?php echo $row["destab"]; ?>" <?php if ($destab1 == $marca1) { ?> selected="selected" <?php } ?>><?php echo $nombre1; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>


                            <td width="82" class="LETRA" align="right">HASTA</td>
                            <td width="1000" colspan="2">
                                <?php //echo $marca2
                                ?>
                                <select name="marca2" id="marca2" style="width:200px">
                                    <?php
                                    $sql = "SELECT codtab,destab,abrev FROM titultabladet where tiptab = '$ltdgen' order by destab DESC";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codtab2 = $row["codtab"];
                                        $destab2 = $row["destab"];
                                        $abrev2 = $row["abrev"];

                                        $nombre2 = $destab2;
                                    ?>
                                        <option value="<?php echo $row["destab"]; ?>" <?php if ($destab2 == $marca2) { ?> selected="selected" <?php } ?>><?php echo $nombre2; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="LETRA">TIPO DE REPORTE </td>
                            <td colspan="7" width="150">
                                <select name="tipo" id="tipo" style="width:322px">
                                    <option value="1" <?php if ($tipo == 1) { ?>selected="selected" <?php } ?>>LISTA DE PRECIOS DE PRODUCTOS</option>
                                    <option value="2" <?php if ($tipo == 2) { ?>selected="selected" <?php } ?>>LISTA DE STOCKS DE PRODUCTOS</option>
                                    <option value="3" <?php if ($tipo == 3) { ?>selected="selected" <?php } ?>>FORMATO DE INVENTARIOS DE PRODUCTOS</option>
                                    <option value="4" <?php if ($tipo == 4) { ?>selected="selected" <?php } ?>>LISTA DE COSTO DE COMPRA Y PRECIOS DE VENTA</option>
                                </select>
                            </td>

                            <?php if ($tipo == 3) { ?>


                                <?php
                                $sql = "SELECT codtab,destab FROM titultabladet where tiptab = 'S' order by destab asc";
                                $result = mysqli_query($conexion, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                                    $cat2 = $row["codtab"];
                                    $destab2 = $row["destab"];
                                ?>
                                    <option value="<?php echo $row["destab"]; ?>" <?php if ($destab2 == $cat2) { ?> selected="selected" <?php } ?>><?php echo $row["destab"] ?></option>
                                <?php
                                }
                                ?>
                                </select>



                            <?php } ?>
                        </tr>

                        <tr>

                            <td width="150" class="LETRA">TIPO DE INFORMACION </td>


                            <td width="150"><label>
                                    <select name="tipo1" id="tipo1">
                                        <option value="1" <?php if ($tipo1 == 1) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS</option>
                                        <option value="2" <?php if ($tipo1 == 2) { ?>selected="selected" <?php } ?>>SOLO PRODUCTOS CON STOCK</option>
                                        <option value="7" <?php if ($tipo1 == 7) { ?>selected="selected" <?php } ?>>SOLO PRODUCTOS SIN STOCK </option>

                                        <!--  <option value="3" <?php if ($tipo1 == 3) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS PERO QUE TENGAN STOCK MINIMO </option>
                                           <option value="4" <?php if ($tipo1 == 4) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS SIN STOCK MINIMO</option>
                                            <option value="5" <?php if ($tipo1 == 5) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS CON STOCK Y CON STOCK MINIMO</option>
                                            <option value="6" <?php if ($tipo1 == 6) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS CON STOCK Y SIN STOCK MINIMO</option>-->

                                    </select>

                                </label>
                            </td>
                            <td colspan="3" width="120" align="right">
                                <input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                                <input type="button" name="Submit22" value="Imprimir" onClick="self.location.href = 'marcas2_1.php?val=<?php echo $val ?>&tipo=<?php echo $tipo ?>&tipo1=<?php echo $tipo1 ?>&ltdgen=<?php echo $ltdgen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>&marca1=<?php echo $marca1 ?>&marca2=<?php echo $marca2 ?>'" class="imprimir" />
                                <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir" />
                            </td>


                        </tr>
                    </table>

                </form>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        require_once("marcas2.php");
    ?>
        <!--  <iframe src="marcas2.php?val=<?php echo $val ?>&tipo=<?php echo $tipo ?>&tipo1=<?php echo $tipo1 ?>&ltdgen=<?php echo $ltdgen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>&marca1=<?php echo $marca1 ?>&marca2=<?php echo $marca2 ?>" name="marco" id="marco" width="954" height="460" scrolling="Automatic" frameborder="0" allowtransparency="0">
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

<link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!--<script src="https://code.jquery.com/jquery-3.3.1.js"></script>-->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>