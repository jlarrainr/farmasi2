<?php include('../../../session_user.php');
$invnum  = $_SESSION['compras'];
require_once('../../../../conexion.php');
require_once('../../../titulo_sist.php');

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
$cod            = $_REQUEST['cod'];        ///invnum
$price          = $_REQUEST['price'];        ///precio de costo
$price1          = $_REQUEST['price1'];        ///margen
$price2            = $_REQUEST['price2'];        ///precio venta
$price3            = $_REQUEST['price3'];        ///precio venta unit

if ($precios_por_local == 1) {

    if (($zzcodloc == 1)) {

        mysqli_query($conexion, "UPDATE producto set margene = '$price1',prevta= '$price2', preuni = '$price3' where codpro = '$cod'");
    } else {

        mysqli_query($conexion, "UPDATE precios_por_local set $margene_p = '$price1',$prevta_p= '$price2', $preuni_p = '$price3' where codpro = '$cod'");
    }
} else {

    mysqli_query($conexion, "UPDATE producto set margene = '$price1',prevta= '$price2', preuni = '$price3' where codpro = '$cod'");
}

header("Location: price.php?cod=$cod");
