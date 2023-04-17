<?php require_once('conexion.php');


$sql = "SELECT codpro FROM producto WHERE s000=0 order by codpro";
$result = mysqli_query($conexion, $sql);
if (mysqli_num_rows($result)) {
	while ($row = mysqli_fetch_array($result)) {
		$codpro    = $row['codpro'];

		$sql1 = "SELECT  * FROM kardex where codpro = '$codpro'  ";
		$result1 = mysqli_query($conexion, $sql1);
		if (mysqli_num_rows($result1)) {
			while ($row1 = mysqli_fetch_array($result1)) {
				$tipmov    = $row1['tipmov'];
			}
		} else {
			mysqli_query($conexion, "DELETE from producto where codpro = '$codpro'");
		}
	}
}
