<?php include('../../../session_user.php');
require_once ('../../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
$proveedor    = $_REQUEST['country_ID'];
if ($proveedor <> "")
{
mysqli_query($conexion, "UPDATE ordmae set provee = '$proveedor' where invnum = '$ord_compra'");
header("Location: ../ocompra_index1.php?tip=2");
}
else
{
header("Location: ../ocompra_index1.php?tip=1");
}
