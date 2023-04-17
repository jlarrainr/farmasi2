<?php include('../../../session_user.php');
$invnum  = $_SESSION['compraspreg'];
require_once ('../../../../conexion.php');
$cod    		= $_REQUEST['cod'];		///invnum
$price  		= $_REQUEST['price'];		///precio de costo
$price1  		= $_REQUEST['price1'];		///margen
$price2    		= $_REQUEST['price2'];		///precio venta
$price3    		= $_REQUEST['price3'];		///precio venta unit
mysqli_query($conexion, "UPDATE producto set tcosto = '$price',tmargene = '$price1',tprevta= '$price2', tpreuni = '$price3' where codpro = '$cod'");
//header("Location: price.php?cod=$cod"); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<script>
function validar()
{
window.close();
}
</script>
</head>

<body onload="validar();">
</body>
</html>
