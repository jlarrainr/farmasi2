<?php include('../../../session_user.php');
require_once ('../../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
$codtab       = $_REQUEST['codtab'];
mysqli_query($conexion, "delete from temp_marca where codtab = '$codtab' and invnum = '$ord_compra'");
header("Location: ../ocompra_index1.php?tip=2");
?>