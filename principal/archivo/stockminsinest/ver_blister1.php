<?php require_once("../../../conexion.php");
include('../../session_user.php');
$codpro	 = $_REQUEST['codpro'];
$blister = $_REQUEST['blister'];
$cr      = $_REQUEST['cr'];
mysqli_query($conexion,"UPDATE producto set blister = '$blister' where codpro = '$codpro'");
header("Location: ver_blister.php?cod=$codpro&cr=$cr");
?>