<?php require_once('../../session_user.php');
require_once('../../../conexion.php');
$venta = $_SESSION['venta'];
$pago  = $_REQUEST['pago'];
$dias  = $_REQUEST['dias'];

mysqli_query($conexion, "UPDATE venta set forpag = '$pago',ndias = '$dias' where invnum = '$venta'");
