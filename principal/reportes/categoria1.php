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
    <?php
    require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
    require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
    require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
    require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
    ?>
    <script type="text/javascript" language="JavaScript1.2" src="../../funciones/js/jquery.js"></script>

    <?php require_once('../../titulo_sist.php'); ?>
    <?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL


    $sqlP = "SELECT precios_por_local FROM datagen";
    $resultP = mysqli_query($conexion, $sqlP);
    if (mysqli_num_rows($resultP)) {
        while ($row = mysqli_fetch_array($resultP)) {
            $precios_por_local = $row['precios_por_local'];
        }
    }
    if ($precios_por_local  == 1) {
        require_once '../../precios_por_local.php';
    }

    ?>
    <script language="JavaScript">
        function buscar() {
            var f = document.form1;
            var tip = document.form1.report.value;
            if (tip == 1) {
                f.action = "categoria1.php";
            } else {
                f.action = "categoria_prog.php";
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
</head>
<?php
//////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
$val = $_REQUEST['val'];
$tipo = $_REQUEST['tipo'];
$tipo1 = $_REQUEST['tipo1'];
$local = $_REQUEST['local'];
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
    require_once("datos_generales.php"); //COGE LA TABLA DE UN LOCAL
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($val == 1) {
    if ($tipo1 == 1) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 2) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 3) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0'  order by desprod";
    }
    if ($tipo1 == 4) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla1 = 0 and destab between '$marca1' and '$marca2 and producto.eliminado='0' order by desprod";
    }
    if ($tipo1 == 5) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 > 0 and destab between '$marca1'  and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 6) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and $tabla1 = 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    if ($tipo1 == 7) {
        $sql = "SELECT desprod FROM producto inner join titultabladet on producto.codcatp = titultabladet.codtab where $tabla > 0 and destab between '$marca1' and '$marca2' and producto.eliminado='0' order by codpro";
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    $sql = mysqli_query($conexion, $sql);
    $total_registros = mysqli_num_rows($sql);
    $total_paginas = ceil($total_registros / $registros);
}
////////////////////////////////////
$sql = "SELECT ltdgen FROM titultabla where dsgen = 'CATEGORIA'";
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
<?php //              if ($tipo == 3){
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
    <table width="954" border="0">
        <tr>
            <td><b><u>REPORTE POR MARCAS </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="850" border="0">
                        <tr>
                            <td width="83">SALIDA</td>
                            <td width="834"><label>
                                    <select name="report" id="report">
                                        <option value="1">POR PANTALLA</option>
                                        <?php if ($export == 1) { ?>
                                            <option value="2">EN ARCHIVO XLS</option>
                                        <?php } ?>
                                    </select>
                                </label>
                            </td>

                            <td width="100">MARCA DESDE</td>
                            <td width="140">
                                <?php //echo $marca1 
                                ?>
                                <select name="marca1" id="marca1">
                                    <?php
                                    $sql = "SELECT codtab,destab FROM titultabladet where tiptab = '$ltdgen' order by destab asc";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codtab1 = $row["codtab"];
                                        $destab1 = $row["destab"];
                                    ?>
                                        <option value="<?php echo $row["destab"]; ?>" <?php if ($destab1 == $marca1) { ?> selected="selected" <?php } ?>><?php echo $row["destab"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>


                            <td width="82">HASTA</td>
                            <td width="550">
                                <?php //echo $marca2
                                ?>
                                <select name="marca2" id="marca2">
                                    <?php
                                    $sql = "SELECT codtab,destab FROM titultabladet where tiptab = '$ltdgen' order by destab asc";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $codtab2 = $row["codtab"];
                                        $destab2 = $row["destab"];
                                    ?>
                                        <option value="<?php echo $row["destab"]; ?>" <?php if ($destab2 == $marca2) { ?> selected="selected" <?php } ?>><?php echo $row["destab"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </td>

                            <td width="52">LOCAL</td>
                            <td width="275">
                                <select name="local" id="local">
                                    <?php /* if ($nombre_local == 'LOCAL0'){?><option value="all" <?php if ($local == 'all'){?> selected="selected"<?php }?>>TODOS LOS LOCALES</option><?php } */ ?>
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT codloc,nomloc,nombre FROM xcompa order by codloc";
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
                                        <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $locals; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <div align="center"><img src="../../images/line2.png" width="960" height="5" /></div>
                    <table width="750" border="0">
                        <tr>
                            <td width="50">TIPO DE REPORTE </td>
                            <td width="150">
                                <select name="tipo" id="tipo">
                                    <option value="1" <?php if ($tipo == 1) { ?>selected="selected" <?php } ?>>LISTA DE PRECIOS DE PRODUCTOS</option>
                                    <option value="2" <?php if ($tipo == 2) { ?>selected="selected" <?php } ?>>LISTA DE STOCKS DE PRODUCTOS</option>
                                    <option value="3" <?php if ($tipo == 3) { ?>selected="selected" <?php } ?>>FORMATO DE INVENTARIOS DE PRODUCTOS</option>
                                </select>
                            </td>

                        </tr>
                    </table>

                    <div align="center"><img src="../../images/line2.png" width="960" height="4" /></div>

                    <table width="949" border="0">
                        <tr>

                            <td width="100">TIPO DE INFORMACION </td>


                            <td width="650"><label>
                                    <select name="tipo1" id="tipo1">
                                        <option value="1" <?php if ($tipo1 == 1) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS</option>
                                        <option value="2" <?php if ($tipo1 == 2) { ?>selected="selected" <?php } ?>>SOLO PRODUCTOS CON STOCK</option>
                                        <option value="7" <?php if ($tipo1 == 7) { ?>selected="selected" <?php } ?>>SOLO PRODUCTOS SIN STOCK </option>

                                        <option value="3" <?php if ($tipo1 == 3) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS PERO QUE TENGAN STOCK MINIMO </option>
                                        <option value="4" <?php if ($tipo1 == 4) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS SIN STOCK MINIMO</option>
                                        <option value="5" <?php if ($tipo1 == 5) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS CON STOCK Y CON STOCK MINIMO</option>
                                        <option value="6" <?php if ($tipo1 == 6) { ?>selected="selected" <?php } ?>>TODOS LOS PRODUCTOS CON STOCK Y SIN STOCK MINIMO</option>

                                    </select>
                                    <input name="val" type="hidden" id="val" value="1" />
                                    <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                                    <input type="button" name="Submit22" value="Imprimir" onclick="printer()" class="imprimir" />
                                    <input type="button" name="Submit2" value="Salir" onclick="salir()" class="salir" />
                                </label></td>

                        </tr>
                    </table>
                </form>
                <div align="center"><img src="../../images/line2.png" width="960" height="4" /></div>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        require_once("categoria2.php");
    ?>
        <!--  <iframe src="marcas2.php?val=<?php echo $val ?>&tipo=<?php echo $tipo ?>&tipo1=<?php echo $tipo1 ?>&ltdgen=<?php echo $ltdgen ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina ?>&tot_pag=<?php echo $total_paginas ?>&marca1=<?php echo $marca1 ?>&marca2=<?php echo $marca2 ?>" name="marco" id="marco" width="954" height="460" scrolling="Automatic" frameborder="0" allowtransparency="0">
                            </iframe>-->
    <?php }
    ?>
</body>

</html>