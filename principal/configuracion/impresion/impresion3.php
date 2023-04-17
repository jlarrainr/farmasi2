<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$local	= $_REQUEST['local'];
$val 	= $_REQUEST['val'];
$tipdocu= $_REQUEST['tipdocu'];
$ancho 	= $_REQUEST['ancho'];
$alto 	= $_REQUEST['alto'];
$exist 	= $_REQUEST['exist'];
$medida 	= $_REQUEST['medida'];
$negrita 	= $_REQUEST['negrita'];
$size	 	= $_REQUEST['size'];
$codimpresion 	= $_REQUEST['codimpresion'];
$numlineas   	= $_REQUEST['numlineas'];
$impresora   	= $_REQUEST['impresora'];
if($exist == 1)
{
mysqli_query($conexion,"update impresion set negrita = '$negrita',size = '$size', numlineas = '$numlineas', impresora = '$impresora' where codimpresion = '$codimpresion'");
}
else
{
mysqli_query($conexion,"INSERT INTO impresion (codlocal,tipodocumento,negrita,size,numlineas,impresora) values ('$local','$tipdocu','$negrita','$size','$numlineas','$impresora')");
}
header("Location: impresion2.php?val=$val&local=$local&tipdocu=$tipdocu"); 
?>