<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$rd     = $_REQUEST['rd'];
$invnum = $_REQUEST['invnum'];
$sql1="SELECT invfec FROM ordmae where invnum= '$invnum'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $invfec     = $row1['invfec'];
}
}
$sql1="SELECT producto.codpro FROM ordmov inner join producto on ordmov.codpro = producto.codpro where invnum= '$invnum'";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result1)){
while ($row1 = mysqli_fetch_array($result1)){
		    $codpro     = $row1[0];
			mysqli_query($conexion,"UPDATE producto set fecord = '$invfec' where codpro = '$codpro'");
}
}
mysqli_query($conexion,"UPDATE ordmae set borrada = '0' where invnum = '$invnum'");
header("Location: ocompra2.php?rd=$rd&invnum=$invnum");
?>