<?php include('../../session_user.php');
require_once ('../../../conexion.php');
$ord_compra   = $_SESSION['ord_compra'];
//$hour   = date(G)-5;
$date	= date('Y-m-d');
//$date	= CalculaFechaHora($hour);
$sql="SELECT codpro FROM ordmov where invnum= '$ord_compra'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codpro     = $row["codpro"];
	mysqli_query($conexion,"UPDATE producto set fecord = '$date' where codpro = '$codpro'");
}
}
$sql1="SELECT auditor FROM datagen_det";
$result1 = mysqli_query($conexion,$sql1);
if (mysqli_num_rows($result)){
while ($row1 = mysqli_fetch_array($result1)){
$auditor     = $row1["auditor"];
}
}
$sql="SELECT codord,codpro,codprobon,canbon,tipbon,costo_real FROM tempordmov_bonif where invnum= '$ord_compra'";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
	$codord     = $row["codord"];
	$codpro     = $row["codpro"];
	$codprobon  = $row["codprobon"];
	$canbon     = $row["canbon"];
	$tipbon     = $row["tipbon"];
	$costo_real = $row["costo_real"];
	$sql1="SELECT codmar,factor FROM producto where codpro= '$codpro'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result)){
	while ($row1 = mysqli_fetch_array($result1)){
		$codmar     = $row1["codmar"];
		$factor     = $row1["factor"];
	}
	}
	$sql1="SELECT canpro FROM ordmov where codord= '$codord'";
	$result1 = mysqli_query($conexion,$sql1);
	if (mysqli_num_rows($result)){
	while ($row1 = mysqli_fetch_array($result1)){
		$canpro     = $row1["canpro"];
	}
	}
	$mont = $costo_real * $canpro;
	mysqli_query($conexion,"UPDATE ordmov set codprobon = '$codpro' where codord = '$codord' and invnum = '$ord_compra'");
	mysqli_query($conexion,"INSERT INTO ordmov (invnum,codmar,codpro,canbon,tipbon,factor,codprobon) values ('$ord_compra','$codmar','$codpro','$canbon','$tipbon','$factor','$codprobon')");
}
}

mysqli_query($conexion,"DELETE from temp_marca where invnum = '$ord_compra'");
mysqli_query($conexion,"DELETE from tempordmov_bonif where invnum = '$ord_compra'")	;
mysqli_query($conexion,"UPDATE ordmae set estado = '0', pendiente = '1', confirmado = '1' where invnum = '$ord_compra'");
if ($auditor == 1)
{
mysqli_query($conexion,"UPDATE ordmae set confirmado = '0' where invnum = '$ord_compra'");
mysqli_query($conexion,"UPDATE ordmov set confirmar = '0' where invnum = '$ord_compra'");
}
header("Location: ocompra.php");
?>