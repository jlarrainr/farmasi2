<?php include('../../../session_user.php');
$invnum  = $_SESSION['compraspreg'];
require_once ('../../../../conexion.php');
$cod    		= $_REQUEST['cod'];		///invnum
$price  		= $_REQUEST['price'];		///precio de costo
$price1  		= $_REQUEST['price1'];		///margen
$price2    		= $_REQUEST['price2'];		///precio venta
$price3    		= $_REQUEST['price3'];		///precio venta unit
mysqli_query($conexion, "UPDATE producto set margene = '$price1',prevta= '$price2', preuni = '$price3' where codpro = '$cod'");
header("Location: price.php?cod=$cod"); 
?>