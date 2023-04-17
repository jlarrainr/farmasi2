<?php include('../../session_user.php');
require_once('../../../conexion.php');	//CONEXION A BASE DE DATOS
$remesa   	  = $_SESSION['remesa'];
$turno = $_REQUEST['turno'];
mysqli_query($conexion,"update remesa set turno = '$turno' where invnum = '$remesa'");
header("Location: remesas1.php");
?>