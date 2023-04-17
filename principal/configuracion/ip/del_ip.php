<?php require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$codip	= $_REQUEST['cod'];
mysqli_query($conexion,"delete from numberip where codip = '$codip'");
header("Location: ip2.php?ok=1"); 
?>