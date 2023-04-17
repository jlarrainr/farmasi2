<?php include('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$remesa   	= $_SESSION['remesa'];
$codtip 	= $_REQUEST['cod'];
mysqli_query($conexion,"DELETE FROM gasres where invnum = '$remesa' and codtab = '$codtip'");
header("Location: f7.php?val=0");
?>