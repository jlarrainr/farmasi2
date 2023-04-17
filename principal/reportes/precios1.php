<?php include('../session_user.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/style1.css" rel="stylesheet" type="text/css" />
    <link href="css/tablas.css" rel="stylesheet" type="text/css" />
</head>
<?php
require_once('../../conexion.php'); //CONEXION A BASE DE DATOS
require_once('../../titulo_sist.php');
?>
<?php require_once("../../funciones/functions.php"); //DESHABILITA TECLAS
?>
<?php require_once("../../funciones/funct_principal.php"); //IMPRIMIR-NUMEROS ENTEROS-DECIMALES
?>
<?php require_once("../../funciones/botones.php"); //COLORES DE LOS BOTONES
?>
<?php require_once("local.php"); //OBTENGO EL NOMBRE Y CODIGO DEL LOCAL  
?>
<title><?php echo $desemp ?></title>
<link href="../select2/css/select2.min.css" rel="stylesheet" />
<script src="../select2/jquery-3.4.1.js"></script>
<script src="../select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        $('#local').select2();

    });
</script>
<script language="JavaScript">
    function buscar() {
        var f = document.form1;
        var tip = document.form1.report.value;
        if (tip == 1) {
            f.action = "precios1.php";
        } else {
            f.action = "precios_prog.php";
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
        window.marco.print();
    }
</script>
</head>
<?php
//////////////////////////////////7
//$hour   = date(G);
//$date	= CalculaFechaHora($hour);
$date = date("Y-m-d");
$val = $_REQUEST['val'];
$local = $_REQUEST['local'];
///////////////////////////////////
$registros = 24;
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
if ($local == 1) {
    $local = 'all';
}
if ($val == 1) {
    if ($local == 'all') {
        $sql = "SELECT codpro,desprod,pcostouni,preuni,margene FROM producto where eliminado='0'";
    } else {
        $sql = "SELECT codpro,desprod,pcostouni,preuni,margene FROM producto where $tabla > 0 and eliminado='0' ";
    }
    $sql = mysqli_query($conexion, $sql);
    $total_registros = mysqli_num_rows($sql);
    $total_paginas = ceil($total_registros / $registros);
}
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

<body>
    <table width="100%" border="0">
        <tr>
            <td><b><u>REPORTE POR PRECIO DE PRODUCTOS </u></b>
                <form id="form1" name="form1" method="post" action="">
                    <table width="100%" border="0" class="tablarepor">
                        <tr>
                            <td width="81" class="LETRA">SALIDA</td>
                            <td width="158">
                                <select name="report" id="report">
                                    <option value="1">POR PANTALLA</option>
                                    <?php if ($export == 1) { ?>
                                        <option value="2">EN ARCHIVO XLS</option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td width="39" class="LETRA">LOCAL</td>
                            <td width="580">
                                <select style="width:150px" name="local" id="local">
                                    <?php
                                    if ($nombre_local == 'LOCAL0') {
                                        $sql = "SELECT * FROM xcompa order by codloc ASC LIMIT $nlicencia";
                                    } else {
                                        $sql = "SELECT * FROM xcompa where codloc = '$codigo_local' ORDER BY codloc ASC LIMIT $nlicencia";
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
                                        <option value="<?php echo $row["codloc"]; ?>" <?php if ($loc == $local) { ?> selected="selected" <?php } ?>><?php echo $nloc ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input name="val" type="hidden" id="val" value="1" />
                                <input type="button" name="Submit" value="Buscar" class="buscar" onclick="buscar()" />
                                <input type="button" name="Submit" value="Salir" class="salir" onclick="salir()" />
                            </td>
                            <td width="16">
                                <?php
                                if (($pagina - 1) > 0) {
                                ?>
                                    <a href="precios1.php?val=<?php echo $val ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina - 1 ?>"> <img src="../../images/play1.gif" width="16" height="16" border="0" /> </a>
                                <?php }
                                ?>
                            </td>
                            <td width="27">
                                <?php
                                if (($pagina + 1) <= $total_paginas) {
                                ?>
                                    <a href="precios1.php?val=<?php echo $val ?>&local=<?php echo $local ?>&inicio=<?php echo $inicio ?>&registros=<?php echo $registros ?>&pagina=<?php echo $pagina + 1 ?>"> <img src="../../images/play.gif" width="16" height="16" border="0" /> </a>
                                <?php }
                                ?>
                            </td>
                        </tr>
                    </table>
                </form>
                <div align="center"><img src="../../images/line2.png" width="100%" height="4" /></div>
            </td>
        </tr>
    </table>
    <br>
    <?php
    if ($val == 1) {
        require_once("precios2.php");
    }
    ?>
</body>

</html>