<?php
require_once ('conexion.php');
$numero = 0;
$sql="SELECT invnum,WEEK(invfec) - WEEK(DATE_SUB(invfec, INTERVAL DAYOFMONTH(invfec)-1 DAY)) + 1 FROM venta order by invnum";
$result = mysqli_query($conexion,$sql);
if (mysqli_num_rows($result)){
while ($row = mysqli_fetch_array($result)){
		$invnum    = $row['invnum'];
		$semana    = $row[1];
	//	mysqli_query($conexion,"UPDATE venta set semana = '$semana' where invnum = '$invnum'");
}
}
?>