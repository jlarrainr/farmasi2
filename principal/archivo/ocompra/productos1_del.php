<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
$codpro       = $_REQUEST['codpro'];
$codord       = $_REQUEST['codord'];
$cr           = $_REQUEST['cr'];
mysqli_query($conexion,"DELETE from ordmov where codpro = '$codpro' and invnum = '$ord_compra' and codord = '$codord'");
mysqli_query($conexion,"DELETE from tempordmov_bonif where codord = '$codord' and invnum = '$ord_compra'");
$sql1="SELECT sum(mont_total) FROM ordmov where invnum= '$ord_compra'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
$sum     = $row1[0];
}
}
mysqli_query($conexion,"UPDATE ordmae set invtot = '$sum' where invnum = '$ord_compra'");
header("Location: productos.php?tip=2&cr=$cr");
?>