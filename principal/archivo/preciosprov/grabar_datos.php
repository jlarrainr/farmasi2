<?php include('../../session_user.php');
require_once('../../../conexion.php');
$codpro   = $_REQUEST['codpro'];
$val      = $_REQUEST['val'];
$search   = $_REQUEST['search'];
$p3       = $_REQUEST['p3'];
//mysqli_query($conexion,"UPDATE producto set pcostouni = '$p1', prevta = '$p2',preuni = '$p3' where codpro = '$codpro'");
mysqli_query($conexion,"UPDATE producto set pdistribuidor = '$p3' where codpro = '$codpro'");
header("Location: precios2.php?search=$search&val=$val");
?>