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
$xfactor        = $_REQUEST['factor'];

//echo $price;exit;

/// Esto es una invencion mia no se porque pero funciona !!!!
if ($xfactor >= 2) {
} else {
    $price3 = $price2;
    //    echo $price2;
    //    echo $price3;
    //    sleep(1); // Se detiene 2 segundos en continuar la ejecuci�0�1�0�6n
}

if ($precios_por_local == 1) {

    if (($zzcodloc == 1)) {

        mysqli_query($conexion, "UPDATE producto set tcosto = '$price',tmargene = '$price1',tprevta= '$price2', tpreuni = '$price3', tcostpr = '$price' where codpro = '$cod'");
    } else {

        mysqli_query($conexion, "UPDATE precios_por_local set $tcosto_p = '$price',$tmargene_p = '$price1',$tprevta_p= '$price2', $tpreuni_p = '$price3', $tcostpr_p = '$price' where codpro = '$cod'");
    }
} else {

    mysqli_query($conexion, "UPDATE producto set tcosto = '$price',tmargene = '$price1',tprevta= '$price2', tpreuni = '$price3', tcostpr = '$price' where codpro = '$cod'");
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=gb18030">

    <title>Documento sin t&iacute;tulo</title>
    <script>
        function validar() {
            window.close();
        }
    </script>
</head>

<body onload="validar();">
</body>

</html>