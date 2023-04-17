<?php include('../../session_user.php');
require_once ('../../../conexion.php');	//CONEXION A BASE DE DATOS
$ord_compra   = $_SESSION['ord_compra'];
$obs  		  = $_REQUEST['obs'];
$cod  		  = $_REQUEST['codpro'];
mysqli_query($conexion,"UPDATE ordmov set observacion = '$obs' where invnum = '$ord_compra' and codpro = '$cod'");
header("Location: observacion.php?cod=$cod");
?>