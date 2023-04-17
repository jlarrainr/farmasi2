<?php require_once('../../../conexion.php');
require_once('../../session_user.php');
$venta   = $_SESSION['venta'];
$tradio  = $_REQUEST['tradio'];

mysqli_query($conexion, "UPDATE venta set tipoOpcionPrecio = '$tradio' where invnum = '$venta'");
header("Location: tipoPrecios.php?close=1");
