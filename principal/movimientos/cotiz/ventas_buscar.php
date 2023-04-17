<?php require_once('../../session_user.php');
$venta   = $_SESSION['cotiz'];
require_once('../../../conexion.php');
require_once('funciones/datos_generales.php'); //////CODIGO Y NOMBRE DEL LOCAL
require_once('../tabla_local.php'); //////CODIGO Y NOMBRE DEL LOCAL
mysqli_query($conexion,"DELETE from cotizacion where invnum = '$venta'");
mysqli_query($conexion,"DELETE from cotizacion_det where invnum = '$venta'");
mysqli_query($conexion,"DELETE from venta where invnum = '$venta'");
header("Location: ventas.php");
?>