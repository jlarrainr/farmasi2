<?php include('../../session_user.php');
$ord_compra   = $_SESSION['ord_compra'];
require_once ('../../../conexion.php');
mysqli_query($conexion,"DELETE from temp_marca where invnum = '$ord_compra'");
mysqli_query($conexion,"DELETE from ordmov where invnum = '$ord_compra'");
mysqli_query($conexion,"DELETE from ordmae where invnum = '$ord_compra'");
header("Location: ocompra.php");
?>