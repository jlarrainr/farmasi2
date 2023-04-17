<?php include('../../../session_user.php');
require_once ('../../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
$codtab       = $_REQUEST['country_ID'];
$sql="SELECT codtab,invnum FROM temp_marca where codtab= '$codtab' and invnum = '$ord_compra'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result))
{
mysqli_query($conexion, "DELETE from temp_marca where codtab = '$codtab' and invnum = '$ord_compra'");
}
else
{
mysqli_query($conexion, "INSERT INTO temp_marca (codtab,invnum) values ('$codtab','$ord_compra')");
}
header("Location: ../ocompra_index1.php?tip=2");
?>